<?php
/**
 * Auteur : Ricchy DURAND
 * Version : 1.0
 * Licence : MIT
 */

namespace App\Model;

use \PDO;

class Database
{
	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_host;
	private $pdo;

	public function __construct($configs)
	{
		$this->db_name = $configs['database_name'];
		$this->db_user = $configs['username'];
		$this->db_pass = $configs['password'];
		$this->db_host = $configs['server'];
	}

	private function getPDO()
	{
		if ($this->pdo === null) {
			try{
				$pdo = new PDO ('mysql:dbname='. $this->db_name .';host=' . $this->db_host, $this->db_user, $this->db_pass);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(Exception $e){
				die('IMPOSSIBLE DE CONTACTER LA BASE DE DONNEES');
			}
			$this->pdo = $pdo;
		}
		return $this->pdo;
	}

	private function prepare($statement, $attributes)
	{
		$res = $this->getPDO()->prepare($statement);
		$res->execute($attributes);
	}

	private function query($statement, $class_name = null)
	{
		$res = $this->getPDO()->query($statement);
		if ($class_name === null) {
			$res->setFetchMode(PDO::FETCH_OBJ); // objet
		}
		else {
			$res->setFetchMode(PDO::FETCH_CLASS, $class_name); // classe
		}
		return $res->fetchall();
	}

	private function whereClause(&$conditions, &$map)
	{
		if (isset($conditions)) {
			foreach ($conditions as $key => $value) {
				switch ($key) {
					case 'AND':
						if (is_array($conditions['AND'])) {
							foreach ($conditions['AND'] as $key => $value) {
								if ($value != '' || $value != null) {
									$map .= $key . "=" . $value . " AND ";
								}
								else {
									throw new \Exception("Le champ ".$key." a une valeur null");
								}
							}
							$map = preg_replace("# AND $#", "", $map);
						}
						else {
							$conditions = null;
						}
						break;

					case 'OR':
						if (is_array($conditions['OR'])) {
							foreach ($conditions['OR'] as $key => $value) {
								if ($value != '' || $value != null) {
									$map .= $key . "=" . $value . " OR ";
								}
								else {
									throw new \Exception("Le champ ".$key." a une valeur null");
								}
							}
							$map = preg_replace("# OR $#", "", $map);
						}
						else {
							$conditions = null;
						}
						break;
					
					default:
						$conditions = null;
						break;
				}
			}
		}
	}

	public function select($table, $champs = null, $where = null)
	{
		$map = "";
		$statement = "SELECT <champs> FROM <table> WHERE <conditions>";

		//
		$this->whereClause($where, $map);
		//
		if ($where === null) {
			// Suppression de Where dans la requete de base
			$statement = preg_replace("# WHERE <conditions>#", "", $statement);
		}
		else {
			// Ajout de condition dans la requete SQL
			$statement = preg_replace("#<conditions>#", $map, $statement);
		}

		//
		$statement = preg_replace("#<table>#", $table, $statement);

		if ($champs === null || $champs === "*") {
			$statement = preg_replace("#<champs>#", "*", $statement);
		}
		else {
			$map = "";
			foreach ($champs as $value) {
				$map .= $value . ", ";
			}
			$map = preg_replace("#, $#", "", $map);
			$statement = preg_replace("#<champs>#", $map, $statement);
		}

		return $this->query($statement, '\\App\\Object\\'.ucfirst($table)); // retourne un objet
	}

	public function insert($table, $champs, $where = null)
	{
		$statement = "INSERT INTO <table> (<champs>) VALUES(<valeur>) WHERE <conditions>";

		//
		if ($where === null) {
			// Suppression de Where dans la requete de base
			$statement = preg_replace("# WHERE <conditions>#", "", $statement);
		}
		else {
			throw new \Exception("Le Where n'est pas pris en compte");
		}

		//
		$statement = preg_replace("#<table>#", $table, $statement);

		//
		$map = "";
		$strValeur = "";
		foreach ($champs as $key => $value) {
			$map .= $key . ", ";
			$strValeur .= ":" . $key . ", ";
		}
		$map = preg_replace("#, $#", "", $map);
		$strValeur = preg_replace("#, $#", "", $strValeur);
		//
		$statement = preg_replace("#<champs>#", $map, $statement);
		$statement = preg_replace("#<valeur>#", $strValeur, $statement);

		$this->prepare($statement, $champs);
	}

	public function update($table, $champs, $where = null)
	{
		$statement = "UPDATE <table> SET <fields> WHERE <conditions>";

		//
		$map = "";
		$this->whereClause($where, $map);

		//
		if ($where === null) {
			// Suppression de Where dans la requete de base
			$statement = preg_replace("# WHERE <conditions>#", "", $statement);
		}
		else {
			// Ajout de condition dans la requete SQL
			$statement = preg_replace("#<conditions>#", $map, $statement);
		}

		//
		$statement = preg_replace("#<table>#", $table, $statement); // Nom de la table

		//
		$map = "";
		$strValeur = "";
		foreach ($champs as $key => $value) {
			$map .= $key . '=:' . $key . ', ';
		}
		$map = preg_replace("#, $#", "", $map);
		$strValeur = preg_replace("#, $#", "", $strValeur);
		//
		$statement = preg_replace("#<fields>#", $map, $statement);

		$this->prepare($statement, $champs);
	}

	public function delete($table, $where = null)
	{
		$statement = "DELETE FROM <table> WHERE <conditions>";
		//
		$statement = preg_replace("#<table>#", $table, $statement); // Nom de la table

		//
		$map = "";
		$this->whereClause($where, $map);

		//
		if ($where === null) {
			// Suppression de Where dans la requete de base
			$statement = preg_replace("# WHERE <conditions>#", "", $statement);
		}
		else {
			// Ajout de condition dans la requete SQL
			$statement = preg_replace("#<conditions>#", $map, $statement);
			$this->prepare($statement, $champs);
		}
	}

}
