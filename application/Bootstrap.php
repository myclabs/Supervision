<?php

// Initialisation de l'autoloading
error_reporting(E_ALL);
// Enregistre le module de l'application : "Mycsense"
$autoloader = new Zend_Application_Module_Autoloader(array(
	'namespace' => 'Mycsense',
	'basePath'  => dirname(__FILE__),
));
// Enregistre la librairie (meme nom que le module mais c'est pas grave)
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Mycsense_');


class Bootstrap extends Mycsense_Bootstrap
{

	/**
	 * D�sactive la prise en compte des droits d'acc�s
	 */
	protected function _initAcl()
	{
		Zend_Registry::set('activerAcl', false);
	}

}
