<?php

require_once('../Model/pdo.php');

/*** Récup' données BDD ***/
$verif = $database->prepare('SELECT * FROM utilisateur');
$verif->execute();
/* $data = $verif->fetchAll(PDO::FETCH_OBJ); */
$data = $verif->fetchAll(PDO::FETCH_ASSOC);