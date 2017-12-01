<?php

require_once("class.bd.php");
//
class Candidate extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_Candidate=$numero_Candidate;
    
      if($id > 0)
      {
        $sql = "SELECT * FROM Candidate WHERE can_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
        $this->can_id = $id;
				$this->can_dni=$r["can_dni"];
				$this->can_firstname=$r["can_firstname"];
				$this->can_lastname=$r["can_lastname"];
				$this->can_gender=$r["can_gender"];
				$this->can_datebirth=$r["can_datebirth"];
				$this->can_email=$r["can_email"];
				$this->can_adress=$r["can_adress"];
				$this->can_telephone=$r["can_telephone"];
				$this->can_cellphone=$r["can_cellphone"];
				$this->can_visa=$r["can_visa"];
				$this->can_disability=$r["can_disability"];
				$this->can_disabilitycom=$r["can_disabilitycom"];
				$this->exp_id=$r["exp_id"];
				$this->exa_id=$r["exa_id"];
				$this->can_candidatetype=$r["can_candidatetype"];
				$this->prc_id=$r["prc_id"];
				$this->can_candidatenum=$r["can_candidatenum"];
				$this->can_paymentfile=$r["can_paymentfile"];
				$this->can_dnifile=$r["can_dnifile"];
				$this->can_acifile=$r["can_acifile"];
				$this->can_disabilityfile=$r["can_disabilityfile"];
				$this->epa_id=$r["epa_id"];
				$this->can_status=$r["can_status"];
				$this->can_comment=$r["can_comment"];
				$this->can_commentadmin=$r["can_commentadmin"];
				$this->can_timelistening=$r["can_timelistening"];
				$this->can_timespeaking=$r["can_timespeaking"];
				$this->can_datespeaking=$r["can_datespeaking"];
				$this->can_timewriting=$r["can_timewriting"];
				$this->can_timereading=$r["can_timereading"];
				$this->can_timereadingandwriting=$r["can_timereadingandwriting"];
				$this->can_timereadinganduseofenglish=$r["can_timereadinganduseofenglish"];
				$this->can_packingcodespeaking=$r["can_packingcodespeaking"];

	
        
      }
    }


	//-----------------Get Methods---------------

	function getCan_id(){return $this->can_id;}
	function getCan_dni(){return $this->can_dni;}
	function getCan_firstname(){return $this->can_firstname;}
	function getCan_lastname(){return $this->can_lastname;}
	function getCan_gender(){return $this->can_gender;}
	function getCan_datebirth(){return $this->can_datebirth;}
	function getCan_email(){return $this->can_email;}
	function getCan_adress(){return $this->can_adress;}
	function getCan_telephone(){return $this->can_telephone;}
	function getCan_cellphone(){return $this->can_cellphone;}
	function getCan_visa(){return $this->can_visa;}
	function getCan_disability(){return $this->can_disability;}
	function getCan_disabilitycom(){return $this->can_disabilitycom;}
	function getExp_id(){return $this->exp_id;}
	function getExa_id(){return $this->exa_id;}
	function getCan_candidatetype(){return $this->can_candidatetype;}
	function getPrc_id(){return $this->prc_id;}
	function getCan_candidatenum(){return $this->can_candidatenum;}
	function getEpa_id(){return $this->epa_id;}
	function getCan_paymentfile(){return $this->can_paymentfile;}
	function getCan_dnifile(){return $this->can_dnifile;}
	function getCan_acifile(){return $this->can_acifile;}
	function getCan_disabilityfile(){return $this->can_disabilityfile;}
	function getCan_status(){return $this->can_status;}
	function getCan_comment(){return $this->can_comment;}
	function getCan_commentadmin(){return $this->can_commentadmin;}
	function getCan_timelistening(){return $this->can_timelistening;}
	function getCan_timespeaking(){return $this->can_timespeaking;}
	function getCan_datepeaking(){return $this->can_datespeaking;}
	function getCan_timewriting(){return $this->can_timewriting;}
	function getCan_timereading(){return $this->can_timereading;}
	function getCan_timereadingandwriting(){return $this->can_timereadingandwriting;}
	function getCan_timereadinganduseofenglish(){return $this->can_timereadinganduseofenglish;}
	function getCan_timestamp(){return $this->can_timestamp;}


	//-----------------Set Methods---------------

	function setCan_id($value){
		$sql="UPDATE Candidate SET can_id='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_dni($value){
		$sql="UPDATE Candidate SET can_dni='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_firstname($value){
		$sql="UPDATE Candidate SET can_firstname='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_lastname($value){
		$sql="UPDATE Candidate SET can_lastname='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_gender($value){
		$sql="UPDATE Candidate SET can_gender='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_datebirth($value){
		$sql="UPDATE Candidate SET can_datebirth='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_email($value){
		$sql="UPDATE Candidate SET can_email='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_adress($value){
		$sql="UPDATE Candidate SET can_adress='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_telephone($value){
		$sql="UPDATE Candidate SET can_telephone='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_cellphone($value){
		$sql="UPDATE Candidate SET can_cellphone='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_visa($value){
		$sql="UPDATE Candidate SET can_visa='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_disability($value){
		$sql="UPDATE Candidate SET can_disability= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_disabilitycom($value){
		$sql="UPDATE Candidate SET can_disabilitycom= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setExp_id($value){
		$sql="UPDATE Candidate SET exp_id= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setExa_id($value){
	    $sql="UPDATE Candidate SET exa_id= '{$value}' WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_candidatetype($value){
		$sql="UPDATE Candidate SET can_candidatetype='{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setPrc_id($value){
		$sql="UPDATE Candidate SET prc_id= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_candidatenum($value){
		$sql="UPDATE Candidate SET can_candidatenum= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setEpa_id($value){
		$sql="UPDATE Candidate SET epa_id= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_paymentfile($value){
    	$sql="UPDATE Candidate SET can_paymentfile= '{$value}' WHERE can_id={$this->can_id}";
    	$this-> ejecutar($sql);
	}	
	function setCan_dnifile($value){
		$sql="UPDATE Candidate SET can_dnifile= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}	
	function setCan_acifile($value){
		$sql="UPDATE Candidate SET can_acifile= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_disabilityfile($value){
		$sql="UPDATE Candidate SET can_disabilityfile= '{$value}' WHERE can_id={$this->can_id}";
		$this-> ejecutar($sql);
	}
	function setCan_status($value){
	    $sql="UPDATE Candidate SET can_status= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_comment($value){
	    $sql="UPDATE Candidate SET can_comment= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_commentadmin($value){
	    $sql="UPDATE Candidate SET can_commentadmin= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timelistening($value){
	    $sql="UPDATE Candidate SET can_timelistening= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timespeaking($value){
	    $sql="UPDATE Candidate SET can_timespeaking= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_datespeaking($value){
	    $sql="UPDATE Candidate SET can_datespeaking= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timewriting($value){
	    $sql="UPDATE Candidate SET can_timewriting= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timereading($value){
	    $sql="UPDATE Candidate SET can_timereading= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timereadingandwriting($value){
	    $sql="UPDATE Candidate SET can_timereadingandwriting= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_timereadinganduseofenglish($value){
	    $sql="UPDATE Candidate SET can_timereadinganduseofenglish= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}
	function setCan_packingcodespeaking($value){
	    $sql="UPDATE Candidate SET can_packingcodespeaking= '{$value}'  WHERE can_id={$this->can_id}";
	    $this-> ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($can_dni,$can_firstname,$can_lastname,$can_gender,$can_datebirth,$can_email,$can_adress,$can_telephone,$can_cellphone,$can_visa,$can_disability,$can_disabilitycom,$exp_id,$exa_id,$can_candidatetype,$prc_id,$can_candidatenum,$epa_id){
	
	$sql="INSERT INTO Candidate 			
			(can_dni,can_firstname,can_lastname,can_gender,can_datebirth,can_email,can_adress,can_telephone,can_cellphone,can_visa,can_disability,can_disabilitycom,exp_id,exa_id,can_candidatetype,prc_id,can_candidatenum,epa_id) 
		
	VALUES ( '{$can_dni}','{$can_firstname}','{$can_lastname}','{$can_gender}','{$can_datebirth}','{$can_email}','{$can_adress}','{$can_telephone}','{$can_cellphone}', '{$can_visa}', '{$can_disability}','{$can_disabilitycom}', '{$exp_id}','{$exa_id}', '{$can_candidatetype}', '{$prc_id}', '{$can_candidatenum}', '{$epa_id}')";
		
		return($this->ejecutar($sql));
	}

//-----------------Insert---------------

	function delete($id){
	
	$sql="DELETE FROM Candidate WHERE can_id={$id}";
	$this->ejecutar($sql);
	}

//-----------------GetAll---------------

function getAll(){
		$sql = "SELECT * FROM Candidate";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}
}
?>