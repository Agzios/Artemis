<?php 

/**** On démarre la session ****/
/** */
session_start();

/**** On supprime la session actuelle ****/
/** */
session_destroy();

/**** On redirige l'utilisateur vers la page de connexion (index.php) ****/
/** */
header('location: ../Vue/vue_connexion.php');