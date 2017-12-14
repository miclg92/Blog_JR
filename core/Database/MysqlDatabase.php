<?php
namespace Core\Database;
use \PDO;

class MysqlDatabase extends Database
{
	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_host;
	private $pdo;
	
	/**
	 * MysqlDatabase constructor.
	 * @param $db_name
	 * @param string $db_user
	 * @param string $db_pass
	 * @param string $db_host
	 */
	public function __construct($db_name, $db_user = 'dbo713703916', $db_pass = 'Bordeaux1980*', $db_host = 'db713703916.db.1and1.com')
	{
		$this->db_name = $db_name;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_host = $db_host;
	}
	
	/**
	 * @return PDO Permet de n'accéder qu'une seule fois à la base de données
	 */
	private function getPDO()
	{
		if ($this->pdo === null) {
			$pdo = new PDO('mysql:dbname=db713703916;host=db713703916.db.1and1.com', 'dbo713703916', 'Bordeaux1980*');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		}
		return $this->pdo;
	}
	
	/**
	 * @param $statement
	 * @param null $class_name
	 * @param bool $one
	 * @return array|mixed|\PDOStatement
	 */
	public function query($statement, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->query($statement);
		
		if(
			strpos($statement, 'UPDATE') === 0 ||
			strpos($statement, 'INSERT') === 0 ||
			strpos($statement, 'DELETE') === 0
		) {
			return $req;
		}
		
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		} else {
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		
		if($one)
		{
			$datas = $req->fetch();
		} else {
			$datas = $req->fetchAll();
		}
		return $datas;
	}
	
	/**
	 * @param $statement
	 * @param $attributes
	 * @param null $class_name
	 * @param bool $one
	 * @return array|bool|mixed
	 */
	public function prepare($statement, $attributes, $class_name = null, $one = false)
	{
		$req = $this->getPDO()->prepare($statement);
		$res = $req->execute($attributes);
		
		if(
			strpos($statement, 'UPDATE') === 0 ||
			strpos($statement, 'INSERT') === 0 ||
			strpos($statement, 'DELETE') === 0
		) {
			return $res;
		}
		
		/**
		 * Définit le fetchStyle selon si la $class_name existe ou pas
		 */
		if ($class_name === null)
		{
			$req->setFetchMode(PDO::FETCH_OBJ);
		} else {
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		
		/**
		 * Définit le type de fetch utilisé
		 */
		if($one)
		{
			$datas = $req->fetch();
		} else {
			$datas = $req->fetchAll();
		}
		
		return $datas;
	}
	
	/**
	 * @return string
	 * Récupère de dernier ID inséré dans la bdd
	 */
	public function lastInsertId()
	{
		return $this->getPDO()->lastInsertId();
	}
}