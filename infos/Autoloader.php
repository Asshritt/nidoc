<?php

class Autoloader{
	
	static function register() {
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}
	
	static function autoload($class) {
        $class = 'infos' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class);

		$file = $class . '.php';
		if (is_file($file)) {
			require_once($file);
		} else {
			return false;
		}
	}
}