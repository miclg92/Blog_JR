<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;

class UsersController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('User');
	}
	
	public function login()
	{
		$errors = false;
		if(!empty($_POST))
		{
			$auth = new DBAuth(App::getInstance()->getDb());
			if ($auth->login($_POST['username'], $_POST['password']))
			{
				header('Location: index.php?p=users.login');
			} else {
				$errors = true;
			}
	}
	$form = new BootstrapForm($_POST);
	$this->render('users.login', compact('form', 'errors'));
	}
	
	public function register()
	{
		$errors = array();
		
		if (!empty($_POST)) {
			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
				$errors['username'] = "Veuillez indiquer un pseudo valide";
			}
			
			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Veuillez indiquer un email valide";
			}
			
			if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
				$errors['password'] = "Veuillez indiquer un mot de passe valide";
			}
			
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$users = $this->User->create([
				'username' => $_POST['username'],
				'email' => $_POST['email'],
				'password' => $password
			]);
			
		} else{
			$form = new BootstrapForm($_POST);
			$this->render('users.register', compact('users', 'form', 'errors'));
		}
	}
	
}