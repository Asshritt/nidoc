<?php
/* Smarty version 3.1.30, created on 2017-12-06 16:23:00
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\fonctionnalites.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a2819649e7017_03736845',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '88c9ebfee777bb1b2483655475e945eed5526986' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\fonctionnalites.tpl',
      1 => 1512577350,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5a2819649e7017_03736845 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-lg-6">
					<ul class="list-group">
						<li class="list-group-item">
							Fonctionnalité 1
							<div class="material-switch pull-right">
								<input id="1" name="someSwitchOption001" type="checkbox" checked/>
								<label for="1" class="label-default"></label>
							</div>
						</li>
						<li class="list-group-item">
							Fonctionnalité 2
							<div class="material-switch pull-right">
								<input id="2" name="someSwitchOption001" type="checkbox"/>
								<label for="2" class="label-default"></label>
							</div>
						</li>
						<li class="list-group-item">
							Fonctionnalité 3
							<div class="material-switch pull-right">
								<input id="3" name="someSwitchOption001" type="checkbox"/>
								<label for="3" class="label-default"></label>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
