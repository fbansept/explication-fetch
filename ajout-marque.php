<?php

include_once 'header-json.php';

$jsonNouvelleMarque = file_get_contents('php://input');
$nouvelleMarque = json_decode($jsonNouvelleMarque, TRUE);

try{

    include_once 'bdd.php';

    $requete = $bdd->prepare("INSERT INTO marques (nom) VALUES (:nom)");

    $requete->execute([
        "nom" => $nouvelleMarque["nom"]
    ]);

    include 'liste-marque.php';

} catch (PDOException $e) {
    exit;
}