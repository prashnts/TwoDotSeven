<?php

function tMessagingPage() {
	global $SiteTitle, $SiteSubTitle;
	?>

	<!DOCTYPE html>
	<html lang="en" class="app bg-light">

	<head>
		<meta charset="utf-8" />
		<title>Messages | <?php echo $SiteTitle . " | " . $SiteSubTitle ?></title>

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
			<?php tShowBar(array('Collapse'=>FALSE, 'Page'=>'Messaging'));?>
			<!-- /.aside -->
			<section id="content">

				<section class="vbox">
					<section class="scrollable">
						<section class="hbox stretch">
							<!-- .aside -->
							<aside class="aside-lg bg-success" id="email-list">
								<section class="vbox">
									<header class="dker header clearfix fix-height-header-hack">
										<div class="btn-group pull-right">
											<button type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-left"></i>
											</button>
											<button type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-right"></i>
											</button>
										</div>
										<div class="btn-toolbar">
											<div class="btn-group select">
												<button class="btn btn-default btn-sm btn-bg dropdown-toggle" data-toggle="dropdown"> <span class="dropdown-label" style="width: 65px;">Filter</span>  <span class="caret"></span> 
												</button>
												<ul class="dropdown-menu text-left text-sm">
													<li><a href="#">Read</a>
													</li>
													<li><a href="#">Unread</a>
													</li>
													<li><a href="#">Starred</a>
													</li>
													<li><a href="#">Unstarred</a>
													</li>
												</ul>
											</div>
											<div class="btn-group">
												<button class="btn btn-sm btn-bg btn-default" data-toggle="tooltip" data-placement="bottom" data-title="Refresh"><i class="fa fa-refresh"></i>
												</button>
											</div>
										</div>
									</header>
									<section class="scrollable hover fix-position-header-hack w-f">
										<ul class="list-group auto no-radius m-b-none m-t-n-xxs list-group-lg">
											<li class="list-group-item">
												<a href="#" class="thumb-sm pull-left m-r-sm">
													<img src="ui/images/UserPic.png" class="img-circle">
												</a>
												<a href="#" class="clear text-ellipsis"> <small class="pull-right">3 minuts ago</small>  <strong class="block">Drew Wllon</strong>  <small>Wellcome and play this web application template </small> 
												</a>
											</li>
											<li class="list-group-item">
												<a href="#" class="thumb-sm pull-left m-r-sm">
													<img src="ui/images/Ok.jpg" class="img-circle">
												</a>
												<a href="#" class="clear text-ellipsis"> <small class="pull-right">1 hour ago</small>  <strong class="block">Jonathan George</strong>  <small>Morbi nec nunc condimentum</small> 
												</a>
											</li>
											<li class="list-group-item">
												<a href="#" class="thumb-sm pull-left m-r-sm">
													<img src="ui/images/NoMeme.jpg" class="img-circle">
												</a>
												<a href="#" class="clear text-ellipsis"> <small class="pull-right">2 hours ago</small>  <strong class="block">Josh Long</strong>  <small>Vestibulum ullamcorper sodales nisi nec</small> 
												</a>
											</li>
											<li class="list-group-item active">
												<a href="#" class="thumb-sm pull-left m-r-sm">
													<img src="ui/images/WhatHaveYouDone.jpg" class="img-circle">
												</a>
												<a href="#" class="clear text-ellipsis"> <small class="pull-right">1 day ago</small>  <strong class="block">Jack Dorsty</strong>  <small>Morbi nec nunc condimentum</small> 
												</a>
											</li>
											
										</ul>
									</section>
									<footer class="footer dk clearfix">
										<form class="m-t-sm">
											<div class="input-group">
												<input type="text" class="input-sm form-control input-s-sm" placeholder="Search">
												<div class="input-group-btn">
													<button class="btn btn-sm btn-default"><i class="fa fa-search"></i>
													</button>
												</div>
											</div>
										</form>
									</footer>
								</section>
							</aside>
							<!-- /.aside -->
							<!-- .aside -->
							<aside id="email-content" class="bg-light lter">
								<section class="vbox">
									<section class="scrollable">
									<header class="dker header clearfix fix-height-header-hack">
										<div class="btn-group pull-right">
											<button type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-left"></i>
											</button>
											<button type="button" class="btn btn-sm btn-bg btn-default"><i class="fa fa-chevron-right"></i>
											</button>
										</div>
										<div class="btn-toolbar">
											<div class="btn-group select">
												<button class="btn btn-default btn-sm btn-bg dropdown-toggle" data-toggle="dropdown"> <span class="dropdown-label" style="width: 65px;">Filter</span>  <span class="caret"></span> 
												</button>
												<ul class="dropdown-menu text-left text-sm">
													<li><a href="#">Read</a>
													</li>
													<li><a href="#">Unread</a>
													</li>
													<li><a href="#">Starred</a>
													</li>
													<li><a href="#">Unstarred</a>
													</li>
												</ul>
											</div>
											<div class="btn-group">
												<button class="btn btn-sm btn-bg btn-default" data-toggle="tooltip" data-placement="bottom" data-title="Refresh"><i class="fa fa-refresh"></i>
												</button>
											</div>
										</div>
									</header>
										<div class="wrapper">
											<P>SOMETHING AWESOME'S COMING!</P>
										</div>
										</div>
									</section>
									<footer class="footer dk clearfix">
										<form class="m-t-sm">
											<div class="input-group">
												<input type="text" class="input-sm form-control input-s-sm" placeholder="Search">
												<div class="input-group-btn">
													<button class="btn btn-sm btn-default"><i class="fa fa-search"></i>
													</button>
												</div>
											</div>
										</form>
									</footer>
								</section>
							</aside>
							<!-- /.aside -->
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
	</body>

	</html>
	<?php
}
?>