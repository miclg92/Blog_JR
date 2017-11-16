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
	}
	
	/* Affiche la liste de tous les épisodes */
	public function indexall()
	{
		$posts = $this->Post->all();
		$categories = $this->Category->all();
		$this->render('posts.indexall', compact('posts', 'categories'));
	}
	
	/* Affiche la liste des 3 derniers épisodes */
	public function index()
	{
		$posts = $this->Post->last();
		$categories = $this->Category->all();
		$this->render('posts.index', compact('posts', 'categories'));
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
	
	/* Affiche un épisode en particulier avec la catégorie correspondante */
	public function show()
	{
		$article = $this->Post->findWithCategory($_GET['id']);
		$this->render('posts.show', compact('article'));
	}
	
	/* Affiche la liste des épisodes à administrer (Episodes et catégories) */
	public function indexadmin()
	{
		$errors = false;
		$form = new BootstrapForm($_POST);
		$this->render('posts.indexadmin', compact('posts', 'categories', 'form', 'errors'));
	}
	

}