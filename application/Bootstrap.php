<?php

// Initialisation de l'autoloading
error_reporting(E_ALL);
// Enregistre la librairie (meme nom que le module mais c'est pas grave)
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Mycsense_');


class Bootstrap extends Mycsense_Bootstrap
{

	/**
	 * Désactive la prise en compte des droits d'accès
	 */
	protected function _initAcl()
	{
		Zend_Registry::set('activerAcl', false);
	}

}
