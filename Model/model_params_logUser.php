<?php

session_start();
require_once('./pdo.php');

if (!isset($_SESSION['user'])) {
  header('Location: ../Vue/vue_accueil.php');
}

/** */
/**** Vérification des données entrées par l'utilisateur (mdp actuel) ****/
/** */
if (isset($_POST["curPassword"])) {
    $curPassword = sha1(SALT.$_POST["curPassword"]);
}

/** */
/**** Gestion d'erreurs & Insertion BDD ****/
/** */
try {
    $verif = $database->prepare("SELECT mdp FROM utilisateur WHERE utilisateur.pseudo = :pseudo AND utilisateur.email = :email");
    $verif->execute(array(':pseudo'=>$_SESSION['user']['pseudo'], ':email'=>$_SESSION['user']['email']));
    $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
}

if (!isset($curPassword) OR $curPassword != $data[0]['mdp']) {
    $_SESSION['error'] = "Le mot de passe actuel entré n'est pas bon.<br/>";
}
if (isset($_SESSION['error'])) {
    header('Location: ../Vue/vue_params_logUser.php');
}

/** */
/**** Vérification des données entrées par l'utilisateur (nouveau mdp) ****/
/** */
if (isset($_POST["password"])) {
    $password = $_POST["password"]; /*********************************************** rechercher fonction de hashage **********/
}
if (isset($_POST["verifpassword"])) {
    $verifpassword = $_POST["verifpassword"];
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (!isset($password) OR !preg_match("/.{8,}/", $password)) {
  $_SESSION['error'] .= "Le mot de passe doit contenir minimum 8 caractères.<br/>";
}
if (!preg_match("/[a-z]/", $password)) {
  $_SESSION['error'] .= "Le mot de passe doit contenir une lettre minuscule.<br/>";
}
if (!preg_match("/[A-Z]/", $password)) {
  $_SESSION['error'] .= "Le mot de passe doit contenir une lettre majuscule.<br/>";
}
if (!preg_match("/[0-9]/", $password)) {
  $_SESSION['error'] .= "Le mot de passe doit contenir un chiffre.<br/>";
}
if (!preg_match("/\W/", $password)) {
  $_SESSION['error'] .= "Le mot de passe doit contenir un caractère spécial.<br/>";
}
if (!isset($verifpassword) OR $password != $verifpassword) {
  $_SESSION['error'] .= "Les mot de passe sont différents.<br/>";
}
if (isset($_SESSION['error'])) {
  header('location: ../Vue/vue_params_logUser.php');
  exit();
}

$password = sha1(SALT.$_POST["password"]);
$verifpassword = sha1(SALT.$_POST["verifpassword"]);

if ($password === $curPassword) {
    $_SESSION['error'] .= "Le nouveau mot de passe doit être différent de l'ancien.<br/>";
}
if (isset($_SESSION['error'])) {
header('location: ../Vue/vue_params_logUser.php');
exit();
}

/** */
/**** Gestion d'erreurs & Insertion BDD ****/
/** */
try {
  $donneesPDO = $database->prepare('UPDATE `utilisateur` SET mdp = :mdp WHERE pseudo = :pseudo');
  $donneesPDO -> execute(array(':mdp'=>$password, ':pseudo'=>$_SESSION['user']['pseudo']));
  header('Location: ./logout_co.php');
  exit();
}
catch(Exception $e) {
  echo 'Erreur : '.$e->getMessage().'</br>';
  echo 'Numéro : '.$e->getCode();
  exit();
}