<?php
session_start();
ob_start();
include_once("../../classes/class.candidate.php");
include_once("../../classes/class.utiles.php");

$session_prc_id=$_SESSION["prc_id"]; 
$session_use_usertype=$_SESSION["use_usertype"];
$get_exa_id=$_POST["exa_id"];
$class_utiles=new utiles();
if ($_SESSION["use_usertype"]!=1)
    $field_visible["schedule_admin"]="none";


 Function getPlaceForSit($get_exa_id){
     $class_bd=new bd();
     $sql="SELECT * FROM PlaceForSit INNER JOIN ExamPlace on PlaceForSit.exp_id=ExamPlace.exp_id WHERE exa_id={$get_exa_id}";
     $resultado=$class_bd->ejecutar($sql);
     
     while($r=$class_bd->retornar_fila($resultado)){
        $string.= "<li class='list-group-item'>".$r['exp_name']."</li>";
        $control=1;
     }
     if ($control!=1)
         $string.="<li class='list-group-item'>There is not available Venues</li>";
     return ($string);
 } 
 
 
 function getCandidateStatus($exa_id, $session_use_usertype, $session_prc_id){
     $class_bd=new bd();
     if ($session_use_usertype<2)
        $sql="SELECT * FROM Candidate WHERE exa_id={$exa_id}";
     else
        $sql="SELECT * FROM Candidate WHERE exa_id={$exa_id} AND prc_id={$session_prc_id}";
     $counter=array(0,0,0,0);
     $resultado=$class_bd->ejecutar($sql); 
     while($r=$class_bd->retornar_fila($resultado)){
             $counter[$r["can_status"]]++;
     }
     return ($counter);
 }
 
 function getExamInformation($exa_id){
     $class_bd=new bd();
     $sql="SELECT * FROM Exam WHERE exa_id={$exa_id}";
     $resultado=$class_bd->ejecutar($sql);
     $r=$class_bd->retornar_fila($resultado);
     return ($r);
 }
 
 $counter=array(0,0,0,0);
 $counter=getCandidateStatus($get_exa_id, $session_use_usertype, $session_prc_id);
 $exam_info=getExamInformation($get_exa_id);
 
 $string.="
         <div class='panel panel-default'>
             <div class='panel-heading'>
             <h3 class='panel-title'>Dates</h3>
             </div>
            <ul class='list-group'>
                <li class='list-group-item'> Deadline: {$class_utiles->fecha_mysql_php($exam_info["exa_deadlineshow"])}</li>
                <li class='list-group-item'> Date Exam: <a href='candidate_table_admin_warnings.php?date={$exam_info["exa_date"]}'> {$class_utiles->fecha_mysql_php($exam_info["exa_date"])}</a></li>
                <li class='list-group-item'> View Candidate Schedules: <a href='exam_info_all.php?exa_id={$get_exa_id}'> Schedules </a></li>
                <li class='list-group-item' style='display:{$field_visible["schedule_admin"]};'> View Candidate Schedules Admin: <a href='exam_info_all_admin.php?exa_id={$get_exa_id}'> Schedules </a></li>
            </ul>
        </div>
        ";
 
 $string.="
      <div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'>Candidate Workflow</h3>
		</div>
		<div class='panel-body'>			             
             <div class='row list-separated'>
                <div class='col-md-3 col-sm-3 col-xs-6'>
                    <div class='font-black-mint font-sm'>
                        Not Sent
                    </div>
                    <div class='uppercase font-hg '>
                    {$counter[0]} 
                    </div>
                </div>
                <div class='col-md-3 col-sm-3 col-xs-6'>
                    <div class='font-black-mint font-sm'>
                        Sent
                    </div>
                    <div class='uppercase font-hg font-blue-sharp'>
                    {$counter[1]}    
                    </div>
                </div>
                <div class='col-md-3 col-sm-3 col-xs-6'>
                    <div class='font-black-mint font-sm'>
                        Confirmed
                    </div>
                    <div class='uppercase font-hg theme-font'>
                     {$counter[2]} 
                    </div>
               </div>
                <div class='col-md-3 col-sm-3 col-xs-6'>
                    <div class='font-black-mint font-sm'>
                        Error
                    </div>
                    <div class='uppercase font-hg font-red-flamingo'>
                     {$counter[3]} 
                    </div>
                </div>
            </div>			
		</div>
	</div>
	
     
 ";
 
$string.= "
    <div class='panel panel-default'>
		<!-- Default panel contents -->
		<div class='panel-heading'>
			<h3 class='panel-title'>Venues</h3>
		</div>
		";
$string.="<ul class='list-group'>";
$string.=getPlaceForSit($get_exa_id);  
$string.="</ul>";
$string.="</div>";



echo $string;





?>