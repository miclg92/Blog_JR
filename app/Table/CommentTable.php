<?php

namespace App\Table;
use Core\Table\Table;

class CommentTable extends Table
{
	protected $table = "Comments";
	
	public function getSignaledComments(){
		return $this->query('
			SELECT *
			FROM comments
			WHERE is_signaled = 1');
	}
	
	
}