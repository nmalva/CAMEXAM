<?php

session_start();
ob_start();
include_once ("../classes/class.candidate.php");
include_once ("../classes/class.utiles.php");

$session_use_usertype=$_SESSION["use_usertype"];
$class_utiles=new utiles();

//

$array_ids= $_POST["ids"];
$init_value = $_POST["init_value"];
$epa_id=  $_POST["epa_id"]; //ExamPlaceAula Id
$set= $_POST["set"];
$time_interval=$_POST["time_interval"];
$time_start_speaking= $_POST["time_start_speaking"];//$_POST["time_start_speaking"];
$time_group=$_POST["time_group"];

$can_timelistening= $_POST["can_timelistening"];
$can_timewriting= $_POST["can_timewriting"];
$can_timereading= $_POST["can_timereading"];
$can_timereadingandwriting= $_POST["can_timereadingandwriting"];
$can_timereadinganduseofe =$_POST["can_timereadinganduseofe"];
$can_datespeaking = $_POST["can_datespeaking"];

//echo $set;
$quantity = count($array_ids);
$time_listening="08:23:01"; 




if($set=="set_candidate"){
    updateCandidatenum($array_ids, $quantity, $init_value);
}
if($set=="set_packingcode"){
    updatePackingcode($array_ids, $quantity, $epa_id);
}
if($set=="set_packingcode_speaking"){
    updatePackingcodespeaking($array_ids, $quantity, $epa_id);
}
if($set=="set_timespeaking"){
    updateTimespeaking($array_ids, $quantity, $time_start_speaking, $time_interval, $time_group, $can_datespeaking);
}

if($set=="set_timevarious"){
   updateTimelistening($array_ids, $quantity, $can_timelistening);
   updateTimewriting($array_ids, $quantity, $can_timewriting);
   updateTimereading($array_ids, $quantity, $can_timereading);
   updateTimereadingandwriting($array_ids, $quantity, $can_timereadingandwriting);
   updateTimereadinganduseofe($array_ids, $quantity, $can_timereadinganduseofe);
}
/*
updateTimelistening($array_ids, $quantity, $time_listening);

*/

function updateCandidatenum($array_ids, $quantity, $init_value){
    
    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_candidatenum($init_value+$i);
    }
}

function updatePackingcode($array_ids, $quantity, $epa_id){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setEpa_id($epa_id);
    }
}
function updatePackingcodespeaking($array_ids, $quantity, $epa_id){

     for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_packingcodespeaking($epa_id);
    }
}
function updateTimespeaking($array_ids, $quantity, $time_start_speaking,$time_interval, $time_group, $can_datespeaking){
    $a==0;
    $b=0;
    $class_utiles=new utiles();
    for ($i=0; $i<$quantity; $i++){
        
        $time_speaking = date("H:i:s",strtotime($time_start_speaking)+($b*$time_interval*60));
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timespeaking($time_speaking);
        $class_candidate[$i]->setCan_datespeaking($class_utiles->fecha_php_mysql_2($can_datespeaking));

        $a++;
        if ($a==$time_group){
            $b++;
            $a=0;
        }
    }

echo $can_datespeaking."hola";

}

function updateTimelistening($array_ids, $quantity, $can_timelistening){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timelistening($can_timelistening);
    }
}
function updateTimewriting($array_ids, $quantity, $can_timewriting){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timewriting($can_timewriting);
    }
}
function updateTimereading($array_ids, $quantity, $can_timereading){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timereading($can_timereading);
    }
}
function updateTimereadingandwriting($array_ids, $quantity, $can_timereadingandwriting){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timereadingandwriting($can_timereadingandwriting);
    }
}
function updateTimereadinganduseofe($array_ids, $quantity, $can_timereadinganduseofe){

    for ($i=0; $i<$quantity; $i++){
        $class_candidate[$i]= new Candidate($array_ids[$i]);
        $class_candidate[$i]->setCan_timereadinganduseofenglish($can_timereadinganduseofe);
    }
}



//print_r ($array_ids);
/*
$campos["can_dni"]="32204488";
$campos["can_name"]="Nicolas";
$campos["can_lastname"]="Malvasio";
$campos["can_gender"]="1";
$campos["can_datebirth"]="20/03/1986";
$campos["can_email"]="nmalva@hotmail.com";
$campos["can_adress"]="Posadas 454";
$campos["can_telephone"]="4517607";
$campos["can_cellphone"]="153222280";
$campos["can_visa"]="1";
$campos["can_disability"]="0";
$campos["can_disabilitycom"]="blabla";
$campos["exp_id"]="2";
$campos["can_candidatetype"]="1";
$campos["prc_id"]="3";
$campos["can_candidatenum"]="5000";
$campos["can_packingcode"]="10";
*/
?>