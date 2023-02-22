<?php

include 'App/modele/M_Utilisateur.php';


switch ($action) {

    case 'connexionClient':
        $email = filter_input(INPUT_POST, 'mail');
        $password = filter_input(INPUT_POST, 'password');
        $client = M_utilisateur::findUserMail($email, $password);


       

        if (!$client) {
           echo "Veuillez vous inscrire :)";
        } else {
            $_SESSION['client'] = $client;
            echo 'Vous etes connectez !!';
            header('Location: index.php');
            
        }
        break;

    case 'deconnexionClient':
        supprimerPanier();
        unset($_SESSION['client']);
        header('Location: index.php');
        die();
        break;

    case 'inscriptionClient':
        $email = filter_input(INPUT_POST, 'mail');
        $password = filter_input(INPUT_POST, 'mdp');
        $rue = filter_input(INPUT_POST, 'rue');
        $nomPrenom = filter_input(INPUT_POST, 'nom');
        $codePostal = filter_input(INPUT_POST, 'cp');
        $ville = filter_input(INPUT_POST, 'ville');
        $tel = filter_input(INPUT_POST, 'tel');
        header('Location: index.php');
        $client = M_utilisateur::createUser($nomPrenom, $email, $tel, $rue, $ville, $codePostal, $password);
        break;

}