<?php
include 'App/modele/M_Categorie.php';
include 'App/modele/M_Exemplaire.php';
include 'App/modele/M_jeu.php';
include 'App/modele/M_console.php';

/**
 * Controleur pour la consultation des exemplaires
 * @author Loic LOG
 */
switch ($action) {
    case 'voirJeux':
        $id_jeu = filter_input(INPUT_GET, 'id_jeu');
        $lesJeux = M_Exemplaire::trouveExemplaire($id_jeu);
        break;
    case 'voirCategories':
        $categorie = filter_input(INPUT_GET, 'categorie');
        $lesJeux = M_Exemplaire::trouveLesJeuxDeCategorie($categorie);
       
        break;

    case 'voirCatalogue':
        $lesJeux = M_jeu::tousLesJeux();

        break;
    case 'voirConsole':
        $categorie = filter_input(INPUT_GET, 'console');

        $lesJeux = M_Exemplaire::trouveLesConsolesParExemplaires($categorie);
        break;
    case 'ajouterAuPanier':
        $lesJeux = [];
        $idJeu = filter_input(INPUT_GET, 'jeu');
        $categorie = filter_input(INPUT_GET, 'categorie');
        if (!ajouterAuPanier($idJeu)) {
            afficheErreurs(["Ce jeu est déjà dans le panier !!"]);
        } else {
            afficheMessage("Ce jeu a été ajouté");
        }
        break;
    default:
        $lesJeux = [];
        break;

}

$vendu = M_Exemplaire::etiquetteVendu($lesJeux);
$lesCategories = M_Categorie::trouveLesCategories();
$lesConsoles = M_console::trouveLesConsoles();
