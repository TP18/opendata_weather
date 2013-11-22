<link rel="stylesheet" type="text/css" href="resource/css/style.css" />
<?php

/**
 * time array /  http://p2511-141-opendata.thpe.rz.snowflake.ch/index.php?controller=blabla&action=index1
 */

require_once 'application/config/global.php';
	$parameters = array_merge($_GET, $_POST);
	$controller = 'index';
	$action = 'index';

$controllerClassName = ucfirst($controller) . 'Controller'; //indexController

$controllerClass = new $controllerClassName($parameters);

$controllerAction = $action . 'Action'; //indexController

$controllerClass->$controllerAction();
/**

	$validControllers = array(
	'index',
	'test',
	);

	$controller = 'index';
	if (empty($parameters['controller'])) {
		$parameters['controller'] = 'index';
	}

	if (in_array($parameters['controller'], $validControllers)) {
		$controller = $parameters['controller'];
	}

	try {
		if (!in_array($parameters['controller'], $validControllers)) {// hier muss $parameters['controller'] stehen. $contoller macht keinen Sinn
			$error = 'Not a valid controller';
			throw new Exception($error);
		}
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
	}


	$validActions = array(
	'index',
	'test',
	);

	$action = 'index';
	if (empty($parameters['action'])) {
		$parameters['action'] = 'index';
	}

	if (in_array($parameters['action'], $validActions)) {
		$action = $parameters['action'];
	}

	try {
		if (!in_array($parameters['action'], $validActions)) {
			$error = 'Not a valid action';
			throw new Exception($error);
		}
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), '<br><br>';
	}


$test = new JSONParser();

echo $test->selecter();

echo $test->getOutput();

echo $test->mappingOutput();
*/