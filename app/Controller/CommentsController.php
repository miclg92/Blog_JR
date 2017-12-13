<?php
namespace App\Controller;
use Core\HTML\BootstrapForm;

class CommentsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Comment');
	}
}