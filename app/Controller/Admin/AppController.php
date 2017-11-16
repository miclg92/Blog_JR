<?php
namespace App\Controller\Admin;

use \App;
use \Core\Auth\DBAuth;

class AppController extends \App\Controller\AppController
{
	public function __construct()
	{
		parent::__construct();
		
		// On récupère l'instance et on vérifie si l'utilisateur est connecté (Auth)
		$app = App::getInstance();
		$auth = new DBAuth($app->getDb());
		if(!$auth->logged())
		{
			$this->forbidden();
		}
	}
}