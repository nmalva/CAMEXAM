<?php

session_start();
ob_start();
include_once ("../classes/class.prepcentre.php");

		$campos["prc_id"]=$_POST["prc_id"];
		$campos["prc_name"]=$_POST["prc_name"];
		$campos["prc_shortname"]=$_POST["prc_shortname"];
		$campos["prc_firstname"]=$_POST["prc_firstname"];
		$campos["prc_lastname"]=$_POST["prc_lastname"];
		$campos["prc_adress1"]=$_POST["prc_adress1"];
		$campos["prc_adress2"]=$_POST["prc_adress2"];
		$campos["cit_id"]=$_POST["cit_id"];
		$campos["prc_postcode"]=$_POST["prc_postcode"];
		$campos["prc_areacode"]=$_POST["prc_areacode"];
		$campos["prc_telephone"]=$_POST["prc_telephone"];
		$campos["prc_email"]=$_POST["prc_email"];
		$campos["prc_typefunding"]=$_POST["prc_typefunding"];
		$campos["prc_preparationtype"]=$_POST["prc_preparationtype"];
		$campos["prc_uniqueid"]=$_POST["prc_uniqueid"];
	
	
				
function insert(){
	global $campos;
	$class_prepcentre= new PrepCentre();
	$class_prepcentre->insert(
														$campos["prc_name"],
														$campos["prc_shortname"],
														$campos["prc_firstname"],
														$campos["prc_lastname"],
														$campos["prc_adress1"],
														$campos["prc_adress2"],
														$campos["cit_id"],
														$campos["prc_postcode"],
														$campos["prc_areacode"],
														$campos["prc_telephone"],
														$campos["prc_email"],
														$campos["prc_typefunding"],
														$campos["prc_preparationtype"],
														$campos["prc_uniqueid"]);
}

function delete($prc_id){
	$class_prepcentre= new PrepCentre();
	$class_prepcentre->delete($prc_id);
}


?>



