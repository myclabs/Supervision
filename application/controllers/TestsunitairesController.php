<?php

class TestsunitairesController extends Mycsense_Controller
{

	/**
	 * Lancement des tests
	 */
	public function executerAction()
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

		// Pages et menus
		$dossier = $basePath . 'langues/tests';
		$commande = "$phpunit $dossier 2>&1";
		$this->view->langues = array();
		exec($commande, $this->view->langues, $retour);
	}

	/**
	 * Génerer le rapport de couverture de code
	 */
	public function generercouverturecodeAction()
	{
		$output = array();
		// Copie des tests dans le dossier testscomplets
		$commande = "cp /home/dev/acl/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/basecarbone/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/langues/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/pagesmenus/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/stationsmontagne/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/unites/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$commande = "cp /home/dev/utilisateurs/tests/* /home/dev/testscomplets/tests/";
		exec($commande, $output, $retour);
		$output[] = '';
		// Execution de phpdoc
		$phpdoc = 'phpunit --coverage-html /home/dev/couverturecode';
		$source = '/home/dev/acl/tests';
		$this->view->commande = "$phpdoc $source";
		exec($this->view->commande, $output, $retour);
		$this->view->resultat = $output;
	}

	/**
	 * Affiche le rapport de couverture de code
	 */
	public function couverturecodeAction()
	{
	}

}
