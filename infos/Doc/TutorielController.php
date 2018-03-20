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

        $tuto = $this->pdo->query('SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $id)->fetch()[0];

        if($tuto != null) {

        // Récupération des étapes de la base de données
            $results = $this->pdo->query('SELECT * FROM Etape WHERE NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $id . ')')->fetchAll();

            $etapes = array();
            foreach ($results as $result) {
                $etapes[] = $result;
            }

        // Récupération des étapes de la base de données
            $results = $this->pdo->query('SELECT * FROM Choix WHERE NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $id . ')')->fetchAll();

            $choix = array();
            foreach ($results as $result) {
                $choix[] = $result;
            }

        // Récupération des étapes de la base de données
            $results = $this->pdo->query('SELECT * FROM Lien WHERE NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $id . ')')->fetchAll();

            $liens = array();
            foreach ($results as $result) {
                $liens[] = $result;
            }

        //var_dump($choix);
        //var_dump($etapes);
        //var_dump($liens);

            $entities = array();

        // Chercher le début :

        /*SELECT * FROM Etape
        WHERE Etape.NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = 1)
        AND Etape.NumEtape IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape')
        AND Etape.NumEtape NOT IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')*/

        // Chercher la fin :

        /*SELECT * FROM Etape
        WHERE Etape.NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = 1)
        AND Etape.NumEtape NOT IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape')
        AND Etape.NumEtape IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')*/


        $debut = $this->pdo->query("SELECT * FROM Etape WHERE Etape.NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = " . $id . ") AND Etape.NumEtape IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape') AND Etape.NumEtape NOT IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')")->fetch();


        $fin = $this->pdo->query("SELECT * FROM Etape WHERE Etape.NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = " . $id . ") AND Etape.NumEtape NOT IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape') AND Etape.NumEtape IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')")->fetch();

        //var_dump($debut);

        $numTutoriel = $debut['NumTutoriel'];

        $etape = $debut;

        do {
            if (array_key_exists('NumEtape', $etape)) {
                $numEtape = $etape['NumEtape'];
            } else if (array_key_exists('NumChoix', $etape)){
                $numEtape = $etape['NumChoix'];
            }
            /* else if (array_key_exists('NumEtape', $etape[0])){
                $numEtape = $etape[0]['NumEtape'];
            } else if (array_key_exists('NumChoix', $etape[0])){
                $numEtape = $etape[0]['NumChoix'];
            }*/

            $typeCible = $this->pdo->query("SELECT TypeCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " . $debut['NumTutoriel'])->fetch()[0];
            //var_dump("type" . $typeCible);

            //var_dump($etape);
            //var_dump($numEtape);
            //var_dump($numTutoriel);

            if ($typeCible == "Etape") {
                //echo ('etape ' . $etape['Description'] . '<br>');
                $suivant = $this->pdo->query("SELECT * FROM Etape WHERE NumEtape IN (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = "
                 . $numTutoriel . " AND TypeCible = 'Etape')")->fetch();
            } else if ($typeCible == "Choix"){
                //echo ('choix ' . $etape['Description']);
                //var_dump($etape);
                $suivant = $this->pdo->query("SELECT * FROM Choix WHERE NumChoix = (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " 
                    . $numTutoriel . " AND TypeCible = 'Choix')")->fetch();

            }

            $etape = $suivant;
            if ($suivant != $fin) {
                $entities[] = $suivant;
            }

        } while ($typeCible == "Etape"); // Jusqu'a ce qu'on trouve la fin
       // var_dump($entities);


        // Parcours de mon arbre
        // A chaque sortie d'entite, la stocker dans le tableau $entities

        $this->smarty->assign('page', 'Tutoriel');
        $this->smarty->assign('etapes', $entities);
        $this->smarty->assign('tutoriel', $numTutoriel);

        // Ajax
        $this->smarty->assign('WEB_ROOT', WEB_ROOT);
        $this->smarty->assign('ADMIN_DIR', _ADMIN_DIR_);
        return $this->smarty->fetch('tutoriel.tpl');


    } else {
        $this->smarty->assign('page', 'Tutoriel');
        return $this->smarty->fetch('notuto.tpl');
    }
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
        // Recuperation extention fichier upload
            $ext = pathinfo($basename, PATHINFO_EXTENSION);

            if ($ext == "xml") {
            // Si l'extention est xml
                if (move_uploaded_file($_FILES['uploadXML']['tmp_name'], $uploadfile)) {

                } else {
                    exit("Erreur lors de l'upload du fichier.");
                }
            } else {
                exit("Extention du fichier non valide.");
            }

            libxml_use_internal_errors(TRUE);

            if (simplexml_load_file($uploaddir . $basename)) {
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

            $stmt = $this->pdo->prepare("INSERT INTO Tutoriel (Nom, Description, DateAdd, Reference) VALUES (:nom, :description, :dateAdd, :reference)");
            $stmt->bindParam(':nom', $nomTutoriel);
            $stmt->bindParam(':description', $descriptionTutoriel);
            $stmt->bindParam(':dateAdd', $dateAdd);
            $stmt->bindParam(':reference', $referenceTutoriel);
            $res = $stmt->execute();
            if($res == FALSE){
                throw new \Exception('Problème lors de l\'insertion du tutoriel.');
            }

            // Recuperation de l'ID du dernier Tutoriel
            $numTutoriel = $this->pdo->lastInsertId();

            // Recuperation de l'ID Fonctionnalite passe en POST TODO
            $numFonctionnalite = $_POST['selectFonct'];

            // Mise a jour de la fonctionnalite avec l'ID du Tutoriel
            $stmt = $this->pdo->prepare("UPDATE Fonctionnalite SET NumTutoriel = :numTutoriel WHERE NumFonctionnalite = :numFonctionnalite");
            $stmt->bindParam(':numTutoriel', $numTutoriel);
            $stmt->bindParam(':numFonctionnalite', $numFonctionnalite);
            $stmt->execute();


            // Creation des Etapes dans la base de données
            foreach ($actionTab as $action) {

                // Récupération de l'ID dans le XML
                $idGenereAction = $action->getId();
                // Récupération de la description
                $libelleAction = $action->getLibelle();

                if (ctype_space($libelleAction) || empty($libelleAction)) {
                    $this->pdo->rollback();
                    throw new \Exception('Fichier invalide, il manque un libellé.');
                } else {
                    // Ajout de l'Etape dans la BDD
                    $stmt = $this->pdo->prepare("INSERT INTO Etape (Description, NumTutoriel, IdGenere) VALUES (:description, :numTutoriel, :idGenere)");
                    $stmt->bindParam(':description', $libelleAction);
                    $stmt->bindParam(':numTutoriel', $numTutoriel);
                    $stmt->bindParam(':idGenere', $idGenereAction);
                    $stmt->execute();
                }

            }

            // Creation des Debuts/Fins/Choix
            foreach ($pseudoTab as $pseudo) {

                // Récupération de l'ID dans le XML
                $idGenerePseudo = $pseudo->getId();
                // Récupération de la description
                $libellePseudo = $pseudo->getLibelle();

                if (ctype_space($libellePseudo) || empty($libellePseudo)) {
                    $this->pdo->rollback();
                    throw new \Exception('Fichier invalide, il manque un libellé.');
                } else {
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
                        $this->pdo->rollback();
                        throw new \Exception('Fichier invalide, il manque un libellé.');
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

            // Validation de la transaction
            $this->pdo->commit();
            echo("Le tutoriel à bien été enregistré.");
        } else {
                // Exception

            $libxmlErrors = libxml_get_errors();
            $erreur = "Erreur de chargement du fichier XML:";
            foreach ($libxmlErrors as $libxmlError) {
                $erreur.= "<br />" . $libxmlError->message;
            }
            echo $erreur;
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
        $results = $this->pdo->query('SELECT * FROM Module')->fetchAll();

        $modules = array();
        foreach ($results as $result) {
            $modules[] = $result;
        }

        $dropdown = '';

        foreach ($modules as $module) {

        // Récupération des fonctionnalités sans tutoriel
            $results = $this->pdo->query('SELECT * FROM Fonctionnalite WHERE NumFonctionnalite IN (SELECT NumFonctionnalite FROM AssoModuleFonctionnalite WHERE NumModule = ' . $module['NumModule'] . ')')->fetchAll();

            $foncts = array();
            foreach ($results as $result) {
                $foncts[] = $result;
            }
            // Création libellé module
            $dropdown .= '<optgroup label="' . $module['Nom'] . '">';

            // Création du dropdown contenant les fonctionnalités
            foreach ($foncts as $fonct) {
                $tuto = $this->pdo->query('SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = ' . $fonct['NumFonctionnalite'])->fetch();
                $dropdown .= '<option id="' . $fonct['NumFonctionnalite'] . '"';
                $dropdown .= ($tuto['NumTutoriel'] != null) ? ' disabled' : "" ;
                $dropdown .= '>' . $fonct['Nom'] . '</option>';
            }
            $dropdown .= '</optgroup>';
        }

        // Affichage template
        $this->smarty->assign('page', 'Ajout d\'un tutoriel');
        $this->smarty->assign('html', $dropdown);
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

    /**
     * @pattern /{_ADMIN_DIR_}/getSuivant
     * @return string
     */

    public function getSuivantAction() {

        header('Content-Type: application/json');


        if (isset($_POST['numId']) && $_POST['numTuto'] && $_POST['estUnChoix']){
            $numEtape = $_POST['numId'];
            $numTutoriel = $_POST['numTuto'];
            $estUnChoix = $_POST['estUnChoix'];


            // probleme lié au paramètre envoyé en ajax qi est un string au lieu d'un bool. La conversion string vers bool ne marche pas.
            // le code ci-dessous résout le problème.            
            if ($estUnChoix == "true")
                $boolEstUnChoix = true;
            else
                $boolEstUnChoix = false;


            // si c'est un Choix, on affiche uniquement les étapes correspondantes
            if ($boolEstUnChoix == true){
                $type = 'Choix';

                $queryChoix = "SELECT * FROM Etape WHERE NumEtape IN (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " 
                . $numTutoriel . " AND TypeSource LIKE \"" . $type . "\")";

                $results = $this->pdo->query($queryChoix)->fetchALL();


                $choix = array();
                
                foreach ($results as $result) {
                    $choix[] = $result;
                }

                echo(json_encode($choix));

            }

            // si c'est une Etape choisie, on affiche toutes les étapes jusqu'à avoir un prochain choix
            else {
                if (!isset($_POST['numFonctionnalite']))
                    throw new \Exception("Le paramètre numFonctionnalite n'a pas ete envoye par HTTP POST");

                $numFonctionnalite = $_POST['numFonctionnalite'];
                //pour s'arreter d'itérer plus tard
                $fin = $this->pdo->query("SELECT * FROM Etape WHERE Etape.NumTutoriel = (SELECT NumTutoriel FROM Fonctionnalite WHERE NumFonctionnalite = " . $numFonctionnalite . ") AND Etape.NumEtape NOT IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape') AND Etape.NumEtape IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')")->fetch();


                //$type = 'Etape';

                //$queryEtapes = "SELECT * FROM Etape WHERE NumEtape IN (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " . $numTutoriel . " AND TypeSource LIKE \"" . $type . "\")";

                //utilisation d'un bout de la fonction située en haut du fichier : $this->fonctionnaliteAction($id)


                $entities = array();
                $suivant = null;
                do {


                    if ($suivant) //si suivant n'est pas null, on change de numEtape
                    $numEtape = $suivant['NumEtape'];

                    $typeCible = $this->pdo->query("SELECT TypeCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " . $numTutoriel)->fetch()[0];

                    if ($typeCible == "Etape") {

                        $suivant = $this->pdo->query("SELECT * FROM Etape WHERE NumEtape IN (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = "
                            . $numTutoriel . " AND TypeCible = 'Etape')")->fetch();
                    } 

                    else if ($typeCible == "Choix"){
                        $suivant = $this->pdo->query("SELECT * FROM Choix WHERE NumChoix = (SELECT NumCible FROM Lien WHERE NumSource = " . $numEtape . " AND NumTutoriel = " 
                            . $numTutoriel . " AND TypeCible = 'Choix')")->fetch();
                    }

                    /* $etape = $suivant;*/
                    if ($suivant != $fin) {
                        $entities[] = $suivant;
                    }

                } while ($typeCible == "Etape"); 

                echo(json_encode($entities));

            }//else (c'est une étape)

        } // if $_POST valide

        else
            throw new \Exception ("Les données attendues n'ont pas été transmises par HTTP POST");
    }


    
}