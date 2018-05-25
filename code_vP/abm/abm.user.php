<?php


session_start();
ob_start();

include_once ("../classes/class.user.php");


$campos["use_id"]=$_POST["use_id"];
$campos["use_name"]=$_POST["use_name"];
$campos["use_lastname"]=$_POST["use_lastname"];
$campos["use_email"]=$_POST["use_email"];
$campos["use_telephone"]=$_POST["use_telephone"];
$campos["use_user"]=$_POST["use_user"];
$campos["use_password"]=$_POST["use_password"];
$campos["use_usertype"]=$_POST["use_usertype"];
$campos["prc_id"]=$_POST["prc_id"];


$campos["use_name"]="Nicolas";
$campos["use_lastname"]="Malvasio";
$campos["use_email"]="nmalva@hotmail.com";
$campos["use_telephone"]="3514534567";
$campos["use_user"]="nmalva";
$campos["use_password"]="14411441";
$campos["use_usertype"]=0;
$campos["prc_id"]=2;


delete(1);

function insert(){
	global $campos;
	$class_user= new User();
	$class_user->insert(
											$campos["use_name"],
											$campos["use_lastname"],
											$campos["use_email"],
											$campos["use_telephone"],
											$campos["use_user"],
											$campos["use_password"],
											$campos["use_usertype"],
											$campos["prc_id"]
											);
}

function delete($use_id){
	$class_user= new User();
	$class_user->delete($use_id);
}


?>



