<?php

class TestsunitairesController extends MCS_Controller
{

    /**
     * Lancement des tests
     */
    public function executerAction()
    {
        //tests unitaires qui vont etre lancer
        $librairies = array(
            'Librairie' => array('nom' => 'librairie', 'chemin' => 'tests-librairie/tests'),
            'Base carbone' => array('nom' => 'basecarbone', 'chemin' => 'basecarbone/tests'),
            'Stations de montagne ' => array('nom' => 'stationsmontagne', 'chemin' => 'stationsmontagne/tests'),
            'Spiritueux ' => array('nom' => 'spiritueux', 'chemin' => 'spiritueux/tests'),
            'Utilisateurs' => array('nom' => 'utilisateurs', 'chemin' => 'utilisateurs/tests'),
            'Unites' => array('nom' => 'unites', 'chemin' => 'unites/tests'),
            'Navigation' => array('nom' => 'navigation', 'chemin' => 'navigation/tests'),
            'Acl' => array('nom' => 'acl', 'chemin' => 'acl/tests'),
            'International' => array('nom' => 'langues', 'chemin' => 'langues/tests'),
            'Calculs' => array('nom' => 'calculs', 'chemin' => 'calculs/tests'),
            'ModulesComptables' => array('nom' => 'modulescomptables', 'chemin' => 'modulescomptables/tests'),
        );
        //on transmet le tableau à la vue
        $this->view->librairies = $librairies;
        $this->view->post = false;
        //si le formulaire a été validé
        if ($this->getRequest()->isPost()) {
            $this->view->post = true;
            // Différences
            $phpunit = 'phpunit --verbose';
            $basePath = '/home/dev/';

            foreach ($librairies as $librairie) {
                //on recupere si la case du test a été coché
                $param = $this->_getParam($librairie['nom']);
                //si la case été coché alors on lance le test
                if ($param != null) {
                    $dossier = $basePath . $librairie['chemin'];
                    $commande = "$phpunit $dossier 2>&1";
                    $this->view->$librairie['nom'] = array();
                    exec($commande, $this->view->$librairie['nom'], $retour);
                }
            }
        }
    }

    public function librairiesAction()
    {
        $phpunit = 'phpunit --verbose';
        $basePath = '/home/dev/';
        $commandeSvnLog = "svn log --quiet --limit 5 --username scripts --password r9e2dij23a svn://localhost/";

        $librairies = array(
            'Stations de montagne' => array('tests' => 'stationsmontagne/tests', 'depot' => 'stationsmontagne'),
            'Spiritueux' => array('tests' => 'spiritueux/tests', 'depot' => 'spiritueux'),
            'Librairie' => array('tests' => 'tests-librairie/tests', 'depot' => 'myc-sensedev/trunk/library/MCS'),
            'Module Utilisateurs' => array('tests' => 'utilisateurs/tests',
                'depot' => 'myc-sensecentral/trunk/utilisateurs'),
            'Module International' => array('tests' => 'langues/tests', 'depot' => 'myc-sensecentral/trunk/locale'),
            'Module Unités' => array('tests' => 'unites/tests', 'depot' => 'myc-sensecentral/trunk/unites'),
            'Module Calculs' => array('tests' => 'unites/tests', 'depot' => 'myc-sensecentral/trunk/calculs'),
            'Module ACL' => array('tests' => 'acl/tests', 'depot' => 'myc-sensecentral/trunk/acl'),
            'Module Navigation' => array('tests' => 'navigation/tests', 'depot' => 'myc-sensecentral/trunk/navigation'),
            'Modules Comptables' => array('tests' => 'modulescomptables/tests',
                'depot' => 'myc-sensecentral/trunk/modulescomptables'),
        );

        $texte = "Rapport journalier des tests unitaires\n\n";
        // Exécution des tests
        foreach ($librairies as $librairie => $chemins) {
            $resultat = array();
            $dossier = $basePath . $chemins['tests'];
            $commande = "$phpunit $dossier 2>&1";
            exec($commande, $resultat, $retour);
            if (strpos($resultat[count($resultat) - 1], 'OK') !== false) {
                $texte .= "- ".$librairie." : OK\n\n";
            }
            else {
                $texte .= "- ".$librairie." : ERREUR\n";
                $texte .= "    Informations sur les 5 derniers commits :\n";
                // variante pour le grep :
                // grep '^r[0-9][0-9]*[^line]*[line]'
                $logs = array();
                exec($commandeSvnLog.$chemins['depot']." | grep -v '\-------------------' 2>&1", $logs, $retour);
                $personnes = array();
                foreach ($logs as $message) {
                    if ($message[0] == 'r' && is_numeric($message[1])) {
                        $infos = explode(' | ', $message);
                        $date = $infos[2];
                        if (empty($personnes[$infos[1]])) {
                            $personnes[$infos[1]] = 1;
                        }
                        else{
                            $personnes[$infos[1]]++;
                        }
                    }
                }
                foreach ($personnes as $personne => $nombreCommits) {
                    $texte .= "      > ".$personne. "(".$nombreCommits.")\n";
                }
                $texte .= "\n";
            }
        }
        $texte .= "Pour voir les details des erreurs, exécutez les tests en allant "
               . "sur la page http://dev.myc-sense.com/supervision/testsunitaires/executer";
        $texte = utf8_decode($texte);

        // Envoi du mail
        $mail = new Zend_Mail();
        $mail->setBodyText($texte);
        $mail->setFrom('rapports@myc-sense.com', 'Rapports Myc-sense');
        $mail->addTo('developpeurs@myc-sense.com', utf8_decode('Développeurs'));
        //$mail->addTo('benjamin.bertin@myc-sense.com', 'Développeurs');
        $mail->setSubject(utf8_decode("Rapport journalier"));
        $mail->send();
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
        $dossiers = array('acl', 'langues', 'navigation', 'unites', 'utilisateurs');
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
