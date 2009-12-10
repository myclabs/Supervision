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
			if ($retour == 0) {
				$differences[] = "Utilisateurs est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Utilisateurs n'est pas à jour";
				$differences[] = "";
			}
		}

		// Unites
		$dossier = $basePath . 'unites/library/Mycsense/Unites';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Unites.";
		} else {
			$commande = "$diff {$baseLibrairie}Unites $dossier 2>&1";
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
		$dossier = $basePath . 'acl/library/Mycsense/Acl';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet Acl.";
		} else {
			$commande = "$diff {$baseLibrairie}Acl $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "Acl est à jour";
				$differences[] = "";
			} else {
				$differences[] = "Acl n'est pas à jour";
				$differences[] = "";
			}
		}

		// Pages et menus
		$dossier = $basePath . 'pagesmenus/library/Mycsense/PagesMenus';
		if (!is_dir($dossier)) {
			$differences[] = "Impossible de vérifier le projet PagesMenus.";
		} else {
			$commande = "$diff {$baseLibrairie}PagesMenus $dossier 2>&1";
			exec($commande, $differences, $retour);
			if ($retour == 0) {
				$differences[] = "PagesMenus est à jour";
				$differences[] = "";
			} else {
				$differences[] = "PagesMenus n'est pas à jour";
				$differences[] = "";
			}
		}

		$this->view->differences = implode("\n", $differences);

	}

}
