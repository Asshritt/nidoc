<?php

require_once __DIR__."/fct.php";
require_once __DIR__."/Autoloader.php";
Autoloader::register();

require_once __DIR__."/Smarty/Autoloader.php";
Smarty_Autoloader::registerBC();
require_once __DIR__."/XMI/XMILoader.php";
XMILoader::register();