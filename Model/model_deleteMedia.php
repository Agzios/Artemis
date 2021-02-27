<?php

session_start();
require_once('./pdo.php');

if (!isset($_SESSION['user'])) {
    header('Location: ../Vue/vue_params_mediaUser.php');
}

if (isset($_POST['suppr'])) {
    $url = $_POST['suppr'];
}
else {
    header('Location: ../Vue/vue_params_mediaUser.php');
}

try {
    $verif = $database->prepare("SELECT utilisateur.id_users FROM utilisateur INNER JOIN post ON utilisateur.id_users = post.id_users WHERE url_post = :url");
    $verif->execute(array(':url'=>$url));
    $infos = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

if ($_SESSION['user']['id_users'] !== $infos[0]['id_users']) {
    header('Location: ../Vue/vue_accueil.php');
}

try {
    $verif = $database->prepare("UPDATE `post` SET status_post = :status WHERE url_post = :url");
    $verif->execute(array(':status'=> 'deleted', ':url'=>$media));
    
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$_SESSION['flash'] = "Media supprimé avec succès.<br/>";
header('Location: ../Vue/vue_params_mediaUser.php');