<?php
/* Smarty version 3.1.30, created on 2017-12-28 13:52:12
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a44f70c666351_63608627',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2f7a1cddde147f32be73b6c4d05558dc581e1dd4' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\login.tpl',
      1 => 1512213143,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a44f70c666351_63608627 (Smarty_Internal_Template $_smarty_tpl) {
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
