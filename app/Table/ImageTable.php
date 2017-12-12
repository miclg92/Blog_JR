<?php


namespace App\Table;
use Core\Table\Table;

class ImageTable extends Table
{
	protected $image = "images";
	
	/**
	 * @return mixed Récupère l'id de la dernière image uploadée
	 */
	public function getImageId()
	{
		return $this->query('
			SELECT id
			FROM images
			WHERE id = LAST_INSERT_ID()
		', [], true);
	}
	
}
