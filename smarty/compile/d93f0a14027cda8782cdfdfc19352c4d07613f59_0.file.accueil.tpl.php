<?php
/* Smarty version 3.1.30, created on 2017-12-06 15:29:56
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\accueil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a280cf44cf2e2_52843432',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd93f0a14027cda8782cdfdfc19352c4d07613f59' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\accueil.tpl',
      1 => 1512574195,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a280cf44cf2e2_52843432 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
						<button id="1" type="button" class="list-group-item">Projet 1</button>
						<button id="1" type="button" class="list-group-item">Projet 2</button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="modules">
						<button id="1" type="button" class="list-group-item">Module 1</button>
						<button id="1" type="button" class="list-group-item">Module 2</button>
						<button id="1" type="button" class="list-group-item">Module 3</button>
						<button id="1" type="button" class="list-group-item">Module 4</button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="fonctionnalites">
						<a href="fonctionnalite/1"><button id="1" type="button" class="list-group-item">Fonctionnalite 1</button></a>
						<a href="fonctionnalite/2"><button id="1" type="button" class="list-group-item">Fonctionnalite 2</button></a>
						<a href="fonctionnalite/3"><button id="1" type="button" class="list-group-item">Fonctionnalite 3</button></a>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
