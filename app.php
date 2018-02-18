<?php

// Use namespaces
use \Tiny\Routing\Router;
use \Tiny\Routing\Route;
use \Tiny\Routing\RouteParameter;
use \Doc\TutorielController;
use \Doc\TestController;

// Autoloader
require(__DIR__.'/infos/load.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = str_replace("?" . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

//Démarage de la seesion
session_start();

/**
 * https://stackoverflow.com/questions/254514/php-and-enumerations
 */
abstract class BaseEnum {

	private static $constCacheArray = NULL;

	public static function getConstants() {
		if (self::$constCacheArray == NULL) {
			self::$constCacheArray = [];
		}
		$calledClass = get_called_class();
		if (!array_key_exists($calledClass, self::$constCacheArray)) {
			$reflect = new ReflectionClass($calledClass);   
			self::$constCacheArray[$calledClass] = $reflect->getConstants();
		}
		return self::$constCacheArray[$calledClass];
	}

	public static function isValidName($name, $strict = false) {
		$constants = self::getConstants();

		if ($strict) {
			return array_key_exists($name, $constants);
		}

		$keys = array_map('strtolower', array_keys($constants));
		return in_array(strtolower($name), $keys);
	}

	public static function isValidValue($value, $strict = true) {
		$values = array_values(self::getConstants());
		return in_array($value, $values, $strict);
	}

}

abstract class Charset extends BaseEnum {

	const UTF8 = 'UTF-8';

}

abstract class ContentType extends BaseEnum {

	const TEXT_HTML = "text/html";
	const TEXT_CSS = "text/css";
	const TEXT_PLAIN = "text/plain";
	const APP_JSON = "application/json";

}

class HTTPHeader {

	private $contentType;
	private $charset;

	public function __construct($contentType, $charset = "") {
		$this->contentType = $contentType;
		$this->charset = $charset;
	}

	public function toString() {
		return "Content-Type: " . $this->contentType . ($this->charset != "" ? ";Charset=" . $this->charset : "");
	}

}

$config = array(
	"root" => __DIR__,
	"smarty" => array(

	)
);

//instancier OBJET PDO ICI -----------------------------------------------------------------------------------------------------

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nidoc_test";

try { // Create connection
	$pdo = new \PDO('mysql:host=localhost;dbname=nidoc_test', $username, $password);
} catch (PDOException $e) { // Check connection
	die("Connection failed: " . $e->getMessage());
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//end -------------------------------------------------------------------------------------------------------------------------

// Variables
$nomRepertoireAdmin = "adminni";
define('_ADMIN_DIR_', $nomRepertoireAdmin);
define('WEB_ROOT', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER["SERVER_NAME"] . str_replace("app.php", "", $_SERVER["SCRIPT_NAME"]));

//var_dump($_SERVER);

$controllerDir = __DIR__."/infos/Doc";

$router = new Router();
$scandir = scandir($controllerDir);
foreach ($scandir as $e) {
	$filename = $controllerDir."/".$e;
	if (is_file($filename)) {
		$controllerClassName = "\\Doc\\" . pathinfo($filename, PATHINFO_FILENAME);
		$rc = new ReflectionClass($controllerClassName);
		$rmList = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
		/* @var $rm ReflectionMethod */
		foreach ($rmList as $rm) {
			$route = new Route();
		$route->setCallback(array(new $controllerClassName($config, $pdo), $rm->name));

		$docComment = $rm->getDocComment();

		$lines = array_map(function($e) {
			return trim($e, " \t\n\r\0\x0B*");
		}, explode("\n", $docComment));

		array_shift($lines);
		array_pop($lines);

		foreach ($lines as $line) {
			if (preg_match("/@pattern\s(.+)/", $line, $matches)) {

				$matches[1] = str_replace("{_ADMIN_DIR_}", _ADMIN_DIR_, $matches[1]);

				$route->setPattern($matches[1]);
			} elseif (preg_match("/@parameter\s(.+)\s(.+)/", $line, $matches)) {
				$route->addParamter(new RouteParameter($matches[1], $matches[2]));
			}
		}
		$router->addRoute($route);
	}
}
}

//var_dump($router);
/*
$uris = array('/hello', '/hello/John', '/read/page/13', '/nimp/13');

foreach ($uris as $uri) {
	var_dump($uri .' -> '. $router->getMatchingRoute($uri));
}
*/

try {
	header("HTTP/1.1 200 OK");
	echo $router->getMatchingRoute('/' . $_GET['url']);
	die();
} catch(Exception $e) {
	//header("HTTP/1.1 404 Not Found");
	//readfile(__DIR__."/template/error404.html");
	var_dump($e);
	die();
}

