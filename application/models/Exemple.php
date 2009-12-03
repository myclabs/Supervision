<?php
/**
 * Classe d'exemple de Mod�le
 * Design pattern multiton
 */
class Mycsense_Model_Exemple extends Mycsense_Modele_ObjetMetier
{

	// Attributs publics
	public $id;
	public $nom;
	public $email;

	// Attributs proteg�s
	protected $_passwordMd5;

	// Mapper
	protected static $_mapperNom = 'Mycsense_Model_Mapper_Exemple';

	/**
	 * Constructeur
	 */
	public function __construct()
	{
	}

	/**
	 * Retourne une instance de la classe correspondant � l'id
	 * @param $id ID de l'objet
	 */
	public static function load($id)
	{
		// Essaye de retrouver une instance existante
		$instance = self::ExisteInstance($id);
		if ($instance === null) {
			// R�cup�re une nouvelle instance
			$instance = new self();
			self::getMapper()->load($id, $instance);
			// Enregistre l'instance
			self::EnregistreInstance($id, $instance);
		}
		return $instance;
	}

	/**
	 * Sauvegarde les modifications faites � l'objet m�tier
	 */
	public function save()
	{
		self::getMapper()->save($this);
		// Enregistre l'instance
		self::EnregistreInstance($this->id, $this);
	}

	/**
	 * Supprime l'objet metier
	 */
	public function delete()
	{
		// D�senregistre l'instance
		self::RetireInstance($this->id);
		// Supprime
		self::getMapper()->delete($this);
	}

	// SET

	protected function setPassword($valeur)
	{
		$this->_passwordMd5 = md5($valeur);
	}

}
