<?php
/**
 * Initialisation de l'application
 */

error_reporting(E_ALL);

// Répertoire vers l'application
defined('APPLICATION_PATH') || define('APPLICATION_PATH', dirname(__FILE__));

// Répertoire vers le package
defined('PACKAGE_PATH') || define('PACKAGE_PATH', realpath(APPLICATION_PATH . '/..'));

// Fichiers de configuration
if (! include_once APPLICATION_PATH . '/configs/paths.php') {
    die("Le fichier application/configs/paths.php n'existe pas");
}

// Vérifie que l'environnement d'exécution est définit
if (! defined('APPLICATION_ENV')) {
    die("Aucun environnement d'exécution définit");
}

// Vérifie que le chemin complet vers la librairie est définit
if (! defined('LIBRARY_PATH')) {
    die("Le chemin d'accès vers la librairie n'est pas définit");
}

// Vérifie que l'url de la librairie est définit
if (! defined('LIBRARY_URL')) {
    die("L'url vers la librairie n'est pas définit");
}

// On récupère la bonne version de la classe Core_Autoloader
// et on charge les dépendances
require_once APPLICATION_PATH.'/configs/dependencies.php';
if (! empty($dependencies['Core'])) {
    $version = $dependencies['Core'];
    if ($version == 'trunk') {
        $packageDir = LIBRARY_PATH . '/Core/trunk';
        if (! is_dir($packageDir)) {
            $messageErreur = 'Le repertoire du package "Core" avec version "'.$version.'" est introuvable.';
            $messageErreur .= 'Verifier les fichiers "dependencies.php".';
            die($messageErreur);
        }
    } else {
        $packageDir = LIBRARY_PATH . '/Core/tags/' . $version;
        if (! is_dir($packageDir)) {
            $packageDir = LIBRARY_PATH . '/Core/branches/' . $version;
            if (! is_dir($packageDir)) {
                $messageErreur = 'Le repertoire du package "Core" avec version "'.$version.'" est introuvable.';
                $messageErreur .= 'Verifier les fichiers "dependencies.php".';
                die($messageErreur);
            }
        }
    }
    // Active l'autoloader
    require_once $packageDir . '/library/Autoloader.php';
    Core_Autoloader::getInstance()->register();
    require_once $packageDir . '/library/Package/Manager.php';
    // Charge les dépendances
    Core_Package_Manager::loadDependencies($dependencies);
    // Charge le package
    Core_Package_Manager::initPackage();
} else {
    die("le package 'Core' doit obligatoirement etre present dans le fichier dependencies.php !");
}

// Enregistrement de l'URL des Ressources externes
Zend_Registry::set('RESOURCES_URL', LIBRARY_URL . '/External/');


// Zend_Application
require_once 'Zend/Application.php';

// Crée l'application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Lance le bootstrap, puis l'application
$application->bootstrap();
if (defined('RUN') && RUN) {
    $application->run();
}
