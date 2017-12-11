<?php
namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{
	protected $table = "users";
	
	public function getUserId($email)
		{
			$result = $this->query('
			SELECT id
			FROM users
			WHERE email = ?', [$email], true);
			return $result->id;
		}
	
	public function getLastUserId()
	{
		return $this->query('
			SELECT id
			FROM users
			WHERE id = LAST_INSERT_ID()
		', [], true);
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
		$user = $this->query('
			SELECT *
			FROM users
			WHERE id = ?',[$user_id] , true);
		return $user;
	}
	
	public function resetPassword($user_id, $reset_token)
	{
		$user = $this->query('
			SELECT *
			FROM users
			WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $reset_token], true);
		return $user;
	}
	
	public function allUsersMails(){
		$mails = $this->query('
			SELECT email
			FROM users
			WHERE flag = 1', []);
		return $mails;
	}
	
	

}
