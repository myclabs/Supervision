<?php
/**
 * @package Core
 */

/**
 * Copie des fichiers
 * @package Core
 */
class Core_OverloadDependencies extends Core_Script_OverloadDependencies
{
    /**
     * Run the populate script which copy the content of public's dependencies.
     */
    public function runLoad()
    {
        // Récupération de l'ensemble des dépendances.
        $dependencies = Zend_Registry::get('dependencies');
        // Parcours des dépendances.
        foreach ($dependencies as $dependency) {
            $dependencyName = strtolower($dependency->getName());
            // Parcours de la liste des dossiers à copier.
            foreach ($this->dirTypeAssoc as $dirName => $fileTypes) {
                $srcPath = $dependency->getPath().'/public/'.$dirName.'/'.$dependencyName;
                $destPath = PACKAGE_PATH.'/public/'.$dirName.'/'.$dependencyName;
                // Copie du dossier.
                $this->copyDir($srcPath, $destPath, $fileTypes);
            }
        }
    }

    /**
     * Run the populate script which overload the content of the public directory.
     */
    public function runOverload()
    {
        // Récupération de l'ensemble des dépendances.
        $dependencies = Zend_Registry::get('dependencies');
        // Parcours des dépendances.
        foreach ($dependencies as $dependency) {
            $dependencyName = strtolower($dependency->getName());
            // Parcours de la liste des dossiers à copier.
            foreach ($this->dirTypeAssoc as $dirName => $fileTypes) {
                $srcPath = PACKAGE_PATH.'/scripts/build/overloadDependencies/'.$dependencyName.'/'.$dirName;
                $destPath = PACKAGE_PATH.'/public/'.$dirName.'/'.$dependencyName;
                // Copie du dossier.
                $this->copyDir($srcPath, $destPath, $fileTypes);
            }
        }
    }
}
