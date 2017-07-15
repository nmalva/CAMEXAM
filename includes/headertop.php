<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-48168619-2', 'auto');
ga('send', 'pageview');

</script>
<?php 
include_once ("../classes/class.bd.php");
include_once ("../classes/class.utiles.php");

$string=write_pendings();
global $pendings;


function write_pendings(){
$class_bd=new bd();
global $pendings;
$sql="SELECT * FROM Candidate
      INNER JOIN Exam on Candidate.exa_id = Exam.exa_id
      INNER JOIN TypeExam on Exam.tye_id = TypeExam.tye_id
WHERE (can_status=0 OR can_status=3) AND prc_id={$_SESSION["prc_id"]}";


$resultado = $class_bd->ejecutar($sql);

while($r=$class_bd->retornar_fila($resultado)){
    $pendings++;
    if ($r["can_status"]==0) {//no enviado
        $string.= "<li>";
        $string.= "<a href='candidate_table.php?exa_id={$r["exa_id"]}'>";
        $string.= "<span class='time'>No Enviado</span>";
        $string.= "<span class='details'>";
        $string.= "<span class='label label-sm label-icon label-warning'>";
        $string.= "<i class='fa fa-bell'></i>";
        $string.= "</span>";
        $string.= "{$r["can_lastname"]} - {$r["tye_name"]} </span>";
        $string.= "</a>";
        $string.= "</li>";
    }else{                   //error
        $string.= "<li>";
        $string.= "<a href='candidate_table.php?exa_id={$r["exa_id"]}'>";
        $string.= "<span class='time'>Error</span>";
        $string.= "<span class='details'>";
        $string.= "<span class='label label-sm label-icon label-danger'>";
        $string.= "<i class='fa fa-times-circle-o'></i>";
        $string.= "</span>";
        $string.= "{$r["can_lastname"]} - {$r["tye_name"]} - {$r["can_commentadmin"]} </span>";
        $string.= "</a>";
        $string.= "</li>";
    }


    
         
}
return ($string);
    
}


?>

<div class="page-header-top">
		<div class="container">
			<!-- BEGIN LOGO -->
			<div class="page-logo">
				<a href="exam_menu.php"></a>
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
						<span class="badge badge-default"><?php echo $pendings;?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="external">
								<h3>You Have <strong><?php echo $pendings;?> pending</strong> alarms</h3>
								<a href="javascript:;">view all</a>
							</li>
							<li>       
                                 <ul class='dropdown-menu-list scroller' style='height: 265px; data-handle-color='#637283'>  
							         <?php echo $string;?>
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
						<span class="username username-hide-mobile"><?php echo $_SESSION["prc_name"]?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="login_form.php">
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