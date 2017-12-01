<?php
namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{
	protected $table = "Users";
	
	public function getUserId($email)
		{
			$result = $this->query('
			SELECT id
			FROM users
			WHERE email = ?', [$email], true);
			return $result->id;
		}
	
	public function checkUsername($username)
	{
		$result = $this->query('
			SELECT COUNT(*) AS nbUsername
			FROM users
			WHERE username = ?', [$username], true);
		return $result->nbUsername;
	}

	public function checkUsermail($email)
	{
		$result = $this->query('
			SELECT COUNT(*) AS nbUsermail
			FROM users
			WHERE email = ?', [$email],  true);
		return $result->nbUsermail;
	}
	
	// Confirmation du compte par mail (confirmation_token)
	public function confirm($user_id)
	{
		$user =  $this->query('
			SELECT *
			FROM users
			WHERE id= ?',[$user_id] , true);
		return $user;
	}
	
	// Quand le compte est confirmé, supprimer le token, et ajouter la date de confirmation du compte à la BDD
	public function updateToken($user_id)
	{
		$this->query('
			UPDATE users
			SET confirmation_token = NULL, confirmed_at = NOW()
			WHERE id = ?',[$user_id] , true);
	}

	
	public function reset($user_id, $reset_token)
	{
		$this->query('
			SELECT *
			FROM users
			WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $reset_token], true);
	}
	
	public function rememberMe($remember_token, $user_id)
	{
		$this->query('
			UPDATE users
			SET remember_token = ?
			WHERE id = ?',[$remember_token, $user_id]);
//		var_dump($result);
//		die();
	}


}