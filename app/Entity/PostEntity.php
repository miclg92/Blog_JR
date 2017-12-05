<?php
namespace App\Entity;
use Core\Entity\Entity;

class PostEntity extends Entity
{
	public function getUrl()
	{
		return 'index.php?p=posts.show&id=' . $this->id;
	}
	
	public function getExtrait()
	{
		$html = '<p class="extrait_episode">' . substr($this->contenu, 0, 400) . '...</p>';
		$html .= '<p class="btn_lire_episode"><a href="' . $this->getURL() . '"><i class="fa fa-file-o" aria-hidden="true"></i>
Lire l\'épisode</a></p>';
		return $html;
	}
	
}