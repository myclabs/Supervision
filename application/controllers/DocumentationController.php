<?php

class DocumentationController extends Mycsense_Controller
{

	public function genererAction()
	{
		// Execution de phpdoc
		$phpdoc = './phpdoc';
		$sortie = '/home/dev/phpdoc/';
		$template = 'HTML:Smarty:PHP';
		$source = '/home/dev/librairies/Mycsense';
		$this->view->commande = "$phpdoc -t $sortie -o $template -d $source 2>&1";
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
