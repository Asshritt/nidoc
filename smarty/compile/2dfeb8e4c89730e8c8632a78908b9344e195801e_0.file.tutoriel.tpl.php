<?php
/* Smarty version 3.1.30, created on 2017-12-06 15:50:15
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\tutoriel.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a2811b709ec41_40578319',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2dfeb8e4c89730e8c8632a78908b9344e195801e' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\tutoriel.tpl',
      1 => 1512575414,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a2811b709ec41_40578319 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					<button type="button" class="list-group-item" disabled="true"><i>Menu...?</i></button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="etapes">
					<button type="button" class="list-group-item" disabled="true"><i>Étapes</i></button>
					<button type="button" class="list-group-item" disabled="true">Choix <input type="checkbox"></button>
					<button type="button" class="list-group-item" disabled="true"><i>Étapes</i></button>
					<button type="button" class="list-group-item" disabled="true"><i>Étapes</i></button>
					<button type="button" class="list-group-item" disabled="true"><i>Étapes</i></button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="medias">
					<button type="button" class="list-group-item" disabled="true"><i>Medias</i></button>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
