<?php
/* Smarty version 3.1.30, created on 2018-03-13 12:55:19
  from "C:\Users\Asshritt\Documents\__Projets\IUP_MIAGE\ProjetAnnee\nidoc\template\fonctionnalites.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5aa7ca37be8a26_55023204',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '19898bb3e012baf28fa1a003ee57c393df0c7a5e' => 
    array (
      0 => 'C:\\Users\\Asshritt\\Documents\\__Projets\\IUP_MIAGE\\ProjetAnnee\\nidoc\\template\\fonctionnalites.tpl',
      1 => 1520945719,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:sidebar.tpl' => 1,
  ),
),false)) {
function content_5aa7ca37be8a26_55023204 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<body>
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-lg-6">
					<ul class="list-group">
						<div class="panel panel-default">
							<!-- Default panel contents -->
							<div class="panel-heading">Affecter les fonctionnalités :</div>

							<!-- Table -->
							<table class="table">
								<thead>
									<tr>
										<!-- Noms de modules -->
										<th scope="col"></th>
										<th scope="col">First</th>
										<th scope="col">Last</th>
										<th scope="col">Handle</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!-- Noms de projets -->
										<th scope="row">1</th>
										<!-- Checkboxes -->
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
									</tr>
									<tr>
										<th scope="row">3</th>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
										<td><input type="checkbox" class="form-check-input" id="exampleCheck1"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body><?php }
}
