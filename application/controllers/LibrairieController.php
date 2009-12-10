<?php

class LibrairieController extends Mycsense_Controller
{

	public function verifierAction()
	{
		$differences = array();

		// Différences
		$diff = 'diff -qr';
		$basePath = '/home/dev/';
		$baseLibrairie = $basePath . 'librairies/Mycsense/';

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/library/Mycsense/Utilisateurs';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Utilisateurs.";
		} else {
			$commande = "$diff {$baseLibrairie}Utilisateurs $dossier 2>&1";
			exec($commande, $differences, $retour);
		}

		// Unites
		$dossier = $basePath . 'unites/library/Mycsense/Unites';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Unites.";
		} else {
			$commande = "$diff {$baseLibrairie}Unites $dossier 2>&1";
			exec($commande, $differences, $retour);
		}

		$this->view->differences = implode("\n", $differences);

	}

}
