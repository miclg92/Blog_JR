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
		if (!empty($_POST)) {
			$auth = new DBAuth(App::getInstance()->getDb());
			if ($auth->login($_POST['username'], $_POST['password'])) {
				header('Location: index.php');
			} else {
				$errors = true;
			}
		}
		$form = new BootstrapForm($_POST);
		$this->render('users.login', compact('form', 'errors'));
	}
	
	
	public function register()
	{
		if (!empty($_POST)) {
			$errors = array();
			
			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
				$errors['username'] = "Ce pseudo n'est pas valide (alphanumérique)";
			} else {
				$user = $this->User->checkUsername($_POST['username']);
				if ($user) {
					$errors['username'] = "Ce pseudo n'est pas disponible.";
				}
			}
			
			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Cet email n'est pas valide";
			} else {
				$user = $this->User->checkUsermail($_POST['email']);
				if ($user) {
					$errors['email'] = "Cet email est déjà utilisé.";
				}
			}
			
			if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
				$errors['password'] = "Veuillez vérifier votre mot de passe";
			}
			
			$form = new BootstrapForm($_POST);
			$this->render('users.register', compact('user', 'form', 'errors'));
			
			if (empty($errors)) {
				$hashPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$token = $this->User->str_random(60);
				
				$users = $this->User->create([
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => $hashPass,
					'confirmation_token' => $token
				]);


//				CONFIRMATION DU COMPTE PAR MAIL -> PB ACCES LASTINSERTID()
//				$user_id = $this->User->lastInsertId();
//				mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien :\n\nhttp://localhost:8888/index.php?p=users.confirm.php?id=$user_id&token=$token");
//				header('Location: index.php');
//				exit();

//				header('Location: index.php');

//				$this->logged();
				
			}
			
		} else {
			$form = new BootstrapForm($_POST);
			$this->render('users.register', compact('users', 'form', 'errors'));
		}
	}
	
	public function confirm()
	{
		
		$token = $_GET['token'];
		$user = $this->User->confirm(['id']);
		
		if ($user && $user->confirmation_token == $token) {
			$this->User->updateToken();
//			die('ok');
		} else {
			die('Pas ok');
		}
	}
	
	public function logout()
	{
		// On détruit les variables de notre session
		session_unset();
		
		// On détruit notre session
		session_destroy();
		
		// On redirige le visiteur vers la page d'accueil
		header('location: index.php');
	}
	
	
}