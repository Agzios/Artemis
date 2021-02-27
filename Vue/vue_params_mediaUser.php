<?php 
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ./vue_connexion.php');
    } 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artemis</title>
    <link rel="stylesheet" href="./Style/params.css">
    <link rel="shortcut icon" href="../Composant/logo_CLASSIQUE_Sans_Fond.ico" type="image/x-icon">
</head>

<div class="AllButFooter">
    <body>
        <!-- En-tête -->
        <header>
            <a id="logo" href="./vue_accueil.php">
                <figure id="containLogo">
                    <img  id="logoArtemis" src='../Composant/logo_CLASSIQUE_Sans_Fond.png' alt='Logo Artemis' />
                    <h1 id="artemis">Artemis</h1>
                </figure>  
            </a> 
            <div id="search">
                <form id="searchForm" action="" method="">
                    <input id="searchBar" type="search" name="search" placeholder="Search"/>
                    <button id="validSearch" type="submit" value="">
                        <figure id="containSearch">
                            <img id="iconSearch" src="../Composant/chercher.png" alt="Icon Search"/>
                        </figure>
                    </button>
                    <button id="filter" type="submit">
                        <figure id="containFilter">
                            <img id="iconFilter" src="../Composant/filter_hard.svg" alt="Icon Filter"/>
                        </figure>
                    </button>
                </form>
            </div>
            <?php 
                if (isset($_SESSION['user'])) {
                    echo 
                        '<a id="avatar" href="./vue_profil.php">
                            <figure id="containAvatar">
                                <img id="userAvatar" src="../Composant/utilisateur.png" alt="Logo User" />
                            </figure>
                        </a>';
                }
                else {
                    echo 
                        '<a id="avatar" href="./vue_connexion.php">
                            <figure id="containAvatar">
                                <img id="userAvatar" src="../Composant/utilisateur.png" alt="Logo User" />
                            </figure>
                        </a>';
                }
            ?>
        </header>

        <div id="asideMain">
            <!-- Naviguation -->
            <aside>   
                 
                <figure class="arrete">
                    <img src="../Composant/arrete.png" alt="Arrete"/>
                </figure>   
                <a href="./vue_accueil.php" class="nav">
                    <figure id="containAccueil">
                        <img id="iconAccueil" src="../Composant/BoutonHome.svg" alt="Icon Accueil"/>
                    </figure>
                    <p>Accueil</p>
                </a>
                <figure class="arrete">
                    <img src="../Composant/arrete.png" alt="Arrete"/>
                </figure>
                <a href="./vue_tendance.php" class="nav">
                    <figure id="containTendance">
                        <img id="iconTendance" src="../Composant/feuille.png" alt="Icon Tendance"/>
                    </figure>
                    <p>Tendance</p>
                </a>
                <figure class="arrete">
                    <img src="../Composant/arrete.png" alt="Arrete"/>
                </figure>
                <?php 
                if (isset($_SESSION['user'])) {
                echo 
                    '<a href="./vue_post.php" class="nav">
                        <figure id="containPost">
                            <img id="iconPost" src="../Composant/plus.svg" alt="Icon Post"/>
                        </figure>
                        <p>Post</p>
                    </a>';
                }
                else {
                echo 
                    '<a href="./vue_connexion.php" class="nav">
                        <figure id="containPost">
                            <img id="iconPost" src="../Composant/plus.svg" alt="Icon Post"/>
                        </figure>
                        <p>Post</p>
                    </a>';
                }
                ?>
                <figure class="arrete">
                    <img src="../Composant/arrete.png" alt="Arrete"/>
                </figure>
            </aside>

            <!-- Medias -->
            <main>
                <?php require("../Model/model_profil.php")?>
                <div id='profilContent'>
                    <div id='choosenCategory'>
                        <a href='./vue_params.php'>Données</a>
                        <figure class='arreteProfil'>
                            <img src='../Composant/arrete.png' alt='Arrete'/>
                        </figure> 
                        <a href='./vue_params_logUser.php'>Authentification</a>
                        <figure class='arreteProfil'>
                            <img src='../Composant/arrete.png' alt='Arrete'/>
                        </figure> 
                        <a href='./vue_params_mediaUser.php'>Media</a>
                        <figure class='arreteProfil'>
                            <img src='../Composant/arrete.png' alt='Arrete'/>
                        </figure> 
                        <a href='./vue_params_removeUser.php'>Supprimer mon Compte</a>
                        <figure class='arreteProfil'>
                            <img src='../Composant/arrete.png' alt='Arrete'/>
                        </figure> 
                        <a href='../Model/logout.php'>Déconnexion</a>
                    </div>
                    <div id="medias">
                        <?php  
                            require("../Model/model_params_mediaUser.php");
                            // var_dump($data);
                            for ($i=0; $i<$dataSize; $i++) {
                                if (isset($data)) {
                                    $typeMime = $data[$i]['type_post'];
                                    //echo $ext['extension'];
                                }
                                if (isset($typeMime) && strpos($typeMime, 'image') !== false) {
                                    echo
                                    '<section>
                                        <a href="./vue_visionnage?url='.$data[$i]["url_post"].'">
                                            <figure>
                                                <img src='.$data[$i]["url_post"].' width="200" height="auto"/>
                                            </figure>
                                        </a>
                                        <p class="title"><strong>'.$data[$i]["title"].'</strong></p>
                                        <p class="name">'.$data[$i]["pseudo"].'</p>
                                        <form action="../Model/model_deleteMedia.php" method="POST">
                                            <input type="hidden" name="suppr" value="'.$data[$i]['url_post'].'">
                                            <input class="suppr" type="submit" value="Supprimer">
                                        </form>
                                    </section>';
                                }
                                if (isset($typeMime) && strpos($typeMime, 'video') !== false) {
                                echo 
                                    '<section>
                                        <a href="./vue_visionnage?url='.$data[$i]["url_post"].'">
                                            <video width="200" height="auto">
                                                <source src='.$data[$i]['url_post'].' type='.$typeMime.'>
                                            </video>
                                        </a>
                                        <p class="title"><strong>'.$data[$i]["title"].'</strong></p>
                                        <p class="name">'.$data[$i]["pseudo"].'</p>
                                        <form action="../Model/model_deleteMedia.php" method="POST">
                                            <input type="hidden" name="suppr" value="'.$data[$i]['url_post'].'">
                                            <input class="suppr" type="submit" value="Supprimer">
                                        </form>
                                    </section>';
                                }
                            }
                        ?>
                        <?php 
                        // Si la session 'error' existe
                        if (isset($_SESSION['error'])) {
                            // alors on affiche un message
                            echo '<div id="error">' . $_SESSION['error'] . '</div><br/>';
                        }
                        // Si la session 'success' existe
                        if (isset($_SESSION['success'])) {
                            // alors on affiche un message
                            echo '<div id="success">' . $_SESSION['flash'] . '</div><br/>';
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</div>

    <!-- Droit et conditions générales-->
    <footer>
        <p id="artemisFooter"><strong>Artemis</strong></p>
        <p>Conditions Générales - Mentions Légales</p> 
        <p>© 2021 - Artemis</p>
    </footer>

</html>

<?php 
    // Les messages disparaîssent lorsque la page est actualisée
    unset($_SESSION['error']);
    unset($_SESSION['success']);
    unset($_SESSION['flash']);
?>