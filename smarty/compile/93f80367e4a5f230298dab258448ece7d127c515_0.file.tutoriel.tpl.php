<?php
/* Smarty version 3.1.30, created on 2018-03-20 14:05:23
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\tutoriel.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5ab11523f26e37_08649256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93f80367e4a5f230298dab258448ece7d127c515' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\tutoriel.tpl',
      1 => 1521552976,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5ab11523f26e37_08649256 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!-- <?php echo var_dump($_smarty_tpl->tpl_vars['etapes']->value);?>
 -->
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="etapes">
					<?php if (count($_smarty_tpl->tpl_vars['etapes']->value) > 0) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['etapes']->value, 'etape');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['etape']->value) {
?>
							<?php if (array_key_exists('NumEtape',$_smarty_tpl->tpl_vars['etape']->value)) {?>
								<button id="<?php echo $_smarty_tpl->tpl_vars['etape']->value['NumEtape'];?>
" name ="<?php echo $_smarty_tpl->tpl_vars['tutoriel']->value;?>
" type="button" class="list-group-item"><?php echo $_smarty_tpl->tpl_vars['etape']->value['Description'];?>
</button>
							<?php } else { ?>
								<button id="choix-<?php echo $_smarty_tpl->tpl_vars['etape']->value['NumChoix'];?>
" name ="<?php echo $_smarty_tpl->tpl_vars['tutoriel']->value;?>
" type="button" class="list-group-item"><?php echo $_smarty_tpl->tpl_vars['etape']->value['Libelle'];?>
</button>
							<?php }?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php } else { ?>
						<button id="" type="button" class="list-group-item"><i>Pas d'étapes pour ce tutoriel</i></button>
					<?php }?>
					<input type="text" hidden id="WEB_ROOT" value="<?php echo $_smarty_tpl->tpl_vars['WEB_ROOT']->value;?>
" /> 
					<input type="text" hidden id="ADMIN_DIR" value="<?php echo $_smarty_tpl->tpl_vars['ADMIN_DIR']->value;?>
" /> 
					<p id="test"> </p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="medias">
					<button type="button" class="list-group-item" disabled="true"><i>Afficher les médias </i></button>
				</div>
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

		var url = $("#WEB_ROOT").val() + $("#ADMIN_DIR").val() + '/getSuivant';
		var pathname = window.location.pathname; // Returns path only
		var pos_dernier_slash = pathname.lastIndexOf("/");
		var numFonctionnalite = pathname.substring(pos_dernier_slash + 1, pathname.length);

		var propositions_choix = [];


		//CLIC SUR UN CHOIX
		$(document).on('click', "button[id^='choix-']", function(e){

			var objet_courant = $(this);
			var numTuto = $(this)[0].name;
			var numChoix = $(this)[0].id;
			var numChoixFormate = numChoix.substring(6, numChoix.length);

			$.ajax({
				type: "POST",
				data:  {'numId' : numChoixFormate, 'numTuto' : numTuto, 'estUnChoix' : true}, 
				dataType: "JSON",
				url: url
			})
			.done(function(data){
				//$("#test").html(data);

				$.each(data, function(index, value){
					propositions_choix[index] = value['NumEtape']; 

					if (index == 0)
						$libelleChoix = "Non"
					else
						$libelleChoix = "Oui"
					$("#etapes").append("<button id=\"etape-" + value['NumEtape'] + "\" name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> <strong> " + $libelleChoix + " - </strong>" + value[1] + " </button>");

				});

				objet_courant.prop("disabled", true);
			})
			.fail(function(data){
				$("#test").html(data.responseText);
			});
		}); // clic on "choix-" object

		//CLIC SUR UNE ETAPE
		$(document).on('click', "button[id^='etape-']", function(e){

			var numTuto = $(this)[0].name;
			var numChoix = $(this)[0].id;	
			var numChoixFormate = numChoix.substring(6, numChoix.length);

			//suppression de l'étape qui n'est pas choisie.
			cacherEtapeNonChoisie(numChoixFormate);

			enleverInteractionEtapes();

			//appel AJAX pour récupérer la suite des étapes
			$.ajax({
				type: "POST",
				data:  {'numId' : numChoixFormate, 'numTuto' : numTuto, 'estUnChoix' : false, 'numFonctionnalite' : numFonctionnalite}, 
				dataType: "JSON",
				url: url

			})
			.done(function(data){
				//$("#test").html(data);


				$.each(data, function(index, value){

					if (value['NumEtape'] !== undefined)
						$("#etapes").append("<button id= " + value['NumEtape'] + " name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> " + value[1] + " </button>");

					else
						$("#etapes").append("<button id=\"choix-" + value['NumChoix'] + "\" name = " + value['NumTutoriel'] + " type=\"button\" class=\"list-group-item\"> " + value[1] + " </button>");

				});

			})
			.fail(function(data){
				$("#test").html(data.responseText);
			});

		}); // click on "etape-" object


		function enleverInteractionEtapes(){

			$.each(propositions_choix, function(index,value){

				$('#etape-' + value).prop('id', value);

			});
		} 

		function cacherEtapeNonChoisie(numChoixFormate){
			$.each(propositions_choix, function(index,value){

				if (value != numChoixFormate)
					$('#etape-' + value).hide();

			});
		}

	}); // ajax


<?php echo '</script'; ?>
>
<?php }
}
