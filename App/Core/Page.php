<?php

namespace App\Core;

class Page
{
	private $pages;

	public function __construct(){
		$this->pages = 'app/Vue/';
	}

	public function render($response, $url, $array = null)
	{
		ob_start();
		if (!is_null($array)) {
			extract($array);
		}
		require($this->pages . $url .'.php');
		$content = ob_get_clean();
		require($this->pages.'default.php');
	}

	public function pathFor($route){
		return $_SESSION['radical'] . '?p=' .strtolower($route);
	}

	public function withRedirect($routename){
		header('Location: '. $_SESSION['radical'] . '?p=' . $routename);
	}
}
