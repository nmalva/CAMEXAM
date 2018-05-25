<?php

session_start();
ob_start();
include_once ("../classes/class.typeexam.php");

$campos["tye_id"]=$_POST["tye_id"];
$campos["tye_name"]=$_POST["tye_name"];
$campos["tye_aci"]=$_POST["tye_aci"];


function insert(){
	global $campos;
	$class_typeexam= new typeExam();
	$class_typeexam->insert($campos["tye_name"],$campos["tye_aci"]);
}

function delete($tye_id){
	$class_typeexam= new TypeExam();
	$class_typeexam->delete($tye_id);
}


?>



