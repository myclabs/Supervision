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
		$dossier = $basePath . 'unites/library/Mycsense/Unites';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Unites.";
		} else {
			$commande = "$diff {$baseLibrairie}Unites $dossier 2>&1";
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
		$dossier = $basePath . 'acl/library/Mycsense/Acl';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet Acl.";
		} else {
			$commande = "$diff {$baseLibrairie}Acl $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Acl est � jour";
				$differences[] = "";
			} else {
				$differences[] = "Acl n'est pas � jour";
				$differences[] = "";
			}
		}

		// Pages et menus
		$dossier = $basePath . 'pagesmenus/library/Mycsense/PagesMenus';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de v�rifier le projet PagesMenus.";
		} else {
			$commande = "$diff {$baseLibrairie}PagesMenus $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "PagesMenus est � jour";
				$differences[] = "";
			} else {
				$differences[] = "PagesMenus n'est pas � jour";
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
