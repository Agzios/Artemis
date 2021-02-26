<?php
require "../Vue/vue_post.php";
switch ($extension) {
    case '.jpeg':$source = imagecreatefromjpeg($url); 
    break;
    case '.jpg': $source = imagecreatefromjpeg($url); 
    break;
    case '.png': $source = imagecreatefrompng($url); 
    break;
    case '.gif': $source = imagecreatefromgif($url); 
    break;
    default : $_SESSION['error'] = 'Type de fichier non pris en charge.<br/>';
    die();             
}
 
$destination = imagecreatetruecolor(180, 150); // On crée la miniature vide
 
// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
 
// On crée la miniature
imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
 
// On enregistre la miniature sous le nom " "
imagejpeg($destination, $url.'miniatures/');