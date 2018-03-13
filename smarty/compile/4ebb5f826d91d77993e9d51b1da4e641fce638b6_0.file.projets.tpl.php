<?php
/* Smarty version 3.1.30, created on 2018-03-13 12:47:07
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\projets.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5aa7c84bc99085_72001951',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ebb5f826d91d77993e9d51b1da4e641fce638b6' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\projets.tpl',
      1 => 1520945226,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5aa7c84bc99085_72001951 (Smarty_Internal_Template $_smarty_tpl) {
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
							<button id="<?php echo $_smarty_tpl->tpl_vars['projet']->value['NumProjet'];?>
" class="glyphicon glyphicon-pencil" onclick="modifierProjet(this.id)"></button>
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
	<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modification</h4>
            </div>
            <div class="modal-body">
                <p>Saisissez le nouveau libellé du projet :</p>
                <input type="text" class="form-control" placeholder="Libellé" maxlength="64">
                <p class="text-warning"><small>64 caractères max.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Confirmer</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>
</body>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">

	function modifierProjet(id) {
		$("#myModal").modal('show');
	}

<?php echo '</script'; ?>
>
<?php }
}
