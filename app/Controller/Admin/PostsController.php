<?php
namespace App\Controller\Admin;
use Core\HTML\BootstrapForm;

class PostsController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Post');
	}
	
	public function index()
	{
		$posts = $this->Post->all();
		$this->render('admin.posts.index', compact('posts'));
	}
	
	public function add()
	{
		if(!empty($_POST))
		{
			$result = $this->Post->create([
				'episode' => $_POST['episode'],
				'titre' => $_POST['titre'],
				'contenu' => $_POST['contenu'],
				'category_id' => $_POST['category_id'],
				'image_id' => $_POST['image_id'],
			]);
			
			if($result)
			{
				return $this->index();
			}
		}
		/*$this->loadModel('Category');
		$categories = $this->Category->extract('id', 'titre');
		$form = new BootstrapForm($_POST);
		$this->render('admin.posts.edit', compact('categories', 'form'));*/
		
		$this->loadModel('Category');
		$categories = $this->Category->extract('id', 'titre');
		$this->loadModel('Image');
		$images = $this->Image->extract('id', 'nom');
		$form = new BootstrapForm($_POST);
		$this->render('admin.posts.add', compact('categories', 'images', 'form'));
	}
	
	public function edit()
	{
		if(!empty($_POST))
		{
			$result = $this->Post->update($_GET['id'], [
				'episode' => $_POST['episode'],
				'titre' => $_POST['titre'],
				'contenu' => $_POST['contenu'],
				'category_id' => $_POST['category_id'],
				'image_id' => $_POST['image_id'],
				'date_modif' => date('Y-m-d H:i:s')
			]);
			
			if($result)
			{
				return $this->index();
			}
		}
		
		$post = $this->Post->find($_GET['id']);
		
		$this->loadModel('Category');
		$categories = $this->Category->extract('id', 'titre');
		$this->loadModel('Image');
		$images = $this->Image->extract('id', 'nom');
		$form = new BootstrapForm($post);
		$this->render('admin.posts.edit', compact('categories', 'images', 'form'));
	}
	
	public function delete()
	{
		if(!empty($_POST))
		{
			$result = $this->Post->delete($_POST['id']);
			return $this->index();
		}
	}
	
}