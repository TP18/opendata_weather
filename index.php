<link rel="stylesheet" type="text/css" href="resource/css/style.css" />
<?php

/**
 * Error Handling / time /
 */

require_once 'application/config/global.php';

$parameters = array_merge($_GET, $_POST); //array_merge $_post

if (empty($parameters['controller'])) {
	$controller = 'index';
} else {
	$controller = $parameters['controller'];
}

if (empty($parameters['action'])) {
	$action = 'index';
} else {
	$action = $parameters['action'];
}

$controllerClassName = ucfirst($controller) . 'Controller'; //indexController

$controllerClass = new $controllerClassName($parameters);

$controllerAction = $action . 'Action'; //indexController

$controllerClass->$controllerAction();


/**
$test = new JSONParser();

echo $test->selecter();

echo $test->getOutput();

echo $test->mappingOutput();
*/