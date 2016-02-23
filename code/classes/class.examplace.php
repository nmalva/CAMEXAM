<?php

require_once("class.bd.php");

class ExamPlace extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_ExamPlace=$numero_ExamPlace;
      
      if($id > 0)
      {
        $sql = "SELECT * FROM ExamPlace WHERE exp_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
				$this->exp_id=$id;
				$this->exp_name=$r["exp_name"];
				$this->exp_adress=$r["exp_adress"];
				$this->exp_telephone=$r["exp_telephone"];
				$this->exp_timestamp=$r["exp_timestamp"];
        
      }
    }


	//-----------------Get Methods---------------

	
	function getExp_id(){return $this->exp_id;}
	function getExp_name(){return $this->exp_name;}
	function getExp_adress(){return $this->exp_adress;}
	function getExp_telephone(){return $this->exp_telephone;}


//-----------------Set Methods---------------

	function setExp_id($value){
		$sql="UPDATE tabla SET exp_id={$value} WHERE exp_id={$this->exp_id}";
		$this-> ejecutar($sql);
	}
	function setExp_name($value){
		$sql="UPDATE tabla SET exp_name={$value} WHERE exp_id={$this->exp_id}";
		$this-> ejecutar($sql);
	}
	function setExp_adress($value){
		$sql="UPDATE tabla SET exp_adress={$value} WHERE exp_id={$this->exp_id}";
		$this-> ejecutar($sql);
	}
	function setExp_telephone($value){
		$sql="UPDATE tabla SET exp_telephone={$value} WHERE exp_id={$this->exp_id}";
		$this-> ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($exp_name,$exp_adress,$exp_telephone){
		$sql="INSERT INTO ExamPlace (exp_name,exp_adress,exp_telephone) VALUES ('{$exp_name}','{$exp_adress}','{$exp_telephone}')";
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM ExamPlace WHERE exp_id={$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM ExamPlace";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}


}
?>

