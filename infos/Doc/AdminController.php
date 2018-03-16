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

        if (isset($_POST['idProjet']) && isset($_POST['libelleProjet'])) {
            $idProjet = $_POST['idProjet'];
            $libelleProjet = $_POST['libelleProjet'];

            // Mise à jour en base de données du libelle du projet
            $stmt = $this->pdo->prepare("UPDATE Projet SET Nom = :libelle WHERE NumProjet = :id");
            $stmt->bindParam(':libelle', $libelleProjet);
            $stmt->bindParam(':id', $idProjet);
            $res = $stmt->execute();

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

}