<?php

namespace Doc;

class AdminController extends \Tiny\BaseController {

    public function __construct($config, $pdo) {
        parent::__construct($config, $pdo);
    }

    /**
     * @pattern /{_ADMIN_DIR_}/accueil
     * @return string
     */

    public function adminAccueilAction() {
        $this->smarty->assign('page', 'Accueil');
        return $this->smarty->fetch('accueiladmin.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/projets
     * @return string
     */

    public function adminProjetsAction() {

        // Récupération des projets de la base de données
        $projets = array();
        $request = $this->pdo->query('SELECT * FROM Projet');
        while ($donnees = $request->fetch(\PDO::FETCH_ASSOC)) {
            $projets[] = $donnees; 
        }
        // Passage des variables pour l'appel Ajax
        $this->smarty->assign('WEB_ROOT', WEB_ROOT);
        $this->smarty->assign('ADMIN_DIR', _ADMIN_DIR_);
        $this->smarty->assign('projets', $projets);
        $this->smarty->assign('page', 'Gestion des Projets');
        return $this->smarty->fetch('projets.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/modules
     * @return string
     */

    public function adminModulesAction() {

        // Récupération de tous les projets
        $sql = "SELECT * FROM Projet";
        $results = $this->pdo->query($sql)->fetchAll();
        $projets = array();
        foreach ($results as $result) {
            $projets[] = $result;
        }

        // Récupération de tous les modules
        $sql = "SELECT * FROM Module";
        $results = $this->pdo->query($sql)->fetchAll();
        $modules = array();
        foreach ($results as $result) {
            $modules[] = $result;
        }

        $str = '<thead><tr><th scope="col"></th>';

        // Ajout des noms de projets en haut du tableau
        foreach ($projets as $projet) {
            $str .= '<th scope="col">' . $projet['Nom'] . '</th>';
        }

        $str .= '</tr></thead><tbody><tr>';

        // Création des lignes du tableau
        foreach ($modules as $module) {
            $str .= '<th scope="row">' . $module['Nom'] . '</th>';
            foreach ($projets as $projet) {

                // Check si le module est affecté au projet
                $sql = "SELECT * FROM AssoModuleProjet WHERE NumProjet = " . $projet['NumProjet'] . " AND NumModule = " . $module['NumModule'];
                $assoModuleProjet = $this->pdo->query($sql)->fetch();

                $str .= '<td><input type="checkbox" class="form-check-input" ';

                // Si le module est affecté on check la case
                if  ($assoModuleProjet) { 
                    $str.= 'checked ';
                }
                $str .= ' id="p' . $projet['NumProjet'] . '-m' . $module['NumModule'] . '" data-idProjet="' . $projet['NumProjet'] . '" data-idModule="' . $module['NumModule'] . '"></td>';
            }
            $str .= '</tr>';
        }

        $str .= '</tr></tbody>';

        // Passage de la chaîne crée au template
        $this->smarty->assign('table', $str);
        // Passage des variables pour l'appel Ajax
        $this->smarty->assign('WEB_ROOT', WEB_ROOT);
        $this->smarty->assign('ADMIN_DIR', _ADMIN_DIR_);
        $this->smarty->assign('page', 'Gestion des Modules');
        return $this->smarty->fetch('modules.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/fonctionnalites
     * @return string
     */

    public function adminFonctionsAction() {

        // Récupération de tous les modules
        $sql = "SELECT * FROM Module";
        $results = $this->pdo->query($sql)->fetchAll();
        $modules = array();
        foreach ($results as $result) {
            $modules[] = $result;
        }

        // Récupération de toutes les fonctionnalités
        $sql = "SELECT * FROM Fonctionnalite";
        $results = $this->pdo->query($sql)->fetchAll();
        $fonctionnalites = array();
        foreach ($results as $result) {
            $fonctionnalites[] = $result;
        }

        $str = '<thead><tr><th scope="col"></th>';

        // Ajout des noms de modules en haut du tableau
        foreach ($modules as $module) {
            $str .= '<th scope="col">' . $module['Nom'] . '</th>';
        }

        $str .= '</tr></thead><tbody><tr>';

        // Création des lignes du tableau
        foreach ($fonctionnalites as $fonctionnalite) {
            $str .= '<th scope="row">' . $fonctionnalite['Nom'] . '</th>';
            foreach ($modules as $module) {

                // Check si la fonctionnalité est affecté au module
                $sql = "SELECT * FROM AssoModuleFonctionnalite WHERE NumModule = " . $module['NumModule'] . " AND NumFonctionnalite = " . $fonctionnalite['NumFonctionnalite'];

                $assoModuleFonctionnalie = $this->pdo->query($sql)->fetch();

                $str .= '<td><input type="checkbox" class="form-check-input" ';

                // Si la fonctionnalité est affecté on check la case
                if  ($assoModuleFonctionnalie) { 
                    $str.= 'checked ';
                }
                $str .= ' id="m' . $module['NumModule'] . '-f' . $fonctionnalite['NumFonctionnalite'] . '" data-idModule="' . $module['NumModule'] . '" data-idFonctionnalite="' . $fonctionnalite['NumFonctionnalite'] . '"></td>';
            }
            $str .= '</tr>';
        }

        $str .= '</tr></tbody>';

        //echo('<table class="table">' . $str . '</table>');

        // Passage de la chaîne crée au template
        $this->smarty->assign('table', $str);
        // Passage des variables pour l'appel Ajax
        $this->smarty->assign('WEB_ROOT', WEB_ROOT);
        $this->smarty->assign('ADMIN_DIR', _ADMIN_DIR_);
        $this->smarty->assign('page', 'Gestion des Fonctions');
        return $this->smarty->fetch('fonctionnalites.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/updateLibelleProjet
     * @return string
     */

    public function updateLibelleProjetAction() {
        // Check si les informations sont passées
        if (isset($_POST['idProjet']) && isset($_POST['libelleProjet'])) {
            $idProjet = $_POST['idProjet'];
            $libelleProjet = $_POST['libelleProjet'];

            // Mise à jour en base de données du libelle du projet
            $stmt = $this->pdo->prepare("UPDATE Projet SET Nom = :libelle WHERE NumProjet = :id");
            $stmt->bindParam(':libelle', $libelleProjet);
            $stmt->bindParam(':id', $idProjet);
            $res = $stmt->execute();
            // Retour
            if ($res) {
                echo("Mise à jour réussie !");
            } else {
                echo("Echec de la mis à jour.");
            }
        }
    }

    /**
     * @pattern /{_ADMIN_DIR_}/updateFonctionnaliteModule
     * @return string
     */

    public function updateFonctionnaliteModuleAction() {
        // Récupération informations passées en paramètres
        $checks = json_decode($_POST['check']);
        // Début de la transaction
        $this->pdo->beginTransaction();
        $message = "Erreur lors de l'enregistrement des informations.";
        //Parcours des informations passées
        foreach ($checks as $check) {
            // Récupérations des informations
            $module = $check->module;
            $fonctionnalite = $check->fonctionnalite;
            $checked = $check->checked;

            // Récupération de l'entrée de la base de données pour le module et la fonctionnalité correspondants
            $stmt = $this->pdo->prepare("SELECT * FROM AssoModuleFonctionnalite WHERE NumModule = :module AND NumFonctionnalite = :fonctionnalite");
            $stmt->bindParam(':module', $module);
            $stmt->bindParam(':fonctionnalite', $fonctionnalite);
            $stmt->execute();
            $infos = false;
            while ($row = $stmt->fetch()) {
                // Si il existe déjà une entrée
                $infos = true;
            }

            $sql = "";
            if ($checked && !$infos) {
                // Si c'est une case cochée et qu'il y n'y a pas d'entrée dans la base de données
                $sql = "INSERT INTO AssoModuleFonctionnalite (NumModule, NumFonctionnalite) VALUES (:module, :fonctionnalite)";
            } else if(!$checked && $infos) {
                // Si c'est une case décochée et qu'il y a une entrée de case cochée dans la base de données
                $sql = "DELETE FROM AssoModuleFonctionnalite WHERE NumModule = :module AND NumFonctionnalite = :fonctionnalite";
            }
            if (!ctype_space($sql) && $sql != "") {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':module', $module);
                $stmt->bindParam(':fonctionnalite', $fonctionnalite);
                $stmt->execute();          
            }
            // Message de retour
            $message = "Modifications enregistrées.";
        }
        // Validation de la transaction
        $this->pdo->commit();
        return $message;
    }

    /**
     * @pattern /{_ADMIN_DIR_}/updateModuleProjet
     * @return string
     */

    public function updateModuleProjetAction() {
        // Récupération informations passées en paramètres
        $checks = json_decode($_POST['check']);
        // Début de la transaction
        $this->pdo->beginTransaction();
        $message = "Erreur lors de l'enregistrement des informations.";
        //Parcours des informations passées
        foreach ($checks as $check) {
            // Récupérations des informations
            $module = $check->module;
            $projet = $check->projet;
            $checked = $check->checked;

            // Récupération de l'entrée de la base de données pour le module et la fonctionnalité correspondants
            $stmt = $this->pdo->prepare("SELECT * FROM AssoModuleProjet WHERE NumModule = :module AND NumProjet = :projet");
            $stmt->bindParam(':module', $module);
            $stmt->bindParam(':projet', $projet);
            $stmt->execute();
            $infos = false;
            while ($row = $stmt->fetch()) {
                // Si il existe déjà une entrée
                $infos = true;
            }

            $sql = "";
            if ($checked && !$infos) {
                // Si c'est une case cochée et qu'il y n'y a pas d'entrée dans la base de données
                $sql = "INSERT INTO AssoModuleProjet (NumModule, NumProjet) VALUES (:module, :projet)";
            } else if(!$checked && $infos) {
                // Si c'est une case décochée et qu'il y a une entrée de case cochée dans la base de données
                $sql = "DELETE FROM AssoModuleProjet WHERE NumModule = :module AND NumProjet = :projet";
            }
            if (!ctype_space($sql) && $sql != "") {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':module', $module);
                $stmt->bindParam(':projet', $projet);
                $stmt->execute();          
            }
            // Message de retour
            $message = "Modifications enregistrées.";
        }
        // Validation de la transaction
        $this->pdo->commit();
        return $message;
    }

    /**
     * @pattern /{_ADMIN_DIR_}/medias
     * @return string
     */

    public function adminMediasAction() {

        // Récupération des fonctionnalités sans tutoriel
        $results = $this->pdo->query('SELECT * FROM Tutoriel')->fetchAll();

        $tutoriels = array();
        foreach ($results as $result) {
            $tutoriels[] = $result;
        }

        $dropdown = '';

        foreach ($tutoriels as $tutoriel) {

            // Récupération des etapes qui ne sont pas débuts ou fins
            $results = $this->pdo->query("SELECT * FROM Etape WHERE  NumTutoriel = " . $tutoriel['NumTutoriel'] . " AND Etape.NumEtape IN (SELECT NumSource FROM Lien WHERE Lien.TypeSource LIKE 'Etape') AND Etape.NumEtape IN (SELECT NumCible FROM Lien WHERE Lien.TypeCible LIKE 'Etape')")->fetchAll();

            $etapes = array();
            foreach ($results as $result) {
                $etapes[] = $result;
            }
            // Création libellé module
            $dropdown .= '<optgroup label="' . $tutoriel['Nom'] . '">';

            // Création du dropdown contenant les fonctionnalités
            foreach ($etapes as $etape) {
                $dropdown .= '<option id="' . $etape['NumEtape'] . '">' . $etape['Description'] . '</option>';
            }
            $dropdown .= '</optgroup>';
        }

        $this->smarty->assign('html', $dropdown);
        // Passage des variables pour l'appel Ajax
        $this->smarty->assign('WEB_ROOT', WEB_ROOT);
        $this->smarty->assign('ADMIN_DIR', _ADMIN_DIR_);
        $this->smarty->assign('page', 'Gestion des Modules');
        return $this->smarty->fetch('medias.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/updateMediaEtape
     * @return string
     */

    public function updateMediaEtapeAction() {

        $this->pdo->beginTransaction();

        $numEtape = $_POST['numEtape'];
        $typeMedia = $_POST['typeMedia'];
        $dateAdd = date('Y-m-d H:i:s');
        $dateEdit = date('Y-m-d H:i:s');

        $this->pdo->exec("DELETE FROM Media WHERE NumMedia = (SELECT NumMedia FROM AssoMediaEtape WHERE NumEtape = " . $numEtape . ')');
        $this->pdo->exec("DELETE FROM AssoMediaEtape WHERE NumEtape = " . $numEtape);

        if ($typeMedia == 3 || $typeMedia == 4) {
            // Recuperation nom du fichier
            $basename = basename($_FILES['valMedia']['name']);
            // Dossier d'upload
            $uploaddir = $this->config['root'] . '\\assets\\media\\';
            // Recuperation extention fichier upload
            $ext = pathinfo($basename, PATHINFO_EXTENSION);
            // Nom complet avec dossier
            $uploadfile = $uploaddir . $numEtape . '.' . $ext;

            if (file_exists($uploadfile)) {
                unlink($uploadfile);
            }

            if ($typeMedia == 4 && $ext == "mp3") {
                if (!move_uploaded_file($_FILES['valMedia']['tmp_name'], $uploadfile)) {
                    exit("Erreur lors de l'upload du fichier.");
                }
            } else if ($typeMedia == 3 && $ext == "png" || $typeMedia == 3 && $ext == "jpg") {
                if (!move_uploaded_file($_FILES['valMedia']['tmp_name'], $uploadfile)) {
                    $this->pdo->rollback();
                    exit("Erreur lors de l'upload du fichier.");
                }
            } else {
                $this->pdo->rollback();
                exit("Extention du fichier non valide.");
            }

            $file = '\\assets\\media\\' . $numEtape . '.' . $ext;
            $stmt = $this->pdo->prepare("INSERT INTO MEDIA (Nom, LienInterne, TypeMedia, DateAdd, DateEdit) VALUES (:nom, :lien, :typeMedia, :add, :edit)");
            $stmt->bindParam(':lien', $file); 
        } else {
            $media = $_POST['valMedia'];
            if($typeMedia == 5) {
                $stmt = $this->pdo->prepare("INSERT INTO MEDIA (Nom, Description, TypeMedia, DateAdd, DateEdit) VALUES (:nom, :description, :typeMedia, :add, :edit)");
                $stmt->bindParam(':description', $media);   
            } else {
                if ($typeMedia == 1) {
                    $media= str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $media);
                }
                $stmt = $this->pdo->prepare("INSERT INTO MEDIA (Nom, LienExterne, TypeMedia, DateAdd, DateEdit) VALUES (:nom, :lien, :typeMedia, :add, :edit)");
                $stmt->bindParam(':lien', $media);   
            }
        }
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':typeMedia', $typeMedia);
        $stmt->bindParam(':add', $dateAdd);
        $stmt->bindParam(':edit', $dateEdit);
        $stmt->execute();
        $numMedia = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("INSERT INTO AssoMediaEtape (NumMedia, NumEtape) VALUES (:numMedia, :numEtape)");
        $stmt->bindParam(':numMedia', $numMedia);
        $stmt->bindParam(':numEtape', $numEtape);
        $stmt->execute();
        
        $this->pdo->rollback();
        return "Le média a bien été enregistré.";
    }

}