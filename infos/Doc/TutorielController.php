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

    public function __construct($config) {
        parent::__construct($config);
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
    }

    /**
     * @pattern /data
     * @return string
     */

    public function dataAction() {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nidoc";

        // Create connection
        $pdo = new \mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($pdo->connect_error) {
            die("Connection failed: " . $pdo->connect_error);
        }

        $sql = "";

        if (isset($_POST['projet'])) {
            $sql = "SELECT * FROM Module WHERE NumModule IN (SELECT NumModule FROM AssoModuleProjet WHERE NumProjet = " . $_POST['projet'] . ")";
        } else if (isset($_POST['module'])) {
            $sql = "SELECT * FROM Fonctionnalite WHERE NumFonctionnalite IN (SELECT NumFonctionnalite FROM AssoModuleFonctionnalite WHERE NumModule = " . $_POST['module'] . ")";
        }

        $result = $pdo->query($sql);

        $res = array();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $res[] = $row;
            }
        } else {
            echo "0 results";
        }
        $pdo->close();

        return json_encode($res);
    }

}