<?php

session_start();
ob_start();
include_once ("../classes/class.placeforsit.php");

$exp_id = $_POST["selected"];
$length = $_POST["length"];
$exa_id = $_POST["exa_id"];

echo $length;

$campos["plf_id"]=$_POST["plf_id"];
$campos["exa_id"]=$_POST["exa_id"];
$campos["exp_id"]=$_POST["exp_id"];



delete_all($exa_id);
update($exa_id, $exp_id, $length);



function delete_all($exa_id){
   $class_placeforsit= new PlaceForSit(); 
   $class_placeforsit->delete($exa_id);
}
    


function update($exa_id, $exp_id, $length){

    $class_placeforsit = new PlaceForSit();
    
    for ($i=0; $i<$length; $i++){
        $class_placeforsit->insert($exa_id, $exp_id[$i]);    
    }
}


function insert(){
	global $campos;
	$class_placeforsit= new PlaceForSit();
	$class_placeforsit->insert($campos["exa_id"],$campos["exp_id"]);
}

function delete($plf_id){
	$class_placeforsit= new PlaceForSit();
	$class_placeforsit->delete($plf_id);
}


?>



