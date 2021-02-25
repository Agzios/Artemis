<?php 
    session_start();
    if (isset($_SESSION['user'])) {
        header('Location: ./vue_accueil.php');
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./Style/inscription.css">
</head>
<body>
    <div id="all">
        <div id="margLogo">
            <a href="./vue_accueil.php"><img id="logo" src="../Composant/logo_CLASSIQUE_Sans_Fond.png" alt="logo"> </a>
        </div>

        <div>
            <main id="card">
                <form action="Model/inscription.php" method="POST">
                    <label for="pseudo"></label>
                    <input class="formulaire" type="text" id="pseudo" name="pseudo" placeholder="pseudo" required>
                    <br/>
                    <label for="email"></label>
                    <input class="formulaire" id="email" type="email" name="email" placeholder="E-mail" required>
                    <br/>
                    <label for="password"></label>
                    <input class="formulaire" id="password" type="password" name="password" placeholder="Mot de passe" required>
                    <br/>
                    <label for="verif_password"></label>
                    <input class="formulaire" id="verif_password" type="password" placeholder="Confirmer le mot de passe" name="verif_password" required>
                    <br/>
                    <input class="formulaire" id="Ins" type="submit" value="Inscription">
                </form>
                <a id="over" class="formulaire" id="connexion" href="./vue_connexion.php">Déjà un compte ? Connexion</a>
            </main>
        </div>
    </div>
    <?php 
        // Si la session 'error' existe
        if (isset($_SESSION['error'])) {
            // alors on affiche un message
            echo '<div id="error">' . $_SESSION['error'] . '</div><br/>';
        }
    ?>
    <footer></footer>
</body>

</html>

<?php 
    // Les messages disparaîssent lorsque la page est actualisée
    unset($_SESSION['error']);
?>