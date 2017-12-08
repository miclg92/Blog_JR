<?php

namespace App\Table;
use Core\Table\Table;

class CommentTable extends Table
{
	protected $table = "comments";
	
	public function getSignaledComments(){
		return $this->query('
			SELECT *
			FROM comments
			WHERE is_signaled = 1');
	}
	
	
}
