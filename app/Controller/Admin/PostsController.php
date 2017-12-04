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
		if(!empty($_POST)){
			$errors = array();
			
			if(empty($_POST['episode'])) {
				$errors['episode'] = "Numéro d'épisode manquant.";
			} else {
				$episode = $this->Post->checkEpisodeNumber($_POST['episode']);
				if ($episode) {
					$errors['episode'] = "Ce numéro d'épisode est déjà utilisé.";
				}
			}
			
			if(empty($_POST['titre']) || empty($_POST['contenu'])) {
				$errors['titre'] = "Titre manquant.";
			}
			
			if(empty($_POST['contenu'])) {
				$errors['contenu'] = "Contenu manquant.";
			}
			
			if (empty($errors)) {
				$result = $this->Post->create([
					'episode' => $_POST['episode'],
					'titre' => $_POST['titre'],
					'contenu' => $_POST['contenu'],
					'category_id' => $_POST['category_id'],
					'image_id' => $_POST['image_id'],
				]);
				if($result) {
					$_SESSION['flash']['success'] = "Cet épisode a bien été ajouté.";
					return $this->index();
				}
			} else {
				$this->loadModel('Category');
				$categories = $this->Category->extract('id', 'titre');
				$this->loadModel('Image');
				$images = $this->Image->extract('id', 'nom');
				$form = new BootstrapForm($_POST);
				$this->render('admin.posts.add', compact('categories', 'images', 'form', 'errors'));
			}
		} else{
			$this->loadModel('Category');
			$categories = $this->Category->extract('id', 'titre');
			$this->loadModel('Image');
			$images = $this->Image->extract('id', 'nom');
			$form = new BootstrapForm($_POST);
			$this->render('admin.posts.add', compact('categories', 'images', 'form', 'errors'));
		}
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
				$_SESSION['flash']['success'] = "Cet épisode a bien été modifié";
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
			$_SESSION['flash']['success'] = "Cet épisode a bien été supprimé";
			return $this->index();
		}
	}
	
}