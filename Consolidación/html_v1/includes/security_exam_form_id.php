<?php  
$get_can_id=$_GET["can_id"];
$session_prc_id=$_SESSION["prc_id"];
$session_use_usertype=$_SESSION["use_usertype"];

include_once("../classes/class.bd.php");

function validationId($get_can_id, $session_prc_id){
    $class_bd= new bd();
    $sql="SELECT * FROM Candidate WHERE can_id={$get_can_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);
    
    if ($get_can_id!=NULL){
        if ($r["prc_id"]!=$session_prc_id)
            $control = "false";
        if ($r["can_status"]==1 or $r["can_status"]==2)
            $control = "false";
    }
    return ($control);
}


$validation= validationId($get_can_id, $session_prc_id);

if ($session_use_usertype>1){ //0-1 admin and internal (NM)
    if($validation=="false"){
       $string.="Invalid operation </br>";
       $string.="<a href='login_form.php'>return to login</a>";
       echo $string;
       exit();
    }
    
    
}
?>