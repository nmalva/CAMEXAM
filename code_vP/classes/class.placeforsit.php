<?php

require_once("class.bd.php");

class PlaceForSit extends bd
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
        
				$this->plf_id=$id;
				$this->exa_id=$r["exa_id"];
				$this->exp_id=$r["exp_id"];
				$this->plf_timestamp=$r["plf_timestamp"];
        
      }
    }


	//-----------------Get Methods---------------

	function getPlf_id(){return $this->plf_id;}
	function getExa_id(){return $this->exa_id;}
	function getExp_id(){return $this->exp_id;}
	function getPlf_timestamp(){return $this->plf_timestamp;}



//-----------------Set Methods---------------

	function setPlf_id($value){
		$sql="UPDATE tabla SET plf_id={$value} WHERE plf_id={$this->plf_id}";
		$this-> ejecutar($sql);
	}
	function setExa_id($value){
		$sql="UPDATE tabla SET exa_id={$value} WHERE plf_id={$this->plf_id}";
		$this-> ejecutar($sql);
	}
	function setExp_id($value){
		$sql="UPDATE tabla SET exp_id={$value} WHERE plf_id={$this->plf_id}";
		$this-> ejecutar($sql);
	} 

//-----------------Insert---------------

	function insert($exa_id,$exp_id){
		$sql="INSERT INTO PlaceForSit (exa_id,exp_id) VALUES ( '{$exa_id}', '{$exp_id}')";
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM PlaceForSit WHERE exa_id={$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM City";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}

//-----------------Delete---------------


}
?>

