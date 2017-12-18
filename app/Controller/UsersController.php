<?php

namespace App\Controller;

use \Core\Auth\DBAuth;
use \Core\HTML\BootstrapForm;
use \App;
use Core\Functions\Str;

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
			$auth = new DBAuth(App::getDb());
			if ($auth->login($_POST['username'], $_POST['password'])) {
				
				if(isset($_POST['remember']) && $_POST['remember']){
					$remember_token = Str::str_random(250);
					$user_id = $_SESSION['auth'];
					$this->User->update($user_id, [
						'remember_token' => $remember_token,
					]);
					setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'ratonslaveurs'), time() + 60 * 60 * 24 * 7, '/', null, null, true);
				}
				
				if($_SESSION['user']->flag == 1){
					$_SESSION['flash']['success']= "Vous êtes maintenant connecté en tant que Membre.";
					$this->render('users.account');
				} elseif($_SESSION['user']->flag == 2){
					$_SESSION['flash']['success']= "Vous êtes maintenant connecté en tant qu'Administrateur.";
					$this->render('posts.administration');
				}
			} else {
				$errors = true;
				$form = new BootstrapForm($_POST);
				$this->render('users.login', compact('form', 'errors', 'message'));
			}
		} else{
			$form = new BootstrapForm($_POST);
			$this->render('users.login', compact('form', 'errors', 'message'));
		}
	}
	
	public function logout()
	{
		setcookie('remember', NULL, -1, '/', null, null, true);
		// On détruit les variables de notre session
		session_unset();
		// On détruit notre session
		session_destroy();
		session_start();
		$_SESSION['flash']['success'] = "Vous êtes bien déconnecté. A bientôt !";
		header('location: index.php');
	}
	
	public function register()
	{
		if (!empty($_POST)) {
			$errors = array();
			
			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
				$errors['username'] = "Ce pseudo n'est pas valide (alphanumérique).";
			} else {
				$user = $this->User->checkUsername($_POST['username']);
				if ($user) {
					$errors['username'] = "Ce pseudo n'est pas disponible.";
				}
			}
			
			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Cet email n'est pas valide.";
			} else {
				$user = $this->User->checkUsermail($_POST['email']);
				if ($user) {
					$errors['email'] = "Cet email est déjà utilisé.";
				}
			}
			
			if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
				$errors['password'] = "Veuillez vérifier votre mot de passe.";
			}
			
			if (empty($errors)) {
				$hashPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$token = Str::str_random(60);
				$auth = new DBAuth(App::getDb());

				$users = $this->User->create([
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => $hashPass,
					'confirmation_token' => $token
				]);

				// Envoi d'un email à l'utilisateur
				$user_array = $this->User->getLastUserId();
				$user_obj = $user_array;
				$user_id = $user_obj->id;
				mail(
					$_POST['email'],
					'Confirmation de votre compte',
					"Bonjour. \n\nAfin de valider votre compte, merci de cliquer sur ce lien :\n\nhttps://www.legoarant.com/projet4/public/index.php?p=users.confirm.php?&id=$user_id&token=$token\n\nA bientôt.\n\nJean Forteroche",
					'From: "Jean Forteroche"<jforteroche@gmail.com>'. "\r\n" .
					'Reply-To: jforteroche@gmail.com' . "\r\n"
				);
				$_SESSION['flash']['success']= "Un email vous a été envoyé afin de valider votre compte.";
				header('Location: index.php');
				exit();
			
			} else {
				$form = new BootstrapForm($_POST);
				$this->render('users.register', compact('users', 'form', 'errors'));
			}
		} else {
			$form = new BootstrapForm($_POST);
			$this->render('users.register', compact('users', 'form', 'errors'));
		}
	}
	
	public function confirm()
	{
		$token = $_GET['token'];
		$id = $_GET['id'];
		$user = $this->User->confirm($id);
		
		if ($user && $user->confirmation_token == $token) {
			$_SESSION['user'] = $user;
			$user_id = $user->id;
			$this->User->update($user_id, [
				'confirmation_token' => NULL,
				'confirmed_at' => date('Y-m-d H:i:s')
			]);
			$_SESSION['flash']['success']= "Votre compte a bien été confimé. Connectez-vous dès maintenant !";
			header('location: index.php');
		} else {
			$_SESSION['flash']['danger']= "Ce lien n'est plus valide, vous avez déjà confirmé votre compte.";
			header('location: index.php');
		}
	}
	
	public function account()
	{
		$this->render('users.account', compact(''));
	}
	
	public function edit()
	{
		$user_id = $this->User->find($_GET['id'])->id;
		if($user_id !== $_SESSION['auth'])
		{
			$this->forbidden();
		}
		
		if (!empty($_POST)) {
			$errors = array();
			
			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
				$errors['username'] = "Ce pseudo n'est pas valide (alphanumérique).";
			} else {
				if($_POST['username'] == $_SESSION['user']->username){
				} else{
					$user = $this->User->checkUsername($_POST['username']);
					if ($user) {
						$errors['username'] = "Ce pseudo n'est pas disponible.";
					}
				}
			}
			
			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Cet email n'est pas valide.";
			} else {
				if($_POST['email'] == $_SESSION['user']->email){
				} else{
					$user = $this->User->checkUsermail($_POST['email']);
					if ($user) {
						$errors['email'] = "Cet email est déjà utilisé.";
					}
				}
			}
			
			if (empty($errors)) {
				$updatedUser = $this->User->update($_GET['id'], [
					'username' => $_POST['username'],
					'email' => $_POST['email'],
				]);
				$_SESSION['flash']['success']= "Votre compte a bien été mis à jour.";
				
				if ($updatedUser) {
					$_SESSION['user']->username = $_POST['username'];
					$_SESSION['user']->email = $_POST['email'];
					return $this->account();
				}
				$this->render('users.account');
			}
		}
		$user = $_SESSION['user'];
		$form = new BootstrapForm($user);
		$this->render('users.edit', compact('user', 'form', 'errors'));
	}
	
	public function changePasswd()
	{
		$user_id = $this->User->find($_GET['id'])->id;
		if($user_id !== $_SESSION['auth'])
		{
			$this->forbidden();
		}
		
		if (!empty($_POST)) {
			$errors = array();
			
			if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
				$errors['password'] = "Veuillez vérifier votre mot de passe.";
			}
			
			if (empty($errors)) {
				$hashPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$this->User->update($_GET['id'], [
					'password' => $hashPass
				]);
				$_SESSION['flash']['success']= "Votre mot de passe a bien été mis à jour.";
				$this->render('users.account');
			}
		}
		$user = $_SESSION['user'];
		$form = new BootstrapForm($user);
		$this->render('users.changePasswd', compact('user', 'form', 'errors'));
	}
	
	public function delete(){
		if(!empty($_POST))
		{
			$result = $this->User->delete($_POST['id']);
			session_unset();
			session_destroy();
			session_start();
			$_SESSION['flash']['success'] = "Votre compte a été supprimé.";
			header('location: index.php');
		}
	}
	
	public function forget(){
		$errors = false;
		
		if(!empty($_POST) && !empty($_POST['email'])){
			$user = $this->User->checkUsermail($_POST['email']);
			if($user == 1){
				$reset_token = Str::str_random(60);
				$user_id = $this->User->getUserId($_POST['email']);
				
				$this->User->update($user_id, [
					'reset_token' => $reset_token,
					'reset_at' => date('Y-m-d H:i:s')
				]);
				
				// Envoi d'un email à l'utilisateur
				$_SESSION['flash']['success'] = "Les instructions de réinitialisation de mot de passe vous ont été envoyées par email.";
				mail(
					$_POST['email'],
					'Réinitialisation de votre compte',
					"Bonjour. \n\nAfin de réinitialiser votre mot de passe, merci de cliquer sur ce lien :\n\nhttps://www.legoarant.com/projet4/public/index.php?p=users.reset.php?&id=$user_id&token=$reset_token\n\nA bientôt.\n\nJean Forteroche",
					'From: "Jean Forteroche"<jforteroche@gmail.com>'. "\r\n" .
					'Reply-To: jforteroche@gmail.com' . "\r\n"
				);
				header('Location: index.php');
				exit();
			} else {
				$errors = true;
			}
		}
		$form = new BootstrapForm($_POST);
		$this->render('users.forget', compact('user', 'form', 'errors'));
	}
	
	
	public function reset()
	{
		$errors = false;
		
		if (isset($_GET['id']) && isset($_GET['token'])) {
			$user = $this->User->resetPassword($_GET['id'], $_GET['token']);
			if ($user) {
				if (!empty($_POST)) {
					if (!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
						$hashPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
						$this->User->update($_GET['id'], [
							'password' => $hashPass,
							'reset_token' => NULL,
							'reset_at' => NULL
						]);
						$_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié. Vous pouvez vous connecter.";
						$_SESSION['user'] = $user;
						header('Location: index.php');
						exit();
					} else {
						$errors = true;
					}
				}
			} else {
				$_SESSION['flash']['danger'] = "Ce lien n'est plus valide.";
				header('Location: index.php');
				exit();
			}
		} else {
			header('Location: index.php');
			exit();
		}
		$form = new BootstrapForm($_POST);
		$this->render('users.reset', compact('user', 'form', 'errors'));
	}
	
	
}