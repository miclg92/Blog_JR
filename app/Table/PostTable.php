<?php

namespace App\Table;
use Core\Table\Table;

class PostTable extends Table
{
	protected $table = 'episodes';
	
/**
 * Récupère tous les episodes
 * @return array
 */
	public function all()
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			ORDER BY episodes.date_episode
		");
	}
	
/**
 * Récupère les 3 derniers episodes
 * @return array
 */
	public function last()
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			ORDER BY episodes.id DESC LIMIT 0,3
		");
	}
	
	/**
	 * Récupère le premier article
	 * @return array
	 */
	public function firstOne()
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			ORDER BY episodes.id LIMIT 1
		");
	}
	
 /**
 * Récupère le dernier article
 * @return array
 */
	public function lastOne()
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			ORDER BY episodes.id DESC LIMIT 1
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
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			WHERE episodes.id > $current_id
			ORDER BY episodes.id LIMIT 1");
	}
	
	/**
	 * Récupère l'article suivant
	 * @param $current_id
	 * @return mixed
	 */
	public function previousOne($current_id)
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			WHERE episodes.id < $current_id
			ORDER BY episodes.id DESC LIMIT 1");
	}
	
	/**
	 * Récupère les episodes d'une catégorie spécifique
	 * @param $category_id int
	 * @return array
	 */
	public function lastByCategory($category_id)
	{
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, categories.title as categorie, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			INNER JOIN images ON image_id = images.id
			WHERE episodes.category_id = ?
			ORDER BY episodes.date_episode DESC
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
		return $this->query("
			SELECT episodes.id, episodes.episode, episodes.title, episodes.content, DATE_FORMAT(episodes.date_episode, '%d/%m/%Y') AS date_episode_fr, DATE_FORMAT(episodes.date_update, '%d/%m/%Y à %H:%i') AS date_update_fr, categories.title as categorie, comments.author as author, comments.comment as comment, DATE_FORMAT(comments.date_comment, '%d/%m/%Y') AS date_comment_fr, images.img_name as image_name, images.img_url as image
			FROM episodes
			LEFT JOIN categories ON category_id = categories.id
			LEFT JOIN comments ON episodes.id = comments.episode_id
			INNER JOIN images ON image_id = images.id
			WHERE episodes.id = ?", [$id], true);
	}
	
	/**
	 * Récupère l'id de l'article courant
	 * @return array
	 */
	public function currentEpisodeId($currentEpisodeId)
	{
		return $this->query("
			SELECT id
			FROM episodes
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
			FROM episodes
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
			FROM episodes
			ORDER BY id DESC LIMIT 1");
		return $result;
	}
	
	/**
	 * @param $episode Vérifie qu'un numéro d'épisode n'est pas déjà utilisé avec COUNT
	 * @return mixed
	 */
	public function checkEpisodeNumber($episode)
	{
		$result = $this->query('
			SELECT COUNT(*) AS episodeNb
			FROM episodes
			WHERE episode = ?', [$episode], true);
		return $result->episodeNb;
	}
	
	/**
	 * @param $post_id Récupère les commentaires liés à un article spécifique
	 * @return mixed
	 */
	public function getPostComments($post_id){
		$result = $this->query("
			SELECT *
			FROM comments
			WHERE episode_id = ?
			ORDER BY date_comment DESC", [$post_id]);
		return $result;
	}
	
	/**
	 * @param $post_id Récupère l'id d'un commentaire
	 * @return mixed
	 */
	public function getCommentId($post_id)
	{
		$result = $this->query('
			SELECT id
			FROM comments
			WHERE episode_id = ?', [$post_id], true);
		return $result->id;
	}
	
}