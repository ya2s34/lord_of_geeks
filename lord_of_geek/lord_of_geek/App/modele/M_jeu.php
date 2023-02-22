<?php

class M_jeu
{

    /**
     * Retourne sous forme d'un tableau associatif tous les jeux
     * 
     *
     * @return un tableau associatif
     */
    public static function tousLesJeux()
    {
        $req = "SELECT jeu.id, jeu.nom, jeu.prix, jeu.image, categories.nom AS categories_nom, categories.id AS categories_id FROM jeu LEFT JOIN categories ON jeu.categories_id=categories.id LEFT JOIN exemplaires ON jeu.id=exemplaires.id";
        $res = AccesDonnees::query($req);
        $jeux = $res->fetchAll();
        return $jeux;

    }
  

}
