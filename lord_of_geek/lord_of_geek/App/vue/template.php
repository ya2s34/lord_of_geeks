<!DOCTYPE html>
<!--
Prototype de Lord Of Geek (LOG)
-->
<html>

<head>
    <title>Lord Of Geek 2022</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public/cssGeneral.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
</head>

<body>
    <header>
        <!-- Images En-tête -->
        <img src="public/images/logo.png" alt="Logo Lord Of Geek" />
        <!--  Menu haut-->
        <nav id="menu">
            <ul>
                <li><a href="index.php?uc=accueil"> Accueil </a></li>
                <li><a href="index.php?uc=visite&action=voirCatalogue"> Voir le catalogue de jeux </a></li>
                <li><a href="index.php?uc=panier&action=voirPanier"> Voir son panier </a></li>

                <?php
                $client = isset($_SESSION['client']) ? $_SESSION['client'] : false;
                if (!$client) {
                    echo "<li><a href='index.php?uc=authentification&action=connexionClient'> Se connecter </a></li>";
                    echo "<li><a href = 'index.php?uc=inscription'> Inscription </a></li>";
                } else {
                    echo '<li><a href="index.php?uc=compte"> Information personelle </a></li>';
                    echo "<li><a href='index.php?uc=authentification&action=deconnexionClient'> Se déconnecter </a></li>";
                    "Vous etes connecter !";
                }
                ?>

            </ul>
        </nav>

    </header>
    <main>
        <?php
        // Controleur de vues
        // Selon le cas d'utilisation, j'inclus un controleur ou simplement une vue
        switch ($uc) {
            case 'accueil':
                include 'App/vue/v_accueil.php';
                break;
            case 'visite':
                include("App/vue/v_jeux.php");
                break;
            case 'panier':
                include("App/vue/v_panier.php");
                break;
            case 'commander':
                include("App/vue/v_commande.php");
                break;
            case 'compte':
                include("App/vue/v_compte.php");
                break;
            case 'authentification':
                include("App/vue/v_authentification.php");
                break;
            case 'inscription':
                include("App/vue/v_inscription.php");
                break;
            default:
                break;
        }
        ?>
    </main>
</body>

</html>