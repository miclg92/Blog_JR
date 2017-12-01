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
		
		if (!empty($_POST)) {
			$comment = $this->comment->create([
				'author' => $_POST['author'],
				'comment' => $_POST['comment'],
				'article_id' => $_POST['id']
			]);
			if($comment){
				header("Refresh:0");
			}
		}
		$this->render('posts.show', compact('article', 'form', 'comments', 'comment'));
		$currentPost = $this->Post->find($_GET['id']);
		$currentId = $currentPost->id;
		$_SESSION['currentId'] = $currentId;
	}
	
	/* Affiche la liste de tous les épisodes */
	public function allEpisodes()
	{
		$posts = $this->Post->all();
		$categories = $this->Category->all();
		$this->render('posts.allEpisodes', compact('posts', 'categories'));
	}
	
	/* Affiche le premier épisode */
	public function firstEpisode()
	{
		$posts = $this->Post->firstOne();
		$categories = $this->Category->all();
		$this->render('posts.episode', compact('posts', 'categories'));
	}
	
	/* Affiche le dernier épisode */
	public function lastEpisode()
	{
		$posts = $this->Post->lastOne();
		$categories = $this->Category->all();
		$this->render('posts.episode', compact('posts', 'categories'));
	}
	
	/* Affiche l'épisode suivant */
	public function nextEpisode()
	{
		$posts = $this->Post->nextOne($_SESSION['currentId']);
		$categories = $this->Category->all();
//		var_dump($posts);
//		die();
		$this->render('posts.next_prev', compact('posts','categories'));
	}
	
	/* Affiche l'épisode précédent */
	public function previousEpisode()
	{
		$posts = $this->Post->previousOne($_SESSION['currentId']);
		$categories = $this->Category->all();
//		var_dump($posts);
//		die();
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