<?php
include "App/modele/M_Commande.php";
include "App/modele/M_utilisateur.php";
$commandesClient = [];
if (!empty($clientSess)) {

    $commandesClient = M_Commande::afficherCommande($clientSess['id']);
}
