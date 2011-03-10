<?php

class IndexController extends Core_Controller
{

    public function indexAction()
    {
        $this->_redirect("index/accueil");
    }

    public function accueilAction()
    {
    }

    public function phpinfoAction()
    {
    }

    public function validationAction()
    {
        $this->view->command = "php /home/dev/library/Core/trunk/scripts/validator/validator.php"
            ." /home/dev/library/AF"
            ." /home/dev/library/Calc"
            ." /home/dev/library/Core"
            ." /home/dev/library/Export"
            ." /home/dev/library/TEC"
            ." /home/dev/library/UI"
            ." /home/dev/library/Unit"
            ." /home/dev/library/User"
            ." 2>&1";
        $output = array();
        exec($this->view->command, $output, $retour);
        $this->view->errors = implode("\n", $output);
    }

}
