<?php

namespace Doc;

use XMI\Debut;
use XMI\Fin;
use XMI\Base;
use XMI\Activite;
use XMI\Decision;
use XMI\Lien;
use XMI\Hydrator;

class TutorielController extends \Tiny\BaseController {

    public function __construct($config, $pdo) {
        parent::__construct($config, $pdo);
    }

    /**
     * @pattern /login
     * @return string
     */

    public function loginAction() {
        $this->smarty->assign('page', 'Connexion');
        return $this->smarty->fetch('login.tpl');
    }

    /**
     * @pattern /accueil
     * @return string
     */

    public function accueilAction() {

        // Récupération des projets de la base de données
        $projets = array();
        $request = $this->pdo->query('SELECT * FROM Projet');
        while ($donnees = $request->fetch(\PDO::FETCH_ASSOC)) {
            $projets[] = $donnees; 
        }

        $this->smarty->assign('page', 'Accueil');
        $this->smarty->assign('projets', $projets);
        return $this->smarty->fetch('accueil.tpl');
    }

    /**
     * @pattern /informations
     * @return string
     */

    public function informationsAction() {
        var_dump($_SESSION);
        /*
        $results = $this->pdo->query('SELECT * FROM Membre WHERE NumMembre = ' . $_SESSION)->fetchAll();

        $res = array();
        foreach ($results as $result) {
            $res[] = $result;
        }
        $this->smarty->assign('infos', $infos);*/

        $this->smarty->assign('page', 'Mes informations');
        return $this->smarty->fetch('informations.tpl');
    }

    /**
     * @pattern /fonctionnalite/{id}
     * @parameter id int
     * @return string
     */

    public function fonctionnaliteAction($id) {

        // Récupération des projets de la base de données
        $results = $this->pdo->query('SELECT * FROM Etape WHERE NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $id . ')')->fetchAll();

        $res = array();
        foreach ($results as $result) {
            $res[] = $result;
        }

        $this->smarty->assign('page', 'Tutoriel');
        $this->smarty->assign('etapes', $res);
        return $this->smarty->fetch('tutoriel.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/tutoriel/import
     * @return string
     */
    public function recupFromXMIAction() {

        // Recuperation du XMI
        $xml = simplexml_load_file($this->config["root"] . '/temp/publier_chaque_variation.xml');
        $xml->registerXPathNamespace("UML", "omg.org/UML1.3");

        // Recuperation des activites/debuts/fins/decisions/liens du XMI
        $actionStateList = $xml->xpath("//UML:ActionState");
        $pseudoStateList = $xml->xpath("//UML:PseudoState");
        $transitionList = $xml->xpath("//UML:Transition");

        $actionTab = array();
        $pseudoTab = array();
        $transitionTab = array();
        $allTab = array();

        foreach ($actionStateList as $actionState) {
            // Creation de chaque activite depuis le tableau
            $actionTab[] = new Activite((string)$actionState->attributes()["xmi.id"], (string)$actionState->attributes()["name"]);
            $allTab[] = end($actionTab);
        }
        foreach ($pseudoStateList as $pseudoState) {
            if ($pseudoState->attributes()['kind'] == 'final') { // Si le pseudoState est une fin
                $pseudoTab[] = new Fin((string)$pseudoState->attributes()["xmi.id"], (string)$pseudoState->attributes()["name"]);
            } else if($pseudoState->attributes()['kind'] == 'branch') { // Si le pseudoState est une decision
                $pseudoTab[] = new Decision((string)$pseudoState->attributes()["xmi.id"], (string)$pseudoState->attributes()["name"]);
            } else { // Si le pseudoState est un debut
                $pseudoTab[] = new Debut((string)$pseudoState->attributes()["xmi.id"], (string)$pseudoState->attributes()["name"]);
            }
            $allTab[] = end($pseudoTab);
        }

        // Si le lien part d'une décision et n'a pas de libelle, abort 

        foreach ($transitionList as $transition) {
            $sourceId = (string)$transition->attributes()["source"];
            $cibleId = (string)$transition->attributes()["target"];
            $source = null;
            $cible = null;
            foreach ($allTab as $all) {
                // Parcours de toutes les Actions pour trouver la source et la cible
                if ($all->getId() == $sourceId){
                    $source = $all;
                }
                if($all->getId() == $cibleId){
                    $cible = $all;
                }
            }
            if ($cible != null && $source != null) { // Si on a bien trouve une source et une cible
                $transitionTab[] = new Lien((string)$transition->attributes()["xmi.id"], (string)$transition->attributes()["name"], $source, $cible);
            }
        }

        var_dump($actionTab);
        echo "--------------------------------------------------------------------------------------------------------------------------------------";
        var_dump($pseudoTab);
        echo "--------------------------------------------------------------------------------------------------------------------------------------";
        var_dump($transitionTab);


        $sql = "SELECT MAX(NumTutoriel) FROM Tutoriel";
        $numTutoriel = $this->pdo->query($sql)->fetch();
        $numTutoriel = $numTutoriel[0] + 1;
        
        /*
        $sql = $this->pdo->prepare("INSERT INTO TUTORIEL (NumTutoriel) VALUES (:numTutoriel)");
        $sql->bindParam(':numTutoriel', $numTutoriel);
        $sql->execute();
        
        foreach ($actionTab as $action) {
            $description = $action->getLibelle();
            $sql = $this->pdo->prepare("INSERT INTO ETAPE (Description, NumTutoriel) VALUES (:description, :numTutoriel)");
            $sql->bindParam(':description', $description);
            $sql->bindParam(':numTutoriel', $numTutoriel);
            $sql->execute();
        }*/

    }

    /**
     * @pattern /data
     * @return string
     */

    public function dataAction() {

        $sql = "";

        if (isset($_POST['projet'])) {
            $sql = "SELECT * FROM Module WHERE NumModule IN (SELECT NumModule FROM AssoModuleProjet WHERE NumProjet = " . $_POST['projet'] . ")";
        } else if (isset($_POST['module'])) {
            $sql = "SELECT * FROM Fonctionnalite WHERE NumFonctionnalite IN (SELECT NumFonctionnalite FROM AssoModuleFonctionnalite WHERE NumModule = " . $_POST['module'] . ")";
        } else if (isset($_POST['tutoriel'])) {
            $sql = "SELECT * FROM Fonctionnalite WHERE NumTutoriel = " . $_POST['tutoriel'];
        }

        $results = $this->pdo->query($sql)->fetchAll();

        $res = array();

        foreach ($results as $result) {
            $res[] = $result;
        }

        /*
        echo('<pre>'); 
        print_r($res); 
        echo('</pre>');
        */

        return json_encode($res);
    }

}