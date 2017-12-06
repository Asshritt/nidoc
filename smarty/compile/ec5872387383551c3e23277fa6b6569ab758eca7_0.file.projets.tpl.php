<?php
/* Smarty version 3.1.30, created on 2017-12-06 14:37:31
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\projets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a2800ab352280_40679004',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ec5872387383551c3e23277fa6b6569ab758eca7' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\projets.tpl',
      1 => 1512571050,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5a2800ab352280_40679004 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					<button type="button" class="list-group-item"><i>Market Invaders</i></button>
					<button type="button" class="list-group-item"><i>NiShop</i></button>
				</div>
			</div>
			<div class="col-md-1">
				<div class="list-group" id="edit">
					<button type="button" class="list-group-item glyphicon glyphicon-pencil"></button>
					<button type="button" class="list-group-item glyphicon glyphicon-pencil"></button>
				</div>
			</div>
			<div class="col-md-1">
				<div class="list-group" id="delete">
					<button type="button" class="list-group-item glyphicon glyphicon-remove"></button>
					<button type="button" class="list-group-item glyphicon glyphicon-remove"></button>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
