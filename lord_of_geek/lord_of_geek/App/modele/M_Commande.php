<?php

/**
 * Requetes sur les commandes
 *
 * @author Loic LOG
 */
class M_Commande
{

    /**
     * Crée une commande
     *
     * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
     * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
     * tableau d'idProduit passé en paramètre
     * @param $nom
     * @param $rue
     * @param $cp
     * @param $ville
     * @param $mail
     * @param $listJeux

     */
    // public static function creerCommande($nomPrenom, $rue, $cp, $ville, $mail, $listJeux)
    // {
    //     $reqClient = "insert into client(nomPrenom, adresse, c_postal, ville, email) values (:nomPrenom,:rue,:cp,:ville,:mail)";

    //     $pdo = AccesDonnees::getPdo();
    //     $stmt = $pdo->prepare($reqClient);
    //     $stmt->bindParam(':nomPrenom', $nomPrenom, PDO::PARAM_STR);
    //     $stmt->bindParam(':rue', $rue, PDO::PARAM_STR);
    //     $stmt->bindParam(':cp', $cp, PDO::PARAM_INT);
    //     $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
    //     $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    //     $stmt->execute();
    //     $idClient = AccesDonnees::getPdo()->lastInsertId();

    //     $reqCommande = "insert into commandes(client_id) values($idClient)";
    //     $res = AccesDonnees::exec($reqCommande);
    //     $idCommande = AccesDonnees::getPdo()->lastInsertId();

    //     foreach ($listJeux as $jeu) {
    //         $req = "insert into lignes_commande(commande_id, exemplaire_id) values ('$idCommande','$jeu')";
    //         $res = AccesDonnees::exec($req);
    //     }
    // }

    public static function creerCommande($idClient, $listJeux)
    {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare("INSERT INTO commandes(created_at, client_id) VALUES (NOW(), :idClient)");
        $stmt->bindParam(":idClient", $idClient);
        $stmt->execute();
        $idCommande = AccesDonnees::getPdo()->lastInsertId();
        foreach ($listJeux as $jeu) {
            $pdo = AccesDonnees::getPdo();
            $stmt = $pdo->prepare("INSERT INTO lignes_commande(commande_id, exemplaire_id) VALUES (:idCommande, :jeu)");
            $stmt->bindParam(":idCommande", $idCommande);
            $stmt->bindParam(":jeu", $jeu);
            $stmt->execute();
        }
    }
     public static function afficherCommande($idClient)
    {
        $pdo = Accesdonnees::getPdo();
        $stmt = $pdo->prepare("SELECT exemplaires.*, commandes.*, client.*
        FROM client
        JOIN commandes ON commandes.client_id = client.id
        JOIN lignes_commande ON lignes_commande.commande_id = commandes.id
        JOIN exemplaires ON exemplaires.id = lignes_commande.exemplaire_id
     
        WHERE client.id = :clientId
        ORDER BY commandes.id DESC");
        $stmt->bindParam(":clientId", $idClient);
        $stmt->execute();
        $lesCommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lesCommandes;
    }


    /**
     * Retourne vrai si pas d'erreur
     * Remplie le tableau d'erreur s'il y a
     *
     * @param $nom : chaîne
     * @param $rue : chaîne
     * @param $ville : chaîne
     * @param $cp : chaîne
     * @param $mail : chaîne
     * @return : array
     */
    public static function estValide($nom, $rue, $ville, $cp, $mail)
    {
        $erreurs = [];
        if ($nom == "") {
            $erreurs[] = "Il faut saisir le champ nom";
        }
        if ($rue == "") {
            $erreurs[] = "Il faut saisir le champ rue";
        }
        if ($ville == "") {
            $erreurs[] = "Il faut saisir le champ ville";
        }
        if ($cp == "") {
            $erreurs[] = "Il faut saisir le champ Code postal";
        } else if (!estUnCp($cp)) {
            $erreurs[] = "erreur de code postal";
        }
        if ($mail == "") {
            $erreurs[] = "Il faut saisir le champ mail";
        } else if (!estUnMail($mail)) {
            $erreurs[] = "erreur de mail";
        }
        return $erreurs;
    }
}

