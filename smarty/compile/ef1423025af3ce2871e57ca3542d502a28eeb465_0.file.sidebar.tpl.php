<?php
/* Smarty version 3.1.30, created on 2018-01-24 16:30:25
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\sidebar.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a68b4a1c56487_97654380',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ef1423025af3ce2871e57ca3542d502a28eeb465' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\sidebar.tpl',
      1 => 1512580384,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a68b4a1c56487_97654380 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<body>

	<div id="wrapper" class="toggled">

		<!-- Sidebar -->
		<div id="sidebar-wrapper">
			<ul class="sidebar-nav">
				<li class="sidebar-brand">
					Menu
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/membres">Membres</a>
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/projets">Projets</a>
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/modules">Modules</a>
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/fonctionnalites">Fonctionnalites</a>
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/tutoriels">Tutoriels</a>
				</li>
				<li>
					<a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;
echo $_smarty_tpl->tpl_vars['adminDir']->value;?>
/medias">Medias</a>
				</li>
			</ul>
		</div>
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div id="page-content-wrapper">
			<div class="container-fluid"><?php }
}
