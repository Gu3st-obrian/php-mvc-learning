<?php
// Gestion des erreurs
ini_set('display_errors', 'on');
ini_set('session.gc_maxlifetime', 36000);
error_reporting(E_ALL);

require 'boot/kernel.php'; // Chargement du noyau

$app->run(); // Lancement du programme
