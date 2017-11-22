<?php

namespace Doc;

use XMI\Debut;
use XMI\Fin;
use XMI\Base;

class TestController extends \Tiny\BaseController {

    public function __construct($config) {
        parent::__construct($config);
    }

    /**
     * @pattern /hello
     * @return string
     */

    public function helloWorldAction() {
        $this->smarty->assign('name', 'world');
        return $this->smarty->fetch('hello.tpl');
        
        // $smarty->assign('ok', 'ok');
        // return "Hello World !";
    }

    /**
     * @pattern /hello/{name}
     * @parameter name string
     * @return string
     */
    public function helloAction($name) {
        $smarty = new \Smarty();
        $smarty->assign('name', $name);
        $smarty->display(__DIR__.'/../../template/hello.tpl');


        // return "Hello $name !";
    }

    /**
     * @pattern /read/{entity}/{id}
     * @parameter entity string
     * @parameter id int
     * @return string
     */
    public function readEntityAction($entity, $id) {
        return "Lecture de l'entite $entity $id";
    }

    /**
     * @pattern /xmi
     * @return string
     */
    public function xmiAction() {
        ob_start();
        echo '<div style="border-style: solid">';

        $debut = new Debut('EAID_DA1D9CF3_32BD_4354_BEDC_0F8F266CC8AE', 'Début');
        $debut->affiche();
        echo('<br>');
        $act1 = new Activite('EAID_11CC4948_94D5_477a_B8EF_97CBDEDDB0EC', 'Se connecter à la plateforme');
        $act1->affiche();
        echo('<br>');
        $act2 = new Activite('EAID_2250379C_A2B4_4cc2_AABD_6FE36FFC27B4', 'Cliquer sur "Liste des Annonces"');
        $act2->affiche();
        echo('<br>');
        $dec1 = new Decision('EAID_B7FE8F11_6830_48f6_8C91_35CD1425B2E6', 'Les annonces présentées sont-elles celles que je souhaite publier ?');
        $dec1->affiche();
        echo('<br>');
        $act3 = new Activite('EAID_EBD02390_BB27_4869_BBC3_F0BECDEA6B19', 'Filtrer les annonces');
        $act3->affiche();
        echo('<br>');
        $act4 = new Activite('EAID_E0A01C71_0E0D_42d9_8614_EB66AB7411A3', 'Cocher les annonces a publier');
        $act4->affiche();
        echo('<br>');
        $dec2 = new Decision('EAID_7E826934_5A39_4eb2_9749_3ACF07177F0A', 'Faut-il publier chaque variation de ces annonces ?');
        $dec2->affiche();
        echo('<br>');
        $act5 = new Activite('EAID_A8B721EB_E730_4b42_8CA1_AE1345D0E348', 'Cliquer sur "Publier chaque variation"');
        $act5->affiche();
        echo('<br>');
        $act6 = new Activite('EAID_68A94229_0ADD_4f2a_8AC9_13AE0106E39E', 'Cliquer sur "Publier"');
        $act6->affiche();
        echo('<br>');
        $fin = new Fin('EAID_1E385115_54A3_4091_ABFE_0DBA7FF52624', 'Fin');
        $fin->affiche();
        echo('<br>');

        echo '</div><br><div style="border-style: solid">';

        $liens[] = new Lien('1', '', $debut, $act1);
        $liens[] = new Lien('2', '', $act1, $act2);
        $liens[] = new Lien('3', '', $act2, $dec1);
        $liens[] = new Lien('4', 'Non', $dec1, $act3);
        $liens[] = new Lien('5', 'Oui', $dec1, $act4);
        $liens[] = new Lien('6', '', $act3, $act4);
        $liens[] = new Lien('7', '', $act4, $dec2);
        $liens[] = new Lien('8', 'Oui', $dec2, $act5);
        $liens[] = new Lien('9', 'Non', $dec2, $act6);
        $liens[] = new Lien('10', '', $act5, $fin);
        $liens[] = new Lien('11', '', $act6, $fin);

        foreach ($liens as $lien) {
            echo($lien->affiche() . '<br>');
        }
        return ob_get_clean();
    }

}