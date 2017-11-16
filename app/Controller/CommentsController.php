<?php

namespace App\Controller;

use Core\HTML\BootstrapForm;

class CommentsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('comment');
		$this->loadModel('Post');
	}
	
	public function index()
	{
			$comments = $this->comment->all();
			$this->render('comments.index', compact('comments'));
	}
	
	public function add()
	{
		if (!empty($_POST)) {
			$result = $this->comment->create([
				'author' => $_POST['author'],
				'comment' => $_POST['comment'],
			]);
			return $this->index();
		}
		
		$form = new BootstrapForm($_POST);
		$this->render('comments.add', compact('form'));
	}
	
}