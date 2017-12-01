<?php

namespace App\Table;
use Core\Table\Table;

class PostTable extends Table
{
	protected $table = 'articles';
	
/**
 * Récupère tous les articles
 * @return array
 */
	public function all()
	{
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			ORDER BY articles.date_public
		");
	}
	
/**
 * Récupère les 3 derniers articles
 * @return array
 */
	public function last()
	{
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			ORDER BY articles.id DESC LIMIT 0,3
		");
	}
	
	
	/**
	 * Récupère le premier article
	 * @return array
	 */
	public function firstOne()
	{
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			ORDER BY articles.episode LIMIT 1
		");
	}
	
 /**
 * Récupère le dernier article
 * @return array
 */
	public function lastOne()
	{
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			ORDER BY articles.episode DESC LIMIT 1
		");
	}
	
	/**
	 * Récupère l'article suivant
	 * @param $current_id
	 * @return mixed
	 */
	public function nextOne($current_id)
	{
		return $this->query("
			SELECT *
			FROM articles
			WHERE articles.id > $current_id
			ORDER BY articles.id LIMIT 1");
	}
	
	/**
	 * Récupère l'article suivant
	 * @param $current_id
	 * @return mixed
	 */
	public function previousOne($current_id)
	{
		return $this->query("
			SELECT *
			FROM articles
			WHERE articles.id < $current_id
			ORDER BY articles.id DESC LIMIT 1");
	}

	
	/**
	 * Récupère les derniers articles de la catégorie
	 * @param $category_id int
	 * @return array
	 */
	public function lastByCategory($category_id)
	{
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			WHERE articles.category_id = ?
			ORDER BY articles.date_public DESC
			", [$category_id]
		);
	}
	
	/**
	 * Récupère un article en liant la cétégorie associée, et en affichant les commentaires propres à cet article
	 * @param $id int
	 * @return \App\Entity\PostEntity
	 */
	public function findWithCategory($id)
	{
//		return $this->query("
//			SELECT articles.id, articles.episode, articles.titre, articles.contenu, categories.titre as categorie, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr
//			FROM articles
//			LEFT JOIN categories ON category_id = categories.id
//			WHERE articles.id = ?", [$id], true);
		
		return $this->query("
			SELECT articles.id, articles.episode, articles.titre, articles.contenu, DATE_FORMAT(articles.date_public, '%d/%m/%Y') AS date_public_fr, DATE_FORMAT(articles.date_modif, '%d/%m/%Y à %H:%i') AS date_modif_fr, categories.titre as categorie, comments.author as author, comments.comment as comment, DATE_FORMAT(comments.date_comment, '%d/%m/%Y') AS date_comment_fr
			FROM articles
			LEFT JOIN categories ON category_id = categories.id
			LEFT JOIN comments ON articles.id = comments.article_id
			WHERE articles.id = ?", [$id], true);
	}
//
//		return $this->query("
//			SELECT *
//			FROM articles
//			LEFT JOIN comments ON articles.id = comments.article_id
//			WHERE articles.id = ?
//			GROUP BY comments.id", [$id]);
//	}
	
	/**
	 * Récupère l'id de l'article courant
	 * @return array
	 */
	public function currentEpisodeId($currentEpisodeId)
	{
		return $this->query("
			SELECT id
			FROM articles
			WHERE id = ?", $currentEpisodeId);
	}
	
	/**
	 * Récupère l'id du premier article
	 * @return array
	 */
	public function firstEpisodeId()
	{
		$result = $this->query("
			SELECT id
			FROM articles
			ORDER BY id LIMIT 1");
		return $result;
	}
	
	/**
	 * Récupère l'id du dernier article
	 * @return array
	 */
	public function lastEpisodeId()
	{
		$result = $this->query("
			SELECT id
			FROM articles
			ORDER BY id DESC LIMIT 1");
		return $result;
	}
	
	
}