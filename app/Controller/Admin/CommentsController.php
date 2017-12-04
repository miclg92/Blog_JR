<?php
namespace App\Controller\Admin;
use Core\HTML\BootstrapForm;

class CommentsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Comment');
	}
	
	public function index()
	{
		$comments = $this->Comment->all();
		$signaled_comments = $this->Comment->getSignaledComments();
		$this->render('admin.comments.index', compact('comments', 'signaled_comments'));
	}

	public function edit()
	{
		if(!empty($_POST))
		{
			$result = $this->Comment->update($_GET['id'], [
			'comment' => $_POST['comment'],
			'is_signaled' => 0
			]);
			$_SESSION['flash']['success'] = "Ce commentaire a bien été modifié.";
			return $this->index();
		}
		$comment = $this->Comment->find($_GET['id']);
		$commentContent = $comment->comment;
		$form = new BootstrapForm($commentContent);
		$this->render('admin.comments.edit', compact('form', 'commentContent'));
	}

	public function delete()
	{
		if(!empty($_POST))
		{
			$result = $this->Comment->delete($_POST['id']);
			$_SESSION['flash']['success'] = "Ce commentaire a bien été supprimé.";
			return $this->index();
		}
	}
	
	
}