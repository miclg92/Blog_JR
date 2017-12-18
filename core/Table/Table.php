<?php

namespace Core\Table;

use Core\Database\Database;
use Core\Database\MysqlDatabase;


class Table
{
	protected $table;
	protected $db;
	
	/**
	 * Table constructor.
	 * Récupère le nom de la table à partir du nom de la classe (FACTORY)
	 * @param Database $db
	 */
	public function __construct(MysqlDatabase $db)
	{
		$this->db = $db;
		if(is_null($this->table))
		{
			$parts = explode('\\', get_class($this));
			$class_name = end($parts);
			$this->table = strtolower(str_replace('Table', '', $class_name)) . 's';
		}
	}
	
	/**
	 * @param $statement
	 * @param null $attributes
	 * @param bool $one
	 * @return mixed
	 */
	public function query($statement, $attributes = null, $one = false)
	{
		if($attributes)
		{
			// Requete préparée si les attributs sont définis
			return $this->db->prepare(
				$statement,
				$attributes,
				str_replace('Table', 'Entity', get_class($this)),
				$one
			);
		// Sinon requete simple
		} else {
			return $this->db->query(
				$statement,
				str_replace('Table', 'Entity', get_class($this)),
				$one
			);
		}
	}
	
	/**
	 * @return mixed
	 * Récupère tous les éléments d'une table
	 */
	public function all()
	{
		return $this->query('
		SELECT *
		FROM ' . $this->table
		);
	}
	
	/**
	 * @param $id
	 * Récupère tous les éléments d'une table ayant un ID spécifique
	 * @return mixed
	 */
	public function find($id)
	{
		return $this->query("
			SELECT *
			FROM {$this->table}
			WHERE id = ?", [$id], true
		);
	}
	
	/**
	 * @param $id
	 * @param $fields
	 * Met à jour les données d'une table
	 * @return mixed
	 */
	public function update($id, $fields)
	{
		$sql_parts = [];
		$attributes = [];
		
		foreach ($fields as $k => $v)
		{
			$sql_parts[] = "$k = ?";
			$attributes[] = $v;
		}
		$attributes[] = $id;
		$sql_part = implode(', ', $sql_parts);
		return $this->query("UPDATE {$this->table} SET $sql_part WHERE id = ?", $attributes, true);
	}
	
	/**
	 * @param $id
	 * Supprime une élément d'une table
	 * @return mixed
	 */
	public function delete($id)
	{
		return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
	}
	
	/**
	 * @param $fields
	 * Créé un élément d'une table
	 * @return mixed
	 */
	public function create($fields)
	{
		$sql_parts = [];
		$attributes = [];
		
		foreach ($fields as $k => $v)
		{
			$sql_parts[] = "$k = ?";
			$attributes[] = $v;
		}
		$sql_part = implode(', ', $sql_parts);
		return $this->query("INSERT INTO {$this->table} SET $sql_part", $attributes, true);
	}
	
	/**
	 * @param $key
	 * @param $value
	 * Récupère tous les enregistrements, et créé un tableau pour chaque enregistrement
	 * @return array
	 */
	public function extract($key, $value)
	{
		$records = $this->all();
		$return = [];
		foreach($records as $v)
		{
			$return[$v->$key] = $v->$value;
		}
		return $return;
	}
	
}