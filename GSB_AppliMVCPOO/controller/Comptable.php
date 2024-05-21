<?php

/**
 * Class Controller Visiteur
 * 
 * Liste des méthodes qui correspondent à une action demandée par le Visiteur
 */

class Comptable
{
    public function connexionComptable($params)
    {
        $myView = new View('v_connexion');
        $myView->render(array('estConnecte' => null));
    }

    
    
    public function deconnexion($params)
    {
        //Appel de la vue
        $myView = new View('v_deconnexion');
        deconnecter();
        $myView->render(array('estConnecte' => true));
    }

    
    public function accueil($params)
    {
        //extraction des paramètres pour récupérer action à faire et autres (GET|POST)
        extract($params);
        //Affichage de la vue accueil Visiteur
        $myView = new View('v_accueil');
        $myView->render(array('estConnecte' => true));

    }
    
    public function gererFrais($params)
    {
        //Recup les données en cours du Visiteur
        $idVisiteur = $_SESSION['idVisiteur'];
        $mois = getMois(date('d/m/Y'));
        $numAnnee = substr($mois, 0, 4);
        $numMois = substr($mois, 4, 2);
        $pdo = GsbManager::getPdoGsb();
        //extraction des paramètres pour récupérer action à faire et autres (GET|POST)
        extract($params);
        //En fonction de l'action demandée par le visiteur
        switch($action)
        {
            //cas de création de la fiche de frais vide pour mois courant
            case 'saisirFrais':
                if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
                    $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
                }
                break;
            //cas de validation de la saisie d'une fiche de frais
            case 'validerMajFraisForfait':
                //S'assurer que les données saisies sont correctes
                if (lesQteFraisValides($lesFrais)) {
                    $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
                } else {
                    //Vue erreur saisies erronnées
                    ajouterErreur('Les valeurs des frais doivent être numériques');
                    $myView = new View('v_erreurs');
                    $myView->render(array('estConnecte' => true, 'retour' => 'accueil'));
                }
                break;
            //Valider la saisie d'un frais hors forfait
            case 'validerCreationFrais':
                //S'assurer que les données sont valides
                valideInfosFrais($dateFrais, $libelle, $montant);
                //Y-a-t-il des erreurs ?
                if (nbErreurs() != 0) {
                    //Vue erreur correspondante
                    $myView = new View('v_erreurs');
                    $myView->render(array('estConnecte' => true, 'retour' => 'accueil'));
                } else {
                    //Création du nouveau frais hors forfait
                    $pdo->creeNouveauFraisHorsForfait(
                        $idVisiteur,
                        $mois,
                        $libelle,
                        $dateFrais,
                        $montant
                    );
                }
                break;
            case 'supprimerFrais':
                //Suppression du frais hors forfait
                $pdo->supprimerFraisHorsForfait($idFrais);
                break;
        }
        //Récupérer les données des frais pour le visiteur
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        //Appel de la vue qui affiche les frais du visiteur
        $myView = new View('v_listeFraisForfait');
        $myView->render(array('estConnecte' => true, 
                            'numMois' => $numMois, 
                            'numAnnee' => $numAnnee,
                            'lesFraisForfait' => $lesFraisForfait,
                            'lesFraisHorsForfait' => $lesFraisHorsForfait));
    }

    public function etatFrais($params)
    {
        $pdo = GsbManager::getPdoGsb();
        //Recup les données actuelles
        $idVisiteur = $_SESSION['idVisiteur'];
        //extraction des paramètres pour récupérer action à faire et autres (GET|POST)
        extract($params);
        //En fonction de l'action demandée par le visiteur
        switch($action)
        {
            case 'selectionnerMois':
                $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
                // Afin de sélectionner par défaut le dernier mois dans la zone de liste
                // on demande toutes les clés, et on prend la première,
                // les mois étant triés décroissants
                $lesCles = array_keys($lesMois);
                $moisASelectionner = $lesCles[0];
                //Affichage de la vue actualisée
                $myView = new View('v_listeMois');
                $myView->render(array('estConnecte' => true, 
                                'lesMois' => $lesMois));
                break;
            case 'voirEtatFrais':
                //Récupérer les informations et fiches du visiteur
                $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
                $leMois = $lstMois;
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
                $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
                $numAnnee = substr($leMois, 0, 4);
                $numMois = substr($leMois, 4, 2);
                $libEtat = $lesInfosFicheFrais['libEtat'];
                $montantValide = $lesInfosFicheFrais['montantValide'];
                $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
                $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
                //Appel de la vue v_etatFrais
                $myView = new View('v_etatFrais');
                $myView->render(array('estConnecte' => true, 
                            'lesMois' => $lesMois,
                            'numMois' => $numMois, 
                            'numAnnee' => $numAnnee,
                            'libEtat' => $libEtat,
                            'dateModif' => $dateModif,
                            'montantValide' => $montantValide,
                            'nbJustificatifs' => $nbJustificatifs,
                            'lesFraisForfait' => $lesFraisForfait,
                            'lesFraisHorsForfait' => $lesFraisHorsForfait));
                break;
        }
    }

}