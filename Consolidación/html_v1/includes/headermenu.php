<?php 

$session_use_usertype=$_SESSION["use_usertype"];
$display_admin=(($session_use_usertype== 0 or $session_use_usertype== 1)  ? "inline": "none");

?>
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
					<li>
						<a href="exam_menu.php">Home</a>
					</li>
					<li class="menu-dropdown mega-menu-dropdown " style="display: <?php echo $display_admin;?>;">
						<a data-toggle="dropdown" href="javascript:;" class="dropdown-toggle">
						Admin <i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu" style="min-width: 710px">
							<li>
								<div class="mega-menu-content">
									<div class="row">
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Exam</h3>
												</li>
												<li>
													<a href="exam_table.php" class="iconify">
													<i class="glyphicon glyphicon-align-justify"></i>
													List of Exam </a>
												</li>
												<li>
													<a href="exam_type.php" class="iconify">
													<i class="glyphicon glyphicon-align-justify"></i>
													Exam Type </a>
												</li>
												<li>
													<a href="exam_form.php" class="iconify">
													<i class="glyphicon glyphicon-plus"></i>
													New Exam </a>
												</li>
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>Preparation Centre</h3>
												</li>
												<li>
													<a href="prepcentre_table.php" class="iconify">
													<i class="glyphicon glyphicon-align-justify"></i>
													List of Prep Centre </a>
												</li>
												<li>
													<a href="venue_table.php" class="iconify">
													<i class="glyphicon glyphicon-align-justify"></i>
													Venues </a>
												</li>
												<li>
													<a href="layout_mega_menu_fixed.html" class="iconify">
													<i class="glyphicon glyphicon-plus"></i>
													New Preparation Centre </a>
												</li>
	
											</ul>
										</div>
										<div class="col-md-4">
											<ul class="mega-menu-submenu">
												<li>
													<h3>User</h3>
												</li>
												<li>
													<a href="layout_click_dropdowns.html" class="iconify">
													<i class="glyphicon glyphicon-align-justify"></i>
													List of Users </a>
												</li>
												<li>
													<a href="layout_mega_menu_fixed.html" class="iconify">
													<i class="glyphicon glyphicon-plus"></i>
													New User </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
			<!-- END MEGA MENU -->
		</div>
	</div>