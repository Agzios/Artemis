<?php

require_once("../.env/dbconfig.php");

// On vérifie les données
try {
    $database = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->exec("SET NAMES 'utf8'");
}
catch(Exception $e)
{
    echo 'Erreur de connexion PDO !';
	die();
}