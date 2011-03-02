<?php
/**
 * Définition du package
 */

/**
 * Nom du package
 * @var string
 */
$packageName = 'Supervision';

/**
 * Spécifier si le package est un module zend ou pas.
 * Si oui, le répertoire 'application/{package}/' sera alors automatiquement
 * chargé par l'autoloader.
 * @var bool
 */
$packageIsModule = false;

/**
 * Mettre ici les répertoires qui doivent se retrouver dans l'include path
 *
 * Format : array('repertoire1', 'repertoire2')
 * Le chemin des répertoires doit être relatif au répertoire de ce fichier
 *
 * Attention, à l'intérieur de chaque répertoire spécifié, le nom des classes doit
 * avoir comme préfixe le nom du package.
 * @var array
 */
$pathsToInclude = array('library');

