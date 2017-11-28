<?php

namespace App\Controller;

use Core\Auth\DBAuth;
use Core\HTML\BootstrapForm;
use \App;
use \PDO;
use Core\Database\MysqlDatabase;

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
				if($_SESSION['user']->flag == 1){
					$_SESSION['flash']['success']= "Vous êtes maintenant connecté en tant que Membre.";
					$this->render('users.account');
				} elseif($_SESSION['user']->flag == 2){
					$_SESSION['flash']['success']= "Vous êtes maintenant connecté en tant qu'Administrateur.";
					$this->render('posts.administration');
				}
			} else {
				$errors = true;
			}
		} else{
			$form = new BootstrapForm($_POST);
			$this->render('users.login', compact('form', 'errors', 'message'));
		}
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
				$token = $this->User->str_random(60);
				$auth = new DBAuth(App::getInstance()->getDb());
				
				$users = $this->User->create([
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => $hashPass,
					'confirmation_token' => $token
				]);
				
				if($users){
					$auth->login($_POST['username'], $_POST['password']);
					$auth->logged();
				}
				
				$_SESSION['flash']['success']= "Votre compte a bien été créé, et vous êtes maintenant connecté.";
				$this->render('users.account');


//				CONFIRMATION DU COMPTE PAR MAIL -> PB ACCES LASTINSERTID()
//				$user_id = $auth->getUserId();
				$user_id = $_SESSION['auth'];
				$mail = mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien :\n\nhttp://localhost:8888/index.php?p=users.confirm.php?id=$user_id&token=$token");
//				var_dump($mail);
//				die();
//				header('Location: index.php');
				exit();
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
			header('Location: index.php?p=users.account');
		} else {
			header('Location: index.php?p=users.login');
		}
	}
	
	public function logout()
	{
		// On détruit les variables de notre session
		session_unset();
		
		// On détruit notre session
		session_destroy();
		
		session_start();
		$_SESSION['flash']['success'] = "Vous êtes bien déconnecté. A bientôt !";
		header('location: index.php');
	}
	
	public function account()
	{
		$this->render('users.account', compact(''));
	}
	
	public function edit()
	{
		if (!empty($_POST)) {
			$errors = array();
			
			if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
				$errors['username'] = "Ce pseudo n'est pas valide (alphanumérique).";
			} else {
				$user = $this->User->checkUsername($_POST['username']);
				if ($user > 1) {
					$errors['username'] = "Ce pseudo n'est pas disponible.";
				}
			}
			
			if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Cet email n'est pas valide.";
			} else {
				$user = $this->User->checkUsermail($_POST['email']);
				if ($user > 1) {
					$errors['email'] = "Cet email est déjà utilisé.";
				}
			}
			
			if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
				$errors['password'] = "Veuillez vérifier votre mot de passe.";
			}
			
			if (empty($errors)) {
				$hashPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$updatedUser = $this->User->update($_GET['id'], [
					'username' => $_POST['username'],
					'email' => $_POST['email'],
					'password' => $hashPass
				]);
				$_SESSION['flash']['success']= "Votre compte a bien été mis à jour.";
				
				if ($updatedUser) {
					$_SESSION['user']->username = $_POST['username'];
					$_SESSION['user']->email = $_POST['email'];
					$_SESSION['user']->password = $_POST['password']; // Probleme nouveau mdp qui ne s'affiche pas, mais il s'enregistre bien dans la bdd, et il s'affiche bien si logout puis login
					return $this->account();
				}
				$this->render('users.account');
			}
		}
		$user = $_SESSION['user'];
		$form = new BootstrapForm($user);
		$this->render('users.edit', compact('user', 'form', 'errors'));
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
				$reset_token = $this->User->str_random(60);
				$user_id = $this->User->getUserId($_POST['email']);
				
				$this->User->update($user_id, [
					'reset_token' => $reset_token,
					'reset_at' => date('Y-m-d H:i:s')
				]);
				
				$_SESSION['flash']['success'] = "Les instructions de réinitialisation de mot de passe vous ont été envoyées par email.";
				mail($_POST['email'], 'Réinitialisation de votre compte', "Afin de réinitialiser votre mot de passe, merci de cliquer sur ce lien :\n\nhttp://localhost:8888/index.php?p=users.reset.php?id=$user_id&token=$reset_token");
				$form = new BootstrapForm($_POST);
				$this->render('users.login', compact('user', 'form', 'errors'));
				exit();
			} else {
				$errors = true;
			}
		}
		$form = new BootstrapForm($_POST);
		$this->render('users.forget', compact('user', 'form', 'errors'));
	}
	
	
	
	
}