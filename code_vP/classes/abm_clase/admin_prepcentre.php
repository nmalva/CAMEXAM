<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title>Demo abm</title>
	
	<!-- Estilos -->
	<link href="../classes/abm_clase/css/sitio.css" rel="stylesheet" type="text/css">
	<link href="../classes/abm_clase/css/abm.css" rel="stylesheet" type="text/css">

	<!-- MooTools -->
	<script type="text/javascript" src="../classes/abm_clase/js/mootools-1.2.3-core.js"></script>
	<script type="text/javascript" src="../classes/abm_clase/js/mootools-1.2.3.1-more.js"></script>
	
	<!--FormCheck-->
	<script type="text/javascript" src="../classes/abm_clase/js/formcheck/lang/es.js"></script>
	<script type="text/javascript" src="../classes/abm_clase/js/formcheck/formcheck.js"></script>
	<link rel="stylesheet" href="../classes/abm_clase/js/formcheck/theme/classic/formcheck.css" type="text/css" media="screen"/>

	<!--Datepicker-->
	<link rel="stylesheet" href="../classes/abm_clase/js/datepicker/datepicker_vista/datepicker_vista.css" type="text/css" media="screen"/>
	<script type="text/javascript" src="../classes/abm_clase/js/datepicker/datepicker.js"></script>

</head>
<body>

<?

require("../classes/abm_clase/comun/class_db.php");
require("../classes/abm_clase/comun/class_abm.php");
require("../classes/abm_clase/comun/class_paginado.php");
require("../classes/abm_clase/comun/class_orderby.php");


//conexión a la bd
$db = new class_db();
$db->mostrarErrores = true;
$db->connect();



$abm = new class_abm(); 
$abm->tabla = 'PrepCentre'; 
$abm->campoId = 'prc_id'; 
$abm->mostrarBorrar = false; 
$abm->registros_por_pagina = 50;  
$abm->textoTituloFormularioEdicion = "Editar"; 
$abm->campos = array( 
	array('campo' => 'prc_name', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Name'
	), 
	array('campo' => 'prc_shortname', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Short Name'
	), 
	array('campo' => 'prc_firstname', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'First Name'
	), 
	array('campo' => 'prc_lastname', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Last Name'
	), 
	array('campo' => 'prc_adress1', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 100,
		'titulo' => 'Adress 1'
	), 
	array('campo' => 'prc_adress2', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 100,
		'titulo' => 'Adress 2'
	), 
	array('campo' => 'prc_city', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'City'
	), 
	array('campo' => 'prc_areacode', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 5,
		'titulo' => 'Area Code'
	), 
	array('campo' => 'prc_telephone', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 10,
		'titulo' => 'Telephone'
	), 
	array('campo' => 'prc_email', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Email'
	), 
	array('campo' => 'prc_typefunding', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Type Funding'
	), 
	array('campo' => 'prc_preparationtype', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Preparation Type'
	), 
	array('campo' => 'prc_uniqueid', 
		'tipo' => 'texto',
		'requerido' => true,
		'maxLen' => 50,
		'titulo' => 'Unique ID'
	)
); 
$abm->generarAbm('', 'Administrar PrepCentre'); 


/*
echo "<br><br>";

if ( $_GET['vercodigo'] ){
	highlight_file(__FILE__);
}else{
	echo "<a href='?vercodigo=1'>Ver c�digo fuente</a>";
}
*/
?>

</body>
</html>