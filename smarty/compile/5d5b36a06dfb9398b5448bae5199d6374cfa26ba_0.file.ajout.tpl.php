<?php
/* Smarty version 3.1.30, created on 2018-02-26 13:34:12
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\ajout.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a940cd4e82859_24509602',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d5b36a06dfb9398b5448bae5199d6374cfa26ba' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\ajout.tpl',
      1 => 1519652015,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a940cd4e82859_24509602 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
	
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<form id ="importForm" action="<?php echo WEB_ROOT;?>
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
				<p id="msgResultat"></p>
			</div>
		</div>
	</div>
</body>

<?php echo '<script'; ?>

  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">

	 $(function() {
	
		$('#importForm').submit(function(e){
			e.preventDefault();

			var action = $(this).attr('action');

			var selectId = $(this).find('option:selected').attr("id");
			var inputTitre = $("#inputTitre").val();
			var inputDescription = $("#inputDescription").val();
			var uploadXML = $("#uploadXML")[0].files[0];

			var datas = new FormData();
			datas.append('selectFonct', selectId);
			datas.append('inputTitre', inputTitre);
			datas.append('inputDescription', inputDescription);
			datas.append('uploadXML', uploadXML);


			$.ajax({
				type: "POST",
				data:  datas,
				contentType: false,
				processData: false, 
				url: action
			})

			.done(function(data){
				$("#msgResultat").html(data);
			})

			.fail(function(data){
				$("#msgResultat").html(data.responseText);
			});

		});

	 });



<?php echo '</script'; ?>
>
<?php }
}
