<?php include ("includes/title.php");?>
<?php include ("includes/security_session.php");?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<!--  BEGIN INCLUDE CLASSES -->
<?php include_once("../classes/class.exam.php");?>
<?php include_once("../classes/class.utiles.php");?>
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
function write_exam(){
     $class_bd=new bd();
     $class_utiles= new utiles();
     $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id";                                 
     $resultado=$class_bd->ejecutar($sql);
     while ($r=$class_bd->retornar_fila($resultado))
     {
         if ($r["exa_status"]==0)
              $exa_status="No Visible";
         if ($r["exa_status"]==1)
             $exa_status="Open";
         if ($r["exa_status"]==2)
             $exa_status="Close";
                 
         $table="<tr onclick=redirect({$r["exa_id"]}); style='cursor:pointer'>";
         $table.="<td>{$r["exa_id"]}</td>";
         $table.="<td>".$class_utiles->fecha_mysql_php($r["exa_date"])."</td>"; 
         $table.="<td>{$r["tye_name"]}</td>";
         $table.="<td>".$class_utiles->fecha_mysql_php($r["exa_deadline"])."</td>";
         $table.="<td>".$class_utiles->fecha_mysql_php($r["exa_deadlineshow"])."</td>";
         $table.="<td>{$exa_status}</td>";
         $table.="<td>{$r["exa_comment"]}</td>";
         $table.="</tr>";
         echo $table;

      }   
 }
?>

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
						Exams Administrator <small>Add and Update Exams</small>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- BEGIN PAGE TOOLBAR -->
				<div class="page-toolbar">
					<!-- BEGIN THEME PANEL -->
					<div class="btn-group btn-theme-panel">
						<a href="javascript:;" class="btn dropdown-toggle"
							data-toggle="dropdown"> <i class="icon-settings"></i>
						</a>
						<div
							class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h3>THEME COLORS</h3>
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<ul class="theme-colors">
												<li class="theme-color theme-color-default"
													data-theme="default"><span class="theme-color-view"></span>
													<span class="theme-color-name">Default</span></li>
												<li class="theme-color theme-color-blue-hoki"
													data-theme="blue-hoki"><span class="theme-color-view"></span>
													<span class="theme-color-name">Blue Hoki</span></li>
												<li class="theme-color theme-color-blue-steel"
													data-theme="blue-steel"><span class="theme-color-view"></span>
													<span class="theme-color-name">Blue Steel</span></li>
												<li class="theme-color theme-color-yellow-orange"
													data-theme="yellow-orange"><span class="theme-color-view"></span>
													<span class="theme-color-name">Orange</span></li>
												<li class="theme-color theme-color-yellow-crusta"
													data-theme="yellow-crusta"><span class="theme-color-view"></span>
													<span class="theme-color-name">Yellow Crusta</span></li>
											</ul>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<ul class="theme-colors">
												<li class="theme-color theme-color-green-haze"
													data-theme="green-haze"><span class="theme-color-view"></span>
													<span class="theme-color-name">Green Haze</span></li>
												<li class="theme-color theme-color-red-sunglo"
													data-theme="red-sunglo"><span class="theme-color-view"></span>
													<span class="theme-color-name">Red Sunglo</span></li>
												<li class="theme-color theme-color-red-intense"
													data-theme="red-intense"><span class="theme-color-view"></span>
													<span class="theme-color-name">Red Intense</span></li>
												<li class="theme-color theme-color-purple-plum"
													data-theme="purple-plum"><span class="theme-color-view"></span>
													<span class="theme-color-name">Purple Plum</span></li>
												<li class="theme-color theme-color-purple-studio"
													data-theme="purple-studio"><span class="theme-color-view"></span>
													<span class="theme-color-name">Purple Studio</span></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 seperator">
									<h3>LAYOUT</h3>
									<ul class="theme-settings">
										<li>Theme Style <select
											class="theme-setting theme-setting-style form-control input-sm input-small input-inline tooltips"
											data-original-title="Change theme style"
											data-container="body" data-placement="left">
												<option value="boxed" selected="selected">Square corners</option>
												<option value="rounded">Rounded corners</option>
										</select>
										</li>
										<li>Layout <select
											class="theme-setting theme-setting-layout form-control input-sm input-small input-inline tooltips"
											data-original-title="Change layout type"
											data-container="body" data-placement="left">
												<option value="boxed" selected="selected">Boxed</option>
												<option value="fluid">Fluid</option>
										</select>
										</li>
										<li>Top Menu Style <select
											class="theme-setting theme-setting-top-menu-style form-control input-sm input-small input-inline tooltips"
											data-original-title="Change top menu dropdowns style"
											data-container="body" data-placement="left">
												<option value="dark" selected="selected">Dark</option>
												<option value="light">Light</option>
										</select>
										</li>
										<li>Top Menu Mode <select
											class="theme-setting theme-setting-top-menu-mode form-control input-sm input-small input-inline tooltips"
											data-original-title="Enable fixed(sticky) top menu"
											data-container="body" data-placement="left">
												<option value="fixed">Fixed</option>
												<option value="not-fixed" selected="selected">Not Fixed</option>
										</select>
										</li>
										<li>Mega Menu Style <select
											class="theme-setting theme-setting-mega-menu-style form-control input-sm input-small input-inline tooltips"
											data-original-title="Change mega menu dropdowns style"
											data-container="body" data-placement="left">
												<option value="dark" selected="selected">Dark</option>
												<option value="light">Light</option>
										</select>
										</li>
										<li>Mega Menu Mode <select
											class="theme-setting theme-setting-mega-menu-mode form-control input-sm input-small input-inline tooltips"
											data-original-title="Enable fixed(sticky) mega menu"
											data-container="body" data-placement="left">
												<option value="fixed" selected="selected">Fixed</option>
												<option value="not-fixed">Not Fixed</option>
										</select>
										</li>
									</ul>
								</div>
							</div>
						</div>
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
        					<a href="exam_menu.php">Return</a><i class="fa fa-circle"></i>
        				</li>
        				<li>
        					<a href="exam_form.php">Add Exam</a>
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
											<th>Exam #</th>
											<th>Date</th>
											<th>Exam Type</th>
											<th>Deadline (Real)</th>
											<th>Deadline (To Show)</th>
											<th>Status</th>
											<th>Comment</th>
										</tr>
									</thead>
									<tbody>
							<?php 
							    write_exam();	
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
function redirect(exa_id){

	pagina = "exam_form.php?exa_id="+ exa_id;
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