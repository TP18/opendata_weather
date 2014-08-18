<?php

use TPetersen\OpenData\Model\Validator\ControllerActionValidator;

/**
 * time array /  http://p2511-141-opendata.thpe.rz.snowflake.ch/index.php?controller=blabla&action=index1
 */

require_once 'application/config/global.php';

$parameters = array_merge($_GET, $_POST);
$validControllerAction = new ControllerActionValidator($parameters);
$controllerClassName = $validControllerAction->getControllerClassName();
$controllerAction = $validControllerAction->getAction();

$controllerClass = new $controllerClassName($parameters);
$controllerClass->$controllerAction();
