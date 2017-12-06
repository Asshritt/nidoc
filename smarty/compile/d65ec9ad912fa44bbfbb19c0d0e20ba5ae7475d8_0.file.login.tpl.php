<?php
/* Smarty version 3.1.30, created on 2017-12-02 11:12:28
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a228a9c814666_46083773',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd65ec9ad912fa44bbfbb19c0d0e20ba5ae7475d8' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\login.tpl',
      1 => 1512213143,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a228a9c814666_46083773 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Adresse mail" aria-describedby="basic-addon1">
			</div>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Mot de Passe" aria-describedby="basic-addon1">
			</div>
			<a href="accueil">
				<button type="button" class="btn btn-default">Se connecter</button>
			</a>
		</div>
	</div>
</body><?php }
}
