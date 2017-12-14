<?php
namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{
	protected $table = "users";
	
	/**
	 * @param $email
	 * Récupère l'id d'un user avec l'email
	 * @return mixed
	 */
	public function getUserId($email)
		{
			$result = $this->query('
			SELECT id
			FROM users
			WHERE email = ?', [$email], true);
			return $result->id;
		}
	
	/**
	 * @return mixed
	 * Récupère l'ID du dernier utilisateur
	 */
	public function getLastUserId()
	{
		return $this->query('
			SELECT id
			FROM users
			WHERE id = LAST_INSERT_ID()
		', [], true);
	}
	
	/**
	 * @param $username
	 * Vérifie d'un disponibilité d'un username avec COUNT
	 * @return mixed
	 */
	public function checkUsername($username)
	{
		$result = $this->query('
			SELECT COUNT(*) AS nbUsername
			FROM users
			WHERE username = ?', [$username], true);
		return $result->nbUsername;
	}
	
	/**
	 * @param $email
	 * Vérifie d'un disponibilité d'un email avec COUNT
	 * @return mixed
	 */
	public function checkUsermail($email)
	{
		$result = $this->query('
			SELECT COUNT(*) AS nbUsermail
			FROM users
			WHERE email = ?', [$email],  true);
		return $result->nbUsermail;
	}
	
	/**
	 * @param $user_id
	 * Récupère le user avec l'ID pour la confirmation du compte par mail
	 * @return mixed
	 */
	public function confirm($user_id)
	{
		$user = $this->query('
			SELECT *
			FROM users
			WHERE id = ?',[$user_id] , true);
		return $user;
	}
	
	/**
	 * @param $user_id
	 * @param $reset_token
	 * Récupère le reset_token d'un user avec l'id
	 * @return mixed
	 */
	public function resetPassword($user_id, $reset_token)
	{
		$user = $this->query('
			SELECT *
			FROM users
			WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $reset_token], true);
		return $user;
	}
	
	/**
	 * @return mixed
	 * Récupère tous les emails des users enregistrés
	 */
	public function allUsersMails(){
		$mails = $this->query('
			SELECT email
			FROM users
			WHERE flag = 1', []);
		return $mails;
	}

}
