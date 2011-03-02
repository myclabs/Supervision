<?php
error_reporting(E_ALL);

class Bootstrap extends Core_Bootstrap
{

    /**
     * Surcharge
     */
    protected function _initDb()
    {
    }
    /**
     * Désactive la prise en compte des droits d'accès
     */
    protected function _initAcl()
    {
        Zend_Registry::set('activerAcl', false);
    }

}
