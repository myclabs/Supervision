<?php
/**
 * Fichier d'initialisation de l'application
 * À placer dans application/configs/
 */

/**
 * Chemin d'accès complet vers la librairie
 * @var string
 */
define('LIBRAIRIE_PATH', '..../myc-sensedev/trunk/library');

/**
 * Environnement d'exécution de l'application
 * @see http://dev.myc-sense.com/wiki/index.php/Environnement_d%27ex%C3%A9cution
 * @var string
 */
if (! defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', 'developpement');
}
