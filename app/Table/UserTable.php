<?php
namespace App\Table;

use Core\Table\Table;

class UserTable extends Table
{
	protected $table = "Users";
	
	/**
	 * Récupère tous les utilisateurs
	 * @return array
	 */
	public function allUsers()
	{
		return $this->query("
			SELECT users.id, users.username, users.email, users.password, users.flag
			FROM users
			ORDER BY users.id
		");
	}
}