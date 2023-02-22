<?php

use PhpParser\Node\Stmt;

/**
 * Requetes sur les exemplaires  de jeux videos
 *
 * @author Loic LOG
 */
class M_Exemplaire
{
    public static function trouveExemplaire($id)
    {
        $req = "SELECT exemplaires.id AS exemplaires_id,exemplaires.prix,exemplaires.image,exemplaires.categorie_id,exemplaires.etat,exemplaires.nom as exemplaires_nom,exemplaires.console_id,exemplaires.jeu_id AS id, console.nom from exemplaires JOIN console ON exemplaires.console_id=console.id WHERE jeu_id=:id";
        $pdo = AccesDonnees::getPdo();
        $res = $pdo->prepare($req);
        $res->bindParam(':id', $id);
        $res->execute();
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Retourne sous forme d'un tableau associatif tous les jeux de la
     * catégorie passée en argument
     *
     * @param $idCategorie
     * @return un tableau associatif
     */
    public static function trouveLesJeuxDeCategorie($idCategorie)
    {

        $req = "SELECT jeu.id, jeu.prix, jeu.image,jeu.nom,exemplaires.id AS exemplaires_id, exemplaires.nom AS nom, console.id AS console_id,console.nom AS console_nom 
         FROM jeu
         LEFT JOIN console ON jeu.console_id=console.id 
         LEFT JOIN exemplaires ON exemplaires.jeu_id = jeu.id
         WHERE jeu.categories_id = '$idCategorie'";
        $res = AccesDonnees::query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }


    public static function trouveLesConsolesParExemplaires($idConsole)
    {
        $req = "SELECT exemplaires.id AS exemplaires_id,exemplaires.prix,exemplaires.image,exemplaires.categorie_id,exemplaires.etat,exemplaires.nom as exemplaires_nom,exemplaires.console_id,exemplaires.jeu_id AS id, console.nom from exemplaires JOIN console ON exemplaires.console_id=console.id where console_id='$idConsole' ";
        $res = AccesDonnees::query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }


    /**
     * Retourne les jeux concernés par le tableau des idProduits passée en argument
     *
     * @param $desIdJeux tableau d'idProduits
     * @return un tableau associatif
     */
    public static function trouveLesJeuxDuTableau($desIdJeux)
    {

        $nbProduits = count($desIdJeux);
        $lesProduits = array();
        if ($nbProduits != 0) {
            foreach ($desIdJeux as $unIdProduit) {
                $req = "SELECT * FROM exemplaires WHERE id =:unIdProduit";
                $pdo = AccesDonnees::getPdo();
                $stmt = $pdo->prepare($req);
                $stmt->bindParam(':unIdProduit', $unIdProduit, PDO::PARAM_INT);
                $stmt->execute();
                $unProduit = $stmt->fetch();
                $lesProduits[] = $unProduit;
            }
        }
        return $lesProduits;
    }

    public static function trouveLesJeuxConsole($idConsole)
    {
        $req = "SELECT jeu.id, jeu.prix, jeu.image,jeu.nom, exemplaires.nom AS nom, console.id AS console_id,console.nom AS console_nom 
         FROM jeu
         LEFT JOIN console ON jeu.console_id=console.id 
         LEFT JOIN exemplaires ON console.id=exemplaires.console_id
         WHERE categorie.console_id = '$idConsole'";
        $res = AccesDonnees::query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    public static function etiquetteVendu($lesJeux)
    {
        $vendu = [];

        foreach ($lesJeux as $value) {

            if (isset($value['exemplaires_id'])) {
                $exemplaires_id = $value['exemplaires_id'];

                $req = "SELECT exemplaire_id as exemplaires_id
                    FROM `lignes_commande` 
                    WHERE exemplaire_id =$exemplaires_id";
                $res = AccesDonnees::query($req);
                $lesLignes = $res->fetch();

                $vendu[] = $lesLignes ? $lesLignes['exemplaires_id'] : [];
              
            }
        }

        return $vendu;
    }
}
