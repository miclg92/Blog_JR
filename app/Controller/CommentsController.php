<?php
//
//namespace App\Controller;
//
//use Core\HTML\BootstrapForm;
//
//class CommentsController extends AppController
//{
//	public function __construct()
//	{
//		parent::__construct();
//		$this->loadModel('Post');
//		$this->loadModel('Category');
//		$this->loadModel('comment');
//	}
//
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
//
//
//}