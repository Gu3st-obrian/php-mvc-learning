<?php

namespace App\Manager;

class Manager
{
	protected $api;

	public function __construct($api){

		$this->api = $api;
	}

	public function __get($property){

		if (array_key_exists($property, $this->api)) {
			//
			return call_user_func($this->api[$property]);
		}
		else {
			throw new \Exception("Cet objet n'existe pas");
		}
	}
}