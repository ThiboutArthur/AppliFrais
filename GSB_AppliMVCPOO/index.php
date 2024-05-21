<?php

/**
 * Index du projet GSB
 *
 * PHP Version 8
 *
 * @category  AP
 * @package   GSB
 * @link      Contexte « Laboratoire GSB »
 */

include_once('_config.php');
require_once 'includes/fct.inc.php';

//Appel de la méthode de classe
MyAutoload::start();

//Utilisateur déjà connecté ?
session_start();
$estConnecte = estConnecte();

//Récupérer la demande de la requête
if (isset($_GET['uc'])) {
    $request = $_GET['uc'];
} else {
    $request = null;
}

//Création d'un objet routeur dans lequel on va passer la demande
$routeur = new Routeur($request);
//demander au routeur d'activer le controleur
$routeur->renderController();

