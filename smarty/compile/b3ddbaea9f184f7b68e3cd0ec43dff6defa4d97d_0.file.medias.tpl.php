<?php
/* Smarty version 3.1.30, created on 2018-03-22 22:18:13
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\medias.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5ab42ba5e22bf5_86612147',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b3ddbaea9f184f7b68e3cd0ec43dff6defa4d97d' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\medias.tpl',
      1 => 1521757092,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5ab42ba5e22bf5_86612147 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<select class="form-control" id="selectFonct" name="selectFonct" required>
					<?php echo $_smarty_tpl->tpl_vars['html']->value;?>

				</select>
				<input type="radio" name="type" id="lien" value="2" checked> Lien<br>
				<input type="radio" name="type" id="lienyt" value="1"> Lien YouTube<br>
				<input type="radio" name="type" id="texte" value="5"> Texte<br>
				<input type="radio" name="type" id="image" value="3"> Image(jpg/png)<br>
				<input type="radio" name="type" id="audio" value="4"> Audio(mp3)
				<div id="typeMedia">
					<input type="textarea" id="inputLien" name="inputLien" placeholder="Lien" class="form-control" aria-describedby="basic-addon1" required>
				</div>
				<button type="submit" class="btn btn-default" id="btnValider">Valider</button>
			</div>
		</div>
	</div>
	<p id="test"></p>
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

	$("input:radio[name='type']").change(function() {
		if ($(this).is(':checked') && $(this).val() == '2' || $(this).is(':checked') && $(this).val() == '1') {
			$("#typeMedia").html('<input type="textarea" id="inputLien" name="inputLien" placeholder="Lien" class="form-control" aria-describedby="basic-addon1" required>');
		} else if ($(this).is(':checked') && $(this).val() == '5') {
			$("#typeMedia").html('<textarea class="form-control" id="inputTexte" name="inputTexte" class="span6" rows="3" placeholder="Texte" required></textarea>');
		} else {
			$("#typeMedia").html('<input type="file" id="uploadMedia" name="uploadMedia" required>');
		}
	});

	$( "#btnValider" ).click(function() {

		
		var WEB_ROOT = '<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
';
		var ADMIN_DIR = '<?php echo $_smarty_tpl->tpl_vars['ADMIN_DIR']->value;?>
'
		

		var type = $('input:radio:checked').val();

		var numEtape = $('option:selected').attr('id');

		var value;
		var length = 0;

		switch(type) {
			case "1": 
			case "2":
			value = $('#inputLien').val();
			break;
			case "5":
			value = $('#inputTexte').val();
			break;
			case "3":
			case "4":
			length = $('#uploadMedia')[0].files.length;
			value = $('#uploadMedia')[0].files[0];
			break;
		}

		if ((/\S/.test(value) && type == 1) || 
			(/\S/.test(value) && type == 2) || 
			(/\S/.test(value) && type == 5) || 
			(length !== 0 && type == 3) || 
			(length !== 0 && type == 4)) {

			var datas = new FormData();
			datas.append('typeMedia', type);
			datas.append('numEtape', numEtape);
			datas.append('valMedia', value);

			$.ajax({
				type: "POST",
				data: datas, 
				contentType: false,
				processData: false,
				url: WEB_ROOT + ADMIN_DIR + "/updateMediaEtape"
			})
			.done(function(data){
				if (data == "Le média a bien été enregistré.") {
					$('#btnValider').attr('disabled', 'disabled');
				}
				$('#test').html(data);
			})
			.fail(function(data){
				console.log(data);
			});
		} else {
			alert('Veuillez remplir le formulaire correctement.')
		}
	});

<?php echo '</script'; ?>
>
<?php }
}
