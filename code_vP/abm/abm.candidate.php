<?php

session_start();
ob_start();
include_once ("../classes/class.candidate.php");
include_once ("../classes/class.utiles.php");


$session_use_usertype=$_SESSION["use_usertype"];

$class_utiles=new utiles();

$campos["can_id"]= $_POST["can_id"];
$campos["can_dni"]=$_POST["can_dni"];
$campos["can_firstname"]=addslashes($_POST["can_firstname"]);
$campos["can_lastname"]=addslashes($_POST["can_lastname"]);
$campos["can_gender"]=$_POST["can_gender"];
$campos["can_datebirth"]=$class_utiles->fecha_php_mysql($_POST["can_datebirth"]);
$campos["can_email"]=$_POST["can_email"];
$campos["can_adress"]=addslashes($_POST["can_adress"]);
$campos["can_telephone"]=$_POST["can_telephone"];
$campos["can_cellphone"]=$_POST["can_cellphone"];
$campos["can_visa"]=$_POST["can_visa"];
$campos["can_disability"]=$_POST["can_disability"];
$campos["can_disabilitycom"]=$_POST["can_disabilitycom"];
$campos["exp_id"]=$_POST["exp_id"];
$campos["exa_id"]=$_POST["exa_id"];
$campos["prc_id"]=$_POST["prc_id"];
$campos["can_candidatenum"]=$_POST["can_candidatenum"];
$campos["can_packingcode"]=$_POST["can_packingcode"];
$campos["can_status"]=$_POST["can_status"]; // it is used to update status candidate.
$campos["can_comment"]=$_POST["can_comment"]; // it is used to update comment candidate.
$campos["can_commentadmin"]=$_POST["can_commentadmin"]; // it is used to update comment admin.
$campos["can_candidatenum"]=$_POST["can_candidatenum"];
$campos["can_packingcode"]=$_POST["can_packingcode"];
// this is use v19 for the change o f Prc_id administrator
if ($campos["prc_id"]==2)
   $campos["can_candidatetype"] =1;
else 
   $campos["can_candidatetype"] =2;


if ($campos["can_status"]!=NULL)
    updateStatus($campos);
elseif ($campos["can_comment"]!=NULL)
    updateComment($campos);
elseif ($campos["can_commentadmin"]!=NULL)
    updateCommentadmin($campos);
elseif ($campos["can_candidatenum"]!=NULL)
    updateCandidatenum($campos);
elseif ($campos["can_packingcode"]!=NULL)
    updatePackingcode($campos);
else
    insertUpdate($campos, $session_use_usertype);

function updateCandidatenum($campos){
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_candidatenum($campos["can_candidatenum"]);

}
function updatePackingcode($campos){
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_packingcode($campos["can_packingcode"]);

}

function updateComment($campos){
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_comment($campos["can_comment"]);
}

function updateCommentadmin($campos){
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_commentadmin($campos["can_commentadmin"]);

}

function updateStatus($campos){
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_status($campos["can_status"]);
  
}

function insertUpdate($campos, $session_use_usertype){
    if ($campos["can_id"]==""){
        if (checkdni($campos)=="false"){
            $id=insert();
            if ($session_use_usertype<2 and $session_use_usertype!=NULL) {//it is admin or internal to get the candidates in workflow // The null its add because widthout session the status was setted to sent
                $class_candidate= new Candidate($id);
                $class_candidate->setCan_status(1);
            }   
        }
        else
            echo "-10";
    }else{
        update();
    }
}


function insert(){
	global $campos;
	$class_candidate= new Candidate();
	$new_can_id=$class_candidate->insert(
    							$campos["can_dni"],
    							$campos["can_firstname"],
    							$campos["can_lastname"],
    							$campos["can_gender"],
    							$campos["can_datebirth"],
    							$campos["can_email"],
    							$campos["can_adress"],
    							$campos["can_telephone"],
    							$campos["can_cellphone"],
    							$campos["can_visa"],
    							$campos["can_disability"],
    							$campos["can_disabilitycom"],
    							$campos["exp_id"],
	                            $campos["exa_id"],
    							$campos["can_candidatetype"],
    							$campos["prc_id"],
    							$campos["can_candidatenum"],
    							$campos["can_packingcode"]
    							);
	echo $new_can_id;
	return ($new_can_id);
}

function update(){
    global $campos;
    $class_candidate= new Candidate($campos["can_id"]);
    $class_candidate->setCan_dni($campos["can_dni"]);
    $class_candidate->setCan_firstname($campos["can_firstname"]);
    $class_candidate->setCan_lastname($campos["can_lastname"]);
    $class_candidate->setCan_gender($campos["can_gender"]);
    $class_candidate->setCan_datebirth($campos["can_datebirth"]);
    $class_candidate->setCan_email($campos["can_email"]);

    $class_candidate->setCan_adress($campos["can_adress"]);
    $class_candidate->setCan_telephone($campos["can_telephone"]);
    $class_candidate->setCan_cellphone($campos["can_cellphone"]);
    $class_candidate->setCan_visa($campos["can_visa"]);
    $class_candidate->setCan_disability($campos["can_disability"]);
    $class_candidate->setCan_disabilitycom($campos["can_disabilitycom"]);
    $class_candidate->setPrc_id($campos["prc_id"]);
    $class_candidate->setExp_id($campos["exp_id"]);
   // $class_candidate->setExa_id($campos["exa_id"]);
    $class_candidate->setCan_candidatetype($campos["can_candidatetype"]);
    $class_candidate->setCan_candidatenum($campos["can_candidatenum"]);

    //$class_candidate->setCan_packingcode($campos["can_packingcode"]);

   
}

function delete($can_id){
	$class_candidate= new Candidate();
	$class_candidate->delete($can_id);
}

function checkdni($campos){
    $class_bd=new bd();
    $sql="SELECT can_id, exa_status FROM Candidate
    INNER JOIN Exam ON Candidate.exa_id = Exam.exa_id
    WHERE Candidate.can_dni={$campos["can_dni"]} AND (Exam.exa_status='1') ";  //esto se modifico para no permitir carga de un alumno en dos cursos abiertos
    $numrows= mysql_num_rows($class_bd->ejecutar($sql));
    if ($numrows>0)
        $exist="true";
    else    
        $exist="false"; 
    return ($exist);
}


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