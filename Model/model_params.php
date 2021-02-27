<?php

session_start();
require_once('./pdo.php');

if (!isset($_SESSION['user'])) {
  header('Location: ../Vue/vue_accueil.php');
}

/** */
/**** Vérification des données entrées par l'utilisateur (mdp actuel) ****/
/** */
if (!isset($_POST["newpseudo"]) && !isset($_POST["newemail"])) {
  $_SESSION['error'] = "Aucun champ n'est rempli.<br/>";
}

if (isset($_POST["newpseudo"])) {
  $newpseudo = $_POST["newpseudo"];
}
if (isset($_POST["newemail"])) {
  $newemail = $_POST["newemail"];
}

/** */
/**** Vérification des données entrées par l'utilisateur ****/
/** */
if (isset($newpseudo)) {
  if (!preg_match("/[\w]{4,}/", $newpseudo)) {
    $_SESSION['error'] = "Le pseudo doit contenir minimum 4 caractères alphanumériques uniquement<br/>";
  }
}
if (isset($newemail)) {
  if (!filter_var($newemail , FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] .= "L'email ne correspond pas au format ***@***.**'.<br/>";}
}
if (isset($_SESSION['error'])) {
  header('location: ../Vue/vue_params.php');
  exit();
}

/** */
/**** Gestion d'erreurs & verif BDD ****/
/** */
if (isset($newpseudo)) {
  try {
    $verif = $database->prepare("SELECT pseudo FROM utilisateur WHERE utilisateur.pseudo = :pseudo");
    $verif->execute(array(':pseudo'=>$newpseudo));
    $datapseudo = $verif->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
  }
}
if (isset($newemail)) {
  try {
    $verif = $database->prepare("SELECT email FROM utilisateur WHERE utilisateur.email = :email");
    $verif->execute(array(':email'=>$newemail));
    $dataemail = $verif->fetchAll(PDO::FETCH_ASSOC);
  }
  catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
  }
}

if (isset($newpseudo) && isset($datapseudo[0]['pseudo'])) {
  if ($newpseudo === $datapseudo[0]['pseudo']) {
    $_SESSION['error'] = "Le pseudo est déjà pris.<br/>";
  }
}

if (isset($newemail) && isset($dataemail[0]['email'])) {
  if ($newemail === $dataemail[0]['email']) {
    $_SESSION['error'] = "Le email est déjà pris.<br/>";
  }
}

if (isset($_SESSION['error'])) {
  header('Location: ../Vue/vue_params.php');
}

/** */
/**** Gestion d'erreurs & Insertion BDD ****/
/** */
if (isset($newpseudo)) {
  try {
    $donneesPDO = $database->prepare('UPDATE `utilisateur` SET pseudo = :pseudo WHERE id_users = :id');
    $donneesPDO -> execute(array(':id'=>$_SESSION['user']['id_users'], ':pseudo'=>$newpseudo));
    exit();
  }
  catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
  }
}
if (isset($newemail)) {
  try {
    $donneesPDO = $database->prepare('UPDATE `utilisateur` SET email = :email WHERE id_users = :id');
    $donneesPDO -> execute(array(':id'=>$_SESSION['user']['id_users'], ':email'=>$newemail));
    exit();
  }
  catch(Exception $e) {
    echo 'Erreur : '.$e->getMessage().'</br>';
    echo 'Numéro : '.$e->getCode();
    exit();
  }
}


/** */
/**** Actualisation des données ****/
/** */
try {
  $verif = $database->prepare("SELECT id_users, prenom, nom, pseudo, email, mdp, date_creation, url_avatar FROM utilisateur WHERE id_users = :id");
  $verif->execute(array(':id'=>$_SESSION['user']['id_users']));
  $data = $verif->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e) {
  echo 'Erreur : '.$e->getMessage().'</br>';
  echo 'Numéro : '.$e->getCode();
  exit();
}

if (isset($data)) {
  $_SESSION['user'] = $data[0];
}

$_SESSION['success'] .= "Les informations ont bien été changées.<br/>";
header('Location: ../Vue/vue_params.php');