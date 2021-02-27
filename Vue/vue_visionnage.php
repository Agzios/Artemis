<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artemis</title>
    <link rel="stylesheet" href="./Style/visionnage.css">
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
                    require_once('../Model/pdo.php');

                    $url = ($_SERVER['REQUEST_URI']);
                    $position = strpos($url, "=");
                    $media = substr($url, $position + 1);

                    try {
                        $verif = $database->prepare("SELECT type_post, title, description, url_post, view_post, status_post FROM post WHERE url_post = :url");
                        $verif->execute(array(':url'=>$media));
                        $infos = $verif->fetchAll(PDO::FETCH_ASSOC);
                    }
                    catch(Exception $e) {
                        echo 'Erreur : '.$e->getMessage().'</br>';
                        echo 'Numéro : '.$e->getCode();
                        exit();
                    }

                    if (isset($infos)) {
                        $typeMime = $infos[0]['type_post'];
                        $ext = pathinfo($media);
                        //echo $ext['extension'];
                    }

                    if ($infos[0]['status_post'] !== 'deleted') {
                        // Si dans le typeMime il y a 'image' alors
                        if (isset($typeMime) && strpos($typeMime, 'image') !== false) {
                            echo 
                            "<img src=".$media." width='500' height='auto'/>";
                        }
                        // Si dans le typeMime il y a 'video' alors
                        if (isset($typeMime) && strpos($typeMime, 'video') !== false) {
                            echo 
                            '<video preload="auto" autoplay loop controls width="500">
                                <source src='.$media.' type='.$typeMime.'>
                            </video>';
                        }

                        $view = $infos[0]['view_post'];
                        $view += 1;

                        try {
                            $verif = $database->prepare("UPDATE `post` SET view_post = :view WHERE url_post = :url");
                            $verif->execute(array(':view'=>$view, ':url'=>$media));
                            
                        }
                        catch(Exception $e) {
                            echo 'Erreur : '.$e->getMessage().'</br>';
                            echo 'Numéro : '.$e->getCode();
                            exit();
                        }

                        echo 
                        '<section>
                            <h2 id="title">'.$infos[0]['title'].'</h2>
                            <p id="description">'.$infos[0]['description'].'</p>
                            <p id="vues">'. $view. 'Vues</p>
                        </section>';
                    }
                    else {
                        echo 'Le media n\'existe plus.';
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