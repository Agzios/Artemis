<?php

if (!isset($accueil)) {
    $accueil = '';
}

switch ($accueil) {
    case "tendance":
        header("Location: ./vue_tendance.php");
        break;
    case "recherche":
        header("Location: ./vue_recherche.php");
        break;
    case "post":
        header("Location: ./vue_post.php");
        break;
    default:
        header("Location: ./vue_accueil.php");
        break;
}