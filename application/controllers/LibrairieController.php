<?php

class LibrairieController extends Mycsense_Controller
{

	public function verifierAction()
	{
		$differences = array();

		// Diff�rences
		$diff = 'diff -qr';
		$basePath = '/home/dev/';
		$baseLibrairie = $basePath . 'librairies/Modules/';

		// Utilisateurs
		$dossier = $basePath . 'utilisateurs/application/utilisateurs';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Utilisateurs.";
		} else {
			$commande = "$diff {$baseLibrairie}utilisateurs $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Utilisateurs est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Utilisateurs n'est pas � jour";
				$differences[] = "";
			}
		}

		// Unites
		$dossier = $basePath . 'unites/application/unites';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Unites.";
		} else {
			$commande = "$diff {$baseLibrairie}unites $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Unites est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Unites n'est pas � jour";
				$differences[] = "";
			}
		}

		// Acl
		$dossier = $basePath . 'acl/applications/acl';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Acl.";
		} else {
			$commande = "$diff {$baseLibrairie}acl $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Acl est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Acl n'est pas � jour";
				$differences[] = "";
			}
		}

		// Navigation
		$dossier = $basePath . 'navigation/application/navigation';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Navigation.";
		} else {
			$commande = "$diff {$baseLibrairie}navigation $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Navigation est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Navigation n'est pas � jour";
				$differences[] = "";
			}
		}

		// Langues
		$dossier = $basePath . 'langues/library/Mycsense/Langues';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Langues.";
		} else {
			$commande = "$diff {$baseLibrairie}Langues $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Langues est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Langues n'est pas � jour";
				$differences[] = "";
			}
		}

		$this->view->differences = implode("\n", $differences);

	}

}
