<?php

function tBroadcast() {
	global $SiteTitle, $SiteSubTitle;
	?>

	<!DOCTYPE html>
	<html lang="en" class="app bg-light">

	<head>
		<meta charset="utf-8" />
		<title>Broadcast | <?php echo $SiteTitle . " | " . $SiteSubTitle ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
		<link rel="stylesheet" href="assets/js/datepicker/datepicker.css" type="text/css" />
		<link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
		<script src="assets/js/jquery.js"></script>
		<!--[if lt IE 9]> <script src="assets/js/ie/html5shiv.js"></script> <script src="assets/js/ie/respond.min.js"></script> <script src="assets/js/ie/excanvas.js"></script> <![endif]-->
	</head>

	<body class="">
		<section class="hbox stretch">
			<!-- .aside -->
			<?php tShowBar(array('Collapse'=>FALSE, 'Page'=>'Broadcasts'));?>
			<!-- /.aside -->
			<section id="content">
				<section class="vbox">
					<section class="scrollable">
						<section class="hbox stretch">
							<aside class="col-lg-8 b-l no-padder" style="">
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
							<aside class="col-lg-4 b-l no-padder" style="">
LOL
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
		<script src="assets/js/datepicker/bootstrap-datepicker.js"></script>
		<script type="text/javascript">

		</script>
	</body>

	</html>
	<?php
}
?>