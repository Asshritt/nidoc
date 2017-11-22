<?php
/* Smarty version 3.1.30, created on 2017-11-15 17:27:25
  from "C:\wamp64\www\nidoc\template\hello.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0c78fd86c395_35153168',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '783412b2f8ede9d7b25be5016d0ceb46600eee40' => 
    array (
      0 => 'C:\\wamp64\\www\\nidoc\\template\\hello.tpl',
      1 => 1510764866,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0c78fd86c395_35153168 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hello</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
	<h3> Hello <?php echo $_smarty_tpl->tpl_vars['name']->value;?>
 </h3>
</body><?php }
}
