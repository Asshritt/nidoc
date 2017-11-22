<?php

use \Tiny\Routing\Router;
use \Tiny\Routing\Route;
use \Tiny\Routing\RouteParameter;
use \Doc\TestController;

require(__DIR__.'/infos/load.php');
define('BASE_DIR', substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1));

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = str_replace("?" . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);

//var_dump($requestMethod, $requestUri, $_GET, $_POST);



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

//instancier OBJET PDO ICI

$controllerClassName = TestController::class;

$router = new Router();
$rc = new ReflectionClass($controllerClassName);
$rmList = $rc->getMethods(ReflectionMethod::IS_PUBLIC);
/* @var $rm ReflectionMethod */
foreach ($rmList as $rm) {
	$route = new Route();
	$route->setCallback(array(new $controllerClassName($config /* RAJOUTER L'OBJET PDO ICI */), $rm->name));

	$docComment = $rm->getDocComment();

	$lines = array_map(function($e) {
		return trim($e, " \t\n\r\0\x0B*");
	}, explode("\n", $docComment));

	array_shift($lines);
	array_pop($lines);

	foreach ($lines as $line) {
		if (preg_match("/@pattern\s(.+)/", $line, $matches)) {
			$route->setPattern($matches[1]);
		} elseif (preg_match("/@parameter\s(.+)\s(.+)/", $line, $matches)) {
			$route->addParamter(new RouteParameter($matches[1], $matches[2]));
		}
	}
	$router->addRoute($route);
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
	header("HTTP/1.1 404 Not Found");
	readfile(__DIR__."/template/error404.html");
	die();
}

