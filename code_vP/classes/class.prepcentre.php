<?php

require_once("class.bd.php");

class PrepCentre extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_City=$numero_City;
      
      if($id > 0)
      {
        $sql = "SELECT * FROM City WHERE cit_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
        $this->cit_id = $id;
				$this->prc_id=$id;
				$this->prc_name=$r["prc_name"];
				$this->prc_shortname=$r["prc_shortname"];
				$this->prc_firstname=$r["prc_firstname"];
				$this->prc_lastname=$r["prc_lastname"];
				$this->prc_adress1=$r["prc_adress1"];
				$this->prc_adress2=$r["prc_adress2"];
				$this->cit_id=$r["cit_id"];
				$this->prc_postcode=$r["prc_postcode"];
				$this->prc_areacode=$r["prc_areacode"];
				$this->prc_telephone=$r["prc_telephone"];
				$this->prc_email=$r["prc_email"];
				$this->prc_typefunding=$r["prc_typefunding"];
				$this->prc_preparationtype=$r["prc_preparationtype"];
				$this->prc_uniqueid=$r["prc_uniqueid"];
				$this->prc_timestamp=$r["prc_timestamp"];
        
      }
    }


	//-----------------Get Methods---------------

	function getPrc_id(){return $this->prc_id;}
	function getPrc_name(){return $this->prc_name;}
	function getPrc_shortname(){return $this->prc_shortname;}
	function getPrc_firstname(){return $this->prc_firstname;}
	function getPrc_lastname(){return $this->prc_lastname;}
	function getPrc_adress1(){return $this->prc_adress1;}
	function getPrc_adress2(){return $this->prc_adress2;}
	function getCit_id(){return $this->cit_id;}
	function getPrc_postcode(){return $this->prc_postcode;}
	function getPrc_areacode(){return $this->prc_areacode;}
	function getPrc_telephone(){return $this->prc_telephone;}
	function getPrc_email(){return $this->prc_email;}
	function getPrc_typefunding(){return $this->prc_typefunding;}
	function getPrc_preparationtype(){return $this->prc_preparationtype;}
	function getPrc_uniqueid(){return $this->prc_uniqueid;}
	function getPrc_timestamp(){return $this->prc_timestamp;}


//-----------------Set Methods---------------

	function setPrc_id($value){
		$sql="UPDATE tabla SET prc_id={$value} WHERE prc_id={$this->prc_id}";
		$this-> ejecutar($sql);
	}
	function setPrc_name($value){
		$sql="UPDATE tabla SET prc_name={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_shortname($value){
		$sql="UPDATE tabla SET prc_shortname={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_firstname($value){
		$sql="UPDATE tabla SET prc_firstname={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_lastname($value){
		$sql="UPDATE tabla SET prc_lastname={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_adress1($value){
		$sql="UPDATE tabla SET prc_adress1={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_adress2($value){
		$sql="UPDATE tabla SET prc_adress2={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setCit_id($value){
		$sql="UPDATE tabla SET cit_id={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_postcode($value){
		$sql="UPDATE tabla SET prc_postcode={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_areacode($value){
		$sql="UPDATE tabla SET prc_areacode={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_telephone($value){
		$sql="UPDATE tabla SET prc_telephone={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_email($value){
		$sql="UPDATE tabla SET prc_email={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_typefunding($value){
		$sql="UPDATE tabla SET prc_typefunding={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_preparationtype($value){
		$sql="UPDATE tabla SET prc_preparationtype={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_uniqueid($value){
		$sql="UPDATE tabla SET prc_uniqueid={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}
	function setPrc_timestamp($value){
		$sql="UPDATE tabla SET prc_timestamp={$value} WHERE tabla_id=tablaid";
		$this-> ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($prc_name,$prc_shortname,$prc_firstname,$prc_lastname,$prc_adress1,$prc_adress2,$cit_id,$prc_postcode,$prc_areacode,$prc_telephone,$prc_email,$prc_typefunding,$prc_preparationtype,$prc_uniqueid){
	
		$sql="INSERT INTO PrepCentre (prc_name,prc_shortname,prc_firstname,prc_lastname,prc_adress1,prc_adress2,cit_id,prc_postcode,prc_areacode,prc_telephone,prc_email,prc_typefunding,prc_preparationtype,prc_uniqueid) 
		
		VALUES ('{$prc_name}','{$prc_shortname}','{$prc_firstname}','{$prc_lastname}','{$prc_adress1}','{$prc_adress2}', '{$cit_id}','{$prc_postcode}', '{$prc_areacode}', '{$prc_telephone}','{$prc_email}', '{$prc_typefunding}', '{$prc_preparationtype}','{$prc_uniqueid}')";
		
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM PrepCentre WHERE prc_id={$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM City";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}
}
?>

