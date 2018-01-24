<?php
/* Smarty version 3.1.30, created on 2018-01-24 16:39:39
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\projets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a68b6cbe6c017_35744540',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ebb5f826d91d77993e9d51b1da4e641fce638b6' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\projets.tpl',
      1 => 1516811979,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5a68b6cbe6c017_35744540 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<ul class="list-group" id="projets">
					<?php if (count($_smarty_tpl->tpl_vars['projets']->value) > 0) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['projets']->value, 'projet');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['projet']->value) {
?>
					<li class="list-group-item">
						<label><?php echo $_smarty_tpl->tpl_vars['projet']->value['Nom'];?>
</label>
						<div class="material-switch pull-right">
							<button class="glyphicon glyphicon-pencil"></button>
							<button class="glyphicon glyphicon-remove"></button>
						</div>
					</li>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php } else { ?> 
					<?php echo '<script'; ?>
 type="text/javascript">alert('Pas de projets a afficher');<?php echo '</script'; ?>
>
					<?php }?>
				</ul>
			</div>
		</div>
	</div>
</body><?php }
}
