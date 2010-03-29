<?php

class ValidateurController extends Mycsense_Controller
{

	/**
	 * Lance le script de validation du code source
	 */
	public function validerAction()
	{
		$dossier = '/home/dev/';
		$validateur = Mycsense_Model_Validateur::getInstance();
		// Valide les projets
		$this->view->basecarbone = $validateur->validerProjet($dossier . 'basecarbone');
		$this->view->stationsmontagne = $validateur->validerProjet($dossier . 'stationsmontagne');
		$this->view->unites = $validateur->validerProjet($dossier . 'unites');
		$this->view->utilisateurs = $validateur->validerProjet($dossier . 'utilisateurs');
		$this->view->acl = $validateur->validerProjet($dossier . 'acl');
		$this->view->pagesmenus = $validateur->validerProjet($dossier . 'pagesmenus');
		$this->view->langues = $validateur->validerProjet($dossier . 'langues');
		$this->view->interfacesgeneriques = $validateur->validerProjet($dossier . 'interfacesgeneriques');
		$this->view->supervision = $validateur->validerProjet($dossier . 'supervision');
		$this->view->librairie = $validateur->validerLibrairie($dossier . 'librairies');
	}

	/**
	 * Vérifie le respect du guide de style
	 */
	public function guidestyleAction()
	{
		// Execution de phpdoc
		$phpdoc = 'phpcs -n --standard=/home/dev/supervision/GuideStyle/Mycsense';
		$source = '/home/dev/librairies/Mycsense/';
		$this->view->commande = "$phpdoc $source 2>&1 | grep -v 'Break statement'";
		$output = array();
		exec($this->view->commande, $output, $retour);
		$this->view->resultat = $output;
	}

}
