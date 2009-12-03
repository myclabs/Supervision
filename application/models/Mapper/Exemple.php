<?php
/**
 * Classe Data Mapper Exemple
 * Design Pattern singleton
 */
class Mycsense_Model_Mapper_Exemple extends Mycsense_Modele_Mapper
{

	// Variables de configuration de la classe
	private $_daoExempleNom = 'Mycsense_Model_DAO_Exemple';

	// Variables privées
	private $_daoExemple;

	/**
	 * Constructeur
	 */
	protected function __construct()
	{
		// Charge le DAO
		$daoNom = $this->_daoExempleNom;
		$this->_daoExemple = $daoNom::getInstance();
	}

	/**
	 * Charge un objet
	 * @param int $id ID de l'objet
	 */
	public function load($id, $objet)
	{
		$result = $this->_daoExemple->find($id);
		if (count($result) == 0) {
			throw new Exception('Impossible de charger l\'exemple : id inconnu');
		}
		$row = $result->current();
		$this->setAttributs($objet, $row);
	}

	/**
	 * Charge une liste d'objet
	 * @return array()
	 */
//	public function loadList($id) {}

	/**
	 * Sauvegarde un objet
	 * @param $objet
	 */
	public function save($objet)
	{
		// Prépare les attributs
		$data = array(
			'nom'	=> $objet->nom,
			'email'	=> $objet->email
		);
		// Si il faut créer l'objet
		if ($objet->id === null) {
			// Champ à null pour l'auto-increment
			unset($data['id']);
			$objet->id = $this->_daoExemple->insert($data);
		}
		// Mettre à jour l'objet
		else {
			$this->_daoExemple->update($data, array('id = ?' => $objet->id));
		}
	}

	/**
	 * Supprime l'objet
	 * @param $objet
	 */
	public function delete($objet)
	{
		if ($objet->id === null) {
			throw new Exception('Impossible de supprimer : pas d\'id');
		}
		$this->_daoExemple->delete(array('id = ?' => $objet->id));
		$objet->id = null;
	}

	/**
	 * Applique les valeurs de l'enregistrement à l'objet
	 * @param $objet Objet à modifier
	 * @param Zend_Db_Table_Row $row Enregistrement source des données
	 */
	public function setAttributs($objet, $row)
	{
		$objet->id		= $row->id;
		$objet->nom		= $row->nom;
		$objet->email	= $row->email;
	}

}
