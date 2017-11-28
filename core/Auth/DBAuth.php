<?php
namespace Core\Auth;

use Core\Database\Database;

class DBAuth
{
	private $db;
	
	//	Connexion a la bdd avec injection de dépendance
	public function __construct(Database $db)
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
			WHERE username = ?', [$username], null, true);
		
		if($user){
			$verifiedPass = password_verify($password, $user->password);
			if($verifiedPass === true ){
				$_SESSION['auth'] = $user->id;
				$_SESSION['user'] = $user;
				$_SESSION['visible_password'] = $password;
				return true;
			}
		} return false;
	}
	
	/**
	 * @return bool
	 */
	public function logged()
	{
		return isset($_SESSION['auth']);
	}

	
}