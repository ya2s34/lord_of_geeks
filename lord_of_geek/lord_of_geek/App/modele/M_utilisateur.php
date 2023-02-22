<?php

class M_utilisateur
{

    public static function createUser($nomPrenom, $email, $tel, $adresse, $ville, $codePostal, $password)
    {
        

        if ($erreurs = static::estValide($nomPrenom, $email, $tel, $adresse, $ville, $codePostal, $password)) {
            return $erreurs;
        };

        $pdo = AccesDonnees::getPdo();
        $password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO client(nomPrenom, email, tel, adresse, ville, c_postal, password) VALUES (:nomPrenom, :email, :tel, :adresse, :ville, :codePostal, :password)');
        $stmt->bindParam(':nomPrenom', $nomPrenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':codePostal', $codePostal);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }
    public static function trouverClientParId($idClient)
    {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM client WHERE id = :id");
        $stmt->bindParam(":id", $idClient);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        return $client;
    }





    public static function findUserMail($email, $password)
    {
        $pdo = AccesDonnees::getPdo();
        $stmt = $pdo->prepare("SELECT * FROM client WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($client && password_verify($password, $client["password"])) {
            return $client;
        }
        return false;
    }

    public static function estValide($nomPrenom, $email, $tel, $adresse, $ville, $codePostal, $password) {
            $erreurs = [];
            if ($nomPrenom == "") {
                $erreurs[] = "Il faut saisir le champ nom";
            }
            if ($email == "") {
                $erreurs[] = "Il faut saisir le champ mail";
            }
            if ($ville == "") {
                $erreurs[] = "Il faut saisir le champ ville";
            }
            if ($tel == "") {
                $erreurs[] = "Il faut saisir le champ Code téléphone";
            } else if (!estUnCp($codePostal)) {
                $erreurs[] = "erreur de code postal";
            }
            if ($adresse == "") {
                $erreurs[] = "Il faut saisir le champ adresse";
            if ($codePostal == "") {
                $erreurs[] = "Il faut saisir le champ code postal";
            } else if (!estUnMail($email)) {
                $erreurs[] = "erreur de mail";
            }
            return $erreurs;
        }
    }

}
