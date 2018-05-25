
<?php include ("includes/title.php");?>
<?php //include ("includes/security_session.php");?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEADDD -->
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<!--  BEGIN INCLUDE CLASSES -->
<?php 
include_once("../classes/class.bd.php");
include_once("../classes/class.utiles.php");
?>
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<?php 
$session_can_id = $_SESSION["can_id"];
$r = get_candidate($session_can_id);
$class_utiles = new utiles();
?>
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 

function getTypeExams($year){
    $class_bd=new bd();
    $year_ini=$year-1;
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_status > 0
                                 AND exa_date > '{$year_ini}-12-31'
                                 AND exa_date < '{$year}-12-31' ORDER BY tye_name ASC";
    $resultado = $class_bd->ejecutar($sql);
    $i=0;
    While ($r=$class_bd->retornar_fila($resultado)){
        $exams[$i]=$r["tye_name"];
        $i++;
    }
    return (@array_keys(array_count_values($exams)));
}
function getDates($exams, $session_use_usetype, $year){
    $class_utiles=new utiles();
    $class_bd=new bd();
    $year_ini=$year-1;
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE tye_name = '{$exams}' AND exa_status>0
             AND exa_date > '{$year_ini}-12-31'
             AND exa_date < '{$year}-12-31' ORDER BY exa_date ASC";
    $resultado = $class_bd->ejecutar($sql);
    While ($r=$class_bd->retornar_fila($resultado)){
        if ($r["exa_status"]=='1') // if the exam is opened (NM)
            $stringPrint.="<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-success\" }' onclick='writeInfo({$r["exa_id"]})' ondblclick='redirect({$r["exa_id"]},{$session_use_usetype});'>";
        else                       // if the exam is closed (NM)
            $stringPrint.="<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-danger\" }' ondblclick='redirect({$r["exa_id"]},{$session_use_usetype});'>";

        $stringPrint.=$class_utiles->fecha_mysql_php_format($r["exa_date"]);
        $stringPrint.="</li></ul>";
    }  	
    return ($stringPrint);
}

function get_candidate($can_id){
    $class_bd=new bd();
    $sql="SELECT * FROM Candidate
	    LEFT JOIN ExamPlaceAula on Candidate.epa_id=ExamPlaceAula.epa_id
	    LEFT JOIN ExamPlace on Candidate.exp_id=ExamPlace.exp_id
	    LEFT JOIN Exam on Candidate.exa_id=Exam.exa_id
    	WHERE can_id = '{$can_id}'
    	ORDER BY can_id ASC";
    $resultado = $class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);

    return ($r);

}

function get_newepaname($can_packingcodespeaking){
    $class_bd1 = new bd();
    $sql="SELECT * FROM ExamPlaceAula
        WHERE epa_id = {$can_packingcodespeaking}";
        $resultado = $class_bd1->ejecutar($sql);
        $r=$class_bd1->retornar_fila($resultado);

        return ($r["epa_name"]);
}

function exp_datos($epa_id){
	//Esta funcion es para traer los datos de la institucion relacionados al Paking Code cargado
	// y no al exa id cargado al alumno en una primera instancia.
	$class_bd = new bd();
	$sql="SELECT * FROM ExamPlaceAula 
		  INNER JOIN ExamPlace on ExamPlaceAula.exp_id=ExamPlace.exp_id WHERE epa_id={$epa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);   
    return ($r);
}

function type_exam($tye_id){
	$class_bd3 = new bd();
	$sql="SELECT * FROM TypeExam 
		  WHERE tye_id={$tye_id}";
    $resultado=$class_bd3->ejecutar($sql);
    $r=$class_bd3->retornar_fila($resultado);   
    return ($r["tye_name"]);

}


function time_array_order_speaking($can_id){
	$class_bd2 = new bd();
	$sql="SELECT * FROM Candidate 
		  WHERE can_id={$can_id}";
    $resultado=$class_bd2->ejecutar($sql);
    $r=$class_bd2->retornar_fila($resultado);  

    $time_array = array(

    	0 => strtotime($r["can_timelistening"]),
    	1 => strtotime($r["can_timereadingandwriting"]),
    	2 => strtotime($r["can_timereadinganduseofenglish"]),
    	3 => strtotime($r["can_timereading"]),
    	4 => strtotime($r["can_timewriting"]),
    	5 => strtotime($r["can_timespeaking"]),

    );

    asort($time_array);

	return (array_keys($time_array));
}

function time_array_order_nospeaking($can_id){
	$class_bd2 = new bd();
	$sql="SELECT * FROM Candidate 
		  WHERE can_id={$can_id}";
    $resultado=$class_bd2->ejecutar($sql);
    $r=$class_bd2->retornar_fila($resultado);  

    $time_array = array(

    	0 => strtotime($r["can_timelistening"]),
    	1 => strtotime($r["can_timereadingandwriting"]),
    	2 => strtotime($r["can_timereadinganduseofenglish"]),
    	3 => strtotime($r["can_timereading"]),
    	4 => strtotime($r["can_timewriting"]),

    );

    asort($time_array);

	return (array_keys($time_array));
}

function exam_info($r,$field_visible){
$class_utiles=new utiles();
$date_exam = $class_utiles->fecha_mysql_php($r["exa_date"]);

$exp_datos= exp_datos($r["epa_id"]);

if($r["can_datespeaking"]== NULL || $r["can_datespeaking"]=="0000-00-00" )
	$date_speaking = $date_exam;
else
	$date_speaking = $class_utiles->fecha_mysql_php($r["can_datespeaking"]);



if($r["can_packingcodespeaking"]== NULL || $r["can_packingcodespeaking"]=="0"){
	$epa_name = $r["epa_name"];
	$new_exp_adress = $exp_datos["exp_adress"];
	$new_exp_name = $exp_datos["exp_name"];
}
else{
	$epa_name = get_newepaname($r["can_packingcodespeaking"]);
	$new_expdatos_function = exp_datos ($r["can_packingcodespeaking"]);
	$new_exp_adress = $new_expdatos_function["exp_adress"];
	$new_exp_name = $new_expdatos_function["exp_name"];
}



if($r["can_datespeaking"]== NULL || $r["can_datespeaking"]=="0000-00-00" )
	$fecha = 1; // if can_datespeaking is Null, same day so order by tima.
else
	$fecha = $class_utiles->compararFechas($r["can_datespeaking"],$r["exa_date"]); //2 --> fecha 1 > fecha 2


  
  $filds_array[0]= "<tr style='display:{$field_visible["listening"]};'>
     	    <td width='200px'>Listening </td>
     		<td> {$r["can_timelistening"]} hs</td>
     		<td> {$date_exam}</td>
     		<td> {$exp_datos["exp_name"]}</td>
     		<td> {$exp_datos["exp_adress"]}</td>
     		<td> {$r["epa_name"]}</td>
  </tr>";

 $filds_array[1]= "<tr style='display:{$field_visible["readingandwriting"]};'>
     	    <td width='200px'>Reading and Writing </td>
     		<td> {$r["can_timereadingandwriting"]} hs</td>
     		<td> {$date_exam}</td>
     		<td> {$exp_datos["exp_name"]}</td>
     		<td> {$exp_datos["exp_adress"]}</td>
     		<td> {$r["epa_name"]}</td>
     	 </tr>";

 $filds_array[2]= "<tr style='display:{$field_visible["readinganduseofenglish"]};'>
     	    <td width='200px'>Reading and use of English </td>
     		<td> {$r["can_timereadinganduseofenglish"]} hs</td>
     		<td> {$date_exam}</td>
     		<td> {$exp_datos["exp_name"]}</td>
     		<td> {$exp_datos["exp_adress"]}</td>
     		<td> {$r["epa_name"]}</td>
     	 </tr>";

  $filds_array[3]= "<tr style='display:{$field_visible["reading"]};'>
     	    <td width='200px'>Reading</td>
     		<td> {$r["can_timereading"]} hs</td>
     		<td> {$date_exam}</td>
     		<td> {$exp_datos["exp_name"]}</td>
     		<td> {$exp_datos["exp_adress"]}</td>
     		<td> {$r["epa_name"]}</td>
     	 </tr>";

   $filds_array[4]= "<tr style='display:{$field_visible["writing"]};'>
     	    <td width='200px'>Writing </td>
     		<td> {$r["can_timewriting"]} hs</td>
     		<td> {$date_exam}</td>
     		<td> {$exp_datos["exp_name"]}</td>
     		<td> {$exp_datos["exp_adress"]}</td>
     		<td> {$r["epa_name"]}</td>
     	 </tr>";

   $filds_array[5] = "<tr'>
     	    <td width='200px'>Speaking</td>
     		<td> {$r["can_timespeaking"]} hs</td>
     		<td> {$date_speaking}</td>
     		<td> {$new_exp_name}</td>
     		<td> {$new_exp_adress}</td>
     		<td> {$epa_name}</td>
     	 </tr>";


if ($fecha ==1 ){ // f1=f2
	$time_array= time_array_order_speaking($r["can_id"]);
	for ($i=0;$i<=5;$i++){
		echo $filds_array[$time_array[$i]];
	}
}elseif ($fecha == 2) {  //> f1 de f2
	$time_array= time_array_order_nospeaking($r["can_id"]);
   for ($i=0;$i<=4;$i++){
		echo $filds_array[$time_array[$i]];
	}
	echo $filds_array[5];

}elseif ($fecha == 0){   //f1 < f2
	$time_array= time_array_order_nospeaking($r["can_id"]);
	echo $filds_array[5];
	for ($i=0;$i<=4;$i++){
		echo $filds_array[$time_array[$i]];
	}
}
  

    
}

function field_visible($exa_id){
    $class_utiles=new utiles();
    $class_bd=new bd();
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_id={$exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);   
    
    ($r["tye_listening"]==0) ? $fild_visible["listening"]='none':"";
    ($r["tye_speaking"]==0) ? $fild_visible["speaking"]='none':"";
    ($r["tye_writing"]==0) ? $fild_visible["writing"]='none':"";
    ($r["tye_reading"]==0) ? $fild_visible["reading"]='none':"";
    ($r["tye_readingandwriting"]==0) ? $fild_visible["readingandwriting"]='none':"";
    ($r["tye_readinganduseofenglish"]==0) ? $fild_visible["readinganduseofenglish"]='none':"";

    return $fild_visible;    
}
    
function place_info($r){
    echo "<b>El lugar en donde se rinde se llama:</b> {$r['exp_name']} <br/>";
    echo "<b>La dirección es: </b> {$r['exp_adress']} <br/>";
    echo "<b> Tu aula es: </b> {$r['epa_name']}";
    
}


 function get_examStatus($get_exa_id){
    $class_bd=new bd();
    $sql="SELECT * FROM Exam WHERE exa_id = {$get_exa_id}"; 
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);  

    return($r["exa_status"]);	
}
    
?>
<!--  END PHP FUNCTIONS -->
<!--  PAGE TITLE  -->
<?php include ("includes/pagetitle.php");?>
<!--  END PAGE TITLE  -->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php include("includes/globalstyle.html");?>
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES USED BY TABLE-->
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<link href="../../assets/admin/pages/css/invoice.css" rel="stylesheet" type="text/css"/>


<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<?php include ("includes/themestyle.html")?>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body>
<!-- BEGIN HEADER -->
<div class="page-header">
	<!-- BEGIN HEADER TOP -->


<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<!-- <a href=""><img src="../../assets/admin/layout3/img/logo-academia-5.jpg" alt="logo" ></a>-->
			</div>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="menu-toggler"></a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" >
						<i class="icon-bell"></i>
						<span class="badge badge-default"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You Have <strong> pending</strong> alarms</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>       
                                 <ul class='dropdown-menu-list scroller' style='height: 265px; data-handle-color='#637283'>  
							        
							     </ul>
                            </li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-tasks" id="header_task_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="icon-calendar"></i>
						<span class="badge badge-default">0</span>
						</a>
						<ul class="dropdown-menu extended tasks">
							<li class="external">
								<h3>You have <strong>0 pending</strong> tasks</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
									<!-- 
									<li>
										<a href="javascript:;">
										<span class="task">
										<span class="desc">New release v1.2 </span>
										<span class="percent">30%</span>
										</span>
										<span class="progress">
										<span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">40% Complete</span></span>
										</span>
										</a>
									</li>
									-->
								</ul>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->
					<li class="droddown dropdown-separator">
						<span class="separator"></span>
					</li>
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown dropdown-extended dropdown-dark dropdown-inbox" id="header_inbox_bar">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="circle">0</span>
						<span class="corner"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You have <strong> 0 </strong> Messages</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>
								<ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
									<!--
									<li>
										<a href="inbox.html?a=view">
										<span class="photo">
										<img src="../../assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
										</span>
										<span class="subject">
										<span class="from">
										Lisa Wong </span>
										<span class="time">Just Now </span>
										</span>
										<span class="message">
										Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
										</a>
									</li>
									-->
								</ul>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="../../assets/admin/layout3/img/avatar.png">
						<span class="username username-hide-mobile"><?php echo $_SESSION["can_firstname"]?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="login_form_info.php">
								<i class="icon-key"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
	</div>



	<!-- END HEADER TOP -->
	<!-- BEGIN HEADER MENU -->
	 

<div class="page-header-menu">
		<div class="container">
			<!-- BEGIN HEADER SEARCH BOX -->
			<form class="search-form" action="" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN MEGA MENU -->
			<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
			<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
			<div class="hor-menu ">
				<ul class="nav navbar-nav">
					
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>
	 
	 
	 
	 
	 
	<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<!-- END PAGE TITLE -->
			<!-- BEGIN PAGE TOOLBAR -->
			<div class="page-toolbar">
				<!-- BEGIN THEME PANEL -->
	
	           <!-- END THEME PANEL -->
			</div>
			<!-- END PAGE TOOLBAR -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->

			<!-- END PAGE BREADCRUMB -->






				<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<!--<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="extra_invoice.html">Pages</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Invoice
				</li>
			</ul>-->
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->



<?php
	$exam_status=get_examStatus($r["exa_id"]);
	if($exam_status!=3){
		echo"Este Examen no cuenta aún con los horarios cargados o el mismo no se encuentra disponible";
		echo "<!--";

	}
?>

			<div class="portlet light">
				<div class="portlet-body">
					<div class="invoice">
						<div class="row invoice-logo">
							<div class="col-xs-3 invoice-logo-space">

								<img src="../../assets/admin/layout3/img/logo-academia-5.jpg" class="img-responsive" alt=""/>
								 <br/>
							
							</div>
							<div class="col-xs-9">
								<p>

									 <?echo $r["can_firstname"]. " " . $r["can_lastname"];?> 
									 <span class="muted"><?echo "<strong>DNI: </strong>".$r["can_dni"]." - <strong>Fecha de Nacimiento: </strong>".$class_utiles->fecha_mysql_php($r["can_datebirth"]);?> </span>
									 <span class="muted"><?echo "<strong>Número de Candidato: </strong>".$r["can_candidatenum"]. " - <strong>Examen: </strong>".type_exam($r["tye_id"]);?> </span>
									
								</p>
							</div>
						</div>
						<hr/>
						<h3>Horario de Examen:</h3>
						<div class="row">
							<div class="col-xs-12">
								<table class="table table-striped table-bordered table-hover"
									id="sample_examinfo">
								<thead>
								<tr>
									<th>
										 Examen
									</th>
									<th>
										 Horario
									</th>
									<th >
										 Fecha
									</th>
									<th >
										 Lugar
									</th>
									<th >
										 Dirección
									</th>
									<th >
										 Aula
									</th>
								</tr>
								</thead>
								<tbody>		
									<?php 
										$field_visible = field_visible($r["exa_id"]);
										echo exam_info($r,$field_visible);
									?>	
								</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<ul class="well">
										 Haciendo click en <a href="documents/notice_adolescentes_adultos.pdf">"Notice to candidates Exámenes para adolescentes y adultos"</a> podrá visualizar el documento. Haciendo click en <a href="documents/flyer.pdf">"Starters -  Movers - Flyers en castellano"</a> podrá visualizar el documento. Por favor leer en detalle y ante cualquier consulta, comuníquense con nosotros con antelación.
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<ul class="well">
									<strong>Consideraciones</strong><br/>
										Los alumnos deben presentarse 30 minutos antes del examen con su DNI o pasaporte (ORIGINAL Y VÁLIDO), lápiz, goma,lapicera y este horario ** Los teléfonos celulares, relojes y dispositivos electrónicos están ABSOLUTAMENTE PROHIBIDOS EN TODO MOMENTO Y LUGAR, incluso en salas de espera y recreos. No nos responsabilizamos por estos dispositivos.
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<img src="../../assets/admin/layout3/img/logo-academia-7.jpg" alt="logo" >
							</div>
							<div class="col-xs-6">
								<div class="well">
									<address>
									<strong>Contacto</strong><br/>
										Eugenia Obrist: 03543 443030/0351 153450614 / admin.cambridge@aa.edu.ar
									</address>
								</div>
							</div>
							<div class="col-xs-6" align="right">
								<a class="btn btn-lg blue hidden-print margin-bottom-8" onclick="javascript:window.print();">
								Imprimir <i class="fa fa-print"></i>
								</a>
							</div>
						</div>

							<div class="col-xs-8 invoice-block">
								<!--<ul class="list-unstyled amounts">
									<li>
										<strong>Sub - Total amount:</strong> $9265
									</li>
									<li>
										<strong>Discount:</strong> 12.9%
									</li>
									<li>
										<strong>VAT:</strong> -----
									</li>
									<li>
										<strong>Grand Total:</strong> $12489
									</li>
								</ul>-->
								
								
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->


			
			<!-- BEGIN POPOVERS PORTLET-->			
					<!-- END POPOVERS PORTLET-->
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN PRE-FOOTER -->
<?php include("includes/prefooter.html")?>
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<?php include("includes/footer.html");?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php include("includes/coreplugins.html");?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/plugins/jstree/dist/jstree.min.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript"
	src="../../assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/scripts/metronic.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js"
	type="text/javascript"></script>
<script src="../../assets/admin/pages/scripts/table-advanced.js"></script>


<script>
jQuery(document).ready(function() {       
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
  TableAdvanced.init();
  Layout.init(); // init current layout
  Demo.init(); // init demo features
  UITree.init();

});

//--START JAVASCRIPT FUNCTIONS--
function writeInfo(exa_id){
        $.ajax({
        url:"ajax/ajax.placeforsit.php",
        type: "POST",
        data:{exa_id:exa_id}, 
        success: function(opciones){ 
          $("#info").html(opciones);				
          }
       });
    }
function redirect(exa_id, use_usertype){
    if (use_usertype==1 | use_usertype==0){
    	pagina = "candidate_table_admin.php?exa_id="+ exa_id;
    	setTimeout(redireccionar, 100, pagina);
        }
	
    if (use_usertype==2){
    	pagina = "candidate_table.php?exa_id="+ exa_id;
    	setTimeout(redireccionar, 100, pagina);
        }
}    

function redireccionar(pagina) {
    	{
    	location.href=pagina;
    	}          
}          
//--END JAVASCRIPT FUNCTIONS--
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>