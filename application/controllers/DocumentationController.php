<?php
       
class DocumentationController extends MCS_Controller
{

    public function genererAction()
    {
        // Execution de phpdoc
        $phpdoc = 'phpdoc';
        $sortie = '/home/dev/phpdoc/';
        //$template = 'HTML:Smarty:PHP';
        $template = 'HTML:frames/Extjs:default';
        $source1 = '/home/dev/librairies/MCS';
        $source2 = '/home/dev/librairies/Modules';
        $this->view->commande = "$phpdoc -t $sortie -o $template -d $source1,$source2 2>&1";
        if (!is_dir($sortie) || !is_dir($source)) {
            $this->view->resultatGeneration = 'echec';
            $this->view->detailGeneration = "Les dossiers sources ou destination n'existent pas.";
        } else {
            $output = array();
            exec($this->view->commande, $output, $retour);
            if ($retour == 0) {
                $this->view->resultatGeneration = 'succès';
                $this->view->detailGeneration = implode("\n", $output);
            } else {
                $this->view->resultatGeneration = 'echec';
                $this->view->detailGeneration = implode("\n", $output);
            }
        }
    }

    public function voirAction()
    {
    }

}
