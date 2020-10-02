<?php

namespace App\Object;

class Personne
{
	private $id;
	private $first_name;
	private $last_name;
	private $sexe;
	private $age;

	public function __get($attr)
	{
		return $this->{$attr};
	}
}