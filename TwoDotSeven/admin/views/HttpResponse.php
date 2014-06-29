<?php

function afGetDescription($Code) {
	switch($Code) {
		case 404:	return 'The resource thou requested doesn\'t exists.<br>Sorry about that.';
		case 400:	return 'What have you done?! Did you enter the URL on your own? Please double-check it.';
		case 403:	return 'Back-up, aye! Ye art not allow\'d hither. Go back from whence thou hast came from.';
		case 500:	return 'Forgive us. Our server is not responding. We are fixing this error.';
		default:	return 'Aliens are invading our servers, leave the internet and grab a tin-foil hat asap!';
	}
}

function afGetImage($Code) {
	switch($Code) {
		case 404:	return 'ui/images/SadFrown.jpg';
		case 400:	return 'ui/images/NoMeme.jpg';
		case 403:	return 'ui/images/WhatHaveYouDone.jpg';
		case 500:	return 'ui/images/SadCrying.jpg';
		default:	return 'ui/images/RageFace.jpg';
	}
}

function tHttpResponse($Code) {
	http_response_code($Code);
	global $SiteTitle, $SiteSubTitle, $SiteFooter;
	?>

	<!DOCTYPE html>
	<html lang="en" class="bg-dark">

	<head>
		<meta charset="utf-8" />
		<title><?php echo (string)$Code . " | " . $SiteTitle . " | " . $SiteSubTitle ?></title>
		<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
		<!--[if lt IE 9]> <script src="js/ie/html5shiv.js"></script> <script src="js/ie/respond.min.js"></script> <script src="js/ie/excanvas.js"></script> <![endif]-->
	</head>

	<body class="">
		<section id="content">
			<div class="img" >
				<img src="<?php echo afGetImage($Code) ?>" style="position:fixed; z-index:-1; left:0; bottom:0; max-width:100%;width:400px">
			</div>
			<div style="background:rgba(34,39,51,0.7);">
				<div class="row m-n">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="text-center m-b-lg">
							<h1 class="h text-white animated fadeInDownBig" style="color:#C2E6E7"><?php echo $Code;?></h1>
							<p class="text-white animated" style="color:#C2E6E7">
								<span style="font-size:2em"><?php echo afGetDescription($Code);?></span>
								<br>
								<span style="font-size:1.2em">If you believe this error is an error (error-ception), you can contact us on <strong><a href="mailto:one@ducic.ac.in">one@ducic.ac.in</a></strong>.</span>
							</p>
						</div>
					</div>
					<div class="col-sm-4 col-sm-offset-4">
						<div class="list-group bg-info auto m-b-sm m-b-lg">
							<a href="index.php" class="list-group-item"> <i class="fa fa-chevron-right icon-muted"></i>  <i class="fa fa-fw fa-home icon-muted"></i> Goto homepage</a>
							<a href="mailto:one@ducic.ac.in" class="list-group-item"> <i class="fa fa-chevron-right icon-muted"></i>  <span class="badge bg-danger lt">one@ducic.ac.in</span>  <i class="fa fa-fw fa-envelope icon-muted"></i> EMail Us</a>
							<p style="padding:10px; text-align:center"><img src="assets/images/logoinv.png" style="height:40px; width:auto; max-width:100%"></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- footer -->
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p> <small><?php echo $SiteFooter;?></small> 
				</p>
			</div>
		</footer>
		<!-- / footer -->
		<!-- Bootstrap -->
		<!-- App -->
	</body>

	</html>
	<?php
}
?>