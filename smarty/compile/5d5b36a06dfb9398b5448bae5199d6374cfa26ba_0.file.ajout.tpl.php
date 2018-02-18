<?php
/* Smarty version 3.1.30, created on 2018-02-13 15:29:57
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\ajout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a830475908861_92911154',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d5b36a06dfb9398b5448bae5199d6374cfa26ba' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\ajout.tpl',
      1 => 1518535778,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a830475908861_92911154 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form action="<?php echo WEB_ROOT;?>
uploadXML" method="post" enctype="multipart/form-data">
					<div class="form-group" id="fonctionnalites">
						<select class="form-control" id="selectFonct" name="selectFonct" required>
							<?php if (count($_smarty_tpl->tpl_vars['fonctionnalites']->value) > 0) {?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fonctionnalites']->value, 'fonct');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['fonct']->value) {
?>
							<option id="<?php echo $_smarty_tpl->tpl_vars['fonct']->value['NumFonctionnalite'];?>
" name="test"><?php echo $_smarty_tpl->tpl_vars['fonct']->value['Nom'];?>
</option>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

							<?php } else { ?>
							<option disabled selected>Pas de fonctionnalités disponibles</option>
							<?php }?>
						</select>
						<input type="text" id="inputTitre" name="inputTitre" placeholder="Titre du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="text" id="inputDescription" name="inputDescription" placeholder="Description du tutoriel" class="form-control" aria-describedby="basic-addon1" required>
						<input type="file" id="uploadXML" name="uploadXML" required>
						<button type="submit" class="btn btn-default" id="btnValider">Valider</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body><?php }
}
