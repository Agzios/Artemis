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
    <title>Artemis</title>
    <link rel="stylesheet" href="./Style/inscription.css">
</head>
<body>
    <div id="all">
        <div id="margLogo">
            <a href="./vue_accueil.php"><img id="logo" src="../Composant/logo_CLASSIQUE_Sans_Fond.png" alt="logo"></a>
        </div>

        <main id="card">
            <form action="../Model/model_connexion.php" method="POST">
                <label for="username"></label>
                <input class="formulaire" type="text" id="username" name="username" placeholder="email ou pseudo" required/>
                <br/>
                <label for="password"></label>
                <input class="formulaire" id="password" type="password" name="password" placeholder="password" required/>
                <br/>
                <input id="Ins" class="formulaire" type="submit" name="Connexion">
            </form>
            <a id="over" class="formulaire" id="connexion" href="./vue_inscription.php">Pas de compte ? Inscription</a>
        </main>
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