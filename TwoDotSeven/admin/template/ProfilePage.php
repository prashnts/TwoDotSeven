<?php

function tProfilePage($Mode, $Data) {
	global $SiteTitle, $SiteSubTitle;
	?>

	<!DOCTYPE html>
	<html lang="en" class="app bg-light">

	<head>
		<?php atfPutHead(); ?>
	</head>

	<body class="">
		<section class="hbox stretch">
			<!-- .aside -->
			<?php tShowBar(array('Collapse'=>FALSE, 'Page'=>'People'));?>
			<!-- /.aside -->
			<section id="content">
				<section class="vbox">
					<section class="scrollable">
						<section class="hbox stretch">
							<aside class="aside-lg bg-dark lter b-r lt">
								<section class="vbox">
									<section class="scrollable">
										<div class="wrapper">
											<?php
											if($Mode==='View') {
												atfPutViewProfilePanel($Data);
											}
											elseif($Mode==='Edit' & $Data['Depth']==='Private') {
												atfPutEditProfilePanel($Data);
											} ?>
										</div>
									</section>
								</section>
							</aside>
							<aside class="col-lg-4 b-l no-padder" style="">
								<section class="vbox">
									<section class="scrollable">
										<div class="wrapper">
											<section class="panel panel-default bg-">
												<form>
													<textarea class="form-control no-border" rows="3" placeholder="Broadcast to everyone."></textarea>
												</form>
												<footer class="panel-footer bg-light lter">
													<button class="btn btn-info pull-right btn-sm">POST</button>
													<ul class="nav nav-pills nav-sm">
														<li><a href="#"><i class="fa fa-camera text-muted"></i></a>
														</li>
														<li><a href="#"><i class="fa fa-video-camera text-muted"></i></a>
														</li>
													</ul>
												</footer>
											</section>
											<section class="panel panel-default">
												<h4 class="padder">Your Feeds</h4>
												<ul class="list-group">
													<li class="list-group-item">
														<p>Wellcome <a href="#" class="text-info">@Drew Wllon</a> and play this web application template, have fun1</p>
														<small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
													</li>
													<li class="list-group-item">
														<p>Morbi nec <a href="#" class="text-info">@Jonathan George</a> nunc condimentum ipsum dolor sit amet, consectetur</p>
														<small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
													</li>
													<li class="list-group-item">
														<p><a href="#" class="text-info">@Josh Long</a> Vestibulum ullamcorper sodales nisi nec adipiscing elit.</p>
														<small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
													</li>
												</ul>
											</section>
											<section class="panel clearfix bg-primary dk">
												<div class="panel-body">
													<a href="#" class="thumb pull-left m-r">
														<img src="images/a0.jpg" class="img-circle b-a b-3x b-white">
													</a>
													<div class="clear"> <a href="#" class="text-info">@Mike Mcalidek <i class="fa fa-twitter"></i></a>  <small class="block text-muted">2,415 followers / 225 tweets</small>  <a href="#" class="btn btn-xs btn-info m-t-xs">Follow</a>
													</div>
												</div>
											</section>
										</div>
									</section>
								</section>
							</aside>
						</section>
					</section>
				</section>
				<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
			</section>
		</section>
		<!-- Bootstrap -->
		<!-- App -->
		<script src="assets/js/ajax-public-lib.js"></script>
		<script src="assets/js/app.v1.js"></script>
		<script src="assets/js/app.plugin.js"></script>
		<script src="assets/js/cookies.js"></script>
		<script src="assets/js/jquery-ui-core.js"></script>
		<script src="assets/js/datepicker/bootstrap-datepicker.js"></script>
		<link rel="stylesheet" href="assets/js/datepicker/datepicker.css" type="text/css" />
		<script src="assets/js/app/Profile.js" type="text/javascript"></script>
	</body>

	</html>
	<?php
}

function atfPutEditProfilePanel($Data) {
	?>
	<!--
		
	-->
	<section class="panel position-hack no-border <?php echo $Data['UIClass']?>" id='Basis'>
		<div id="UserProfileEditColorStudent" class="UserProfileBackgroundEdit ColorStudent" style="display: <?php echo $Data['Designation']==1 ? 'all' : 'none' ?>"></div>
		<div id="UserProfileEditColorFaculty" class="UserProfileBackgroundEdit ColorFaculty" style="display: <?php echo $Data['Designation']==2 ? 'all' : 'none' ?>"></div>
		<div id="UserProfileEditColorStaff" class="UserProfileBackgroundEdit ColorStaff" style="display: <?php echo $Data['Designation']==3 ? 'all' : 'none' ?>"></div>
		<div id="UserProfileEditColorAdmin" class="UserProfileBackgroundEdit ColorAdmin" style="display: <?php echo $Data['Designation']>3 ? 'all' : 'none' ?>"></div>
		<div id="UserProfileEditColorLoading" class="UserProfileBackgroundEdit ColorLoading" style="display: none"></div>
		<div class="cover-pic" style="background: url(<?php echo $Data['CoverLocation']; ?>); background-size:cover"></div>
		<div class="panel-body">
			<div class="row m-t-xl">
				<div class="col-xs-12 text-center">
					<div class="">
						<div class="thumb-lg" style="position:relative">
							<i class="fa fa-<?php echo $Data['Badge'] ? 'check' : 'times'; ?> VerifyBadge"></i>
							<img src="<?php echo $Data['DPLocation'];?>" class="dp-circle">
							<div class="dp-overlay" id="overlay">
								<i class="fa fa-upload"></i>
								<small>Upload New</small>
							</div>
								<!--  -->
							<div class="overlay-transparent">

							</div>
						</div>

						<div class="h4 m-t m-b-xs text-lt">
							<div class="col-sm-12">
								<input class="form-control input-lg array" name="dName" required type="text" placeholder="Your Name" value="<?php echo (strlen($Data['Name'])>3) ? $Data['Name'] : ''; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="wrapper m-t m-b">
				<div class="row text-center">
					<div class="m-b-sm">
						<h4 data-toggle="tooltip" data-placement="top" title="You can change your EMail address in Account Settings."><i class="fa fa-globe small"></i> <a href="mailto:<?php echo $Data['EMail'];?>"><?php echo $Data['EMail'];?></a></h4>
					</div>
					<div class="m-b-sm">
						<div class="btn-group go-center" data-toggle="buttons">
							<input type="text" value="<?php echo $Data['Designation']; ?>" style="display:none" id="DesignationPrevious">
							<label class="btn btn-sm btn-primary inlineBTNHack" id="OptionStudent" data-toggle="tooltip" data-placement="top" title="Register a Student's account.">
								<input type="radio" name="dDesignationCode" id="option1" value="1">
								<i class="fa fa-check text-active"></i> Student
							</label>
							<label class="btn btn-sm btn-success inlineBTNHack" id="OptionFaculty" data-toggle="tooltip" data-placement="top" title="Register a Faculty Member's account.">
								<input type="radio" name="dDesignationCode" id="option2" value="2">
								<i class="fa fa-check text-active"></i> Faculty
							</label>
							<label class="btn btn-sm btn-info inlineBTNHack" id="OptionStaff" data-toggle="tooltip" data-placement="top" title="Register a Staff's account.">
								<input type="radio" name="dDesignationCode" id="option3" value="3">
								<i class="fa fa-check text-active"></i> Staff
							</label>
							<label class="btn btn-sm btn-dark inlineBTNHack" id="OptionAdmin" data-toggle="tooltip" data-placement="top" title="Register an Admin's account. This requires top-level clearance.">
								<input type="radio" id="option4">
								<i class="fa fa-check text-active"></i> Admin
							</label>
						</div>
					</div>
				</div>
				<div class="row m-b" id="AdminOptions"  style="display:<?php echo ($Data['Designation']>=4) ? 'all' : 'none'; ?>">
					<div class="col-xs-12 text-center">
						<p>Your Designation:</p>
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-sm btn-dark inlineBTNHack <?php echo ($Data['Designation']==4) ? 'active' : ''; ?>" id="OptionStudentSec" data-toggle="tooltip" data-placement="top" title="Select this if you're a Student.">
								<input type="radio" name="dDesignationCode" id="option1" value="4">
								<i class="fa fa-arrow-circle-down text-active"></i> Student
							</label>
							<label class="btn btn-sm btn-dark inlineBTNHack <?php echo ($Data['Designation']==5) ? 'active' : ''; ?>" id="OptionFacultySec" data-toggle="tooltip" data-placement="top" title="Select this if you're a Faculty.">
								<input type="radio" name="dDesignationCode" id="option2" value="5">
								<i class="fa fa-arrow-circle-down text-active"></i> Faculty
							</label>
							<label class="btn btn-sm btn-dark inlineBTNHack <?php echo ($Data['Designation']==6) ? 'active' : ''; ?>" id="OptionStaffSec" data-toggle="tooltip" data-placement="top" title="Select this if you're a Staff.">
								<input type="radio" name="dDesignationCode" id="option2" value="6">
								<i class="fa fa-arrow-circle-down text-active"></i> Staff
							</label>
						</div>
					</div>
				</div>
				<div class="text-center" id="AJAXContainer">
					<p><img src="assets/images/loader.gif" id="AJAXLoading" style="display:none"></p>
					<p><i class="fa fa-check-circle" style="color:#FFF; font-size:48px; display:none"></i></p>
					<p><i class="fa fa-times-circle" style="color:#FFF; font-size:48px; display:none"></i></p>
					<p id="AJAXResponse" style="color:#FFF; display: none">Working.</p>
				</div>
				<div class="row m-b text-center" id="DesignationConfirm" style="display:none">
					<p class="text-light" style="margin:0"><i class="fa fa-exclamation-triangle" style="font-size:26px; color:#B9B9B9"></i></p>
					<p style="color:#FFFFFF;margin:0">Please confirm the change by clicking the <kbd>Proceed</kbd> Button below.</p>
					<p style="color:#FFFFFF">This change will require (re)verification of your Account. <a href="helper/topic/verification" target="blank">Need Help?</a></p>
					<a class="btn btn-md btn-primary" id="DesignationConfirmBtnProceed">Proceed</a>
					<a class="btn btn-md btn-default" id="DesignationConfirmBtnReset">Reset</a>
				</div>
				<div class="row m-b" id="FacultyDetail"  style="display:<?php echo ($Data['Designation']==2||$Data['Designation']==5) ? 'all' : 'none'; ?>">
					<div class="col-xs-12 text-center"> Designation <i class="fa fa-globe" data-toggle="tooltip" data-placement="right" title="Visible to all"></i>
						<div class="text-lt font-bold">
							<input class="form-control input-sm go-transparent go-center" required name="dDesignationMetaFaculty" type="text" placeholder="eg. Lecturer, Differential Equations" value="<?php if(strlen($Data['DesignationMeta']['Designation'])) echo $Data['DesignationMeta']['Designation']; ?>">
						</div>
					</div>
				</div>
				<div class="row m-b" id="StudentDetail" style="display:<?php echo ($Data['Designation']==1||$Data['Designation']==4) ? 'all' : 'none'; ?>">
					<div class="col-xs-6 text-right">
						<small>Course</small>
						<i class="fa fa-globe" data-toggle="tooltip" data-placement="left" title="Visible to all"></i>
						<div class="text-lt">
							<button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle go-transparent go-right" name="dCourse">
								<span class="dropdown-label"><?php if($Data['DesignationMeta']['Course']) echo $Data['DesignationMeta']['Course']; else echo 'Select One';?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-select" style="width:100%">
								<?php
									foreach (array('Innovation' => 'B.Tech Innovation', 'Humanities' => 'B.Tech Humanities', 'MME' => 'MME') as $Value => $Name) {
										echo '<li '. (strtolower($Data['DesignationMeta']['Course'])==strtolower($Value) ? 'class="active" >' : '>') ;
										echo '<a href="#"><input type="radio" name="dCourse" value="'.$Value.'">'.$Name.'</a>';
										echo '</li>';
									}
								?>
								
							</ul>
						</div>
					</div>
					<div class="col-xs-6">
						<small>Semester</small>
						<i class="fa fa-globe" data-toggle="tooltip" data-placement="right" title="Visible to all"></i>
						<div class="text-lt">
							<button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle go-transparent go-left" name="dSemester">
								<span class="dropdown-label"><?php if($Data['DesignationMeta']['Semester']) echo $Data['DesignationMeta']['Semester']; else echo 'Select One';?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-select" style="">
								<?php 
									for ($Cursor = 1; $Cursor <=8; $Cursor++) {
										echo '<li' . ($Data['DesignationMeta']['Semester'] == $Cursor ? ' class="active">' : '>') ;
										echo '<a href="#"><input type="radio" name="dSemester" value="' . $Cursor . '"' . (($Data['DesignationMeta']['Semester'] == $Cursor) ? ' checked' : '') . '>'.$Cursor.'</a>';
										echo '</li>';
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="row m-b" id="StaffDetail"  style="display:<?php if($Data['Designation']==3||$Data['Designation']==6) echo 'all'; else echo 'none'; ?>">
					<div class="col-xs-12 text-center"> Job Title <i class="fa fa-globe" data-toggle="tooltip" data-placement="right" title="Visible to all"></i>
						<div class="text-lt font-bold">
							<input class="form-control input-sm go-transparent go-center" name="dDesignationMetaStaff" type="text" placeholder="eg. Librarian etc." value="<?php echo ($Data['DesignationMeta']['Title']) ? $Data['DesignationMeta']['Title'] : '';?>">
						</div>
					</div>
				</div>

				<div class="row m-b">
					<div class="col-xs-6 text-right">
						<small>ID</small> <i class="fa fa-lock"></i>
						<div class="text-lt font-bold"><input class="form-control input-sm go-transparent go-right" type="text" name="dCode" placeholder="eg. MIT@72174" value="<?php if($Data['DesignationMeta']['Code']) echo $Data['DesignationMeta']['Code']; ?>"></div>
					</div>
					<div class="col-xs-6"> <small>Date of Birth</small> <i class="fa fa-lock"></i>
						<div class="text-lt">
							<input class="input-sm input-s datepicker-input form-control go-transparent go-left" type="text" name="dDateOfBirth" value="<?php echo ($Data['DateOfBirth']) ? $Data['DateOfBirth'] : '';?>" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
						</div>
					</div>
				</div>
				<div class="row m-b">
					<div class="col-xs-6 text-right">
						<small>Cell Phone</small>
						<i class="fa fa-lock"></i>
						<div class="text-lt font-bold">
							<input class="form-control input-sm go-transparent go-right" name="dCellPhone" type="tel" placeholder="eg. 09999912345" value="<?php if($Data['CellPhone']) echo $Data['CellPhone']; ?>">
						</div>
					</div>
					<div class="col-xs-6">
						<small>Gender</small>
						<i class="fa fa-lock"></i>
						<div class="text-lt font-bold">
							<button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle go-transparent go-left" name="dGender">
								<span class="dropdown-label"><?php if($Data['Gender']) echo $Data['Gender']; else echo 'Select One';?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-select" style="width:100%">
								<li <?php if($Data['Gender']==='Female') echo 'class="active"'; ?>>
									<a href="#">
										<input type="radio" name="dGender" value="Female">Female
									</a>
								</li>
								<li <?php if($Data['Gender']==='Male') echo 'class="active"'; ?>>
									<a href="#">
										<input type="radio" name="dGender" value="Male">Male
									</a>
								</li>
								<li <?php if($Data['Gender']==='Other') echo 'class="active"'; ?>>
									<a href="#">
										<input type="radio" name="dGender" value="Other">Other
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row m-b">
					<div class="col-xs-12 text-center"> Address <i class="fa fa-lock"></i>
						<div class="text-lt font-bold">
							<textarea class="form-control input-sm go-transparent go-center" name="dAddress" type="text" placeholder="eg. 39, RK Puram Sector 3, New Delhi"><?php if($Data['Address']) echo $Data['Address']; ?></textarea>
						</div>
					</div>
				</div>
				<div class="row m-b">
					<div class="col-xs-12 text-center">
						<div class="text-lt font-bold">
							<button type="Submit" class="btn btn-lg btn-info" id="BtnSave"><i class="fa fa-spin"></i> Save Info</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="panel-footer dk text-center no-border">
			<div class="row pull-out">
				<div class="col-xs-4">
					<div class="padder-v"> <span class="m-b-xs h3 block text-white">245</span>  <small class="text-muted">Followers</small>
					</div>
				</div>
				<div class="col-xs-4 dker">
					<div class="padder-v"> <span class="m-b-xs h3 block text-white">55</span>  <small class="text-muted">Following</small>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="padder-v"> <span class="m-b-xs h3 block text-white">2,035</span>  <small class="text-muted">Tweets</small>
					</div>
				</div>
			</div>
		</footer>
	</section>
	<?php
}

function atfPutViewProfilePanel($Data) {
	?>
	<!--
		Generated By: CIC One UI Engine.
		Debug Mode is: On.
		Author: Prashant Sinha
	-->
	<section class="panel no-border position-hack <?php echo $Data['UIClass'];?>">
		<div class="cover-pic" style="background: url(<?php echo $Data['CoverLocation']; ?>); background-size:cover;"></div>
		<div class="panel-body">
			<div class="row m-t-xl">
				<div class="col-xs-12 text-center">
					<div class="">
						<div class="thumb-lg" style="position:relative">
							<i class="fa fa-<?php echo $Data['Badge'] ? 'check' : 'times'; ?> VerifyBadge"></i>
							<img src="<?php echo $Data['DPLocation'];?>" class="dp-circle">
						</div>
						<div class="h4 m-t m-b-xs text-lt">
							<div class="col-sm-12">
								<div class="h4 m-t m-b-xs font-bold text-lt">
									<?php if(strlen($Data['Name'])>2) echo $Data['Name']; else echo 'Not Shared.';?>
								</div>
								<h5>@<?php echo $Data['UserName'];?></h5>
								<small class="text-muted m-b"><?php echo $Data['Bio'];?></small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper m-t-l m-b">
				<?php if($Data['Depth'] == 'Private' | $Data['Depth'] == 'Public') { ?>
					<div class="m-b-sm text-center">
						<h5><i class="fa fa-globe small text-lt"></i> 
							<a href="mailto:<?php echo $Data['EMail'];?>">
								<?php echo $Data['EMail'];?>
							</a>
						</h5>
					</div>
				<?php } ?>
				<?php if($Data['Depth'] == 'Private') { ?>
					<div class="row m-b">
						<div class="col-xs-6 text-right"> <small>Roll Number/ID</small> <i class="fa fa-lock"></i>
							<div class="text-lt"><?php if ($Data['DesignationMeta']['Code']) echo $Data['DesignationMeta']['Code']; else echo 'Unspecified.';?></div>
						</div>
						<div class="col-xs-6"> <small>Date of Birth</small> <i class="fa fa-lock"></i>
							<div class="text-lt">
								<?php if($Data['DateOfBirth']) echo $Data['DateOfBirth']; else echo 'Not Shared.';?>
							</div>
						</div>
					</div>
					<div class="row m-b">
						<div class="col-xs-6 text-right"> <small>Cell Phone</small> <i class="fa fa-lock"></i>
							<div class="text-lt"><?php if($Data['CellPhone']) echo $Data['CellPhone'];else echo 'Not Shared.';?></div>
						</div>
						<div class="col-xs-6"> <small>Gender</small> <i class="fa fa-lock"></i>
							<div class="text-lt"><?php if($Data['Gender']) echo $Data['Gender']; else echo 'Unspecified.';?></div>
						</div>
					</div>
					<div class="row m-b">
						<div class="col-xs-12 text-center"> Address <i class="fa fa-lock"></i>
							<div class="text-lt"><?php if($Data['Address']) echo $Data['Address']; else echo 'Not Shared.'; ?></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<footer class="panel-footer dk text-center no-border">
			<div class="row text-centre">
				<a href="#" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-envelope"></i> Message</a>
			</div>
		</footer>
	</section>
	<?php
}
?>