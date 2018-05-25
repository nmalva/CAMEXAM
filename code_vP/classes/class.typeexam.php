<?php

require_once("class.bd.php");

class TypeExam extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_City=$numero_City;
      
      if($id > 0)
      {
        $sql = "SELECT * FROM TypeExam WHERE cit_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
				$this->tye_id=$id;
				$this->tye_name=$r["tye_name"];
				$this->tye_aci=$r["tye_aci"];
				$this->tye_timestamp=$r["tye_timestamp"];

        
      }
    }


	//-----------------Get Methods---------------

	function getTye_id(){return $this->tye_id;}
	function getTye_name(){return $this->tye_name;}
	function getTye_aci(){return $this->tye_aci;}
	function getTye_timestamp(){return $this->tye_timestamp;}


//-----------------Set Methods---------------

	function setTye_id($value){
		$sql="UPDATE tabla SET tye_id={$value} WHERE tye_id={$this->tye_id}";
		$this-> ejecutar($sql);
	}
	function setTye_name($value){
		$sql="UPDATE tabla SET tye_name={$value} WHERE tye_id={$this->tye_id}";
		$this-> ejecutar($sql);
	}
	function setTye_aci($value){
		$sql="UPDATE tabla SET tye_aci={$value} WHERE tye_id={$this->tye_id}";
		$this-> ejecutar($sql);
	}
	
//-----------------Insert---------------

	function insert($tye_name,$tye_aci){
		$sql="INSERT INTO TypeExam (tye_name,tye_aci) VALUES ('{$tye_name}', '{$tye_aci}')";
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM TypeExam WHERE tye_id={$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM TypeExam";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}

//-----------------GetOption---------------

function getOption($tye_id){
    $sql = "SELECT * FROM TypeExam";
    $resultado=$this->ejecutar($sql);

    while ($r=$this->retornar_fila($resultado))
    {
        if ($r["tye_id"]==$tye_id)
            echo "<option  selected='selected' value='{$r["tye_id"]}'> {$r["tye_name"]}  </option>";
        else
            echo "<option value='{$r["tye_id"]}'>{$r["tye_name"]}  </option>";

					}
    }
}
?>

