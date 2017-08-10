<?php

 include_once("../../classes/class.candidate.php");

 
 
 $get_can_id=$_POST["can_id"];
 $get_exa_aci=$_POST["exa_aci"];
 
 Function getParameters($get_exa_id){
     $class_bd=new bd();
     $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_id={$get_exa_id}";
     $resultado=$class_bd->ejecutar($sql);
     $r=$class_bd->retornar_fila($resultado);
     $parameters["exa_date"]=$r["exa_date"];
     $parameters["tye_name"]=$r["tye_name"];
     return ($parameters);
 
 } 
 
 
$display_exa_aci=($get_exa_aci==0 ? "none" : "") ;

$class_candidate=new Candidate($get_can_id);

$payment_filename=$class_candidate->getCan_paymentfile();
$dni_filename=$class_candidate->getCan_dnifile();
$aci_filename=$class_candidate->getCan_acifile();
$disability_filename=$class_candidate->getCan_disabilityfile();
$path="../../files/";

if ($class_candidate->getCan_disability()==1)
    $display_disability="true";
else   
    $display_disability="false";


if($payment_filename!="")
    $string.= "<li class='list-group-item'>
    <a href='{$path}{$payment_filename}'> Payment Receipt </a> <span class='badge badge-success'> 1 </span>
    </li>";

if($payment_filename=="")
    $string.= "<li class='list-group-item'>
    Payment Receipt <span class='badge badge-default'> 0 </span>
    </li>";

//DNI eliminated v2.2
/*if($dni_filename!="")
    $string.= "<li class='list-group-item'>
    <a href='{$path}{$dni_filename}'> DNI/Passport Scan </a> <span class='badge badge-success'> 1 </span>
    </li>";
 
if($dni_filename=="")
    $string.= "<li class='list-group-item'>
    DNI/Passport Scan <span class='badge badge-default'> 0 </span>
    </li>";
*///
if($aci_filename!="")
    $string.= "<li class='list-group-item' style='display: {$display_exa_aci};' >
    <a href='{$path}{$aci_filename}'> Photo Consent Scan </a> <span class='badge badge-success'> 1 </span>
    </li>";

if($aci_filename=="")
    $string.= "<li class='list-group-item' style='display: {$display_exa_aci};'>
    Photo Consent Scan <span class='badge badge-default'> 0 </span>
    </li>";

if($disability_filename!="" and $display_disability=="true")
    $string.= "<li class='list-group-item'>
    <a href='{$path}{$disability_filename}'> SC Medical Certificate Scan </a> <span class='badge badge-success'> 1 </span>
    </li>";

if($disability_filename=="" and $display_disability=="true")
    $string.= "<li class='list-group-item'>
   SC Medical Certificate Scan <span class='badge badge-default'> 0 </span>
    </li>";

echo "
    <ul class='list-group'>
    {$string}
    </ul>
";
?>