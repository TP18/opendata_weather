<link rel="stylesheet" type="text/css" href="resource/css/style.css" />
<?php

/**
 * Error Handling php file_gets_content / time array /  Error handlinghttp://p2511-141-opendata.thpe.rz.snowflake.ch/index.php?controller=index&action=index
 */

require_once 'application/config/global.php';

	$parameters = array_merge($_GET, $_POST); //array_merge $_post

	$pattern = '/^[A-ZÄÖÜ0-9,]+$/i';
	$validAction = preg_match($pattern, $parameters['city']);
	if ($validAction == true) {
		$parameters['city'] = $parameters['city'];
	} else {
		$parameters['city'] = "Zurich,ch";
	}


	$pattern = '/^[A-ZÄÖÜ0-9=]+$/i';
	$validAction = preg_match($pattern, $parameters['units']);
	if ($validAction == true) {
		$parameters['units'] = $parameters['units'];
	} else {
		$parameters['units'] = "units=metric";
	}


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