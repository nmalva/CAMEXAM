<?php include ("includes/title.php");?>
<?php include ("includes/security_admin.php");?>
<?php include ("includes/security_session.php");?>
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
$session_use_usetype = $_SESSION["use_usertype"];
?>
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
function getStringExams($year, $session_use_usetype){ //get the string to print exams
    $exams=getTypeExams($year);
    $size=sizeof($exams);
    $class_utiles = new utiles();
    for ($i=0;$i<$size;$i++){
        $stringPrint.="<ul><li data-jstree='{ \"icon\" : \"fa fa-folder icon-state-success\"}'>";
        $stringPrint.=$exams[$i];
        $stringPrint.=getDates($exams[$i], $session_use_usetype, $year);
        $stringPrint.="</li></ul>";
    }
    
    return ($stringPrint);
}
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
            $stringPrint.="<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-danger\" }' onclick='writeInfo({$r["exa_id"]})' ondblclick='redirect({$r["exa_id"]},{$session_use_usetype});'>";

        $stringPrint.=$class_utiles->fecha_mysql_php_format($r["exa_date"]);
        $stringPrint.="</li></ul>";
    }  	
    return ($stringPrint);
}
?>
<!--  END PHP FUNCTIONS -->
<!--  PAGE TITLE  -->
<?php include ("includes/pagetitle.php");?>
<!--  END PAGE TITLE  -->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php include("includes/globalstyle.html");?>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<?php include ("includes/themestyle.html")?>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
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
				<h1>Report Menu <small>Select the exam to add or update a candidate</small></h1>
			</div>
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
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="exam_menu.php">Home</a> <i style="display: <?php if ($session_use_usertype>1)echo "none";?>;" class="fa fa-circle"></i>
					<a href="candidate_table_admin_general.php?year=2018" style="display: <?php if ($session_use_usertype>1)echo "none";?>;">General Table</a>
				</li>		
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">	
				<div class="col-md-6" style="min-height: 400px;"> <!--  added to mantain the bottom in line -->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Report Tree</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div id="tree_1" class="tree-demo">		 
	
							 <ul><li data-jstree='{ \"icon\" : \"fa fa-folder icon-state-success\"}'>
							 	General
								<ul><li data-jstree='{ \"icon\" : \"fa fa-file icon-state-success\" }' ondblclick='redireccionar("dashboard_interanual.php?");'> Interanual </a> </li></ul>
							 </li></ul>                        
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
				<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Exam Information</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
	
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body" id="info">  
						
							<ul class="list-group">
								<li class="list-group-item">
									Select a Report
								</li>
							</ul>
						</div>
					</div>
					</div>
			</div>
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
<!-- END PAGE LEVEL SCRIPTS -->
<script src="../../assets/admin/pages/scripts/ui-tree.js"></script>
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>

<script>
jQuery(document).ready(function() {       
  // initiate layout and plugins
  Metronic.init(); // init metronic core components
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
function redirect(report){
    if (report=="interanual"){
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