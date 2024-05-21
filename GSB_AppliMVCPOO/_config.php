<?php

/*** configuration *****/
ini_set('display_errors', 'on');
error_reporting(E_ALL);
/**
 * Class MyAutoload
 * 
 * Classe qui se charge de configurer l'action au départ
 * Déclarées en static car appelées une seule fois dans l'application
 */
class MyAutoload
{
    public static function start()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
        // constantes
        //Récupérer la racine où se trouve le site
        $root = $_SERVER['DOCUMENT_ROOT'];
        //Récupérer URL
        $host = $_SERVER['HTTP_HOST'];

        //Définir les constantes
        define('ROOT', $root . '/GSB_AppliMVCPOO/');
        define('HOST', 'http://' . $host . '/GSB_AppliMVCPOO/');

        define('CONTROLLER', ROOT . 'controller/');
        define('VIEW', ROOT . 'view/');
        define('MODEL', ROOT . 'model/');
        define('CLASSES', ROOT . 'classes/');
        //Définir le chemin des feuille de style via URL et non chemin accès
        define('ASSETS', HOST . 'assets/');
    }

    /**
     * Méthode autoload avec comme paramètre le tableau des classes à charger
     */
    public static function autoload($class)
    {
        //Si le fichier existe dans le tableau alors inclus-le
        if (file_exists(MODEL . $class . '.php')) {
            include_once(MODEL . $class . '.php');
        } else if (file_exists(CLASSES . $class . '.php')) {
            include_once(CLASSES . $class . '.php');
        } else if (file_exists(CONTROLLER . $class . '.php')) {
            include_once(CONTROLLER . $class . '.php');
        };
    }
}
