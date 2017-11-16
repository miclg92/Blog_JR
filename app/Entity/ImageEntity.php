<?php

namespace App\Entity;
use Core\Entity\Entity;

class ImageEntity extends Entity
{
	public function getUrl()
	{
		return 'index.php?p=posts.image&id=' . $this->id;
	}
	
}