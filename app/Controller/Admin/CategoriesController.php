<?php
namespace App\Controller\Admin;
use Core\HTML\BootstrapForm;

class CategoriesController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Category');
	}
	
	public function index()
	{
		$categories = $this->Category->all();
		$this->render('admin.categories.index', compact('categories'));
	}
	
	public function add()
	{
		if(!empty($_POST))
		{
			$result = $this->Category->create([
				'title' => $_POST['title']
			]);
			$_SESSION['flash']['success'] = "Cette catégorie a bien été ajoutée.";
			return $this->index();
		}
		$form = new BootstrapForm($_POST);
		$this->render('admin.categories.add', compact('form'));
	}
	
	public function edit()
	{
		$categorie = $this->Category->find($_GET['id']);
		if($categorie === false)
		{
			$this->notFound();
		}
		
		if(!empty($_POST))
		{
			$result = $this->Category->update($_GET['id'], [
				'title' => $_POST['title']
			]);
			$_SESSION['flash']['success'] = "Cette catégorie a bien été modifiée.";
			return $this->index();
		}
		$category = $this->Category->find($_GET['id']);
		$form = new BootstrapForm($category);
		$this->render('admin.categories.edit', compact('form'));
	}
	
	public function delete()
	{
		if(!empty($_POST))
		{
			$result = $this->Category->delete($_POST['id']);
			$_SESSION['flash']['success'] = "Cette catégorie a bien été supprimée.";
			return $this->index();
		}
	}
	
}