<?php
//datatypes
$x = "Tayyaba Rani";
echo $x . "<br>";
var_dump($x); //Returs two values that are datatypes and value
$y = 25;
$z = 24.08;
$a = true;
$arr = array("html","css","js");
$n = null;
var_dump($y); //return integer datatype
var_dump($z); //return float datatype
var_dump($a); //return boolean datatype
var_dump($arr); //return array datatype
var_dump($n); //return null datatype

//constants
//constants are global variable and dont use $ sign in definnition
define(num,400); //defines constant
echo num;

//Comparison Operators
//In comparison operators if we have true then it return 1 and if there is false it return empty.

$e = 1;
$f = 2;
echo $e == $f; //return emptty noting as it is false
?>