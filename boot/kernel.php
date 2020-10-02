<?php
session_start();

// Chargement automatique des classes du dossier < app >
require 'App/Autoloader.php';
App\Autoloader::register();

//
// $_SESSION['radical'] = '/L3IRT/'; // La racine du site ( Pensez à le changer au besoin )
$_SESSION['radical'] = dirname(dirname(__DIR__)) . '/';

// Variable Page
$_GET['p'] = (!isset($_GET['p']) or empty($_GET['p'])) ? 'personne.liste' : $_GET['p'];


// Instance de la BDD
$db = new \App\Core\Database([
	'username' => 'admin',
	'password' => 'admin',
	'server' => 'localhost',
	'database_name' => 'db_coding'
]);
// Tableau associatif contenant des modules
$api['db'] = function() use ($db) {
	return $db;
};

// L'objet de l'application
$app = new \App\App($api, $_GET['p']);
