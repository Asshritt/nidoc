<?php

namespace Doc;

class AdminController extends \Tiny\BaseController {

    public function __construct($config) {
        parent::__construct($config);
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
     * @pattern /{_ADMIN_DIR_}/membres
     * @return string
     */

    public function adminMembresAction() {
        $this->smarty->assign('page', 'Gestion des membres');
        return $this->smarty->fetch('todo.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/projets
     * @return string
     */

    public function adminProjetsAction() {
        $this->smarty->assign('page', 'Gestion des Projets');
        return $this->smarty->fetch('projets.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/modules
     * @return string
     */

    public function adminModulesAction() {
        $this->smarty->assign('page', 'Gestion des Modules');
        return $this->smarty->fetch('todo.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/fonctionnalites
     * @return string
     */

    public function adminFonctionsAction() {
        $this->smarty->assign('page', 'Gestion des Fonctions');
        return $this->smarty->fetch('fonctionnalites.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/tutoriels
     * @return string
     */

    public function adminTutorielsAction() {
        $this->smarty->assign('page', 'Gestion des Tutoriels');
        return $this->smarty->fetch('todo.tpl');
    }

    /**
     * @pattern /{_ADMIN_DIR_}/medias
     * @return string
     */

    public function adminMediasAction() {
        $this->smarty->assign('page', 'Gestion des Medias');
        return $this->smarty->fetch('todo.tpl');
    }

}