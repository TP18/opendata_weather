<?php

require_once 'SimpleClass.php';

SimpleClass::echo1();


$tp = new SimpleClass("Petersen", "Thomas", "thomas");
$tp2 = new SimpleClass("Mächler", "Markus");

$tp->echo1();
$tp->addieren(2, 4);

echo $tp->vorname . " " . $tp->name . "<br>";

echo $tp2->getName();


//phpinfo();
