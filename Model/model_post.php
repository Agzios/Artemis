<?php

session_start();
require_once('./pdo.php');
include './function/functions.php';
// ce var_dump devrait nous renvoyer un array de 5 champs : name/ type/ tmp_name/ error/ size
// ce sont les caractéristiques du fichier qui vient d etre chargé

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (!isset($_SESSION['user'])) {
    header('Location: ../Vue/vue_connexion.php');
}
if (isset($_POST['title'])) {
    $title = $_POST['title'];
}
if (isset($_POST['description'])) {
    $description = $_POST['description'];
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (!isset($_FILES)) {
    $_SESSION['error'] = "Veuillez renseigner l'image ou la vidéo à poster.<br/>";
}
if (!isset($title) OR !preg_match("/[\w]{3,}/", $title)) {
    $_SESSION['error'] = "Le titre doit contenir minimum 3 caractères.<br/>";
}
if (isset($description)) {
    if (!preg_match("/[\w]{0,255}/", $description)) {
        $_SESSION['error'] .= "La description doit contenir au maximum 255 caractères.<br/>";
    }
}
if (isset($_SESSION['error'])) {
    header('Location: ../Vue/vue_post.php');
}

/** */
/**** Assignation données utilisateur & url ****/
/** */
// On récupere le nom
$name= $_FILES['file']['name'];
$tmp_name= $_FILES['file']['tmp_name'];
$position= strpos($name, ".");
$fileextension= substr($name, $position + 1);
$fileextension= strtolower($fileextension);
$path= 'upload/';

$name = sha1($_SESSION['user']['id_users'] . $title . date('Y-m-d H:i:s'));

// On stocke le fichier temporaire
$pathAndNameTemp = $_FILES['file']['tmp_name']; 
// On stocke le fichier definitif
$pathAndNameDef = '../upload/' . $name . "." . $fileextension;
// On deplace le media du fichier temp vers le definitif
$moveFile = move_uploaded_file($pathAndNameTemp, $pathAndNameDef);

var_dump($fileextension);

if (($fileextension !== "mp4") && ($fileextension !== "mpeg") && ($fileextension !== "avi") && ($fileextension !== "ogv") && ($fileextension !== "jpg") && ($fileextension !== "jpeg") && ($fileextension !== "png") && ($fileextension !== "svg")) {
    $_SESSION['error'] = "L'extension du fichier n'est pas compatible, veuillez en changer (.mp4, .mpeg, .avi, .ogv, .jpg, .jpeg, .png, .svg).";
}
if (isset($_SESSION['error'])) {
    header('Location: ../Vue/vue_post.php');
}
        
if (($fileextension == "mp4") || ($fileextension == "mpeg") || ($fileextension == "avi") || ($fileextension == "ogv") || ($fileextension == "jpg") || ($fileextension == "jpeg") || ($fileextension == "png") || ($fileextension == "svg")) {
    if (move_uploaded_file($tmp_name, $path.$name)) {
        $_SESSION['success'] = "Uploaded";
    }
}

$idUsers = $_SESSION['user']['id_users'];
$url = $pathAndNameDef;
$status = 'publique';
$type = $_FILES['file']['type'];

/** */
/**** Vérification type fichier ****/
/** */
if ($type === strpos($type, 'image')) {
    // creation minia
    // $url_minia;
    // $minia_title;
    // $url_minia;
    // $minia_type;
}
if ($type === strpos($type, 'video')) {
    // creation minia
    // $url_minia;
    // $minia_title;
    // $url_minia;
    // $minia_type;
}

/** */
/**** Gestion d'erreurs & Insertion miniature du fichier dans BDD ****/
/** */
// try {
//     $donneesPDO = $database->prepare('INSERT INTO `post` (id_users, url_post, title, type_post, description, status_post, url_minia) VALUES (:id_users, :url_post, :title, :type_post, :status)');
//     $donneesPDO -> execute(array(':id_users'=>$idUsers, ':url_post'=>$url_minia, ':title'=>$minia_title, ':type_post'=>$minia_type, ':status'=>$status));
// }
// catch(Exception $e) {
//     echo 'Erreur : '.$e->getMessage().'</br>';
//     echo 'Numéro : '.$e->getCode();
//     exit();
// }

/** */
/**** Gestion d'erreurs & Insertion du fichier dans BDD ****/
/** */
try {
    $donneesPDO = $database->prepare('INSERT INTO `post` (id_users, url_post, title, type_post, description, status_post) VALUES (:id_users, :url_post, :title, :type_post, :description, :status)');
    $donneesPDO -> execute(array(':id_users'=>$idUsers, ':url_post'=>$url, ':title'=>$title, ':type_post'=>$type, ':description'=>$description, ':status'=>$status));
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$_SESSION['success'] = "Fichier enregistré avec succès.<br/>";
header('Location: ../Vue/vue_post.php');