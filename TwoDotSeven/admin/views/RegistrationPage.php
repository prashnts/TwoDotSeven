<?php

function tRegistrationPage($Step=1, $__Args=FALSE) {
	global $SiteTitle, $SiteSubTitle;
	?>

	<!DOCTYPE html>
	<html lang="en" class="app bg-light">

	<head>
		<meta charset="utf-8" />
		<title>Register an account on <?php echo $SiteTitle . " | " . $SiteSubTitle ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
		<!--[if lt IE 9]> <script src="assets/js/ie/html5shiv.js"></script> <script src="assets/js/ie/respond.min.js"></script> <script src="assets/js/ie/excanvas.js"></script> <![endif]-->
	</head>

	<body class="">
		<section class="hbox stretch">
			<!-- .aside -->
			<?php tShowBar(array('Collapse'=>FALSE));?>
			<!-- /.aside -->
			<section id="content">
				<header class="header bg-black b-b b-dark" style="height:60px;padding:10px;">
					<p style="font-size:25px;margin:0;color:#1AAE88"><strong>Sign Up</strong>
						<?php 
							echo "Step ".(string)$Step;
						?>
					</p>
				</header>
				<section class="hbox stretch">
					<section class="vbox">
						
						<section class="scrollable wrapper">
							<?php 	if (!isset($_COOKIE['notice'])) { ?>
								<div class="CookieNotice alert alert-warning">
									<button type="button" class="close" onclick="setCookie('notice', 1, 14)" data-dismiss="alert">&times;</button>
									<p><strong>This WebSite uses cookies to customize your experience.</strong></p>
									<p>Please read our Terms of Use to know more about our Cookie Usage policy. In no way we track your browsing habits other than this Domain.</p>
								</div>
							<?php 	} ?>
							<div class="row">
								<div class="col-lg-9">
									<!-- .breadcrumb -->
									<ul class="breadcrumb">
										<li><a href="#"><i class="fa fa-home"></i> Home</a>
										</li>
										<li class="active"><a href="#"><i class="fa fa-list-ul"></i> User Account Registration</a>
										</li>
									</ul>
									<!-- / .breadcrumb -->
								</div>
								<div class="col-lg-9">
									<section class="panel panel-default">
										<header class="panel-heading font-bold" style="text-align:center">
											<img src="assets/images/logoinv.png" style="max-width:100%; height:40px">
										</header>
										<div class="panel-body">
											<div id="Messages">
												<?php
													if(gettype($__Args)=='array') { 
															foreach ($__Args['Messages'] as $Message) {
																printf ('<div class="%s">',$Message['UIClass']);
																echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
																printf 	('<p>%s</p>', $Message['Message']);
																echo '</div>';
															}
													}
												?>
											</div>

											<?php
												switch ($Step) {
													case 1:
											?>
														<div id="Step1">
															<form class="bs-example form-horizontal" action="<?php echo $__Args['URI'] ?>" method="POST" >
																<div class="form-group">
																	<label class="col-lg-2 control-label">UserName</label>
																	<div class="col-lg-10">
																		<div id="UN" class="form-group input-group">
																			<input type="text" required class="form-control" name="UserName" placeholder="eg. Bazinga" onchange="AJAXRegister(this.value,'UserName','UN','Unique','User')">
																			<span class="input-group-addon" ><i id="UN-fa" class="fa fa-ellipsis-h"></i></span>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-lg-2 control-label">EMail</label>
																	<div class="col-lg-10">
																		<div id="EM" class="form-group input-group">
																			<input type="email" required class="form-control" name="EMail" placeholder="eg. PrashntS@ducic.ac.in" onchange="AJAXRegister(this.value,'EMail','EM','Unique','UserMeta')">
																			<span class="input-group-addon" ><i id="EM-fa" class="fa fa-ellipsis-h"></i></span>
																		</div>
																	</div>
																</div>
																<div id="PWD-P" class="form-group">
																	<label class="col-lg-2 control-label">Create a Password</label>
																	<div class="col-lg-10">
																		<div class="form-group input-group">
																			<input id="PWD" type="password" required class="form-control" name="Password" placeholder="Create a Password." onkeyup="document.getElementById('PWD-P').className='form-group has-warning'; document.getElementById('PWD-C').value='';document.getElementById('PWD-fa').className='fa fa-ellipsis-h';document.getElementById('PWD-C-fa').className='fa fa-ellipsis-h';" onchange="document.getElementById('PWD-fa').className='fa fa-spinner fa-spin';">
																			<span class="input-group-addon" ><i id="PWD-fa" class="fa fa-ellipsis-h"></i> </span>
																		</div>
																		<div class="form-group input-group">
																			<input id="PWD-C" type="password" required class="form-control" name="ConfPass" placeholder="Confirm Password" onchange="if((document.getElementById('PWD').value==this.value)&&this.value.length>5){document.getElementById('PWD-P').className='form-group has-success';document.getElementById('PWD-fa').className='fa fa-check-circle';document.getElementById('PWD-C-fa').className='fa fa-check-circle';} else {document.getElementById('PWD-P').className='form-group has-error';document.getElementById('PWD-fa').className='fa fa-times-circle';document.getElementById('PWD-C-fa').className='fa fa-times-circle';}">
																			<span class="input-group-addon" ><i id="PWD-C-fa" class="fa fa-ellipsis-h"></i></span>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-lg-2 control-label">Terms of Use</label>
																	<div class="col-lg-10">
																		<div class="form-group checkbox i-checks">
																			<label id="TOU"><input type="checkbox"><i></i> I accept the Terms of Use.
																			</label>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="col-lg-offset-2 col-lg-10">
																		<div class="form-group">
																			<button type="submit" class="btn btn-md btn-outline btn-success" id="SubmitBTN">Proceed</button>
																		</div>
																	</div>
																</div>
															</form>
														</div>
											<?php
														break;
													case 2:
											?>
														<div id="Step2">
															<form class="bs-example form-horizontal" action="<?php echo $__Args['URI'] ?>" method="POST">
																<div class="form-group">
																	<label class="col-lg-2 control-label">Code</label>
																	<div class="col-lg-10">
																		<input type="tel" required class="form-control" name="ConfirmationCode" placeholder="xxxxx">
																		<br>
																		<button type="submit" class="btn btn-md btn-outline btn-success">Proceed</button>
																	</div>
																</div>
															</form>
														</div>
											<?php
														break;
													case 3:
											?>
														<div id="Step3">
															<div class="row">
																<div class="col-lg-12">
																	<img src="ui/images/Ok.jpg" style="max-width:100%; height:250px; z-index:-1;">
																</div>
															</div>
														</div>
											<?php
												}
											?>
										</div>
									</section>
								</div>
							</div>
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
		<script src="assets/js/jquery.js"></script>
		<script type="text/javascript"></script>
		<script type="text/javascript">
			var Click = false;
			$("#TOU").click(function(){
				if(Click) {
					$("$SubmitBtn").attr('disabled', 'true');
				}
				else {
					$("SubmitBTN").attr('disabled', 'false');
				}
			});
		</script>
	</body>

	</html>

	<?php
}
?>