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
	
	/* Affiche la liste de tous les épisodes */
	public function allEpisodes()
	{
		$posts = $this->Post->all();
		$categories = $this->Category->all();
		$this->render('posts.allEpisodes', compact('posts', 'categories'));
	}
	
	/* Affiche le dernier épisode */
	public function lastEpisode()
	{
		$posts = $this->Post->lastOne();
		$categories = $this->Category->all();
		$this->render('posts.lastEpisode', compact('posts', 'categories'));
	}
	
	/* Affiche le premier épisode */
	public function firstEpisode()
	{
		$posts = $this->Post->firstOne();
		$categories = $this->Category->all();
		$this->render('posts.firstEpisode', compact('posts', 'categories'));
	}
	
	/* Affiche l'épisode suivant */
	public function nextEpisode()
	{
		$posts = $this->Post->nextOne();
		$categories = $this->Category->all();
		$this->render('posts.nextEpisode', compact('posts',  'categories'));
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
	
	/* Affiche un épisode en particulier avec la catégorie correspondante et les commentaires correspondants */
	public function show()
	{
		if (!empty($_POST)) {
			$result = $this->comment->create([
				'author' => $_POST['author'],
				'comment' => $_POST['comment'],
				'article_id' => $_POST['id']
			]);
			return $this->index();
		}
		$article = $this->Post->findWithCategory($_GET['id']);
		$form = new BootstrapForm($_POST);
		$this->render('posts.show', compact('article', 'form', 'result'));
	}
	
//	/* Affiche le formulaire d'ajout d'un commentaire sur un épisode en particulier */
//	public function addComment()
//	{
//		if (!empty($_POST)) {
//			$result = $this->comment->create([
//				'author' => $_POST['author'],
//				'comment' => $_POST['comment'],
//				'article_id' => $_POST['id']
//			]);
//			return $this->index();
//		}
//
//		$article = $this->Post->findWithCategory($_GET['id']);
//		$form = new BootstrapForm($_POST);
//		$this->render('posts.show', compact('article', 'form', 'comment'));
//	}
//
//	/* Affiche les commentaires d'un épisode en particulier */
//	public function showComments()
//	{
//		$comments = $this->comment->all();
//		$this->render('posts.show', compact('comments'));
//	}
//
	
	/* Affiche la liste des épisodes à administrer (Episodes et catégories) */
	public function administration()
	{
		$errors = false;
		$form = new BootstrapForm($_POST);
		$this->render('posts.administration', compact('posts', 'categories', 'form', 'errors'));
	}

	

}