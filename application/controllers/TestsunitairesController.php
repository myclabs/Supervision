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
		$basePath = '/home/dev';
		// Supprime les fichiers de test existant
		$output[] = 'Suppression des fichiers de test existant';
		$commande = "rm $basePath/testscomplets/tests/*.php 2>&1";
		exec($commande, $output, $retour);
		$output[] = '';
		// Copie des tests dans le dossier testscomplets
		$dossiers = array(	'acl', 'basecarbone', 'langues', 'pagesmenus',
							'stationsmontagne', 'unites', 'utilisateurs');
		foreach ($dossiers as $dossier) {
			$output[] = 'Copie des fichiers de test du projet "' . $dossier . '"';
			$commande = "cp $basePath/$dossier/tests/*.php $basePath/testscomplets/tests/ 2>&1";
			exec($commande, $output, $retour);
			$output[] = '';
		}
		// Supprime les classes de modèle existantes
		$output[] = 'Suppression des classes de modèle existantes';
		$commande = "rm -R $basePath/testscomplets/application/models/ 2>&1";
		exec($commande, $output, $retour);
		$output[] = '';
		// Copie des classes de modèle
		$dossiers = array('basecarbone', 'stationsmontagne');
		foreach ($dossiers as $dossier) {
			$output[] = 'Copie des classes de modèle du projet "' . $dossier . '"';
			$commande = "cp -R $basePath/$dossier/application/models/* $basePath/testscomplets/application/models/ 2>&1";
			exec($commande, $output, $retour);
			$output[] = '';
		}
		// Execution de phpdoc
		$phpunit = "phpunit";
		$sortie = "$basePath/couverturecode";
		$source = "$basePath/testscomplets/tests";
		$this->view->commande = "$phpunit --coverage-html $sortie $source";
		//exec($this->view->commande, $output, $retour);
		$this->view->resultat = $output;
	}

	/**
	 * Affiche le rapport de couverture de code
	 */
	public function couverturecodeAction()
	{
	}

}
