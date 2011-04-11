<?php

class DocumentationController extends Core_Controller
{

    public function genererAction()
    {
        // Génération de la documentation PHPDoc

        $phpdoc = 'phpdoc';
        $sortie = '/home/dev/phpdoc/';
        $template = 'HTML:Smarty:PHP';
        //$template = 'HTML:frames/Extjs:default';
        $sources = array('/home/dev/library/AF/trunk',
                         '/home/dev/library/Calc/trunk',
                         '/home/dev/library/Core/trunk',
                         '/home/dev/library/Doc/trunk',
                         '/home/dev/library/Exec/trunk',
                         '/home/dev/library/Export/trunk',
                         '/home/dev/library/Keyword/trunk',
                         '/home/dev/library/Log/trunk',
                         '/home/dev/library/News/trunk',
                         '/home/dev/library/TEC/trunk',
                         '/home/dev/library/Tree/trunk',
                         '/home/dev/library/UI/trunk',
                         '/home/dev/library/Unit/trunk',
                         '/home/dev/library/User/trunk',
                         '/home/dev/basecarbone/application/basecarbone/models');
        $ignores = array('test/', 'scripts/');

        $this->view->commande = "$phpdoc -t $sortie -o $template -d ";

        $sourceDirsExists = true;
        foreach ($sources as $source) {
            if (!is_dir($source)) {
                $sourceDirsExists = false;
            }
            $this->view->commande .= $source.',';
        }

        $this->view->commande = substr($this->view->commande, 0, -1).' -i ';

        foreach ($ignores as $ignore) {
            $this->view->commande .= $ignore.',';
        }

        $this->view->commande = substr($this->view->commande, 0, -1).' 2>&1';

        if (!is_dir($sortie) || !$sourceDirsExists) {
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
