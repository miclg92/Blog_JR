<?php

namespace Core\Entity;

class Entity
{
	/**
	 * @param $key
	 * Méthode magique qui permet d'utiliser la fonction __get quand on fait appel à une variable qui n'existe pas
	 * Exemple : url n'existe pas -> Appel a la fonction getUrl() / extrait n'existe pas -> Appel a la fonction getExtrait()
	 * @return mixed
	 */
	public function __get($key)
	{
		$method = 'get' . ucfirst($key);
		$this->$key = $this->$method();
		return $this->$key;
	}
}