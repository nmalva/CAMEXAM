<?php include("includes/title.php");?>
<?php include ("includes/security_admin.php");?>
<?php include ("includes/security_session.php");?>
<?php include ("includes/security_exam_form_id.php");?>

<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<!--  BEGIN INCLUDE CLASSES -->
<?php 
include_once("../classes/class.bd.php");
include_once("../classes/class.candidate.php");
include_once("../classes/class.utiles.php");
?>
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<?php 
$session_exa_id=$_SESSION["exa_id"];
$session_prc_id=$_SESSION["prc_id"];
$get_can_id=$_GET["can_id"];
$submit="Save";
?>
<!-- END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
//visiblePlacesform();


function getRowsPerYear($year){
    $class_bd=new bd();
    $year_ini=$year-1;
    $sql="SELECT * FROM Candidate INNER JOIN Exam on Exam.exa_id=Candidate.exa_id WHERE can_status = 2
                                 AND exa_date > '{$year_ini}-12-31'
                                 AND exa_date < '{$year}-12-31'";
    $resultado = $class_bd->ejecutar($sql);
    $total_rows = mysql_num_rows($resultado);
    return ($total_rows);
}

function getCandidatePrepYear(){
	$i=0;
	$class_bd=new bd();
    $year_ini=$year-1;
    $sql="SELECT prc_name, YEAR(exa_date),COUNT(*) AS Cuenta
			FROM Candidate 
			INNER JOIN PrepCentre on PrepCentre.prc_id=Candidate.prc_id
			INNER JOIN Exam on Exam.exa_id=Candidate.exa_id
			GROUP BY prc_name, YEAR(exa_date)
			ORDER BY prc_name ASC";

    $resultado=$class_bd->ejecutar($sql);

    while ($r=$class_bd->retornar_fila($resultado)){
    	$column_year = $r["YEAR(exa_date)"] + 1 - 2015;

    	if($PrepArreglo[$i][0]!=$r["prc_name"]){
			$i++;
		}
    	$PrepArreglo[$i][0]=$r["prc_name"]; 
    	$PrepArreglo[$i][$column_year]= $r ["Cuenta"];
    }

    return ($PrepArreglo);
}



function getCandidateTypeExamYear(){
	$i=0;
	$class_bd=new bd();
    $year_ini=$year-1;
    $sql="
			SELECT tye_name, YEAR(exa_date),COUNT(*) AS Cuenta
			FROM Candidate 
			INNER JOIN Exam on Exam.exa_id=Candidate.exa_id
           	INNER JOIN TypeExam on TypeExam.tye_id=Exam.tye_id
			GROUP BY tye_name, YEAR(exa_date)
			ORDER BY tye_name ASC";

    $resultado=$class_bd->ejecutar($sql);

    while ($r=$class_bd->retornar_fila($resultado)){
    	$column_year = $r["YEAR(exa_date)"] + 1 - 2015;

    	if($PrepArreglo[$i][0]!=$r["tye_name"]){
			$i++;
		}
    	$PrepArreglo[$i][0]=$r["tye_name"]; 
    	$PrepArreglo[$i][$column_year]= $r ["Cuenta"];
    }

    return ($PrepArreglo);
}

function write_candidatePrepYear(){

	$PrepArray = getCandidatePrepYear();
	$i=1;

	foreach($PrepArray as $elemento){

		if ($r["can_status"]==STATUS_NOT_SENT)
            $color=COLOR_NOT_SENT;
        if ($r["can_status"]==STATUS_SENT)
            $color=COLOR_SENT;
        if ($r["can_status"]==STATUS_CONFIRMED)
            $color=COLOR_CONFIRMED;
        if ($r["can_status"]==STATUS_ERROR)
            $color=COLOR_ERROR;

        $año_2015= ($PrepArray[$i][1]==null) ? "0" : $PrepArray[$i][1];  
        $año_2016= ($PrepArray[$i][2]==null) ? "0" : $PrepArray[$i][2];  
        $año_2017= ($PrepArray[$i][3]==null) ? "0" : $PrepArray[$i][3];  
        $año_2018= ($PrepArray[$i][4]==null) ? "0" : $PrepArray[$i][4];  
        //$año_2019= ($PrepArray[$i][5]==null) ? "0" : $PrepArray[$i][5];  
        $total = $año_2015 +
         		 $año_2016 +
         		 $año_2017 +
         		 $año_2018;

        $prc_name = $PrepArray[$i][0];     
            
         $table.="<tr  style='background-color:{$background_tr_color};'>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect_prep(\"{$prc_name}\");'>{$PrepArray[$i][0]}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["prc_id"]});'>{$año_2015}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["prc_id"]});'>{$año_2016}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["prc_id"]});'>{$año_2017}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["prc_id"]});'>{$año_2018}</td>";
         //$table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2019}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["prc_id"]});'>{$total}</td>";
      	 $table.="</tr>";
      	 $i++;
   }    

   echo $table;
      
    } 
   
function write_candidateExamYear(){

	$PrepArray = getCandidateTypeExamYear();
	$i=1;

	foreach($PrepArray as $elemento){

		if ($r["can_status"]==STATUS_NOT_SENT)
            $color=COLOR_NOT_SENT;
        if ($r["can_status"]==STATUS_SENT)
            $color=COLOR_SENT;
        if ($r["can_status"]==STATUS_CONFIRMED)
            $color=COLOR_CONFIRMED;
        if ($r["can_status"]==STATUS_ERROR)
            $color=COLOR_ERROR;

        $año_2015= ($PrepArray[$i][1]==null) ? "0" : $PrepArray[$i][1];  
        $año_2016= ($PrepArray[$i][2]==null) ? "0" : $PrepArray[$i][2];  
        $año_2017= ($PrepArray[$i][3]==null) ? "0" : $PrepArray[$i][3];  
        $año_2018= ($PrepArray[$i][4]==null) ? "0" : $PrepArray[$i][4];  
        //$año_2019= ($PrepArray[$i][5]==null) ? "0" : $PrepArray[$i][5];  
        $total = $año_2015 +
         		 $año_2016 +
         		 $año_2017 +
         		 $año_2018;


         $table.="<tr  style='background-color:{$background_tr_color};'>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$PrepArray[$i][0]}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2015}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2016}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2017}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2018}</td>";
         //$table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$año_2019}</td>";
         $table.="<td style='color:{$color}; cursor:pointer;' onclick='redirect({$r["can_id"]});'>{$total}</td>";
      	 $table.="</tr>";
      	 $i++;
   }    

   echo $table;
      
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
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/select2/select2.css"/>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL STYLES USED BYE TOASTR NOTIFICATION -->
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-toastr/toastr.min.css" />
<!-- END PAGE LEVEL STYLES -->


<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />

<!-- BEGIN THEME STYLES -->
<?php include("includes/themestyle.html");?>
<!-- END THEME STYLES -->

<link rel="shortcut icon" href="favicon.ico"/>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['2016', 'Candidates'],
          ["2015", <?php echo getRowsPerYear("2015");?>],
          ["2016", <?php echo getRowsPerYear("2016");?>],
          ["2017", <?php echo getRowsPerYear("2017");?>],
          ["2018", <?php echo getRowsPerYear("2018");?>]
        ]);

        var options = {
          width: 1000,
          Height: 400,
          legend: { position: 'none' },
          chart: {
          /*title: 'Candidates per Year',
          subtitle: 'Considered Sent State Candidate'*/ },
          vAxis: {format: 'decimal'},
          axes: {
           /* x: {
              0: { side: 'top', label: 'White to move'} // Top x-axis.
            }*/
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>







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
				Interanual
				</h1>
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
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-equalizer font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo bold uppercase">Candidate Per Year</span>
								<span class="caption-helper">It is consider just Sent Candidates</span>
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="row">
								<div class="col-md-6">
									<div id="top_x_div" style="width: 1200px; height: 400px;"></div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-equalizer font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo bold uppercase">Candidate Per Year Per Preparation Centre</span>
								<span class="caption-helper">It is considered just Sent Candidates</span>
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover"
									id="sample_4">
									<thead>
										<tr>
											<th>Prep Centre</th>
											<th>2015</th>
											<th>2016</th>
											<th>2017</th>
											<th>2018</th>
											<th>Total</th>
											<!--<th>2019</th>-->			
										</tr>
									</thead>
									<tbody>
							<?php 
							   //getCandidatePrepYear();
							    write_candidatePrepYear();	
							?>
							</tbody>
								</table>
							</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
				
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-equalizer font-red-sunglo"></i>
								<span class="caption-subject font-red-sunglo bold uppercase">Candidate Per Year Per Type of Exam</span>
								<span class="caption-helper">It is considered just Sent Candidates</span>
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
								<table class="table table-striped table-bordered table-hover"
									id="sample_2">
									<thead>
										<tr>
											<th>Prep Centre</th>
											<th>2015</th>
											<th>2016</th>
											<th>2017</th>
											<th>2018</th>
											<th>Total</th>
											<!--<th>2019</th>-->			
										</tr>
									</thead>
									<tbody>
							<?php 
							   //getCandidatePrepYear();
							    write_candidateExamYear();	
							?>
							</tbody>
								</table>
							</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->


		</div>

	<!-- END PAGE CONTENT -->

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

<!-- BEGIN PAGE LEVEL SCRIPTS USED BY TOASTR-->
<script	src="../../assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="../../assets/admin/pages/scripts/ui-toastr.js"></script>
<!-- END PAGE LEVEL SCRIPTS USED BY TOASTR-->


<!-- BEGIN PAGE LEVEL STYLES -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<script src="../../assets/admin/pages/scripts/table-advanced.js"></script>
<!-- END PAGE LEVEL STYLES -->


<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   Demo.init(); // init demo features
   UIToastr.init(); //used by toastr
   TableAdvanced.init();
 
});
</script>
<!-- END JAVASCRIPTS -->


<!-- START AJAX -->

<script>
//--START JAVASCRIPT FUNCTIONS --

function redirect_prep(prc_name){
    pagina="dashboard_preparation.php?prc_name=" + prc_name ;
    redireccionar(pagina);	
}


function redireccionar(pagina) {
	{
	location.href=pagina;
	} 
    setTimeout ("redireccionar()", 20000);   
}


</script>
<!-- END JAVASCRIPT FUNCTIONS -->
	
</body>
<!-- END BODY -->
</html>