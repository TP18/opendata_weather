<link rel="stylesheet"  type="text/css" href="resource/css/style.css"/>
<link rel="stylesheet" media="only screen and (min-width : 0px) and (max-width: 750px)" type="text/css" href="resource/css/mobile.css"/>
<link rel="stylesheet" media="screen and (device-aspect-ratio: 40/71) " type="text/css" href="resource/css/mobile.css"/>
<?php

use Snowflake\OpenData\Controller\IndexController;

/**
 * time array /  http://p2511-141-opendata.thpe.rz.snowflake.ch/index.php?controller=blabla&action=index1
 */

require_once 'application/config/global.php';

$parameters = array_merge($_GET, $_POST);
$controller = 'index';
$action = 'index';

$controllerClassName = 'Snowflake\\OpenData\\Controller\\' . ucfirst($controller) . 'Controller'; //IndexController

$controllerClass = new $controllerClassName($parameters);

$controllerAction = $action . 'Action'; //IndexController

$controllerClass->$controllerAction();