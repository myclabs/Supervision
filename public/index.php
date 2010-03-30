<?php

// Répertoire vers l'application
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Inclut le fichier d'initialisation
if (! include_once(APPLICATION_PATH . '/configs/init.php')) {
    die("Le fichier application/configs/init.php n'existe pas");
}

// Vérifie que l'environnement d'exécution est définit
if (! defined('APPLICATION_ENV')) {
    die("Aucun environnement d'exécution définit");
}

// Vérifie que le chemin complet vers la librairie est définit
if (! defined('LIBRAIRIE_PATH')) {
    die("Le chemin d'accès vers la librairie n'est pas définit");
}

// Ajoute la librairie MCS à l'include path
// ainsi que le répertoire library/ (priorité sur library/)
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    LIBRAIRIE_PATH,
    get_include_path(),
)));

// Zend_Application
require_once 'Zend/Application.php';

// Crée l'application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Lance le bootstrap, puis l'application
$application->bootstrap()
            ->run();
