<?php

namespace App;

class App
{
	private $url;
	private $api;
	private $request;
	private $response;
	
	public function __construct($api, $url)
	{
		$this->url = $url;
		// Injection des modules
		if (is_null($this->api)) {
			$this->api = $api;
		}
		// Gestion des variables
		if (is_null($this->request)) {
			$this->request = new \App\Core\Request($_REQUEST);
		}
		// Gestion des pages HTML
		if (is_null($this->response)) {
			$this->response = new \App\Core\Page();
		}
	}

	public function run()
	{
		$request = $this->request;
		$response = $this->response;

		// Exemple : personne.liste
		$CallableArrays = explode('.', $this->url);
		// Ex : PersonneManager
		$nsManager = '\\App\\Manager\\' . ucfirst($CallableArrays[0]) . 'Manager';
		// Ex : Liste
		$method = isset($CallableArrays[1]) ? ucfirst($CallableArrays[1]) : "Liste";
		//
		$nsPath = dirname(__DIR__) . str_replace('\\', '/', $nsManager) .'.php'; // chemin de la classe du fichier

		$loader = function() use ($request, $response, $nsManager, $method, $nsPath) {

			if (file_exists($nsPath)) {
				$manager = new $nsManager($this->api); // On instancie le Manager
				//
				if (method_exists($manager, $method)) {
					//
					return $manager->$method($request, $response);
				}
			}

			$manager = new \App\Core\NotFound();
			return $manager->__404Erreur__($request, $response);
		};

		call_user_func($loader);
	}
}

