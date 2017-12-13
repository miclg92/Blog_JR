<?php
namespace Core;

class Config
{
	private $settings = [];
	private static $_instance;
	
	/**
	 * Config constructor.
	 * @param $file
	 */
	public function __construct($file)
	{
		$this->settings = require($file);
	}
	
	/**
	 * @param $file
	 * Fonction statique permettant de récupérer une instance unique de la classe (SINGLETON)
	 * @return Config
	 */
	public static function getInstance($file)
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Config($file);
		}
		return self::$_instance;
	}
	
	/**
	 * @param $key
	 * Récupère la clé demandée
	 * @return mixed|null
	 */
	public function get($key)
	{
		if (isset($this->settings[$key]))
		{
			return null;
		}
		return $this->settings[$key];
	}
	
}