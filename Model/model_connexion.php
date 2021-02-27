<?php

session_start();
require_once('./pdo.php');

if (isset($_SESSION['user'])) {
    header('Location: ../Vue/vue_accueil.php');
}

/** */
/**** Verification des données du formulaire ****/
/** */
if (!isset($_POST["username"]) OR !isset($_POST["password"])) {
    $_SESSION['error'] = "Donnée(s) non saisie(s).<br/>";
    header("Location: ../Vue/vue_connexion.php");
}

$username = $_POST["username"];
$password = sha1(SALT.$_POST["password"]);
  
/** */
/**** Selection depuis la BDD ****/
/** */
try {
    $verif = $database->prepare("SELECT id_users, prenom, nom, pseudo, email, mdp, date_creation, url_avatar FROM utilisateur WHERE (utilisateur.email = :username OR utilisateur.pseudo = :username) AND utilisateur.mdp = :pass AND status_user != 'deleted'");
    $verif->execute(array(':username'=>$username , ':pass'=>$password));
    $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (isset($data)) {
    $_SESSION['user'] = $data[0];
    header("Location: ../Vue/vue_accueil.php");
}

$_SESSION['error'] = "Donnée(s) incorrecte(s).<br/>";
header("Location: ../Vue/vue_connexion.php");