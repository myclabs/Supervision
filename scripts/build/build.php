<?php
/**
 * Création et remplissage de la base de données
 *
 * Utilisation CLI :
 *         #php build.php
 *         #php build.php create
 *         #php build.php populate
 *         #php build.php overload
 *         #php build.php create populate overload
 *         #php build.php -e testsunitaires create
 *         #php build.php -e testsunitaires,developpement populate
 *         #php build.php --no-dependencies
 *
 * La commande par défaut (#php build.php) équivaut à :
 *         #php build.php -env testsunitaires,developpement create populate
 *
 * @package User
 */

set_time_limit(0);

/**
 * Environnement d'exécution de l'application
 * @see http://dev.myc-sense.com/wiki/index.php/Environnement_d%27ex%C3%A9cution
 * @var string
 */
define('APPLICATION_ENV', 'script');

/**
 * Détermine si l'application est lancée après le Bootstrap
 * @var bool
 */
define('RUN', false);

require_once realpath(dirname(__FILE__).'/../../application/init.php');

/**
 * Inclut les actions
 */
require_once PACKAGE_PATH.'/scripts/build/create/create.php';
require_once PACKAGE_PATH.'/scripts/build/populate/populate.php';
require_once PACKAGE_PATH.'/scripts/build/overloadDependencies/overloadDependencies.php';

/**
 * Lance le script
 */
$script = new Core_Script_Build(new User_Create(), new User_Populate(), new Core_OverloadDependencies());
$script->run();
