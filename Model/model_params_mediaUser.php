<?php

require_once('../Model/pdo.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../Vue/vue_accueil.php");
}

/** */
/**** Selection depuis la BDD ****/
/** */
try {
    $verif = $database->prepare("SELECT url_post, title, pseudo, date_post, type_post FROM post INNER JOIN utilisateur on post.id_users = utilisateur.id_users WHERE status_post != 'deleted' AND utilisateur.id_users = :id ORDER BY date_post DESC");
    $verif->execute(array(':id'=>$_SESSION['user']['id_users']));
    $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$dataSize = count($data);