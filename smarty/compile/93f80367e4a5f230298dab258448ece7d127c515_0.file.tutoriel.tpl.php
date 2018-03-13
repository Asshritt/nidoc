<?php
/* Smarty version 3.1.30, created on 2018-03-13 15:52:33
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\tutoriel.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5aa7f3c14aa648_00613404',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93f80367e4a5f230298dab258448ece7d127c515' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\tutoriel.tpl',
      1 => 1520956352,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5aa7f3c14aa648_00613404 (Smarty_Internal_Template $_smarty_tpl) {
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

		$('[id^=choix-').click(function(){

	
			//var url = $(this).URL;
			//var slash = url.lastIndexOf('/');
			//var debutUrl = url.substring(0, slash);

			var numTuto = $(this)[0].name;


			var numChoix = $(this)[0].id;
			var str = numChoix.substring(6, numChoix.length);


			$.ajax({
				type: "POST",
				data:  {'numChoix' : numChoix, 'numTuto' : numTuto}, 
				url: "{_ADMIN_DIR_}" + '/getSuivant'
			})
			.done(function(data){
				$("#test").html(data);
				
			})
			.fail(function(data){
				$("#test").html(data.responseText);
			});
		})
	});



<?php echo '</script'; ?>
>
<?php }
}
