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
		$output = array();

		// Différences
		$phpunit = 'phpunit --verbose';
		$basePath = '/home/dev/';

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/tests';
		if (!is_dir($dossier)) {
			$output[] = "Impossible de tester le projet Utilisateurs.";
		} else {
			$commande = "$phpunit $dossier 2>&1";
			exec($commande, $output, $retour);
			$output[] = "";
		}

		// Unites
		$dossier = $basePath . 'unites/tests';
		if (!is_dir($dossier)) {
			$output[] = "Impossible de tester le projet Unites.";
		} else {
			$commande = "$phpunit $dossier 2>&1";
			exec($commande, $output, $retour);
			$output[] = "";
		}

		// Acl
		$dossier = $basePath . 'acl/tests';
		if (!is_dir($dossier)) {
			$output[] = "Impossible de tester le projet Acl.";
		} else {
			$commande = "$phpunit $dossier 2>&1";
			exec($commande, $output, $retour);
			$output[] = "";
		}

		// Pages et menus
		$dossier = $basePath . 'pagesmenus/tests';
		if (!is_dir($dossier)) {
			$output[] = "Impossible de tester le projet PagesMenus.";
		} else {
			$commande = "$phpunit $dossier 2>&1";
			exec($commande, $output, $retour);
			$output[] = "";
		}

		$this->view->details = implode("\n", $output);
	}

}
