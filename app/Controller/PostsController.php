<?php
namespace App\Controller;

use Core\Controller\Controller;
use Core\HTML\BootstrapForm;


class PostsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Post');
		$this->loadModel('Category');
		$this->loadModel('comment');
	}
	
	/* Affiche la liste des 3 derniers épisodes */
	public function index()
	{
		$posts = $this->Post->last();
		$categories = $this->Category->all();
		$this->render('posts.index', compact('posts', 'categories'));
	}
	
	/* Affiche un épisode en particulier avec la catégorie correspondante et les commentaires correspondants */
	public function show()
	{
		$article = $this->Post->findWithCategory($_GET['id']);
		$post_id = $article->id;
		$comments = $this->Post->getPostComments($post_id);
		$form = new BootstrapForm($_POST);
		$errors = false;
		
		if(!empty($_POST)) {
			if (empty($_POST['comment'])) {
				$errors = true;
			} else {
				$comment = $this->comment->create([
					'author' => $_POST['author'],
					'comment' => $_POST['comment'],
					'article_id' => $_POST['id']
				]);
				if ($comment) {
					header("Refresh:0");
					$_SESSION['flash']['success']= "Votre commentaire a bien été publié.";
				}
			}
		}
		
		if(isset($_POST['signal_comment'])){
			$this->comment->update($_POST['id'], [
				'is_signaled' => 1,
				'signaled_at' => date('Y-m-d H:i:s')
			]);
			header("Refresh:0");
			$_SESSION['flash']['success']= "Ce commentaire a bien été signalé, et sera traité dans les plus brefs délais.";
		}
		
		$this->render('posts.show', compact('article', 'form', 'comments', 'comment', 'errors'));
		$currentPost = $this->Post->find($_GET['id']);
		$currentId = $currentPost->id;
		$_SESSION['currentId'] = $currentId;
	}
	
	public function allEpisodes()
	{
		$posts = $this->Post->all();
		$categories = $this->Category->all();
		$this->render('posts.allEpisodes', compact('posts', 'categories'));
	}
	
	public function firstEpisode()
	{
		$posts = $this->Post->firstOne();
		$categories = $this->Category->all();
		$this->render('posts.episode', compact('posts', 'categories'));
	}
	
	public function lastEpisode()
	{
		$posts = $this->Post->lastOne();
		$categories = $this->Category->all();
		$this->render('posts.episode', compact('posts', 'categories'));
	}
	
	public function nextEpisode()
	{
		$posts = $this->Post->nextOne($_SESSION['currentId']);
		$categories = $this->Category->all();
		$this->render('posts.next_prev', compact('posts','categories'));
	}
	
	public function previousEpisode()
	{
		$posts = $this->Post->previousOne($_SESSION['currentId']);
		$categories = $this->Category->all();
		$this->render('posts.next_prev', compact('posts','categories'));
	}
	
	/* Affiche la liste des catégories */
	public function category()
	{
		$categorie = $this->Category->find($_GET['id']);
		if($categorie === false)
		{
			$this->notFound();
		}
		$articles = $this->Post->lastByCategory($_GET['id']);
		$categories = $this->Category->all();
		$this->render('posts.category', compact('articles', 'categories', 'categorie'));
	}
	
	/* Affiche le menu d'administration du site (Episodes et catégories) */
	public function administration()
	{
		$errors = false;
		$form = new BootstrapForm($_POST);
		$this->render('posts.administration', compact('posts', 'categories', 'form', 'errors'));
	}

}