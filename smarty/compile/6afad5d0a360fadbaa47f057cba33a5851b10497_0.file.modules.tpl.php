<?php
/* Smarty version 3.1.30, created on 2017-12-06 16:22:15
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\modules.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a2819378c2dd1_14157127',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6afad5d0a360fadbaa47f057cba33a5851b10497' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\modules.tpl',
      1 => 1512577333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5a2819378c2dd1_14157127 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-lg-6">
					<ul class="list-group">
						<li class="list-group-item">
							Module 1
							<div class="material-switch pull-right">
								<input id="1" name="someSwitchOption001" type="checkbox"/>
								<label for="1" class="label-default"></label>
							</div>
						</li>
						<li class="list-group-item">
							Module 2
							<div class="material-switch pull-right">
								<input id="2" name="someSwitchOption001" type="checkbox" checked/>
								<label for="2" class="label-default"></label>
							</div>
						</li>
						<li class="list-group-item">
							Module 3
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
