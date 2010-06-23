<?php

class TestsunitairesController extends MCS_Controller
{

    /**
     * Lancement des tests
     */
    public function executerAction()
    {
        // Différences
        $phpunit = 'phpunit --verbose';
        $basePath = '/home/dev/';

        // Base carbone
        $dossier = $basePath . 'basecarbone/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->basecarbone = array();
        exec($commande, $this->view->basecarbone, $retour);

        // Stations de montagne
        $dossier = $basePath . 'stationsmontagne/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->stationsmontagne = array();
        exec($commande, $this->view->stationsmontagne, $retour);

        // Utilisateurs
        $dossier = $basePath . 'utilisateurs/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->utilisateurs = array();
        exec($commande, $this->view->utilisateurs, $retour);

        // Unites
        $dossier = $basePath . 'unites/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->unites = array();
        exec($commande, $this->view->unites, $retour);

        // Acl
        $dossier = $basePath . 'acl/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->acl = array();
        exec($commande, $this->view->acl, $retour);

        // Navigation
        $dossier = $basePath . 'navigation/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->navigation = array();
        exec($commande, $this->view->navigation, $retour);

        // International
        $dossier = $basePath . 'langues/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->langues = array();
        exec($commande, $this->view->langues, $retour);
    }

    public function librairiesAction(){
        $phpunit = 'phpunit --verbose';
        $basePath = '/home/dev/';
        
        // Tableau contenant les chemins vers les modules de la librairie
        $librairies = array(
            'utilisateurs', 'unites', 'acl', 'navigation', 'langues'
        );
        
        $resultats = array();
        
        // Tableau qui va contenir les erreurs
        $erreurs = array();
        
        // Exécution des tests
        foreach($librairies as $librairie){
            $dossier = $basePath . $librairie;
            $commande = "$phpunit $dossier 2>&1";
            exec($commande, $resultats[$librairie], $retour);
        }
        
        // Recherche d'éventuelles erreurs
        foreach($resultats as $librairie => $resultat) {
            // Si c'est OK
            if (strpos($resultat[count($resultat)-1], 'OK') == false) {
                $erreurs[] = 'Une erreur est survenue lors de l\'exécution des tests unitaires sur le module '.$librairie.' de la librairie';
            }   
        }
        
        // Envoi du mail si on a des erreurs
        if(!empty($erreurs)){
            // Préparation du texte
            $texte = "Date : ".date('d-m-Y H:i:s')."\n\n";
            $texte .= "Les erreurs suivantes sont survenues lors des tests :\n";

            foreach($erreurs as $erreur){
                $texte .= "  - ".$erreur."\n";
            }
            
            $texte .= "\nPour voir les details des erreurs, exécutez les tests en allant sur la page http://dev.myc-sense.com/supervision/testsunitaires/librairies";
            
            $texte = utf8_decode($texte);
            
            // Envoi du mail
            $mail = new Zend_Mail();
            $mail->setBodyText($texte);
            $mail->setFrom('rapport@myc-sense.com', 'Rapports Myc-sense');
            //$mail->addTo('dev@myc-sense.com', 'Développeurs');
            $mail->addTo('vpreuvot@gmail.com', 'Développeurs');
            $mail->setSubject(utf8_decode("Rapport d'erreurs lors de l'exécution des tests unitaires"));
            $mail->send();
            
            echo 'mail envoye';
        }
        
        die();
    }
    
    /**
     * Génerer le rapport de couverture de code
     */
    public function generercouverturecodeAction()
    {
        $output = array();
        $basePath = '/home/dev';

        // Supprime les fichiers de test existant
        $output[] = 'Suppression des fichiers de test existant';
        $commande = "rm $basePath/testscomplets/tests/*.php 2>&1";
        exec($commande, $output, $retour);
        $output[] = '';

        // Copie des tests dans le dossier testscomplets
        $dossiers = array(	'acl', 'langues', 'navigation', 'unites', 'utilisateurs');
        foreach ($dossiers as $dossier) {
            $output[] = 'Copie des fichiers de test du projet "' . $dossier . '"';
            $commande = "cp $basePath/$dossier/tests/*.php $basePath/testscomplets/tests/ 2>&1";
            exec($commande, $output, $retour);
            $output[] = '';
        }

        // Supprime les classes de modèle existantes
        $output[] = 'Suppression des classes de modèle existantes';
        $commande = "rm -R $basePath/testscomplets/application/models/* 2>&1";
        exec($commande, $output, $retour);
        $output[] = '';

        // Copie des bases de données
        $basededonnees = array(
            'mcscentral_testsunitaires_acl',
            'mcscentral_testsunitaires_locale',
            'mcscentral_testsunitaires_navigation',
            'mcscentral_testsunitaires_unites',
            'mcscentral_testsunitaires_utilisateurs'
        );
        $mysqldump = "mysqldump -u root -pU8l4MdL0 --add-drop-table";
        $mysql = "mysql -u root -pU8l4MdL0";
        foreach ($basededonnees as $basededonnee) {
            $output[] = 'Copie de la base de données "' . $basededonnee . '"';
            $commande = "$mysqldump $basededonnee | $mysql mcscentral_testsunitaires_testscomplets 2>&1";
            exec($commande, $output, $retour);
            $output[] = '';
        }

        // Execution de phpdoc
        $output[] = 'Génération de la couverture de code';
        $phpunit = "phpunit --process-isolation --testdox";
        $phpunit .= " --configuration /home/dev/testscomplets/configuration.xml";
        $sortie = "$basePath/couverturecode";
        $source = "$basePath/testscomplets/tests";
        $this->view->commande = "nohup $phpunit --coverage-html $sortie $source "
            ."> /home/dev/couverturecode/log.txt 2>&1 &";
        exec($this->view->commande);
        $output[] = "Commande en cours d'exécution en tâche de fond. Ceci peut prendre plusieurs minutes.";
        $this->view->resultat = $output;
    }

    /**
     * Affiche le rapport de couverture de code
     */
    public function couverturecodeAction()
    {
    }

    /**
     * Affiche le log de la génération de couverture de code
     */
    public function logcouverturecodeAction()
    {
        $basePath = '/home/dev/';
        // Pages et menus
        $dossier = $basePath . 'langues/tests';
        $commande = "$phpunit $dossier 2>&1";
        $this->view->log = array();
        exec('cat /home/dev/couverturecode/log.txt', $this->view->log, $retour);
    }

}
