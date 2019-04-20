<?php 

include_once("../classes/class.bd.php");

$TypeExam = array(); 
$class_bd=new bd();
$sql="SELECT * FROM TypeExam";

$resultado=$class_bd->ejecutar($sql);

 while ($r=$class_bd->retornar_fila($resultado)){
	 $temp = [
 		'tye_id'=>$r["tye_id"],
 		'tye_name'=>$r["tye_name"]
 	];
 	array_push($TypeExam, $temp);
 }

 
//displaying the data in json format 
echo json_encode($TypeExam);

?>
