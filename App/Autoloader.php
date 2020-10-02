<?php

namespace App;

class Autoloader{
	
	static function register(){
		spl_autoload_register(array(__CLASS__, 'appLoading'));
	}

	static function appLoading($class)
	{
		if (strpos($class, __NAMESPACE__ . '\\') === 0) {
			$class = str_replace(__NAMESPACE__ . '\\', '', $class);
			$class = str_replace('\\', '/', $class);
			require $class . '.php';
		}
	}

}
