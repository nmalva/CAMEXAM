<?php
require_once("class.bd.php");

class User extends bd
{

function __construct($id = 0)          //recibe como parametro el id, sino lo pone en 0, a hace referencia a la cantidad de campos mostrables del POST del formulario
    {
      parent::__construct();

      //$this->numero_User=$numero_User;
      
      if($id > 0)
      {
        $sql = "SELECT * FROM User WHERE cit_id = {$id}";
        $resultado=$this->ejecutar($sql);
        $r = $this->retornar_fila($resultado);
        
				$this->use_id=$id;
				$this->use_name=$r["use_name"];
				$this->use_lastname=$r["use_lastname"];
				$this->use_email=$r["use_email"];
				$this->use_telephone=$r["use_telephone"];
				$this->use_user=$r["use_user"];
				$this->use_password=$r["use_password"];
				$this->use_usertype=$r["use_usertype"];
				$this->prc_id=$r["prc_id"];
				$this->use_timestamp=$r["use_timestamp"];
        
      }
    }


	//-----------------Get Methods---------------

	function getUse_id(){return $this->use_id;}
	function getUse_name(){return $this->use_name;}
	function getUse_lastname(){return $this->use_lastname;}
	function getUse_email(){return $this->use_email;}
	function getUse_telephone(){return $this->use_telephone;}
	function getUse_user(){return $this->use_user;}
	function getUse_password(){return $this->use_password;}
	function getUse_usertype(){return $this->use_usertype;}
	function getPrc_id(){return $this->prc_id;}
	function getUse_timestamp(){return $this->use_timestamp;}


//-----------------Set Methods---------------

	function setUse_name($value){
		$sql="UPDATE tabla SET use_name={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_lastname($value){
		$sql="UPDATE tabla SET use_lastname={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_email($value){
		$sql="UPDATE tabla SET use_email={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_telephone($value){
		$sql="UPDATE tabla SET use_telephone={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_user($value){
		$sql="UPDATE tabla SET use_user={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_password($value){
		$sql="UPDATE tabla SET use_password={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setUse_usertype($value){
		$sql="UPDATE tabla SET use_usertype={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}
	function setPrc_id($value){
		$sql="UPDATE tabla SET prc_id={$value} WHERE use_id={$this->use_id}";
		$this-> ejecutar($sql);
	}

//-----------------Insert---------------

	function insert($use_name,$use_lastname,$use_email,$use_telephone,$use_user,$use_password,$use_usertype,$prc_id){
		$sql="INSERT INTO User (use_name,use_lastname,use_email,use_telephone,use_user,use_password,use_usertype,prc_id) 
		
		VALUES ('{$use_name}','{$use_lastname}','{$use_email}','{$use_telephone}','{$use_user}','{$use_password}', '{$use_usertype}', '{$prc_id}')";
		
	
		$this->ejecutar($sql);
	}

//-----------------Delete---------------

	function delete($id){
		$sql="DELETE FROM User WHERE use_id = {$id}";
		$this->ejecutar($sql);
	}

//-----------------GetAll---------------
function getAll(){
		$sql = "SELECT * FROM User";
        $resultado=$this->ejecutar($sql);
		return $resultado;
}
}
?>

