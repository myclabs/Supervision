<?php

class LibrairieController extends Mycsense_Controller
{

	public function verifierAction()
	{
		$differences = array();

		// Différences
		$diff = 'diff -qr';
		$basePath = '/home/dev/';
		$baseLibrairie = $basePath . 'librairies/Modules/';

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/application/utilisateurs';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Utilisateurs.";
		} else {
			$commande = "$diff {$baseLibrairie}utilisateurs $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Utilisateurs est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Utilisateurs n'est pas à jour";
				$differences[] = "";
			}
		}

		// Unites
		$dossier = $basePath . 'unites/application/unites';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Unites.";
		} else {
			$commande = "$diff {$baseLibrairie}unites $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Unites est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Unites n'est pas à jour";
				$differences[] = "";
			}
		}

		// Acl
		$dossier = $basePath . 'acl/application/acl';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Acl.";
		} else {
			$commande = "$diff {$baseLibrairie}acl $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Acl est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Acl n'est pas à jour";
				$differences[] = "";
			}
		}

		// Navigation
		$dossier = $basePath . 'navigation/application/navigation';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Navigation.";
		} else {
			$commande = "$diff {$baseLibrairie}navigation $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Navigation est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Navigation n'est pas à jour";
				$differences[] = "";
			}
		}

		// Langues
		$dossier = $basePath . 'langues/library/Mycsense/Langues';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Langues.";
		} else {
			$commande = "$diff {$baseLibrairie}Langues $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Langues est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Langues n'est pas à jour";
				$differences[] = "";
			}
		}

		$this->view->differences = implode("\n", $differences);

	}

}
