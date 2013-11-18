<?php
$baseDir = __DIR__;

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); // or error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);


require_once('constants.php');
require_once($baseDir . '/../model/parser/JSONParser.php');
require_once($baseDir . '/../controller/IndexController.php');
require_once($baseDir . '/../model/Exceptions.php');
