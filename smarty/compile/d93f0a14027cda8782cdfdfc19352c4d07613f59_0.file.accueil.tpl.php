<?php
/* Smarty version 3.1.30, created on 2017-12-01 22:44:48
  from "C:\Users\Asshritt\Documents\__Projets\IUP MIAGE\ProjetAnnee\nidoc\template\accueil.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a21db60636555_49685456',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd93f0a14027cda8782cdfdfc19352c4d07613f59' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP MIAGE\\ProjetAnnee\\nidoc\\template\\accueil.tpl',
      1 => 1512168286,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5a21db60636555_49685456 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="list-group" id="projets">
					<?php if ($_smarty_tpl->tpl_vars['projets']->value) {?>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['projets']->value, 'foo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['foo']->value) {
?>
						<button id="<?php echo $_smarty_tpl->tpl_vars['foo']->value['NumProjet'];?>
" type="button" class="list-group-item" onClick="loadModules(<?php echo $_smarty_tpl->tpl_vars['foo']->value['NumProjet'];?>
)"><?php echo $_smarty_tpl->tpl_vars['foo']->value['Nom'];?>
</button>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php } else { ?>
						<button type="button" class="list-group-item" disabled="true"><i>Pas de projets...</i></button>
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

	
	<?php echo '<script'; ?>
 type="text/javascript">
		function loadModules(id) {
			$('#projets>button').removeClass('active'); 
			$('#projets>#' + id).addClass('active');
			$('#modules').empty();
			$('#fonctionnalites').empty();

			// Appel AJAX Modules selon idProjet
			$.ajax({
				url : 'data',
				type : 'POST',
				data : 'projet=' + id,
				dataType : 'json',
				success : function(html, statut){
					console.log(html);
					for(i = 0; i < html.length; i++) {
						$('#modules').append("<button id='" + html[i]['NumModule'] + "' type='button' class='list-group-item' onClick='loadFonctionnalites(" + html[i]['NumModule'] + ")'>" + html[i]['Nom'] + "</button>");
					}
				},
				error : function(resultat, statut, erreur){
					console.log(resultat);
					console.log(statut);
					console.log(erreur);
					$('#modules').append("<button type='button' class='list-group-item' disabled='true'><i>Pas de modules...</i></button>");
				}
			});
		}

		function loadFonctionnalites(id) {
			$('#modules>button').removeClass('active'); 
			$('#modules>#' + id).addClass('active');
			$('#fonctionnalites').empty();

			// Appel AJAX Fonctionnalites selon idModule
			$.ajax({
				url : 'data',
				type : 'POST',
				data : 'module=' + id,
				dataType : 'json',
				success : function(html, statut){
					console.log(html);
					for(i = 0; i < html.length; i++) {
						console.log(html[i]);
						$('#fonctionnalites').append("<button id='" + html[i]['NumFonctionnalite'] + "' type='button' class='list-group-item' href='fonctionnalite/" + html[i]['NumFonctionnalite'] + "'>" + html[i]['Nom'] + "</button>");
					}
				},
				error : function(resultat, statut, erreur){
					console.log(resultat);
					console.log(statut);
					console.log(erreur);
					$('#fonctionnalites').append("<button type='button' class='list-group-item' disabled='true'><i>Pas de fonctionnalités...</i></button>");
				}
			});
		}
	<?php echo '</script'; ?>
>
	



</body><?php }
}
