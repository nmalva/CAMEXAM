<?php

session_start();
ob_start();
include_once ("../classes/class.city.php");

$campos["cit_id"]=$_POST["cit_id"];
$campos["cit_name"]=$_POST["cit_name"];

function insert(){
	global $campos;
	$class_city= new City();
	$class_city->insert($campos["cit_name"]);
}

function delete($cit_id){
	$class_city= new City();
	$class_city->delete($cit_id);
}


?>



