<?php

require_once('../Model/pdo.php');

/** */
/**** Selection depuis la BDD ****/
/** */
try {
    $verif = $database->prepare("SELECT url_post, title, pseudo, date_post FROM post INNER JOIN utilisateur on post.id_users = utilisateur.id_users WHERE status_post != 'private'");
    $verif->execute(array());
    $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$dataSize = count($data);