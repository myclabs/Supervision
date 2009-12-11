<?php
/**
 * Validateur
 * Design pattern singleton
 */
class Mycsense_Model_Validateur extends Mycsense_Modele_ObjetMetier_Singleton
{

	// Fichiers � analyser
	protected $_extensions = array('.php', '.phtml');

	// R�gles
	protected $_regles = array(
			'#throw new Exception ?\(#'
				=> "Ce type d'exceptions n'est pas autoris�",
			'#(public|protected|private) \$[A-Z]#'
				=> "L'attribut commence par une majuscule : contraire au guide de style",
			'#(protected|private) \$[a-z]#'
				=> "L'attribut prot�g� ou priv� ne commence pas par '_' : contraire au guide de style",
			'#^(class) extends Zend#'
				=> "L'h�ritage direct aux classes de Zend Framework n'est pas autoris�",
			'#extends Mycsense_Modele_DAO[^_]#'
				=> "Pas d'h�ritage directe � la classe abstraite DAO (il faut choisir une de ses classe fille)",
			'#if ?\(.*([^=!]+)=([^=]+)#'
				=> "Pas de '=' dans les if (confusion possible avec '==')",
			'#<\?([^p=])#'
				=> "Les balises PHP d'ouverture simples '&lt;?' ne sont pas autoris�es (cf. guide de style)",
			'#class ([A-Z]([a-z]+)_)?[A-Z]([a-z]+)([A-Z]+)([a-z]+)Controller#'
				=> "Pas de majuscules dans le nom des contr�leurs, � part majuscule initiale et 'Controller'",
			/*'#\$this\->_dbTable\->getAdapter\(\)#'
				=> "getAdapter() est une m�thode d�pr�ci�e. Voir le wiki pour les fonctions � utiliser",*/
			'#\$this\->getMapper\(\)#'
				=> "getMapper() est une m�thode statique, ne pas utiliser '\$this->' mais 'self::'",
			'#[^<]\?(.*):[^:]#'
				=> "Les 'if' contract� (...?...:...) ne sont pas autoris�s"
		);

	/**
	 * Valide le code source d'un projet
	 * @param string $dossier Dossier racine du projet (/trunk/)
	 * @return array(	'controleurs' => array[$nomFichier] => array[]['description', 'ligne', 'numLigne'],
	 * 					'vues' => array[$nomFichier] => array[]['description', 'ligne', 'numLigne'],
	 * 					'modele' => array[$nomFichier] => array[]['description', 'ligne', 'numLigne'],
	 * 					'librairie' => array[$nomFichier] => array[]['description', 'ligne', 'numLigne']
	 */
	public function validerProjet($dossier)
	{
		$retour = array();
		// Fixe le chemin d'acc�s avec "/" � la fin
		if (substr($dossier, -1) != DIRECTORY_SEPARATOR) {
			$dossier .= DIRECTORY_SEPARATOR;
		}
		// Controleurs
		$controleurs = $this->scannerDossier($dossier . 'application/controllers/');
		$retour['controleurs'] = $controleurs;
		// Vues
		$vues = $this->scannerDossier($dossier . 'application/views/scripts/');
		$retour['vues'] = $vues;
		// Mod�le
		$modele = $this->scannerDossier($dossier . 'application/models/');
		$retour['modele'] = $modele;
		// Librairie
		$librairie = $this->scannerDossier($dossier . 'library/Mycsense/');
		$retour['librairie'] = $librairie;
		return $retour;
	}

	/**
	 * Valide le code source de la librairie
	 * @param string $dossier Dossier racine du projet (/trunk/)
	 * @return array(	'librairie' => array[$nomFichier] => array[]['description', 'ligne', 'numLigne'] )
	 */
	public function validerLibrairie($dossier)
	{
		$retour = array();
		// Fixe le chemin d'acc�s avec "/" � la fin
		if (substr($dossier, -1) != DIRECTORY_SEPARATOR) {
			$dossier .= DIRECTORY_SEPARATOR;
		}
		// Librairie
		$librairie = $this->scannerDossier($dossier . 'Mycsense/');
		$retour['librairie'] = $librairie;
		return $retour;
	}

	/**
	 * Scanne recursivement un dossier
	 * @param string $dossier
	 * @return array[$nomFichier] => array[]['description', 'ligne', 'numLigne']
	 */
	protected function scannerDossier($dossier)
	{
		$retour = array();
		if (!is_dir($dossier)) {
			return $retour;
		}
		// Scanne le dossier courant
		$elements = scandir($dossier);
		$sousDossiers = array();
		// Analyse les dossiers et fichiers du dossier courant
		foreach ($elements as $element) {
			if (is_dir($dossier . DIRECTORY_SEPARATOR . $element)) {
				$sousDossiers[] = $element;
			} else {
				$extension = strrchr($element, '.');
				if (	(in_array($extension, $this->_extensions))
					&&	($dossier . $element != __FILE__)) {
					// Valide le fichier trouv�
					$erreurs = $this->validerFichier($dossier . $element);
					$retour[$dossier . $element] = $erreurs;
				}
			}
		}
		// Analyse les sous-dossiers
		foreach ($sousDossiers as $sousDossier) {
			// �vite les fichiers cach�s et "." et ".."
			if ($sousDossier[0] != '.') {
				$tableau = $this->scannerDossier($dossier . $sousDossier . DIRECTORY_SEPARATOR);
				// Utiliser cette syntaxe plutot que array_merge (cf doc en ligne)
				$retour = $retour + $tableau;
			}
		}
		return $retour;
	}

	/**
	 * Valide un fichier avec les r�gles
	 * @param string $fichier Chemin d'acc�s complet vers le fichier
	 * @return array[]['description', 'ligne', 'numLigne']
	 */
	protected function validerFichier($fichier)
	{
		$retour = array();
		$numLigne = 0;
		$handle = fopen($fichier, "r");
		if ($handle) {
			// Parcourt les lignes du fichier
			while (!feof($handle)) {
				$numLigne++;
				$ligne = fgets($handle, 4096);
				// Teste les r�gles
				foreach ($this->_regles as $regle => $message) {
					$trouve = preg_match($regle, $ligne);
					if ($trouve) {
						$retour[] = array(
							'ligne' => $ligne,
							'numLigne' => $numLigne,
							'description' => $message
						);
					}
				}
			}
			fclose($handle);
		}
		return $retour;
	}

}
