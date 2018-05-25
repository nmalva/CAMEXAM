<?php
session_start();
ob_start();

include_once ("../classes/class.exam.php");
include_once ("../classes/class.utiles.php");

$class_utiles=new utiles();

	$campos["exa_id"]=$_POST["submit"];
	$campos["exa_date"]=$class_utiles->fecha_php_mysql($_POST["exa_date"]);
	$campos["tye_id"]=$_POST["tye_id"];
	$campos["exa_comment"]=$_POST["exa_comment"];
	$campos["exa_status"]=$_POST["exa_status"];
	$campos["exa_aci"]=$_POST["exa_aci"];
	$campos["exa_visa"]=$_POST["exa_visa"];
	$campos["exa_deadline"]=$class_utiles->fecha_php_mysql($_POST["exa_deadline"]);
	$campos["exa_deadlineshow"]=$class_utiles->fecha_php_mysql($_POST["exa_deadlineshow"]);
	

if ($campos["exa_id"]==NULL){//el valor de exa_id se puso en el value del boton submit
    
   
    if (!checkexam($campos["exa_date"], $campos["tye_id"]))
        insert();
    else
        echo -1;
}
       	

if ($campos["exa_id"]!=NULL) //el valor de exa_id se puso en el value del boton submit
       update();



function checkexam($exa_date, $tye_id){
    $class_exam=new Exam();
    return($class_exam->checkExam($exa_date, $tye_id));    
}

function insert(){
	global $campos;
	$class_exam= new Exam();
	$new_exa_id=$class_exam->insert($campos["exa_date"],$campos["tye_id"],$campos["exa_comment"],$campos["exa_status"],$campos["exa_aci"],$campos["exa_visa"],$campos["exa_deadline"],$campos["exa_deadlineshow"]);
	echo ($new_exa_id);
}

function update(){ 
    global $campos;
    $class_exam= new Exam($campos["exa_id"]);
    $class_exam->setExa_date($campos["exa_date"]);
    $class_exam->setTye_id($campos["tye_id"]);
    $class_exam->setExa_comment($campos["exa_comment"]);
    $class_exam->setExa_status($campos["exa_status"]);
    $class_exam->setExa_aci($campos["exa_aci"]);
    $class_exam->setExa_visa($campos["exa_visa"]);
    $class_exam->setExa_deadline($campos["exa_deadline"]);
    $class_exam->setExa_deadlineshow($campos["exa_deadlineshow"]);
}

function delete($exa_id){
	$class_exam= new Exam();
	$class_exam->delete($exa_id);
}


?>



