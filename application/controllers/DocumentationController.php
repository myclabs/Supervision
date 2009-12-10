<?php

class DocumentationController extends Mycsense_Controller
{

	public function genererAction()
	{
		// Execution de phpdoc
		$phpdoc = './phpdoc';
		$sortie = '/home/dev/phpdoc/';
		$template = 'HTML:Smarty:PHP';
		$source = '/hom/dev/librairies/Mycsense';
		if (!is_dir($sortie) || !is_dir($source)) {
			$this->view->resultatGeneration = 'erreur';
			$this->view->detailGeneration = "Les dossiers sources ou destination n'existent pas.";
		} else {
			$retour = exec("$phpdoc -t $sortie -o $template -d $source");
			$this->view->resultatGeneration = 'succès';
			$this->view->detailGeneration = "Documentation générée.";
		}
	}

	public function voirAction()
	{
	}

}
