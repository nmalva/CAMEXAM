<?php

session_start();
ob_start();
include_once ("../classes/class.examplace.php");

	$campos["exp_id"]=$_POST["exp_id"];
	$campos["exp_name"]=$_POST["exp_name"];
	$campos["exp_adress"]=$_POST["exp_adress"];
	$campos["exp_telephone"]=$_POST["exp_telephone"];


  $campos["exp_name"]="Marctwein";
	$campos["exp_adress"]="Avenida los paraisos 3344";
	$campos["exp_telephone"]="4333323";
	
	delete(1);

function insert(){
	global $campos;
	$class_examplace= new ExamPlace();
	$class_examplace->insert($campos["exp_name"],$campos["exp_adress"],$campos["exp_telephone"]);
}

function delete($exp_id){
	$class_examplace= new ExamPlace();
	$class_examplace->delete($exp_id);
}


?>



