<?php
use Core\Config;
use Core\Database\MysqlDatabase;

/**
 * Class App FACTORY
 */
class App
{
	public $title = 'Billet simple pour l\'Alaska, Roman en ligne de Jean Forteroche';
	private $db_instance;
	private static $_instance;
	
	/**
	 * @param $file
	 * Fonction statique permettant de récupérer une instance unique de la classe (SINGLETON)
	 * @return Config
	 */
	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new App();
		}
		return self::$_instance;
	}
	
	/**
	 * Charge les autoloaders
	 */
	public static function load()
	{
		session_start();
		require ROOT . '/app/Autoloader.php';
		App\Autoloader::register();
		require ROOT . '/core/Autoloader.php';
		Core\Autoloader::register();
	}
	
	/**
	 * @param $name
	 * Récupère le nom de la table automatiquement
	 * @return mixed
	 */
	public function getTable($name)
	{
		$class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
		return new $class_name($this->getDb());
	}
	
	/**
	 * @return MysqlDatabase
	 * Récupère les infos de connexion a la bdd automatiquement
	 */
	public function getDb()
	{
		// SINGLETON
		$config = Config::getInstance(ROOT . '/config/config.php');
		if(is_null($this->db_instance))
		{
			$this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
		}
		return $this->db_instance;
	}
}