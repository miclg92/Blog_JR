<?php
namespace Core\Auth;

use Core\Database\MysqlDatabase;

class DBAuth
{
	private $db;
	
	/**
	 * Connexion a la bdd avec injection de dépendance (Instance de MysqlDatabase)
	 * */
	public function __construct(MysqlDatabase $db)
	{
		$this->db = $db;
	}
	
	/**
	 * @return bool
	 */
	public function getUserId()
	{
		if($this->logged())
		{
			return $_SESSION['auth'];
		}
		return false;
	}
	
	/**
	 * @param $username
	 * @param $password
	 * @return bool
	 */
	public function login($username, $password)
	{
		$user = $this->db->prepare('
			SELECT *
			FROM users
			WHERE confirmed_at IS NOT NULL AND username = ?', [$username], null, true);
		
		if($user){
			$verifiedPass = password_verify($password, $user->password);
			if($verifiedPass === true ){
				$_SESSION['auth'] = $user->id;
				$_SESSION['user'] = $user;
				return true;
			}
		} return false;
	}
	
	public function loginWithId($user_id)
	{
		return $this->db->prepare('
			SELECT *
			FROM users
			WHERE id = ?', [$user_id], null, true);
	}
	
	/**
	 * @return bool
	 */
	public function logged()
	{
		return isset($_SESSION['auth']);
	}
	
}