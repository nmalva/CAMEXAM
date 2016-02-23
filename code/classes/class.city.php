<?php
require_once("class.bd.php");

class City extends bd
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
				$this->cit_name=$r["cit_name"];
				$this->cit_timestamp=$r["cit_timestamp"];
        
      }
    }


	//-----------------Get Methods---------------

	function getCit_id(){return $this->cit_id;}
	function getCit_name(){return $this->cit_name;}
	function getCit_timestamp(){return $this->cit_timestamp;}


//-----------------Set Methods---------------

	function setCit_name($value){
		$sql="UPDATE tabla SET cit_name='{$value}' WHERE cit_id={$this->cit_id}";
		$this->ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($cit_name){
		$sql="insert into City (cit_name) values ('{$cit_name}')";
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM City WHERE cit_id = {$id}";
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

