<?php
/* Smarty version 3.1.30, created on 2018-01-24 16:29:22
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\accueil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a68b4629dd508_51637198',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '183030751fbe8032a50a083debcac424956c6690' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\accueil.tpl',
      1 => 1516811300,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a68b4629dd508_51637198 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					<label>Projets disponibles :</label>
					<?php if (count($_smarty_tpl->tpl_vars['projets']->value) > 0) {?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['projets']->value, 'projet');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['projet']->value) {
?>
					<button id="<?php echo $_smarty_tpl->tpl_vars['projet']->value['NumProjet'];?>
" type="button" class="list-group-item"><?php echo $_smarty_tpl->tpl_vars['projet']->value['Nom'];?>
</button>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php } else { ?>
					<button id="" type="button" class="list-group-item"><i>Pas de projets</i></button>
					<?php }?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="modules">
				</div>
			</div>
			<div class="col-md-4">
				<div class="list-group" id="fonctionnalites">
				</div>
			</div>
		</div>
	</div>
</body>


<?php echo '<script'; ?>
 type="text/javascript">
	// Appel Ajax pour recuperer les modules apres selection d'un projet
	$('#projets>button').click(function() {
		$.ajax({
			url : 'data',
			type : 'POST',
			data : 'projet=' + this.id,
			dataType : 'json',
			success : function(html, statut){
				// Vider les liste des modules et fonctionnalites au cas ou changement d'avis
				$('#modules').empty();
				$('#fonctionnalites').empty();
				// Ajout du "titre"
				$('#modules').append('<label>Modules disponibles :</label>');
				// Ajout des modules dans le tableau
				for (var i = 0; i < html.length; i++) {
					$('#modules').append('<button id="' + html[i]['NumModule'] + '" type="button" class="list-group-item" onClick="getData(' + html[i]['NumModule'] + ');">' + html[i]['Nom'] + '</button>');
				}
			},
			error : function(resultat, statut, erreur){
				console.log(erreur);
			}
		});
	});
	function getData(id) {
	// Appel Ajax pour recuperer les fonctionnalites apres selection d'un module
		$.ajax({
			url : 'data',
			type : 'POST',
			data : 'module=' + id,
			dataType : 'json',
			success : function(html, statut){
				// Vider la liste des fonctionnalites au cas ou changement d'avis
				$('#fonctionnalites').empty();
				// Ajout du "titre"
				$('#fonctionnalites').append('<label>Fonctionnalités disponibles :</label>');
				// Ajout des fonctionnalites dans le tableau
				for (var i = 0; i < html.length; i++) {
					$('#fonctionnalites').append('<a href="fonctionnalite/' + html[i]['NumFonctionnalite'] + '"><button id="' + html[i]['NumFonctionnalite'] + '" type="button" class="list-group-item">' + html[i]['Nom'] + '</button></a>');
				}
			},
			error : function(resultat, statut, erreur){
				console.log(erreur);
			}
		});
	};
		/* NE MARCHE PAS DEMANDER
		$('#modules>button').click(function() {
			alert(this.id);
		});
		*/
	<?php echo '</script'; ?>
>
	<?php }
}
