<?php

require_once('../Model/pdo.php');

/** */
/**** Vérification des données utilisateur ****/
/** */
if (!isset($_SESSION['user'])) {
    header('Location: ./vue_connexion.php');
} 

$id = $_SESSION['user']['id_users'];
/** */
/**** Selection depuis la BDD ****/
/** */
try {
    $verif = $database->prepare("SELECT url_post, title, pseudo, date_post, type_post FROM post INNER JOIN utilisateur on post.id_users = utilisateur.id_users WHERE utilisateur.id_users = :id AND status_post != 'deleted' ORDER BY date_post DESC");
    $verif->execute(array(':id'=>$id));
    $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$dataSize = count($data);