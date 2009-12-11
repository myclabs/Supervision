<?php

class ValidateurController extends Mycsense_Controller
{

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
		// Diff�rences
		$phpunit = 'phpunit --verbose';
		$basePath = '/home/dev/';

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/tests';
		$commande = "$phpunit $dossier 2>&1";
		exec($commande, $this->view->utilisateurs = array(), $retour);

		// Unites
		$dossier = $basePath . 'unites/tests';
		$commande = "$phpunit $dossier 2>&1";
		exec($commande, $this->view->unites = array(), $retour);

		// Acl
		$dossier = $basePath . 'acl/tests';
		$commande = "$phpunit $dossier 2>&1";
		exec($commande, $this->view->acl = array(), $retour);

		// Pages et menus
		$dossier = $basePath . 'pagesmenus/tests';
		$commande = "$phpunit $dossier 2>&1";
		exec($commande, $this->view->pagesmenus = array(), $retour);

		$this->view->details = implode("\n", $output);
	}

}
