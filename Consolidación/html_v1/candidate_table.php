<?php include ("includes/title.php");?>
<?php include ("includes/security_session.php");?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<!--  BEGIN INCLUDE CLASSES -->
<?php include_once("../classes/class.candidate.php");?>
<?php include_once("../classes/class.utiles.php");?>
<?php include_once("../classes/class.bd.php");?>
<?php include_once("../classes/class.exam.php");?>
<?php include_once("includes/variables.php");?>
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<?php 
$_SESSION["exa_id"]=$_GET["exa_id"]; //It is used in the form (to not use get)
$get_exa_id=$_GET["exa_id"];
$session_prc_id= $_SESSION["prc_id"];
$exa_status=getExaState($get_exa_id);
$display_new_candidate=($exa_status==2 ?"none" : "inline");


?>
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
function getExaTitle($exa_id){
    $class_utiles=new utiles();
    $r=getExaInfo($exa_id);
	$string.="<i style='font-size:20px;' class='icon-book-open'> ".$r["tye_name"]." ".$class_utiles->fecha_mysql_php($r["exa_date"])."</i>";
	$string.= " <i style='font-size:20px;' class='icon-clock'>  DEADLINE: ". $class_utiles->fecha_mysql_php($r["exa_deadlineshow"])."</i>";
	echo $string;	
}

function getExaState($exa_id){
    $class_exam=new Exam($exa_id);
    return($class_exam->getExa_status());
}
function getExaInfo($exa_id){
    $class_utiles=new utiles();
    $class_bd=new bd();
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_id={$exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);   
    return ($r);
}
function write_candidate($session_prc_id, $get_exa_id, $exa_status){
    $class_bd=new bd();
    $class_utiles= new utiles();
    $sql="SELECT * FROM Candidate INNER JOIN ExamPlace on Candidate.exp_id=ExamPlace.exp_id WHERE prc_id={$session_prc_id} and exa_id={$get_exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    while ($r=$class_bd->retornar_fila($resultado))
    {
        if ($r["can_status"]==STATUS_NOT_SENT)
            $color=COLOR_NOT_SENT;
        if ($r["can_status"]==STATUS_SENT)
            $color=COLOR_SENT;
        if ($r["can_status"]==STATUS_CONFIRMED)
            $color=COLOR_CONFIRMED;
        if ($r["can_status"]==STATUS_ERROR)
            $color=COLOR_ERROR;
        
        if ($r["can_gender"]==0)
            $can_gender="Female";
        else
            $can_gender="Male";

        if ($r["can_visa"]==0)
            $can_visa="No";
        else
            $can_visa="Yes";

        if ($r["can_disability"]==0)
            $can_disability="No";
        else
            $can_disability="Yes";
                 
        $table="<tr onclick=redirect({$r["can_id"]},{$exa_status},{$r["can_status"]}); style='cursor:pointer; style='text'>";
        $table.="<td style='color:{$color};'>{$r["can_firstname"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_lastname"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_dni"]}</td>";
        $table.="<td style='color:{$color};'>{$can_gender}</td>";
        $table.="<td style='color:{$color};'>".$class_utiles->fecha_mysql_php($r["can_datebirth"])."</td>";
        $table.="<td style='color:{$color};'>{$r["can_email"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_adress"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_telephone"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_cellphone"]}</td>";
        $table.="<td style='color:{$color};'>{$can_visa}</td>";
        $table.="<td style='color:{$color};'>{$can_disability}</td>";
        $table.="<td style='color:{$color};'>{$color}{$r["exp_name"]}</td>";
        $table.="<td style='color:{$color};'>{$r["can_comment"]}</td>";
        $table.="</tr>";

        echo $table;
    }
}
?>
<head>

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

<!-- BEGIN THEME STYLES -->
<?php include ("includes/themestyle.html")?>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->

<body>
	<!-- BEGIN HEADER -->
	<div class="page-header">
		<!-- BEGIN HEADER TOP -->
	    <?php include("includes/headertop.php");?>
	<!-- END HEADER TOP -->
		<!-- BEGIN HEADER MENU -->
	   <?php include("includes/headermenu.php");?>
	<!-- END HEADER MENU -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN PAGE CONTAINER -->
	<div class="page-container">
		<!-- BEGIN PAGE HEAD -->
		<div class="page-head">
			<div class="container">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>
                        <?php getExaTitle($get_exa_id);?>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- BEGIN PAGE TOOLBAR -->
				<div class="page-toolbar">
					<!-- BEGIN THEME PANEL -->
					<div class="btn-group btn-theme-panel">
						
					</div>
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
				<div class="modal fade" id="portlet-config" tabindex="-1"
					role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"
									aria-hidden="true"></button>
								<h4 class="modal-title">Modal title</h4>
							</div>
							<div class="modal-body">Widget settings form goes here</div>
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
        			<ul class="page-breadcrumb breadcrumb">
        				<li>
        					<a href="exam_menu.php">Return</a><i class="fa fa-circle" style="display: <?php echo $display_new_candidate?>"></i>
        				</li>
        				<li>
        					<a href="javascript:redirect_check(<?php echo $get_exa_id;?>);">Candidate Workflow</a><i class="fa fa-circle" style="display: <?php echo $display_new_candidate?>"></i>
        				</li>
        				<li>
        					<a href="candidate_form.php" style="display: <?php echo $display_new_candidate;?>">New Candidate</a>
        				</li>

        				
        			</ul>
			<!-- END PAGE BREADCRUMB -->
				<!-- BEGIN PAGE CONTENT INNER -->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs font-green-sharp"></i> <span
										class="caption-subject font-green-sharp bold uppercase">Table
										with Exams</span>
								</div>
								<div class="tools"></div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover"
									id="sample_1">
									<thead>
										<tr>
											<th>First Name</th>
											<th>Last Name</th>
											<th>DNI</th>
											<th>Gender</th>
											<th>Date of Birth</th>
											<th>Email</th>
											<th>Address</th>
											<th>Telephone</th>
											<th>Cellphone</th>
											<th>Visa R.</th>
											<th>Sp Arr</th>
											<th>Exam Place</th>
											<th>Comment</th>
										</tr>
									</thead>
									<tbody>
            							<?php 
            							    write_candidate($session_prc_id, $get_exa_id, $exa_status);	
            							?>
        							</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
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
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout    
   Demo.init(); // init demo features
   TableAdvanced.init();
});

//--START JAVASCRIPT FUNCTIONS--
function redirect(can_id, exa_status, can_status){
	if (exa_status==2){ 	// if is it closed (NM)
	    alert ("this exam is closed and you can not modify the information");
		}
	else{
		if (can_status==1){
			alert ("The candidate has been sent to be confirmed. You can not modify it");
		}else if(can_status==2){
			alert ("The candidate has been confirmed. You can not modify it");
		}else{
			pagina = "candidate_form.php?can_id="+ can_id;
			setTimeout(redireccionar, 100, pagina);
			}
		}	
}
function redirect_check(exa_id){
	pagina = "candidate_table_check.php?exa_id="+ exa_id;
	setTimeout(redireccionar, 100, pagina);     
}
function redireccionar(pagina) {
	{
	location.href=pagina;
	}             
}
//--END JAVASCRIPT FUNCTIONS--
</script>

</body>
<!-- END BODY -->
</html>