<link rel="stylesheet" type="text/css" href="resource/css/style.css" />
<?php

/**
 * Error Handling php file_gets_content / time array /  Error handlinghttp://p2511-141-opendata.thpe.rz.snowflake.ch/index.php?controller=index&action=index
 */

require_once 'application/config/global.php';

	$parameters = array_merge($_GET, $_POST);

	$pattern = '/^[A-Z]+[\,]{1}[A-Z]{2}$/i';
	$validCity = preg_match($pattern, $parameters['city']);
	if ($validCity == false) {
		$parameters['city'] = "Zurich,ch";
	}

	$pattern = '/^(imperial|metric)$/i';
	$validUnits = preg_match($pattern, $parameters['units']);
	if ($validUnits == false) {
		$parameters['units'] = "metric";
	}

$validControllers = array(
'index',
'test',
);

if (empty($parameters['controller'])) {
	$parameters['controller'] = 'index';
}

$controller = 'index';
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

if (empty($parameters['action'])) {
	$parameters['action'] = 'index';
}

$action = 'index';
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