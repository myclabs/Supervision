<?php

class IndexController extends Mycsense_Controller
{

	public function indexAction()
	{
		$this->_redirect("index/accueil");
	}

	public function accueilAction()
	{
		// Crée un nouvel enregistrement
		$objet = new Mycsense_Model_Exemple();
		$objet->nom = 'Martin';
		$objet->email = 'martin@mail.com';
		$objet->save();
		$this->view->exemple = $objet;
		$this->render();
	}

}
