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
		$this->view->commande = "$phpdoc -t $sortie -o $template -d $source";
		if (!is_dir($sortie) || !is_dir($source)) {
			$this->view->resultatGeneration = 'erreur';
			$this->view->detailGeneration = "Les dossiers sources ou destination n'existent pas.";
		} else {
			$retour = exec($this->view->commande);
			$this->view->resultatGeneration = 'succès';
			$this->view->detailGeneration = "Documentation générée.";
		}
	}

	public function voirAction()
	{
	}

}
