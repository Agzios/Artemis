<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artemis</title>
    <link rel="stylesheet" href="./Style/accueil.css">
    <link rel="shortcut icon" href="../Composant/logo_CLASSIQUE_Sans_Fond.ico" type="image/x-icon">
</head>

<div class="AllButFooter">
    <body>
        <!-- En-tête -->
        <header>
            <a id="logo" href="./vue_accueil.php">
                <figure id="containLogo">
                    <img  id="logoArtemis" src='../Composant/logo_CLASSIQUE_Sans_Fond.png' alt='Logo Artemis' />
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
                <h1 id="artemis">Artemis</h1> 
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
                <?php  
                    require("../Model/model_accueil.php");
                    // var_dump($data);
                    for ($i=0; $i<$dataSize; $i++) {
                        echo 
                            '<section>
                                <a href="./vue_visionnage?url='.$data[$i]["url_post"].'">
                                    <article>Content</article>
                                </a>
                                <p class="title"><strong>'.$data[$i]["title"].'</strong></p>
                                <p class="name">'.$data[$i]["pseudo"].'</p>
                                <div class="vueDate">
                                    <p class="view">Vues</p>
                                    <p class="separation">-</p>
                                    <p class="date">'.$data[$i]["date_post"].'</p>
                                </div>
                            </section>';
                    }
                ?>
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