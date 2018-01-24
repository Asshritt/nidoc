<?php
/* Smarty version 3.1.30, created on 2018-01-24 16:29:33
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\informations.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a68b46d14e183_43264794',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5fe9fb4e5db657422ca515ccc09bcd85c4a4feed' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\informations.tpl',
      1 => 1516811128,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a68b46d14e183_43264794 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<form>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="input-group">
				<label>Votre adresse mail actuelle:</label>
					<input type="text" class="form-control" placeholder="Adresse mail" disabled="true" aria-describedby="basic-addon1">
				</div>
				<div class="input-group">
					<label>Nouveau mot de passe:</label>
					<input type="password" class="form-control" placeholder="Mot de Passe" aria-describedby="basic-addon1">
				</div>
				<div class="input-group">
					<label>Resaisir le mot de passe:</label>
					<input type="password" class="form-control" placeholder="Mot de Passe" aria-describedby="basic-addon1">
				</div>
				<a href="accueil">
					<button type="button" class="btn btn-default">Enregistrer</button>
				</a>
			</div>
		</div>
	</form>
</body><?php }
}
