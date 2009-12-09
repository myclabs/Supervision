<?php

class ValidateurController extends Mycsense_Controller
{

	public function validerAction()
	{
		$dossier = '/Users/matthieu/Travail/myC-sense/';
		$validateur = Mycsense_Model_Validateur::getInstance();
		// Valide les projets
		$this->view->basecarbone = $validateur->validerProjet($dossier . 'basecarbone/trunk');
		$this->view->stationsmontagne = $validateur->validerProjet($dossier . 'stationsmontagne/trunk');
		$this->view->unites = $validateur->validerProjet($dossier . 'myc-sensecentral/trunk/unites');
		$this->view->utilisateurs = $validateur->validerProjet($dossier . 'myc-sensecentral/trunk/utilisateurs');
		$this->view->acl = $validateur->validerProjet($dossier . 'myc-sensecentral/trunk/acl');
		$this->view->pagesmenus = $validateur->validerProjet($dossier . 'myc-sensecentral/trunk/pagesmenus');
		$this->view->langues = $validateur->validerProjet($dossier . 'myc-sensecentral/trunk/langues');
		$this->view->supervision = $validateur->validerProjet($dossier . 'supervision/trunk');
		$this->view->librairie = $validateur->validerLibrairie($dossier . 'myc-sensedev/ressources/library');
	}

}
