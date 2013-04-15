<?php
error_reporting(E_ALL);

class Bootstrap extends Core_Bootstrap
{
    /**
     * Initialise la base de données principale
     */
    protected function _initDoctrine()
    {
        // Pas de base de données
    }

    /**
     * Initialise la base de données principale
     */
    protected function _initDefaultEntityManager()
    {
        // Pas d'entités
        Zend_Registry::set('EntityManagers', array());
    }

    /**
     * Désactive la prise en compte des droits d'accès
     */
    protected function _initAcl()
    {
        Zend_Registry::set('activerAcl', false);
    }

    /**
     * Enregistre les helpers de UI.
     */
    protected function _initViewHelperUI()
    {
        $this->bootstrap('View');
        $package = Core_Package_Manager::getPackage('UI');
        // Exceptionellement, les helpers de vue de UI sont dans la librairie.
        //  Car UI n'est pas un module.
        $view = $this->getResource('view');
        $view->addHelperPath($package->getPath().'/library/View/Helper', 'UI_View_Helper');
    }

}
