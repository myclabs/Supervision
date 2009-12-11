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
		$this->view->supervision = $validateur->validerProjet($dossier . 'supervision');
		$this->view->librairie = $validateur->validerLibrairie($dossier . 'librairies');
	}

	/**
	 * Lancement des tests
	 */
	public function testsunitairesAction()
	{
		// Différences
		$phpunit = 'phpunit --verbose';
		$basePath = '/home/dev/';

		// Base carbone
		$dossier = $basePath . 'basecarbone/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->basecarbone = array();
		exec($commande, $this->view->basecarbone, $retour);

		// Stations de montagne
		$dossier = $basePath . 'stationsmontagne/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->stationsmontagne = array();
		exec($commande, $this->view->stationsmontagne, $retour);

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->utilisateurs = array();
		exec($commande, $this->view->utilisateurs, $retour);

		// Unites
		$dossier = $basePath . 'unites/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->unites = array();
		exec($commande, $this->view->unites, $retour);

		// Acl
		$dossier = $basePath . 'acl/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->acl = array();
		exec($commande, $this->view->acl, $retour);

		// Pages et menus
		$dossier = $basePath . 'pagesmenus/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->pagesmenus = array();
		exec($commande, $this->view->pagesmenus, $retour);
	}

	/**
	 * Vérifie le respect du guide de style
	 */
	public function guidestyleAction()
	{
		// Execution de phpdoc
		$phpdoc = 'phpcs -n --standard=Zend';
		$source = '/home/dev/librairies/Mycsense/';
		$this->view->commande = "$phpdoc $source";
		$output = array();
		exec($this->view->commande, $output, $retour);
		$this->view->resultat = $output;
	}

}
