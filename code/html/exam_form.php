<?php include("includes/title.php");?>
<?php include ("includes/security_session.php");?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<!--  BEGIN INCLUDE CLASSES -->
<?php include_once("../classes/class.typeexam.php");?>
<?php include_once("../classes/class.exam.php");?>
<?php include_once("../classes/class.examplace.php");?>
<?php include_once("../classes/class.bd.php");?>
<?php include_once("../classes/class.utiles.php");?>
<!--  END INCLUDE CLASSES -->

<!--  BEGIN GLOBAL VARIABLES -->
<?php 
$submit="Save";
$exa_id=NULL; // To Determitae new or update
?>
<!--  END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
visiblePlacesform();
fillFilds();

Function visiblePlacesform(){
    Global $show_Placesform;
    if ($_GET["exa_id"]==NULL)
        $show_Placesform="none";
    else
         $show_Placesform="";
}
function fillFilds(){
    Global $exa_id;
    Global $exa_date;
    Global $tye_id;
    Global $exa_comment;
    Global $exa_status;
    Global $exa_aci;
    Global $exa_visa;
    Global $exa_deadline;
    Global $exa_deadlineshow;
    Global $submit;
    
    if ($_GET["exa_id"]!=NULL){
        $exa_id=$_GET["exa_id"];
        $class_exam=new Exam($exa_id);
        $class_utiles=new utiles();
        $exa_date=$class_utiles->fecha_mysql_php($class_exam->getExa_date());
        $tye_id=$class_exam->getTye_id();
        $exa_comment=$class_exam->getExa_comment();
        $exa_status=$class_exam->getExa_status();
        $exa_aci=$class_exam->getExa_aci();
        $exa_visa=$class_exam->getExa_visa();
        $exa_deadline=$class_utiles->fecha_mysql_php($class_exam->getExa_deadline());
        $exa_deadlineshow=$class_utiles->fecha_mysql_php($class_exam->getExa_deadlineshow());
        $submit="Update";    
   }
}
function getOption_selected($exa_id)
{
    $class_bd = new bd();
    $sql = "SELECT * FROM PlaceForSit INNER JOIN ExamPlace on PlaceForSit.exp_id=ExamPlace.exp_id WHERE exa_id={$exa_id} ORDER BY exp_name ASC";
    $resultado = $class_bd->ejecutar($sql);
    $i = 1;
    while ($r = $class_bd->retornar_fila($resultado)) {
        echo "<option  selected='selected' value='{$r["exp_id"]}'> {$r["exp_name"]}</option>";
        $exp_id_selected[$i] = $r["exp_id"];
        $i ++;
    }
    getOption_nonselected($exp_id_selected);
}
function getOption_nonselected($exp_id_selected){
$class_bd = new bd();
$sql = "SELECT * FROM ExamPlace ORDER BY exp_name ASC";
$length = sizeof($exp_id_selected);
$resultado = $class_bd->ejecutar($sql);
while ($r = $class_bd->retornar_fila($resultado)) {
    $print = true;
    for ($i = 1; $i <= $length; $i ++) {
        if ($r["exp_id"] == $exp_id_selected[$i]) {
            $print = false;
        }
    }
    if ($print)
        echo "<option value='{$r["exp_id"]}'> {$r["exp_name"]} </option>";
}
}
?>
<!--  PAGE TITLE  -->
<?php include ("includes/pagetitle.php");?>
<!--  END PAGE TITLE  -->
<!-- BEGIN GLOBAL STYLE -->
<?php include("includes/globalstyle.html");?>
<!-- END GLOBAL STYLE -->

<!-- BEGIN THEME STYLES -->
<?php include("includes/themestyle.html");?>
<!-- END THEME STYLES -->

<!-- BEGIN PAGE LEVEL STYLES USED BYE TOASTR NOTIFICATION -->
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-toastr/toastr.min.css" />
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES USE BY DATE PICKER-->
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/clockface/css/clockface.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-datepicker/css/datepicker3.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES USED BY MULTIPLE SELECT-->
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/bootstrap-select/bootstrap-select.min.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/select2/select2.css" />
<link rel="stylesheet" type="text/css"
	href="../../assets/global/plugins/jquery-multi-select/css/multi-select.css" />
<!-- END PAGE LEVEL STYLES USED BY MULTIPLE SELECT-->

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
						Exam <small>Add and Update an exam</small>
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
        					<a href="exam_table.php">Return</a></i>
        				</li>	
        			</ul>
			    <!-- END PAGE BREADCRUMB -->



				<!-- <div class="col-md-10 "> -->
				<!-- BEGIN SAMPLE FORM PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs font-green-sharp"></i> <span
								class="caption-subject font-green-sharp bold uppercase">Exam</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse"> </a> <a
								href="#portlet-config" data-toggle="modal" class="config"> </a>
							<a href="javascript:;" class="reload"> </a> <a
								href="javascript:;" class="remove"> </a>
						</div>
					</div>
					<div class="portlet-body form">

						<!-- Form -->
						<form class="form-horizontal" role="form" name="form_exam">
							<div class="form-body">
								<div class="form-group">
									<label class="control-label col-md-3">Day of the Exam</label>
									<div class="col-md-3">
										<input
											class="form-control form-control-inline input-medium date-picker"
											data-date-format="dd/mm/yyyy" size="16" type="text"
											value="<?php echo $exa_date;?>" name="exa_date" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Deadline Date</label>
									<div class="col-md-3">
										<input
											class="form-control form-control-inline input-medium date-picker"
											data-date-format="dd/mm/yyyy" size="16" type="text"
											value="<?php echo $exa_deadline;?>" name="exa_deadline" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Deadline Date to Show</label>
									<div class="col-md-3">
										<input
											class="form-control form-control-inline input-medium date-picker"
											data-date-format="dd/mm/yyyy" size="16" type="text"
											value="<?php echo $exa_deadlineshow;?>" name="exa_deadlineshow" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">AIC Required</label>
									<div class="col-md-9">
										<div class="radio-list">
    										<label class="radio-inline"> <input type="radio"
    											name="exa_aci" value="0"
    											<?php if ($exa_aci==0) echo "checked";?>> No
    										</label> <label class="radio-inline"> <input type="radio"
    											name="exa_aci" value="1"
    											<?php if ($exa_aci==1) echo "checked";?>> Yes
    										</label>
									   </div>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">VISA Required Visible</label>
									<div class="col-md-9">
										<div class="radio-list">
    										<label class="radio-inline"> <input type="radio"
    											name="exa_visa" value="0"
    											<?php if ($exa_visa==0) echo "checked";?>> No
    										</label> <label class="radio-inline"> <input type="radio"
    											name="exa_visa" value="1"
    											<?php if ($exa_visa==1) echo "checked";?>> Yes
    										</label>
									   </div>
								    </div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Exam Type</label>
									<div class="col-md-9">
										<select class="form-control" name="tye_id">
												<?php
                                                    $class_typeexam = new TypeExam();
                                                    $class_typeexam->getOption($tye_id);
                                                 ?>
											</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Coment</label>
									<div class="col-md-9">
										<textarea class="form-control" rows="3" name="exa_comment"><?php echo $exa_comment;?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline"> <input type="radio"
												name="exa_status" value="0"
												<?php if ($exa_status==0) echo "checked";?>> Non Visible
											</label> <label class="radio-inline"> <input type="radio"
												name="exa_status" value="1"
												<?php if ($exa_status==1) echo "checked";?>> Opened
											</label> <label class="radio-inline"> <input type="radio"
												name="exa_status" value="2"
												<?php if ($exa_status==2) echo "checked";?>> Closed
											</label>
										</div>
									</div>
								</div>


							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="button" value="<?php echo $exa_id;?>"
											class="btn green" onclick="newupdateExam();" name="submit"><?php echo $submit;?></button>
										<button type="button" class="btn default" onclick="redirectExamtable();">Return</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- END SAMPLE FORM PORTLET-->


				<div class="row" style="display:<?php echo $show_Placesform;?>">
					<div class="col-md-12">
						<!-- BEGIN PORTLET-->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs font-green-sharp"></i> <span
										class="caption-subject font-green-sharp bold uppercase">Exam
										places</span>
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"> </a> <a
										href="#portlet-config" data-toggle="modal" class="config"> </a>
									<a href="javascript:;" class="reload"> </a> <a
										href="javascript:;" class="remove"> </a>
								</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
								<form name="form_placeforsit"
									class="form-horizontal form-row-seperated">
									<div class="form-body">
										<div class="form-group">
											<label class="control-label col-md-3">Select Places from left
												to Right</label>
											<div class="col-md-9" style="height: 600px;">
												<select multiple="multiple" class="multi-select"
													id="my_multi_select1" name="exp_id[]" >
												<?php
												
    												$exp_id_selected=getOption_selected($exa_id);
                                               
                                                 ?>
											</select>
											</div>
										</div>
									</div>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button name="exa_id" type="button" class="btn green"
													value="<?php echo $exa_id;?>"
													onclick="updatePlaceForSit();">Update</button>
												<button type="button" class="btn default" onclick="redirectExamtable();">Return</button>
											</div>
										</div>
									</div>
								</form>
								<!-- END FORM-->
							</div>
						</div>
						<!-- END PORTLET-->
					</div>
				</div>
				
				<!-- END PAGE CONTENT INNER -->
			</div>
		</div>
		<!-- END PAGE CONTENT -->

		<!-- END PAGE CONTAINER -->
	</div>

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

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS USED BY TOASTR-->
<script
	src="../../assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="../../assets/admin/pages/scripts/ui-toastr.js"></script>
<!-- END PAGE LEVEL SCRIPTS USED BY TOASTR-->

<!-- BEGIN PAGE LEVEL PLUGINS USED BY MULTIPLE SELECT -->
<script type="text/javascript"
	src="../../assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript"
	src="../../assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../assets/global/scripts/metronic.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js"
	type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js"
	type="text/javascript"></script>
<script src="../../assets/admin/pages/scripts/components-pickers.js"></script>
<!-- DATE PICKER -->
<script src="../../assets/admin/pages/scripts/components-dropdowns.js"></script>
<!-- MULTIPLE SELECT -->
<!-- USED BY PICKER -->

<!-- END PAGE LEVEL SCRIPTS -->
<script>
 jQuery(document).ready(function() {       
	 // initiate layout and plugins
     Metronic.init(); // init metronic core components
     Layout.init(); // init current layout
     Demo.init(); // init demo features
     ComponentsPickers.init(); //used by Picker
     UIToastr.init(); //used by toastr
     ComponentsDropdowns.init();
    });   
</script>

<!-- START AJAX -->
<script>

//--START JAVASCRIPT FUNCTIONS --
function updatePlaceForSit(){	  	  
    var selected = $('#my_multi_select1').val();
    var length =  $('#my_multi_select1').val().length;
    var exa_id = this.document.form_placeforsit.exa_id.value;

    $.ajax({
     type:"POST",
     url: "../abm/abm.placeforsit.php",
     data:{selected:selected, length:length, exa_id:exa_id},
     cache: false,
     success : function (msg) {
    	toast();   
    }
    });           
}
function newupdateExam(){
    var exa_date= this.document.form_exam.exa_date.value;
    var tye_id=	this.document.form_exam.tye_id.value;
    var exa_comment= this.document.form_exam.exa_comment.value;
    var exa_status= this.document.form_exam.exa_status.value;
    var exa_aci= this.document.form_exam.exa_aci.value;
    var exa_visa= this.document.form_exam.exa_visa.value;
    var exa_deadline= this.document.form_exam.exa_deadline.value;
    var exa_deadlineshow= this.document.form_exam.exa_deadlineshow.value;
    var submit = this.document.form_exam.submit.value;

	if (submit==""){ //Submit "" = un nuevo registro, en caso contrario se almacena el exa_id.
        $.ajax({
            type:"POST",
            url: "../abm/abm.exam.php",
            data:{exa_date:exa_date, tye_id:tye_id, exa_comment:exa_comment, exa_status:exa_status, exa_aci:exa_aci,exa_visa:exa_visa, exa_deadline:exa_deadline, exa_deadlineshow:exa_deadlineshow, submit:submit},
            cache: false,
            success : function (msg) {
                var new_exa_id;
            	new_exa_id = parseInt(msg);
            	if (new_exa_id==-1)
                	alert ("The exam already exists. Please modify 'Day of the Exam' or 'Exam Type'");
            	else{
                	alert ("Exam successfully added!");
            		redirect(new_exa_id);
                	}    		       
        	}
        });    
	}else{
        $.ajax({
            type:"POST",
            url: "../abm/abm.exam.php",
            data:{exa_date:exa_date, tye_id:tye_id, exa_comment:exa_comment, exa_status:exa_status, exa_aci:exa_aci, exa_visa:exa_visa, exa_deadline:exa_deadline, exa_deadlineshow:exa_deadlineshow, submit:submit},
            cache: false,
            success : function (msg) {
            	toast();   
        	}
        });    
	} 
}   

function toast(){
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
	toastr.success('Correctly Updated', 'Exam');  		        
 }   
 
function redireccionar(pagina) {
    location.href=pagina;
}
function redirect(exa_id){
    pagina="exam_form.php?exa_id="+ exa_id;
    redireccionar(pagina);
}
function redirectExamtable(exa_id){
    pagina="exam_table.php";
    redireccionar(pagina);
    }

//--END JAVASCRIPT FUNCTIONS--
</script>
<!-- END JAVASCRIPTS -->


</body>
<!-- END BODY -->
</html>