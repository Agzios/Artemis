<?php

session_start();
require_once('./pdo.php');

if (isset($_SESSION['user'])) {
  header('Location: ../Vue/vue_accueil.php');
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (isset($_POST["pseudo"])) {
$pseudo = $_POST["pseudo"];
}
if (isset($_POST["email"])) {
$email = $_POST["email"];
}
if (isset($_POST["password"])) {
$password = $_POST["password"];
}
if (isset($_POST["verif_password"])) {
$verifpassword = $_POST["verif_password"];
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if ((!isset($pseudo) OR !preg_match("/[\w]{4,}/", $pseudo)) && $pseudo !== 'admin' && $pseudo !== 'Admin' && $pseudo !== 'administrator' && $pseudo !== 'Administrator' && $pseudo !== 'administrateur'  && $pseudo !== 'Administrateur' && $pseudo !== 'guest' && $pseudo !== 'Guest' && $pseudo !== 'user' && $pseudo !== 'Invité' && $pseudo !== 'invité' && $pseudo !== 'User' && $pseudo !== 'utilisateur' && $pseudo !== 'Utilisateur') {
  $_SESSION['error'] = "Le pseudo doit contenir minimum 4 caractères alphanumériques uniquement<br/>";
}
if (!isset($email) OR !filter_var($email , FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] .= "L'email ne correspond pas au format ***@***.**'.<br/>";
}
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
  $_SESSION['error'] .= "Le mot de passe doit contenir un caractère spécial.<br/>";
}
if (isset($_SESSION['error'])) {
  header('location: ../Vue/vue_inscription.php');
  exit();
}

/** */
/**** Vérification disponibilité pseudo & email ****/
/** */
try {
  $verif = $database->prepare("SELECT pseudo, email FROM utilisateur WHERE (utilisateur.email = :email OR utilisateur.pseudo = :pseudo) AND status_user != 'deleted'");
  $verif->execute(array(':email'=>$email, ':pseudo'=>$pseudo));
  $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
  echo 'Erreur : '.$e->getMessage().'</br>';
  echo 'Numéro : '.$e->getCode();
  exit();
}

if (isset($data)) {
  if ($data[0]['email'] === $email) {
    $_SESSION['error'] = 'Email indisponible.<br/>';
    header('location: ../Vue/vue_inscription.php');
  }
  if ($data[0]['pseudo'] === $pseudo) {
    $_SESSION['error'] = 'Pseudo indisponible.<br/>';
    header('location: ../Vue/vue_inscription.php');
  }
}

/** */
/**** Gestion d'erreurs & Insertion BDD ****/
/** */
try {
  $donneesPDO = $database->prepare('INSERT INTO `utilisateur` (pseudo, email, mdp) VALUES (:pseudo, :email, SHA1(:mdp))');
  $donneesPDO -> execute(array(':pseudo'=>$pseudo ,':email'=>$email ,':mdp'=>SALT.$password));
  header('Location: ../Vue/vue_connexion.php');
  exit();
}
catch(Exception $e) {
  echo 'Erreur : '.$e->getMessage().'</br>';
  echo 'Numéro : '.$e->getCode();
  exit();
}