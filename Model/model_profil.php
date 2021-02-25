<?php

require_once('../Model/pdo.php');

// On affiche les données relatives à l'utilisateur:
// Avatar, Pseudo, A La Une, Media, Favoris

/** */
/**** Vérification des données utilisateur ****/
/** */
if (!isset($_SESSION['user'])) {
    header('Location: ./vue_connexion.php');
} 

/** */
/**** Récupération des données liées à l'utilisateur ****/
/** */
// A la une (photos & vidéos que l'utilisateur a choisi de mettre en avant)
// media (photo & vidéos)
// favoris (personnes suivient)