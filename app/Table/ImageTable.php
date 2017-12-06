<?php


namespace App\Table;
use Core\Table\Table;

class ImageTable extends Table
{
	protected $image = "Images";
	
	public function getImageId()
	{
		return $this->query('
			SELECT id
			FROM images
			WHERE id = LAST_INSERT_ID()
		', [], true);
	}
	
}