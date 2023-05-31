<?php

include_once 'header-json.php';

try{

    include_once 'bdd.php';

    $requete = $bdd->prepare(
        "SELECT *
         FROM marques");

    $requete->execute();

    $listeMarque = $requete->fetchAll();

    echo json_encode($listeMarque);

} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}