<?php

session_start();
require_once('./pdo.php');

if (!isset($_SESSION['user'])) {
    header('Location: ../Vue/vue_params_mediaUser.php');
}

try {
    $verif = $database->prepare("UPDATE `utilisateur` SET status_utilisateur = :status WHERE id_users = :id");
    $verif->execute(array(':status'=> 'deleted', 'id:'=>$_SESSION['user']['id_users']));
    
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

$_SESSION['flash'] = "Compte supprimé avec succès.<br/>";
header('Location: ./logout.php');