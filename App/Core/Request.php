<?php

namespace App\Core;

class Request
{
	private $request;
	private $variables;

	public function __construct($request){
		$this->variables = $request; // stockage de la variable global request
		$this->GetVariables();
	}

	private function GetVariables()
	{
		foreach ($this->variables as $key => $value) {
			if ($key != 'p') { // exclusion de l'url
				$this->request[$key] = $value;
			}
		}
	}

	public function getParam($inode){
		// retourne la valeur du tableau indexé
		return (array_key_exists($inode, $this->request)) ? $this->request[$inode] : '';
	}

	public function getParams(){ // retourne un tableau des valeurs
		return $this->request;
	}
}
