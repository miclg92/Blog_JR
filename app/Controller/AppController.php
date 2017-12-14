<?php
namespace App\Controller;

use Core\Controller\Controller;
use \App;

class AppController extends Controller
{
	protected $template = 'default';
	
	public function __construct()
	{
		$this->viewPath = ROOT . '/app/Views/';
	}
	
	/**
	 * @param $model_name
	 * Charge la table concernée
	 */
	protected function loadModel($model_name)
	{
		$this->$model_name = App::getTable($model_name);
	}
}