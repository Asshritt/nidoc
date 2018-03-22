<?php
/* Smarty version 3.1.30, created on 2018-03-21 16:47:39
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\modules.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5ab28cab6ea0b5_70752958',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '079c5484ac96ba54e3df139b61ccc3fa707966be' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\modules.tpl',
      1 => 1521650725,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5ab28cab6ea0b5_70752958 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="row">
				<ul class="list-group">
					<div class="panel panel-default">
						<div class="panel-heading">Affecter les modules :</div>

						<!-- Table -->
						<table class="table">
							<?php echo $_smarty_tpl->tpl_vars['table']->value;?>

						</table>
					</div>
				</ul>
			</div>
		</div>
		<button type="button" id="btnValider" class="btn btn-primary">Confirmer</button>
	</div>
	
	<input type="text" hidden id="WEB_ROOT" value="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
">
	<input type="text" hidden id="ADMIN_DIR" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_DIR']->value;?>
">
</body>
<p id="test"></p>


<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">

	// Lorsque l'on clique sur le "Valider"
	$( "#btnValider" ).click(function() {
		var check = new Object();
		var i=0;
		// Parcours de chaque case du tableau
		$('.form-check-input').each(function () {
			console.log(this);
			// Création d'un objet contenant les informations de la case
			var o = new Object(); 
			o.module = $('#'+this.id).data('idmodule');
			o.projet = $('#'+this.id).data('idprojet');
			o.checked = this.checked ? true : false;
			check[i] = o;
			i++;
		});
		console.log(check);
		// Transformation en JSON
		check = JSON.stringify(check);

		// Appel Ajax
		$.ajax({
			type: "POST",
			data: "check=" + check,
			url: $("#WEB_ROOT").val() + $("#ADMIN_DIR").val() + "/updateModuleProjet"
		})
		.done(function(data){
			alert(data);
		})
		.fail(function(data){
		});


	});

<?php echo '</script'; ?>
>
<?php }
}
