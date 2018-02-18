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
     * @pattern /uploadXML
     * @return string
     */
    public function uploadXMLAction() {
        try {
        // Recuperation nom du fichier
            $basename = basename($_FILES['uploadXML']['name']);
        // Dossier d'upload
            $uploaddir = $this->config['root'] . '/temp/';
        // Nom complet avec dossier
            $uploadfile = $uploaddir . $basename;
        // Variable pour check si le fichier est coorect et a bien ete upload 
            $fileUploaded = false;
        // Recuperation extention fichier upload
            $ext = pathinfo($basename, PATHINFO_EXTENSION);

            if ($ext == "xml") {
            // Si l'extention est xml
                if (move_uploaded_file($_FILES['uploadXML']['tmp_name'], $uploadfile)) {
                    echo("Le fichier est valide, et a été téléchargé avec succès.\n");
                    $fileUploaded = true;
                } else {
                    echo("Erreur lors de l'upload du fichier.");
                }
            } else {
                echo("Extention du fichier non valide.");
            }

            if ($fileUploaded && @simplexml_load_file($uploaddir . $basename)) {
            // Si le fichier a bien ete upload et est bien charge par simplexml
            // @ pour ne pas afficher l'erreur si le chargement ne fonctionne pas

            // Recuperation du XMI
                $xml = simplexml_load_file($uploaddir . $basename);
                $xml->registerXPathNamespace("UML", "omg.org/UML1.3");

            // Recuperation des activites/debuts/fins/decisions/liens du XMI
                $actionStateList = $xml->xpath("//UML:ActionState");
                $pseudoStateList = $xml->xpath("//UML:PseudoState");
                $transitionList = $xml->xpath("//UML:Transition");

            // Creation des tableaux
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
                    if ($pseudoState->attributes()['kind'] == 'final') { 
                    // Si le pseudoState est une fin
                        $pseudoTab[] = new Fin((string)$pseudoState->attributes()["xmi.id"], (string)$pseudoState->attributes()["name"]);
                    } else if($pseudoState->attributes()['kind'] == 'branch') { 
                    // Si le pseudoState est une decision
                        $pseudoTab[] = new Decision((string)$pseudoState->attributes()["xmi.id"], (string)$pseudoState->attributes()["name"]);
                    } else { 
                    // Si le pseudoState est un debut
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

            //var_dump($actionTab);
            //var_dump($pseudoTab);
            //var_dump($transitionTab);

            $this->pdo->beginTransaction();

            // Recuperation depuis les parametres passes en POST
            $nomTutoriel = $_POST['inputTitre'];
            $descriptionTutoriel = $_POST['inputDescription'];

            // Date au format Y-m-d H:i:s
            $dateAdd = date('Y-m-d H:i:s');

            // Passage sous forme "un-nom-de-tutoriel"
            $referenceTutoriel = str_replace(' ', '-', strtolower($nomTutoriel));

            $stmt = $this->pdo->prepare("INSERT INTO Tutoriel (Nom, Description, DateAdd, Reference) VALUES (:nom, :description, :dateAdd :reference)");
            $stmt->bindParam(':nom', $nomTutoriel);
            $stmt->bindParam(':description', $descriptionTutoriel);
            $stmt->bindParam(':dateAdd', $dateAdd);
            $stmt->bindParam(':reference', $referenceTutoriel);
            $res = $stmt->execute();
            var_dump($res);
            if($res == FALSE){
                //throw new \Exception('Insertion tutoriel KO');
                exit('Insertion KO');
            }

            // Recuperation de l'ID du dernier Tutoriel
            $numTutoriel = $this->pdo->lastInsertId();

            // Recuperation de l'ID Fonctionnalite passe en POST TODO
            $numFonctionnalite = $_POST['selectFonct'];
            /*
            // Mise a jour de la fonctionnalite avec l'ID du Tutoriel
            $stmt = $this->pdo->prepare("UPDATE Fonctionnalite SET NumTutoriel = :numTutoriel WHERE NumFonctionnalite = :numFonctionnalite");
                $stmt->bindParam(':numTutoriel', $numTutoriel);
                $stmt->bindParam(':numFonctionnalite', $numFonctionnalite);
                $stmt->execute();
            */

            // Creation des Etapes dans la base de données
                foreach ($actionTab as $action) {

                // Récupération de l'ID dans le XML
                    $idGenereAction = $action->getId();
                // Récupération de la description
                    $libelleAction = $action->getLibelle();

                // Ajout de l'Etape dans la BDD
                    $stmt = $this->pdo->prepare("INSERT INTO Etape (Description, NumTutoriel, IdGenere) VALUES (:description, :numTutoriel, :idGenere)");
                    $stmt->bindParam(':description', $libelleAction);
                    $stmt->bindParam(':numTutoriel', $numTutoriel);
                    $stmt->bindParam(':idGenere', $idGenereAction);
                    $stmt->execute();
                }

            // Creation des Debuts/Fins/Choix
                foreach ($pseudoTab as $pseudo) {

                // Récupération de l'ID dans le XML
                    $idGenerePseudo = $pseudo->getId();
                // Récupération de la description
                    $libellePseudo = $pseudo->getLibelle();

                    if ($pseudo instanceof Decision) {
                    // Si c'est un choix
                        $stmt = $this->pdo->prepare("INSERT INTO Choix (Libelle, NumTutoriel, IdGenere) VALUES (:description, :numTutoriel, :idGenere)");
                    } else {
                        $stmt = $this->pdo->prepare("INSERT INTO Etape (Description, NumTutoriel, IdGenere) VALUES (:description, :numTutoriel, :idGenere)");
                    }
                    $stmt->bindParam(':description', $libellePseudo);
                    $stmt->bindParam(':numTutoriel', $numTutoriel);
                    $stmt->bindParam(':idGenere', $idGenerePseudo);
                    $stmt->execute();    
                }

                foreach ($transitionTab as $transition) {

                // Recuperation objet source et ID source
                    $sourceLien = $transition->getSource();
                    $idGenereSource = $sourceLien->getId();

                // Recuperation objet cible et ID cible
                    $cibleLien = $transition->getCible();
                    $idGenereCible = $cibleLien->getId();

                // Recuperation libelle Lien et ID Lien
                    $idGenereLien = $transition->getId();
                    $libelleLien = $transition->getLibelle();

                // Definition type source/cible
                    $typeSource = $sourceLien instanceof Decision ? "Choix" : "Etape";
                    $typeCible = $cibleLien instanceof Decision ? "Choix" : "Etape";

                    if ($sourceLien instanceof Decision) {
                    // Si la source est un Choix
                        if ($transition->getLibelle() !== "") {
                        // Si le Lien a un libelle
                        // Recuperation ID Choix source
                            $stmt = $this->pdo->prepare("SELECT NumChoix FROM Choix WHERE IdGenere = :idGenereSource");
                            $stmt->bindParam(':idGenereSource', $idGenereSource);
                            $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                $idSource = $row['NumChoix'];
                            }
                        } else {
                        // Sinon on annule la transaction
                            echo "<script>alert(\"Lien sans libelle\")</script>";
                            $this->pdo->rollback();
                        }
                    } else {
                    // Si la source est une Etape/Debut/Fin
                    // Recuperation ID Etape source
                        $stmt = $this->pdo->prepare("SELECT NumEtape FROM Etape WHERE IdGenere = :idGenereSource");
                        $stmt->bindParam(':idGenereSource', $idGenereSource);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            $idSource = $row['NumEtape'];
                        }
                    }
                    if ($cibleLien instanceof Decision) {
                    // Si la cible est un Choix
                    // Recuperation ID Choix cible
                        $stmt = $this->pdo->prepare("SELECT NumChoix FROM Choix WHERE IdGenere = :idGenereCible");
                        $stmt->bindParam(':idGenereCible', $idGenereCible);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            $idCible = $row['NumChoix'];
                        }
                    } else {
                    // Si la cible est une Etape/Debut/Fin
                    // Recuperation ID Etape cible
                        $stmt = $this->pdo->prepare("SELECT NumEtape FROM Etape WHERE IdGenere = :idGenereCible");
                        $stmt->bindParam(':idGenereCible', $idGenereCible);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            $idCible = $row['NumEtape'];
                        }
                    }

                // Ajout du Lien en BDD
                    $stmt = $this->pdo->prepare("INSERT INTO Lien (Libelle, NumSource, TypeSource, NumCible, TypeCible, NumTutoriel, IdGenere) 
                        VALUES (:libelle, :numSource, :typeSource, :numCible, :typeCible, :numTutoriel, :idGenere)");
                    $stmt->bindParam(':libelle', $libelleLien);
                    $stmt->bindParam(':numSource', $idSource);
                    $stmt->bindParam(':typeSource', $typeSource);
                    $stmt->bindParam(':numCible', $idCible);
                    $stmt->bindParam(':typeCible', $typeCible);
                    $stmt->bindParam(':numTutoriel', $numTutoriel);
                    $stmt->bindParam(':idGenere', $idGenereLien);
                    $stmt->execute();
                }

            // TODO REMPLACER ROLLBACK PAR COMMIT
            // Validation de la transaction
                $this->pdo->commit();
            }
        } catch(\PDOException $e) {
            echo($e->getMessage());
        } catch(\Exception $e) {
            echo($e->getMessage());
        }

        // Suppression du fichier XML
        unlink($uploaddir . $basename);
    }

    /**
     * @pattern /{_ADMIN_DIR_}/tutoriel/import
     * @return string
     */
    public function recupFromXMIAction() {

        // Récupération des fonctionnalités sans tutoriel
        $results = $this->pdo->query('SELECT * FROM Fonctionnalite WHERE NumTutoriel IS NULL')->fetchAll();

        $res = array();
        foreach ($results as $result) {
            $res[] = $result;
        }

        // Affichage template
        $this->smarty->assign('page', 'Ajout d\'un tutoriel');
        $this->smarty->assign('fonctionnalites', $res);
        return $this->smarty->fetch('ajout.tpl');

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