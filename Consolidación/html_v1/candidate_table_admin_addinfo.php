<?php include ("includes/title.php");?>
<?php include ("includes/security_admin.php");?>
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
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<?php 
$_SESSION["exa_id"]=$_GET["exa_id"]; //It is used in the form (to not use get)
$get_exa_id=$_GET["exa_id"];
$session_prc_id= $_SESSION["prc_id"];
$field_visible = field_visible($get_exa_id);
?>
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
function getExaInfo($exa_id){
    $class_utiles=new utiles();
    $class_bd=new bd();
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_id={$exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);   
	echo "{$r["tye_name"]} Exam <small>( {$class_utiles->fecha_mysql_php($r["exa_date"])})</small>";	
}
function write_candidate($session_prc_id, $get_exa_id, $field_visible){
    $class_bd=new bd();
    $class_utiles= new utiles();
    $folder="../../files/";
    $sql="SELECT * FROM Candidate 
                   INNER JOIN ExamPlace on Candidate.exp_id=ExamPlace.exp_id
                   INNER JOIN PrepCentre on Candidate.prc_id=PrepCentre.prc_id
                   LEFT OUTER JOIN ExamPlaceAula on Candidate.epa_id=ExamPlaceAula.epa_id
                   WHERE exa_id={$get_exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $i=1;
    while ($r=$class_bd->retornar_fila($resultado))
    {
        if ($r["can_status"]==0)
            $color="#585858";
        if ($r["can_status"]==1)
            $color="#0c7ed4";
        if ($r["can_status"]==2)
            $color="#3fa785";
        if ($r["can_status"]==3)
            $color="#D26380";
        
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
         
        if($r["can_datespeaking"]=="0000-00-00"){
            $date_speaking="";
        }else
            $date_speaking= $class_utiles->fecha_mysql_php($r["can_datespeaking"]);



        $line="<tr class='odd gradeX'>"; 
        $line.="<td> <input type='checkbox' name='check' id='{$r["can_id"]}' class='checkboxes' value='{$r["can_id"]}'/></td>";
        $line.="<td style='color:{$color};'>{$r["can_id"]}</td>";
        $line.="<td style='color:{$color};'>{$r["can_firstname"]}</td>";
        $line.="<td style='color:{$color};'>{$r["can_lastname"]}</td>";
        $line.="<td style='color:{$color};'>{$r["exp_name"]}</td>";
       // $line.="<td style='color:{$color};'>{$r["prc_name"]}</td>";
        $line.="<td style='color:{$color};'><input type='text' onfocusout='updateCandidateNum({$r["can_id"]},this.value);' value='{$r["can_candidatenum"]}'></td>";
        $line.="<td style='color:{$color};'><input type='text' onfocusout='updatePackingCode({$r["can_id"]},this.value);' value='{$r["epa_packingcode"]}'></td>";
        $line.="<td style='color:{$color}; display:{$field_visible["listening"]};'><input type='text' );' value='{$r["can_timelistening"]}'></td>";
        $line.="<td style='color:{$color};'><input type='text' );' value='{$r["can_timespeaking"]}'></td>";
        $line.="<td style='color:{$color};'><input type='text' );' value='{$date_speaking}'></td>";
        $line.="<td style='color:{$color}; display:{$field_visible["writing"]};'><input type='text' );' value='{$r["can_timewriting"]}'></td>";
        $line.="<td style='color:{$color}; display:{$field_visible["reading"]};'><input type='text' );' value='{$r["can_timereading"]}'></td>";
        $line.="<td style='color:{$color}; display:{$field_visible["readingandwriting"]};'><input type='text' );' value='{$r["can_timereadingandwriting"]}'></td>";
        $line.="<td style='color:{$color}; display:{$field_visible["readinganduseofenglish"]};'><input type='text' );' value='{$r["can_timereadinganduseofenglish"]}'></td>";
        $line.="</tr>";
         
         echo $line;
      }		
      
    }
    
 function getOption()
    {
        $class_bd = new bd();
        $sql = "SELECT * FROM ExamPlaceAula INNER JOIN ExamPlace on ExamPlaceAula.exp_id=ExamPlace.exp_id ORDER BY ExamPlace.exp_name ASC";
        $resultado = $class_bd->ejecutar($sql);
        while ($r = $class_bd->retornar_fila($resultado)) {
          echo "<option value='{$r["epa_id"]}'>{$r["exp_name"]}-{$r["epa_packingcode"]} </option>";
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
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>

<!-- BEGIN PAGE LEVEL STYLES USED BYE TOASTR NOTIFICATION -->
<link rel="stylesheet" type="text/css"
    href="../../assets/global/plugins/bootstrap-toastr/toastr.min.css" />
<!-- END PAGE LEVEL STYLES -->
	
	
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
	<div class="page-container-fluid">
		<!-- BEGIN PAGE HEAD -->
		<div class="page-head">
			<div class="container">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>
                        <?php getExaInfo($get_exa_id);?>
					</h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- BEGIN PAGE TOOLBAR -->
				<div class="page-toolbar">
					<!-- BEGIN THEME PANEL -->
					<div class="btn-group btn-theme-panel">
                    <a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-settings"></i>
                    </a>
                    <div class="dropdown-menu theme-panel pull-right dropdown-custom hold-on-click">
                        <div class="row">
                            
                                <ul class="theme-settings">
                                    <li>
                                         Layout
                                        <select class="theme-setting theme-setting-layout form-control input-sm input-small input-inline tooltips" data-original-title="Change layout type" data-container="body" data-placement="left">
                                            <option value="boxed" selected="selected">Boxed</option>
                                            <option value="fluid">Fluid</option>
                                        </select>
                                    </li>
                                </ul>
                          
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
        					<a href="candidate_table_admin.php?exa_id=<?php echo $get_exa_id;?>">Return</a>
        				</li>
        			</ul>
        			
        			
        			
        			
        		<div class="row">
        		
				<div class="col-md-4 ">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">SET PARAMETERS</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<form role="form">
								<div class="form-body">			
									<div class="form-group">
										
										<div class="input-group">
											<div class="input-icon">
        										    <select name="epa_id" id="epa_id" data-placeholder="Select Packing Code" class="form-control">
        										      <?php  getOption();?>
        											</select>        											
											</div>
											<span class="input-group-btn">
    									       <button id="genpassword" class="btn btn-success" type="button" onclick="set_packingcode();"><i class="fa fa-arrow-left fa-fw"/></i> Set</button>
    									    </span>
											
										</div>
									</div>		 
            			             <div class="form-group">
                			             <div class="input-group">
        									
        									<input id="init_value" class="form-control" type="text" name="init_value" placeholder="Start number - Candidate # Init" />
        									
        									<span class="input-group-btn">
        									<button id="genpassword" class="btn btn-success" type="button" onclick="set_candidate();"><i class="fa fa-arrow-left fa-fw"/></i> Set</button>
        									</span>
        								</div>
                                    </div>
        			          </div> 
        			         </form>
        			     </div>
        			   </div>
                    </div>
                    
                    
                    		
                    
                    
                    <div class="col-md-8 ">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">SET TIME</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						
						<div class="portlet-body form">
							<form role="form">
								<div class="form-body">	
								    <div class="row">		
    								 <div class="form-group">
    										<label class="control-label col-md-1" style="display: <?php echo $field_visible['listening'];?>">L</label>
    										<div class="col-md-3" style="display: <?php echo $field_visible['listening'];?>">
    											<div class="input-group">
    												<input type="text" class="form-control timepicker timepicker-24" id='can_timelistening' name='can_timelistening'>
    												<span class="input-group-btn">
    												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
    												</span>
    											</div>
    										</div>
    										<label class="control-label col-md-1" style="display: <?php echo $field_visible['writing'];?>">W</label>
    										<div class="col-md-3" style="display: <?php echo $field_visible['writing'];?>">
    											<div class="input-group">
    												<input type="text" class="form-control timepicker timepicker-24" id='can_timewriting' name='can_timewriting'>
    												<span class="input-group-btn">
    												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
    												</span>
    											</div>
    										</div>
    										<label class="control-label col-md-1" style="display: <?php echo $field_visible['reading'];?>">R</label>
    										<div class="col-md-3">
    											<div class="input-group" style="display: <?php echo $field_visible['reading'];?>">
    												<input type="text" class="form-control timepicker timepicker-24" id='can_timereading' name='can_timereading'>
    												<span class="input-group-btn">
    												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
    												</span>
    											</div>
    										</div>
    								   </div>
    								 </div>
    								  <span><br/></span>
    								 <div class="row">		
        								 <div class="form-group">
        										<label class="control-label col-md-1" style="display: <?php echo $field_visible['readingandwriting'];?>">R&W</label>
        										<div class="col-md-3" style="display: <?php echo $field_visible['readingandwriting'];?>">
        											<div class="input-group">
        												<input type="text" class="form-control timepicker timepicker-24" id='can_timereadingandwriting' name='can_timereadingandwriting'>
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
        												</span>
        											</div>
        										</div>
        										<label class="control-label col-md-1" style="display: <?php echo $field_visible['readinganduseofenglish'];?>">R&E</label>
        										<div class="col-md-3" style="display: <?php echo $field_visible['readinganduseofenglish'];?>">
        											<div class="input-group">
        												<input type="text" class="form-control timepicker timepicker-24" id='can_timereadinganduseofe' name='can_timereadinganduseofe'>
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
        												</span>
        											</div>
        										</div>
        										<label class="control-label col-md-1"> </label>
        										<div class="col-md-3">
        											<div class="input-group">
        												<input type="text" class="form-control">
        												<span class="input-group-btn">
        												<button id="genpassword" class="btn btn-success" type="button"  onclick="set_cantimevarious();"><i class="fa fa-arrow-left fa-fw"/></i> Set</button>
        												</span>
        											</div>
        										</div>
        								   </div>
    								  </div>
    								 <span><br/><br/><br/></span>
    								 <div class="row">	
        								 <div class="form-group">
        										<label class="control-label col-md-1">Start</label>
        										<div class="col-md-3">
        											<div class="input-group">
        												<input type="text" class="form-control timepicker timepicker-24" id='time_start_speaking' name='time_start_speaking'>
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
        												</span>
        											</div>
        										</div>
        										<label class="control-label col-md-1">Inter.</label>
        										<div class="col-md-3">
        											<div class="input-group">
        												<input type="text" class="form-control" id='time_interval' name='time_interval' placeholder="min. between exams">
        											</div>
        										</div>

        										<label class="control-label col-md-1">Group </label>
        										<div class="col-md-3">
        											<div class="input-group">
        												<input type="text" class="form-control" id='time_group' name='time_group'>
        												<span class="input-group-btn">
        												<button id="genpassword" class="btn btn-success" type="button" onclick="set_cantimespeaking();"><i class="fa fa-arrow-left fa-fw"/></i> Set</button>
        												</span>
        											</div>
        										</div>

        								   </div>
    								  </div>
                                    <br/>
        								  <div class="row">  
                                            <div class="form-group">
                                            <label class="control-label col-md-1">Fecha</label>
                                            <div class="col-md-3">
                                                <div class="input-group date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" id='can_datespeaking' name='can_datespeaking' readonly>
                                                    <span class="input-group-btn">
                                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        			             </div>  			             
        			         </form>
        			     </div>
        			   </div>
                    </div>
                    
        
                  
   
                    </div>
                    
        			
			<!-- END PAGE BREADCRUMB -->
				<!-- BEGIN PAGE CONTENT INNER -->
				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
					
						<!-- END EXAMPLE TABLE PORTLET-->
					
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase" onclick="chequear();">Candidate Table</span>
							</div>
						</div>
								
							<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
										    <th class="table-checkbox">
									            <input type="checkbox" class="group-checkable" name="check" ide='check' data-set="#sample_1 .checkboxes"/>
							             	</th>
											<th>ID</th>
										    <th>First Name</th>
											<th>Last Name</th>
											<th>Venue</th>
										   <!--  <th>Prep. Centre</th>  --> 	
											<th>Candidate #</th>
											<th>Packing Code</th>
											<th style="display: <?php echo $field_visible["listening"];?>">Time Listening</th>
											<th>Time Speaking</th>
                                            <th>Date Speaking</th>
											<th style="display: <?php echo $field_visible["writing"];?>">Time Writing</th>
											<th style="display: <?php echo $field_visible["reading"];?>">Time Reading</th>
											<th style="display: <?php echo $field_visible["readingandwriting"];?>">Time Reading and Writing</th>
											<th style="display: <?php echo $field_visible["readinganduseofenglish"];?>">Time Reading and Use of English</th>
										
										</tr>
									</thead>
							<tbody>
							<?php 
							    write_candidate($session_prc_id, $get_exa_id, $field_visible);							
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
<?php //include("includes/prefooter.html")?>
<!-- END PRE-FOOTER -->
<!-- BEGIN FOOTER -->
<?php //include("includes/footer.html");?>
<!-- END FOOTER -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
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
	
	

<script type="text/javascript" src="../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS USED BY TOASTR-->
<script
    src="../../assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="../../assets/admin/pages/scripts/ui-toastr.js"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/scripts/metronic.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js"
	type="text/javascript"></script>
	<script src="../../assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../assets/admin/pages/scripts/table-managed.js"></script>

<script src="../../assets/admin/pages/scripts/components-pickers.js"></script>


<script>
jQuery(document).ready(function() {       
	   Metronic.init(); // init metronic core components
		Layout.init(); // init current layout
		Demo.init(); // init demo features
	    TableManaged.init();
	    ComponentsPickers.init();
        UIToastr.init(); //used by toastr
	});

//--START JAVASCRIPT FUNCTIONS--
function redirect(can_id){
	pagina = "candidate_form.php?can_id="+ can_id;
	setTimeout(redireccionar, 100, pagina);
}
function redireccionar(pagina) {
    location.href=pagina;	          
}   
function export_excel(exa_id){
	mensaje =	"Do you want to export this table to Excel Format?";
	confirmar=confirm(mensaje); 
	if (confirmar) {			
		var pagina = 'candidate_exportexcel.php?exa_id='+exa_id;
		document.location.href= pagina;
	}
}
function updateStatus(can_id, can_status){
	//showUpdateCheck();
	$.ajax({
        url:"../abm/abm.candidate.php",
        type: "POST",
        data:{can_id:can_id, can_status:can_status}, 
        success: function(opciones){ 
        	//hideUpdateCheck();				
          }
       });
}
function updateCandidateNum(can_id, can_candidatenum){
	//showUpdateCheck();
	if(can_candidatenum!=""){
    	$.ajax({
            url:"../abm/abm.candidate.php",
            type: "POST",
            data:{can_id:can_id, can_candidatenum:can_candidatenum}, 
            success: function(opciones){ 
            	//alert(opciones);	
              }
           });
	}
}
function updatePackingCode(can_id, can_packingcode){
	//showUpdateCheck();
	if (can_packingcode!=""){            //To avoid the err blank field
    	$.ajax({
            url:"../abm/abm.candidate.php",
            type: "POST",
            data:{can_id:can_id, can_packingcode:can_packingcode}, 
            success: function(opciones){ 
            	//alert(opciones);
              }
           });
	}
}
function showUpdateCheck(){
    this.document.getElementById("update_check").style.display = 'inline';
    }
function hideUpdateCheck(){
    this.document.getElementById("update_check").style.display = 'none';
    }
    
function set_candidate(){
	var ids;
	var init_value;
	var set;
	
    ids = $('input[type=checkbox]:checked').map(function() {
  	    return $(this).attr('id');
   	   }).get();
    init_value= this.document.getElementById("init_value").value
    set="set_candidate";
    // alert('IDS: ' + ids.join(', '));

     $.ajax({
        url:"../abm/abm.candidate_parameters.php",
        type: "POST",
        data:{ids:ids, init_value:init_value, set:set},
        success: function(opciones){ 
            toast("Candidate Number");
          }
       });

}

function set_packingcode(){
	var ids;
	var epa_id;
	var set;
	
    ids = $('input[type=checkbox]:checked').map(function() {
  	    return $(this).attr('id');
   	   }).get();  
    epa_id= this.document.getElementById("epa_id").value        
    set="set_packingcode";
    
    
    // alert('IDS: ' + ids.join(', '));

     $.ajax({
        url:"../abm/abm.candidate_parameters.php",
        type: "POST",
        data:{ids:ids, epa_id:epa_id, set:set},
        success: function(opciones){ 
            toast("Packing Code");  
          }
       });
}

function set_cantimespeaking(){

	var ids;
	var time_interval;
	var time_start_speaking;
	var time_group;
    var can_datespeaking;

	var set;
    ids = $('input[type=checkbox]:checked').map(function() {
  	    return $(this).attr('id');
   	   }).get();  
    time_interval= this.document.getElementById("time_interval").value  
    time_start_speaking= this.document.getElementById("time_start_speaking").value
    time_group= this.document.getElementById("time_group").value   
    can_datespeaking = this.document.getElementById("can_datespeaking").value     
    set="set_timespeaking";
    // alert('IDS: ' + ids.join(', '));
         


     $.ajax({
        url:"../abm/abm.candidate_parameters.php",
        type: "POST",
        data:{ids:ids, time_interval:time_interval, time_start_speaking:time_start_speaking, can_datespeaking:can_datespeaking, time_group:time_group,set:set},
        success: function(opciones){ 
           toast("Speaking");
          }
       });
}

function set_cantimevarious(){
	var ids;
	var can_timelistening;
	var can_timewriting;
	var can_timereading;
	var can_timereadingandwriting;
	var can_timereadinganduseofe;
	
	var set;
    ids = $('input[type=checkbox]:checked').map(function() {
  	    return $(this).attr('id');
   	   }).get();  
    can_timelistening= this.document.getElementById("can_timelistening").value
    can_timewriting= this.document.getElementById("can_timewriting").value
    can_timereading= this.document.getElementById("can_timereading").value
    can_timereadingandwriting= this.document.getElementById("can_timereadingandwriting").value
    can_timereadinganduseofe= this.document.getElementById("can_timereadinganduseofe").value         
    set="set_timevarious";
    // alert('IDS: ' + ids.join(', '));

     $.ajax({
        url:"../abm/abm.candidate_parameters.php",
        type: "POST",
        data:{ids:ids, can_timelistening:can_timelistening, can_timewriting:can_timewriting, can_timereading:can_timereading,
              can_timereadingandwriting:can_timereadingandwriting, can_timereadinganduseofe:can_timereadinganduseofe, set:set},
        success: function(opciones){ 
            toast("Times");
          }
       });
}

function toast(variable){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };                  
    toastr.success('Correctly Updated', variable);                
 }   
//--END JAVASCRIPT FUNCTIONS--
</script>

</body>
<!-- END BODY -->
</html>