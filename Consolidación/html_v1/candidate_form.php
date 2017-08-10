<?php include("includes/title.php");?>
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
$use_usertype=(($_SESSION["use_usertype"]==0 or $_SESSION["use_usertype"]==1) ? "admin":"none");
$exa_aci=getExa_aci($session_exa_id);
$exa_visa=getExa_visa($session_exa_id);
$display_exa_visa= ($exa_visa==0 ? "none":"");

$submit="Save";
?>
<!-- END GLOBAL VARIABLES -->

<!--  BEGIN PHP FUNCTIONS -->
<?php 
//visiblePlacesform();
fillFilds($get_can_id);
visibleFileform();

function getExa_aci($exa_id){
    $class_bd=new bd();
    $sql="SELECT * FROM Exam WHERE exa_id='{$exa_id}'";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);
    return($r[exa_aci]);
}

function getExa_visa($exa_id){
    $class_bd=new bd();
    $sql="SELECT * FROM Exam WHERE exa_id='{$exa_id}'";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);
    return($r["exa_visa"]);
}

function getExaInfo($exa_id){
    global $display_exa_visa;
    $class_utiles=new utiles();
    $class_bd=new bd();
    $sql="SELECT * FROM Exam INNER JOIN TypeExam on Exam.tye_id=TypeExam.tye_id WHERE exa_id={$exa_id}";
    $resultado=$class_bd->ejecutar($sql);
    $r=$class_bd->retornar_fila($resultado);
    echo "{$r["tye_name"]} Exam <small>( {$class_utiles->fecha_mysql_php($r["exa_date"])})</small>";
    

    
}

Function visibleFileform(){
    Global $show_Fileform;
    if ($_GET["can_id"]==NULL)
        $show_Fileform="none";
    else
         $show_Fileform="";
}

function fillFilds($get_can_id){
    global $can_dni;
    global $can_firstname;
    global $can_lastname;
    global $can_gender;
    global $can_datebirth;
    global $can_email;
    global $can_adress;
    global $can_telephone;
    global $can_cellphone;
    global $can_visa;
    global $can_disability;   
    global $can_disabilitycom;
    global $prc_id;
    global $exp_id;
    //global $prc_id; 
    global $display_can_disabilitycom;
    global $submit;      
    
    $display_can_disabilitycom="none";
    if ($get_can_id!=NULL){    
        $class_candidate=new Candidate($get_can_id);
        $class_utiles=new utiles();
        
        $can_dni=$class_candidate->getCan_dni();
        $can_firstname=$class_candidate->getCan_firstname();
        $can_lastname=$class_candidate->getCan_lastname();
        $can_gender=$class_candidate->getCan_gender();
        $can_datebirth=$class_utiles->fecha_mysql_php($class_candidate->getCan_datebirth());
        $can_email=$class_candidate->getCan_email();
        $can_adress=$class_candidate->getCan_adress();
        $can_telephone=$class_candidate->getCan_telephone();
        $can_cellphone=$class_candidate->getCan_cellphone();
        $can_visa=$class_candidate->getCan_visa();
        $can_disability=$class_candidate->getCan_disability();
        $can_disabilitycom=$class_candidate->getCan_disabilitycom();
        $prc_id=$class_candidate->getPrc_id();
        $exp_id=$class_candidate->getExp_id();
       // $prc_id=$class_candidate->$class_candidate->getPrc_id(); This is handle by the session
        $submit="Update";
        if( $can_disability==1)
            $display_can_disabilitycom="";
        else
            $display_can_disabilitycom="none";
   }
   
}

function getOption($exa_id, $exp_id)
{
    $class_bd = new bd();
    $sql = "SELECT * FROM PlaceForSit INNER JOIN ExamPlace on PlaceForSit.exp_id=ExamPlace.exp_id WHERE exa_id={$exa_id}";
    $resultado = $class_bd->ejecutar($sql);
    while ($r = $class_bd->retornar_fila($resultado)) {
        if ($r["exp_id"]==$exp_id)
            echo "<option value='{$r["exp_id"]}' selected='selected'>{$r["exp_name"]} </option>";
        else 
            echo "<option value='{$r["exp_id"]}'>{$r["exp_name"]} </option>";
    }
}

function getOptionPrepCentre($prc_id_user, $prc_id_candidate) //this is for change de PrepCentre by Administrator
{
    if ($prc_id_candidate=="")
        $prc_id=$prc_id_user;
    else 
        $prc_id=$prc_id_candidate;
    
    $class_bd = new bd();
    $sql = "SELECT * FROM PrepCentre";
    $resultado = $class_bd->ejecutar($sql);
    while ($r = $class_bd->retornar_fila($resultado)) {
        if ($r["prc_id"]==$prc_id)
            echo "<option value='{$r["prc_id"]}' selected='selected'>{$r["prc_name"]} </option>";
        else
            echo "<option value='{$r["prc_id"]}'>{$r["prc_name"]} </option>";
    }
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

<!-- BEGIN PAGE LEVEL STYLES USED BY VALIDATION-->
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-datepicker/css/datepicker.css"/>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL STYLES USED BY FILE INPUT-->
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/jquery-tags-input/jquery.tagsinput.css"/>
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="../../assets/global/plugins/typeahead/typeahead.css">
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME STYLES -->
<?php include("includes/themestyle.html");?>
<!-- END THEME STYLES -->

<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body <? if ($can_disability==1) echo "onload='showDisability();'";?>>

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
				<?php getExaInfo($session_exa_id);?>
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
        			<ul class="page-breadcrumb breadcrumb">
        				<li>
        					<a onclick="redirectCandidatetable(<?php echo $session_exa_id;?>, <?php echo "'".$use_usertype."'";?>, <?php echo ($get_can_id!=NULL? 1 : 0 );?>);">Return</a>
        				</li>        				
        			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="icon-equalizer font-red-sunglo"></i>
											<span class="caption-subject font-red-sunglo bold uppercase">Candidate</span>
											<span class="caption-helper">Add or Update Candidate</span>
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
										<!-- BEGIN FORM-->
										<form action="javascript:newupdateCandidate();" name="form_candidate" id="form_candidate" class="form-horizontal" accept-charset="UTF-8">
											<div class="form-body">
											<div class="alert alert-danger display-hide">
        										<button class="close" data-close="alert"></button>
        										You have some form errors. Please check below.
        									</div>
        									<div class="alert alert-success display-hide">
        										<button class="close" data-close="alert"></button>
        										Your form validation is successful!
        									</div>
												<h3 class="form-section">Personal Information</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">First Name</label>
															<div class="col-md-9">
																<input type="text" name="can_firstname" data-required="1" class="form-control" placeholder="" value="<?php echo $can_firstname;?>">
																
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Last Name</label>
															<div class="col-md-9">
																<input type="text" name="can_lastname" class="form-control" placeholder="" value="<?php echo $can_lastname;?>">
																
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Gender</label>
															<div class="col-md-9">
																<select name="can_gender" class="form-control">	
																    <?php 
																        if ($can_gender==1){
    																           echo "<option value='1' selected='selected'>Male</option>";
                                                                               echo "<option value='0'>Female </option>";
                                                                           }else{
                                                                               echo "<option value='1'>Male</option>";
                                                                               echo "<option value='0' selected='selected'>Female </option>";
                                                                           }
																    ?>								 
																</select>
																
															</div>
														</div>
													</div>
													<!--/span-->
													
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Date of Birth</label>
															<div class="col-md-9">
																<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
												                    <input type="text" class="form-control" readonly name="can_datebirth" value="<?php echo $can_datebirth;?>">
											                       	<span class="input-group-btn">
												                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												                    </span>
											                     </div>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">DNI/Passport</label>
															<div class="col-md-9">
																<input type="text" name="can_dni" placeholder="DNI Example: 32204489" class="form-control" placeholder="" value ="<?php echo $can_dni;?>">
															</div>
														</div>
													</div>
												</div>
												<h3 class="form-section">Contact Details</h3>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Address</label>
															<div class="col-md-9">
																<input type="text" name="can_adress" class="form-control" value ="<?php echo $can_adress;?>" >
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Email Address</label>
															<div class="col-md-9">
																<input type="text" name="can_email" class="form-control" value ="<?php echo $can_email;?>">
															</div>
															
														</div>
														
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Telephone</label>
															<div class="col-md-9">
																<input type="text" name="can_telephone" class="form-control" placeholder="Example: 3514523456" value ="<?php echo $can_telephone;?>">
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Cellphone</label>
															<div class="col-md-9">
																<input type="text" name="can_cellphone" class="form-control" placeholder="Example: 3515233456 (Without 15)" value ="<?php echo $can_cellphone;?>">
															
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
													<h3 class="form-section">Registration Requirements</h3>
													<!--/span-->
													
													<div class="row">
													 <div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Venue</label>
															<div class="col-md-9">
																<select class="select2_category form-control" name="exp_id" data-placeholder="Choose a Category" tabindex="1">
																	<?php  getOption($session_exa_id, $exp_id);?>
																</select>
															</div>
														</div>
													</div>
													   <div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Special Arragements?</label>
															<div class="col-md-9">
																<div class="radio-list">
    																<?php 
        																if ($can_disability==1){
        																    
        																    echo "<label class='radio-inline'> <input type='radio' onclick='showDisability();' name='can_disability' value='1' checked> Yes </label>";
        																    echo "<label class='radio-inline'> <input type='radio' onclick='hideDisability();' name='can_disability' value='0'> No </label>";
        																}else{
        																    echo "<label class='radio-inline'> <input type='radio' onclick='showDisability();' name='can_disability' value='1'> Yes </label>";
        																    echo "<label class='radio-inline'> <input type='radio' onclick='hideDisability();' name='can_disability' value='0' checked> No </label>";
        																}
    																?>
																	<span class="help-block">
																In case the candidate has any disability pleas select "Yes".  </span>
																</div>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row" >
												   <div class="col-md-6" style="display: <?php echo $display_exa_visa;?>;">
														<div class="form-group">
															<label class="control-label col-md-3">Visa Required?</label>
															<div class="col-md-9">
																<div class="radio-list">
																<?php 
    																if ($can_visa==1){
    																    echo "<label class='radio-inline'> <input type='radio' name='can_visa' value='1' checked> Yes </label>";
    																    echo "<label class='radio-inline'> <input type='radio' name='can_visa' value='0'> No </label>";
    																}else{
    																    echo "<label class='radio-inline'> <input type='radio' name='can_visa' value='1'> Yes </label>";
    																    echo "<label class='radio-inline'> <input type='radio' name='can_visa' value='0' checked> No </label>";
    																}
																?>
																</div>
															</div>
															
														</div>
													</div>
													<div class="col-md-6" style="display: ">
														<div class="form-group">
															<label id="label_can_disabilitycom" class="control-label col-md-3" style="display: <?php echo $display_can_disabilitycom;?>">Description</label>
															<div class="col-md-9">
																<textarea rows ="3" name="can_disabilitycom" class="form-control" style="display: <?php echo $display_can_disabilitycom;?>" placeholder="Please describe in 50 words de special needs of the Candidate"><?php echo $can_disabilitycom;?></textarea>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>											
											</div>
											
											
											
												<h3 class="form-section" style="display:<?php if ($session_use_usertype==2) echo "none;";?>;">Others (Back end)</h3>
													<!--/span-->
													<div class="row" style="display:<?php if ($session_use_usertype==2) echo "none;";?>;">
													 <div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-3">Preparation Center</label>
															<div class="col-md-9">
																<select class="select2_category form-control" name="prc_id" data-placeholder="Choose a Category" tabindex="1">
																	<?php  getOptionPrepCentre($_SESSION["prc_id"], $prc_id);?>
																</select>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
		
		
		
		
                                            <div class="form-actions">
        										<div class="row">
        											<div class="col-md-offset-3 col-md-9">
        												<img alt="" src="../../assets/admin/layout3/img/loading-spinner-blue.gif" id="loading_newupdate" style="display:none;">
        												<button name="can_submit" type="submit" class="btn green"
        													value=""><?php echo $submit;?></button>
        												<button type="button" class="btn default" onclick="redirectCandidatetable(<?php echo $session_exa_id;?>, <?php echo "'".$use_usertype."'";?>, <?php echo ($get_can_id!=NULL? 1 : 0 );?>);">Return</button>
        											
        											</div>									
        										</div>
        										<br/>
        										<p style="color: RED"> Para finalizar la inscripción, debe cambiar el estado a "SENT" en candidate workflow.<p>
        										<!-- Invisible Input -->
        										
        										  <input type="hidden" name="exa_id" value="<?php echo $session_exa_id;?>"/>
        										  <input type="hidden" name="can_id" value="<?php echo $get_can_id;?>"/>
        										<!-- End Invisible Input -->
    									   </div>
										</form>
										<!-- END FORM-->
									</div>
								</div>
								</div>
							    <div class="col-md-8">
								<!-- BEGIN PORTLET-->
                					<div class="portlet light bordered" style="display:<?php echo $show_Fileform;?>">
                						<div class="portlet-title">
                							<div class="caption">
                								<i class="fa fa-cogs font-green-sharp"></i>
                								<span class="caption-subject font-green-sharp bold uppercase">File Input</span>
                								<span class="caption-helper">Max File Allowed (2 MByte) Extensions (pdf, png, jpg, jpeg, gif)</span>
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
                							<!-- BEGIN FORM-->
                							<form name="form5" enctype="multipart/form-data" method="post" action="../classes/class.upload_v32/upload.php" class="form-horizontal form-bordered">
                								<div class="form-body">
                									<div class="form-group">
                										<label class="control-label col-md-3">Payment Receipt</label>
                										
                										<div class="col-md-9">
                    										<div class="fileinput fileinput-new" data-provides="fileinput">
                												<span class="btn default btn-file">
                												<span class="fileinput-new">
                												Select file </span>
                												<span class="fileinput-exists">
                												Change </span>
                												<input type="file" accept="image/jpg, image/png, image/jpeg, image/gif, application/pdf" size="32" name="my_field" value="" id="xhr_field_payment" />
                												</span>
                												<input type="submit"  name="Submit" class="btn blue fileinput-exists" value="upload" id="xhr_upload_payment"/>
                												<span class="fileinput-filename">
                												</span>
                												&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
                												</a>				   
                											</div>          											
                											 <div id="xhr_result_payment"></div> 
                											 	<div id="loading_payment" style="display: none;">
                										             <img alt="" src="../../assets/admin/layout3/img/loading-spinner-blue.gif">
                										       </div>
                										</div>
                									
                									</div>
                									<!-- <div class="form-group"> //DNI Eliminated v2.2
                										<label class="control-label col-md-3">DNI/Passport Scan</label>
                										<div class="col-md-9">
                											<div class="fileinput fileinput-new" data-provides="fileinput">
                												<span class="btn default btn-file">
                												<span class="fileinput-new">
                												Select file </span>
                												<span class="fileinput-exists">
                												Change </span>
                												<input type="file" accept="image/jpg,image/png, image/jpeg, image/gif, application/pdf" size="32" name="my_field" value="" id="xhr_field_dni" />
                												</span>
                												<input type="submit"  name="Submit" class="btn blue fileinput-exists" value="upload" id="xhr_upload_dni"/>
                												<span class="fileinput-filename">
                												</span>
                												&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
                												</a>				   
                											</div>          											
                											<div id="xhr_result_dni"></div>
                											<div id="loading_dni" style="display: none;">
                										             <img alt="" src="../../assets/admin/layout3/img/loading-spinner-blue.gif">
                										    </div>
                										</div>
                									</div>  -->
                									<div class="form-group" style="display: <?php if ($exa_aci==0) echo "none"; ?>;">
                										<label class="control-label col-md-3">Photo Consent Scan</label>
                										<div class="col-md-9">
                											<div class="fileinput fileinput-new" data-provides="fileinput">
                												<span class="btn default btn-file">
                												<span class="fileinput-new">
                												Select file </span>
                												<span class="fileinput-exists">
                												Change </span>
                												<input type="file" accept="image/jpg,image/png, image/jpeg, image/gif, application/pdf" size="32" name="my_field" value="" id="xhr_field_aci" />
                												</span>
                												<input type="submit"  name="Submit" class="btn blue fileinput-exists" value="upload" id="xhr_upload_aci"/>
                												<span class="fileinput-filename">
                												</span>
                												&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
                												</a>				   
                											</div>          											
                											<div id="xhr_result_aci"></div>
                											<div id="loading_aci" style="display: none;">
                										           <img alt="" src="../../assets/admin/layout3/img/loading-spinner-blue.gif">
                										     </div>
                										</div>
                									</div>
                									<div class="form-group" id="file_disability" style="display: <?php echo $display_can_disabilitycom;?>">
                										<label class="control-label col-md-3">Special Consideration Medical Certificate Scan</label>
                										<div class="col-md-9">
                											<div class="fileinput fileinput-new" data-provides="fileinput">
                												<span class="btn default btn-file">
                												<span class="fileinput-new">
                												Select file </span>
                												<span class="fileinput-exists">
                												Change </span>
                												<input type="file" accept="image/jpg,image/png, image/gif, image/jpeg, application/pdf" size="32" name="my_field" value="" id="xhr_field_disability" />
                												</span>
                												<input type="submit"  name="Submit" class="btn blue fileinput-exists" value="upload" id="xhr_upload_disability"/>
                												<span class="fileinput-filename">
                												</span>
                												&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
                												</a>				   
                											</div>          											
                											<div id="xhr_result_disability"></div>
                											<div id="loading_disability" style="display: none;">
                										            <img alt="" src="../../assets/admin/layout3/img/loading-spinner-blue.gif">
                										    </div>
                										</div>
                									</div>
                									

                								</div>
                								
                							</form>
                							<!-- END FORM-->
                						</div>
                						 <p style="color: red"> <br/>Para finalizar la inscripción, debe cambiar el estado a "SENT" en candidate workflow.</p>
                					</div>
                					<!-- END PORTLET-->
							</div>
    							<div class="col-md-4">
    								<!-- BEGIN PORTLET-->
                    					<div class="portlet light bordered" style="display:<?php echo $show_Fileform;?>">
                    					<div class="portlet-title">
                							<div class="caption">
                								<i class="fa fa-cogs font-green-sharp"></i>
                								<span class="caption-subject font-green-sharp bold uppercase">File Check</span>
                							</div>
                							<div class="tools">
                								<a href="javascript:;" class="collapse">
                								</a>
                								<a href="#portlet-config" data-toggle="modal" class="config">
                								</a>
                								<a class="reload" onclick = "reload_filescheck(<?php echo $get_can_id;?>);">
                								</a>
                								<a href="javascript:;" class="remove">
                								</a>
                							</div>
                						</div>
                						<div id="files_check">
                						</div>
                						
                    				
                    				</div>
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
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS USED BY DATE PICKER-->
<script type="text/javascript" src="../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS USED BY TOASTR-->
<script	src="../../assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="../../assets/admin/pages/scripts/ui-toastr.js"></script>
<!-- END PAGE LEVEL SCRIPTS USED BY TOASTR-->

<!-- BEGIN PAGE LEVEL PLUGINS USED BY VALIDATION-->
<script type="text/javascript" src="../../assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS USED BY FILE INPUT-->
<script type="text/javascript" src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS USED BY FILE INPUT-->

<!-- BEGIN PAGE LEVEL STYLES -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
<script src="../../assets/admin/pages/scripts/form-samples.js"></script>
<script src="../../assets/admin/pages/scripts/form-validation.js"></script>
<script src="../../assets/admin/pages/scripts/components-form-tools.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL STYLES -->


<script>
jQuery(document).ready(function() {    
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   FormValidation.init();
   Demo.init(); // init demo features
   FormSamples.init();
   ComponentsFormTools.init();
   UIToastr.init(); //used by toastr
 
});
</script>
<!-- END JAVASCRIPTS -->


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

function newupdateCandidate(){
    var can_dni= this.document.form_candidate.can_dni.value;
    var can_firstname=this.document.form_candidate.can_firstname.value;
    var can_lastname=this.document.form_candidate.can_lastname.value;
    var can_gender=this.document.form_candidate.can_gender.value;
    var can_datebirth=this.document.form_candidate.can_datebirth.value;
    var can_email=this.document.form_candidate.can_email.value;
    var can_adress=this.document.form_candidate.can_adress.value;
    var can_telephone=this.document.form_candidate.can_telephone.value;
    var can_cellphone=this.document.form_candidate.can_cellphone.value;
    var can_visa=this.document.form_candidate.can_visa.value;
    var can_disability=this.document.form_candidate.can_disability.value;     
    var can_disabilitycom=this.document.form_candidate.can_disabilitycom.value;
    var exp_id=this.document.form_candidate.exp_id.value;
    var exa_id=this.document.form_candidate.exa_id.value;
    var prc_id=this.document.form_candidate.prc_id.value;    
    var can_id= this.document.form_candidate.can_id.value;

	if (can_id==""){ //can_id "" = un nuevo registro, en caso contrario se almacena el can_id.
	    mensaje =	"Do you want to add this candidate?";
	    confirmar=confirm(mensaje); 
		if (confirmar) {
    		showLoadingNewupdate();
            $.ajax({
                type:"POST",
                url: "../abm/abm.candidate.php",
                data:{can_dni:can_dni, can_firstname:can_firstname, can_lastname:can_lastname, can_gender:can_gender, 
                      can_datebirth:can_datebirth, can_email:can_email, can_adress:can_adress, can_telephone:can_telephone,
                      can_cellphone:can_cellphone, can_visa:can_visa, can_disability:can_disability, can_disabilitycom:can_disabilitycom,
                      exp_id:exp_id, exa_id:exa_id, prc_id:prc_id, can_id:can_id}, 
                      
                cache: false,
                success : function (msg) {
                   // alert (msg);
                    hideLoadingNewupdate();
                    var new_can_id;
                	new_can_id = parseInt(msg);
                	if (new_can_id==-10)
             		   alert ("Error: There is already a Candidate registered width the same DNI in a recentrly closed exam or in an open Exam");
                	else{
                	   alert ("The candidate was added!. To be confirmed, please complete the documents and the workflow to be verified")
             		   redirect(new_can_id);
                	}    
            	}
            });  
		}   
	}else{
    	showLoadingNewupdate();
        $.ajax({
            type:"POST",
            url: "../abm/abm.candidate.php",
            data:{can_dni:can_dni, can_firstname:can_firstname, can_lastname:can_lastname, can_gender:can_gender, 
                can_datebirth:can_datebirth, can_email:can_email, can_adress:can_adress, can_telephone:can_telephone,
                can_cellphone:can_cellphone, can_visa:can_visa, can_disability:can_disability, can_disabilitycom:can_disabilitycom,
                exp_id:exp_id, prc_id:prc_id, can_id:can_id},
            cache: false,
            success : function (msg) {
            	toast();
            	hideLoadingNewupdate();
        	}
        });    
	}
}   

function showDisability(){
    this.document.form_candidate.can_disabilitycom.style.display = "inline";
    this.document.getElementById("label_can_disabilitycom").style.display = 'inline';
    this.document.getElementById("file_disability").style.display = 'inline';
      }
function hideDisability(){
    this.document.form_candidate.can_disabilitycom.style.display = 'none';
    this.document.getElementById("label_can_disabilitycom").style.display = 'none';
    this.document.getElementById("file_disability").style.display = 'none';
    }

function showLoadingPayment(){
    this.document.getElementById("loading_payment").style.display = 'inline';
    }
function hideLoadingPayment(){
    this.document.getElementById("loading_payment").style.display = 'none';
    }
function showLoadingDni(){
    this.document.getElementById("loading_dni").style.display = 'inline';
      }
function hideLoadingDni(){
    this.document.getElementById("loading_dni").style.display = 'none';
      }
function showLoadingAci(){
    this.document.getElementById("loading_aci").style.display = 'inline';
      }
function hideLoadingAci(){
    this.document.getElementById("loading_aci").style.display = 'none';
      }
function showLoadingDisability(){
    this.document.getElementById("loading_disability").style.display = 'inline';
      }
function hideLoadingDisability(){
    this.document.getElementById("loading_disability").style.display = 'none';
      }
function showLoadingNewupdate(){
    this.document.getElementById("loading_newupdate").style.display = 'inline';
    }
function hideLoadingNewupdate(){
    this.document.getElementById("loading_newupdate").style.display = 'none';
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
	toastr.success('Correctly Updated', 'Candidate');  		        
 }   
function redirect(can_id){
    pagina="candidate_form.php?can_id="+ can_id;
    redireccionar(pagina);	
}

function redirectCandidatetable(exa_id, use_usertype, can_id){
	if (can_id=="0"){
      	mensaje =	"You are leaving the actual page. You will lose the information";
  		confirmar=confirm(mensaje); 
  		if (confirmar) {
          	if (use_usertype=="admin"){
                  pagina="candidate_table_admin.php?exa_id="+exa_id;
                  redireccionar(pagina);
              }else{
              	pagina="candidate_table.php?exa_id="+exa_id;
                  redireccionar(pagina);
                  }
  		}
      }else{
    	  if (use_usertype=="admin"){
              pagina="candidate_table_admin.php?exa_id="+exa_id;
              redireccionar(pagina);
          }else{
          	pagina="candidate_table.php?exa_id="+exa_id;
              redireccionar(pagina);
              }
      }
}
function redireccionar(pagina) {
	{
	location.href=pagina;
	} 
    setTimeout ("redireccionar()", 20000);   
}
function reload_filescheck(can_id, exa_aci){
    $.ajax({
    url:"ajax/ajax.filescheck.php",
    type: "POST",
    data:{can_id:can_id, exa_aci:exa_aci}, 
    success: function(opciones){ 
        $("#files_check").html(opciones);				
    }
    });
}

</script>
<!-- END JAVASCRIPT FUNCTIONS -->
<script type="text/javascript">

//--BEGIN FILES UPLOAD--
window.onload = function () {
	reload_filescheck(<?php echo $get_can_id;?>, '<?php echo $exa_aci;?>'); //exa_aci is to determinate to put or not the line in filecheck
    function xhr_send(f, e, doc_type) { // it was added doc_type to build the file name
        if (f) {
          xhr.onreadystatechange = function(){
            if(xhr.readyState == 4){
              document.getElementById(e).innerHTML = xhr.responseText;
              reload_filescheck(<?php echo $get_can_id;?>, <?php echo $exa_aci;?>);
              if (doc_type=="payment")
            	  hideLoadingPayment();
             // if (doc_type=="dni")
            //	  hideLoadingDni();
              if (doc_type=="aci")
            	  hideLoadingAci();
              if (doc_type=="disability")
            	  hideLoadingDisability();
            } 
          }
      xhr.open("POST", "../classes/class.upload_v32/upload.php?action=xhr&exa_id=<?echo $session_exa_id;?>&can_id=<?php echo $get_can_id;?>&doc_type=" + doc_type);
      xhr.setRequestHeader("Cache-Control", "no-cache");
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.setRequestHeader("X-File-Name", f.name);
      xhr.send(f);
      }
}

function xhr_parse(f, e) {
    if (f) {       
        document.getElementById(e).innerHTML = "File selected : " + f.name + "(" + f.type + ", " + f.size + ")";
    }else {
        document.getElementById(e).innerHTML = "No file selected!";
    }
}

var xhr = new XMLHttpRequest();

if (xhr && window.File && window.FileList) { // it was added the numer to xhr_file to aboid upload the same doc.
    // xhr Payment  
    var xhr_file1 = null;
    var type;
    document.getElementById("xhr_field_payment").onchange = function () {
        xhr_file1 = this.files[0];
        xhr_parse(xhr_file1, "xhr_status_payment");      
    }
    document.getElementById("xhr_upload_payment").onclick = function (e) {
      e.preventDefault();
      type= xhr_file1.type;
      if (type=="image/jpg" || type=="image/png" || type=="image/gif" || type=="image/jpeg" || type== "application/pdf"){ //to avoid diferent Formats (NM)
    	  xhr_send(xhr_file1, "xhr_result_payment", "payment");
    	  showLoadingPayment();
      }else{
  	     alert ("File format Incorrect!. It is only allowed pdf, jpg, jpeg, png, gif formats");
          }
    }
    // xhr DNI
  /*  var xhr_file2 = null;
    document.getElementById("xhr_field_dni").onchange = function () {
      xhr_file2 = this.files[0];
      xhr_parse(xhr_file2, "xhr_status_dni");
    }
    document.getElementById("xhr_upload_dni").onclick = function (e) {
      e.preventDefault();
      type= xhr_file2.type;
      if (type=="image/jpg" || type=="image/png" || type=="image/gif" || type=="image/jpeg" || type== "application/pdf"){//to avoid diferent Formats (NM)
    	  xhr_send(xhr_file2, "xhr_result_dni", "dni");
          showLoadingDni();
      }else{
  	     alert ("File format Incorrect!. It is only allowed pdf, jpg, jpeg, png, gif formats");
          }
    }*/
    // xhr Aci
    var xhr_file3 = null;
    document.getElementById("xhr_field_aci").onchange = function () {
      xhr_file3 = this.files[0];
      xhr_parse(xhr_file3, "xhr_status_aci");
    }
    document.getElementById("xhr_upload_aci").onclick = function (e) {
      e.preventDefault();
      type= xhr_file3.type;
      if (type=="image/jpg" || type=="image/png" || type=="image/gif" || type=="image/jpeg" || type== "application/pdf"){//to avoid diferent Formats (NM)
    	  xhr_send(xhr_file3, "xhr_result_aci", "aci");
          showLoadingAci();
      }else{
  	     alert ("File format Incorrect!. It is only allowed pdf, jpg, jpeg, png, gif formats");
          }
      
    }
    // xhr Disability
    var xhr_file4 = null;
    document.getElementById("xhr_field_disability").onchange = function () {
      xhr_file4 = this.files[0];
      xhr_parse(xhr_file4, "xhr_status_disability");
    }
    document.getElementById("xhr_upload_disability").onclick = function (e) {
      e.preventDefault();
      type= xhr_file4.type;
      if (type=="image/jpg" || type=="image/png" || type=="image/gif" || type=="image/jpeg" || type== "application/pdf"){//to avoid diferent Formats (NM)
    	  xhr_send(xhr_file4, "xhr_result_disability", "disability");
          showLoadingDisability();
      }else{
  	     alert ("File format Incorrect!. It is only allowed pdf, jpg, jpeg, png, gif formats");
          }
     
    }
  }
}
    </script>		
</body>
<!-- END BODY -->
</html>