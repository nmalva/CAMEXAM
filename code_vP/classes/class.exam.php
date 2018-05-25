<?php

require_once("class.bd.php");

class Exam extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_Exam=$numero_Exam;
      
      if($id > 0)
      {
        $sql = "SELECT * FROM Exam WHERE exa_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
      	$this->exa_id=$id;
				$this->exa_date=$r["exa_date"];
				$this->tye_id=$r["tye_id"];
				$this->exa_comment=$r["exa_comment"];
				$this->exa_status=$r["exa_status"];
				$this->exa_aci=$r["exa_aci"];
				$this->exa_visa=$r["exa_visa"];
				$this->exa_deadline=$r["exa_deadline"];
				$this->exa_deadlineshow=$r["exa_deadlineshow"];
				$this->exa_timestamp=$r["exa_timestamp"]; 
      }
    }


	//-----------------Get Methods---------------

	function getExa_id(){return $this->exa_id;}
	function getExa_date(){return $this->exa_date;}
	function getTye_id(){return $this->tye_id;}
	function getExa_comment(){return $this->exa_comment;}
	function getExa_status(){return $this->exa_status;}
	function getExa_aci(){return $this->exa_aci;}
	function getExa_visa(){return $this->exa_visa;}
	function getExa_deadline(){return $this->exa_deadline;}
	function getExa_deadlineshow(){return $this->exa_deadlineshow;}
	


//-----------------Set Methods---------------

	function setExa_id($value){
		$sql="UPDATE Exam SET exa_id={$value} WHERE exa_id={$this->exa_id}";
		$this-> ejecutar($sql);
	}
	function setExa_date($value){
		$sql="UPDATE Exam SET exa_date='{$value}' WHERE exa_id= {$this->exa_id}";
		$this-> ejecutar($sql);
	}
	function setTye_id($value){
		$sql="UPDATE Exam SET tye_id={$value} WHERE exa_id={$this->exa_id}";
		$this-> ejecutar($sql);
	}
	function setExa_comment($value){
		$sql="UPDATE Exam SET exa_comment='{$value}' WHERE exa_id={$this->exa_id}";
		$this-> ejecutar($sql);
	}
	function setExa_status($value){
		$sql="UPDATE Exam SET exa_status={$value} WHERE exa_id={$this->exa_id}";
		$this-> ejecutar($sql);
	}
	function setExa_aci($value){
	    $sql="UPDATE Exam SET exa_aci={$value} WHERE exa_id={$this->exa_id}";
	    $this-> ejecutar($sql);
	}
	function setExa_visa($value){
	    $sql="UPDATE Exam SET exa_visa={$value} WHERE exa_id={$this->exa_id}";
	    $this-> ejecutar($sql);
	}
	function setExa_deadline($value){
	    $sql="UPDATE Exam SET exa_deadline='{$value}' WHERE exa_id={$this->exa_id}";
	    $this-> ejecutar($sql);
	}
	function setExa_deadlineshow($value){
	    $sql="UPDATE Exam SET exa_deadlineshow='{$value}' WHERE exa_id={$this->exa_id}";
	    $this-> ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($exa_date,$tye_id,$exa_comment,$exa_status,$exa_aci,$exa_visa, $exa_deadline,$exa_deadlineshow){
		$sql="INSERT INTO Exam (exa_date,tye_id,exa_comment,exa_status, exa_aci,exa_visa, exa_deadline, exa_deadlineshow) 
		      VALUES ('{$exa_date}', '{$tye_id}','{$exa_comment}', '{$exa_status}', '{$exa_aci}', '{$exa_visa}', '{$exa_deadline}', '{$exa_deadlineshow}')";
		return ($this->ejecutar($sql));
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM Exam WHERE exa_id={$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM Exam";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}

//-----------------GetAll---------------
function checkExam($exa_date, $tye_id){
    $sql = "SELECT * FROM Exam WHERE exa_date='{$exa_date}' AND tye_id= {$tye_id}";
    $resultado=$this->ejecutar($sql);
    $r=$this->retornar_fila($resultado);
    if($r[exa_id]!=NULL)
        $exist=true;
    else
        $exist=false;
    
    return ($exist);
}
}
?>

