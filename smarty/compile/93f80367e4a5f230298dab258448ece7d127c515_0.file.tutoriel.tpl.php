<?php
/* Smarty version 3.1.30, created on 2018-03-07 10:58:19
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\tutoriel.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a9fc5cba1f901_48622350',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93f80367e4a5f230298dab258448ece7d127c515' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\tutoriel.tpl',
      1 => 1520419919,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a9fc5cba1f901_48622350 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo var_dump($_smarty_tpl->tpl_vars['debut']->value);?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="etapes">
					<?php if (count($_smarty_tpl->tpl_vars['debut']->value) > 0) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['debut']->value, 'etape');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['etape']->value) {
?>
					<?php if ($_smarty_tpl->tpl_vars['etape']->value['Description'] == "Début") {?>
					<?php }?>
					<button id="<?php echo $_smarty_tpl->tpl_vars['etape']->value['NumEtape'];?>
" type="button" class="list-group-item"><?php echo $_smarty_tpl->tpl_vars['etape']->value['Description'];?>
</button>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php } else { ?>
					<button id="" type="button" class="list-group-item"><i>Pas d'étapes pour ce tutoriel</i></button>
					<?php }?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="medias">
					<button type="button" class="list-group-item" disabled="true"><i>Afficher les médias </i></button>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
