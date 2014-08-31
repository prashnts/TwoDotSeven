<?php
namespace TwoDot7\Admin\Template\Dashboard;
use TwoDot7\Admin\Template\Dashboard as Node;

#  _____                      _____ 
# /__   \__      _____       |___  |     _   ___              
#   / /\/\ \ /\ / / _ \         / /     | | / (_)__ _    _____
#  / /    \ V  V / (_) |  _    / /      | |/ / / -_) |/|/ (_-<
#  \/      \_/\_/ \___/  (_)  /_/       |___/_/\__/|__,__/___/

/**
 * _init throws the Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 16072014
 * @version	0.0
 */
function _init($Data = False) {
	?>
	<!DOCTYPE html>
	<html lang="en" class="app bg-light">
	<head>
		<?php Node\Head($Data); ?>
	</head>
	<body>
		<?php Node\Body($Data); ?>
	</body>
	</html>
	<?php
}

function Head($Data) {
	?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven'); ?></title>

	<link rel="shortcut icon" href="/TwoDotSeven/admin/assets/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" href="/TwoDotSeven/admin/assets/images/2.7/apple-touch-icon-precomposed.png" type="image/png" />

	<meta name="msapplication-TileImage" content="/TwoDotSeven/admin/assets/images/2.7/icon-Windows8-tile.png"/>
	<meta name="msapplication-TileColor" content="#343434"/>

	<meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven'); ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="google" content="notranslate" />
	<meta name="generator" content="TwoDotSeven" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/base.css" type="text/css" />
	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/style.css" type="text/css" />
	<link rel="stylesheet" href="/assetserver/css/backgroundstyles" type="text/css" />


	<!--[if lt IE 9]>	
		<script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
	<![endif]-->
	<?php
}

function Body($Data) {
	?>
	<section class="hbox stretch">
		<!-- .aside -->
		<?php Node\Nav($Data);?>
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

						</aside>
					</section>
				</section>
			</section>
			<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
		</section>
	</section>
	<script src="/TwoDotSeven/admin/assets/js/jquery.js"></script>
	<script src="/TwoDotSeven/admin/assets/js/app.js"></script>
	<script src="/TwoDotSeven/admin/assets/js/app/SignInUp.js"></script>
	<?php
}

function Nav($Data) {
	?>
	<aside class="bg-black aside <?php //echo 'spl-header';?>" id="nav">
		<section class="vbox">
			<header class="header header-md navbar navbar-fixed-top-xs bg" style="z-index:9">
				<div class="navbar-header">
					<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="fa fa-bars"></i> 
					</a>
					<a href="index.php" class="navbar-brand">
						<img src="/TwoDotSeven/admin/assets/images/2.7-light.png" class="m-r-sm <?php //echo 'spl-logo';?>" >
						<?php //echo '<img src="assets/images/OneLtSm.png" class="spl-logo-alt">';?>
					</a>
					<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> 
					</a>
				</div>
			</header>
			<section class="w-f scrollable">
				<!-- nav -->
				<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
					<div class="clearfix wrapper dker nav-user hidden-xs spl-user-info">
						<div class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb avatar pull-left m-r"> <img src="/TwoDotSeven/admin/assets/images/generic/alphabet/p.png"> <i class="on md b-black"></i> </span>  <span class="hidden-nav-xs clear"> <span class="block m-t-xs"> <strong class="font-bold text-lt">John.Smith</strong> <b class="caret"></b> </span> 
								<span
								class="text-muted text-xs block">Art Director</span>
									</span>
							</a>
							<ul class="dropdown-menu">
								<?php if (!True) { ?>
									<li> <a href="#">Take a tour</a>
									</li>
									<li> <a href="register.php">Register an Account</a>
									</li>
									<li> <a href="login.php">Login</a>
									</li>
									<li> <a href="#">Help/Support</a> 
									</li>
								<?php }
								else { ?>
									<li> <a href="#">Settings</a> 
									</li>
									<li> <a href="profile.php">Profile</a> 
									</li>
									<li> <a href="#">Help/Support</a> 
									</li>
									<li> <a href="logout.php">Logout</a> 
									</li>
								<?php }?>
							</ul>
						</div>
					</div>
					<!-- nav -->
					<?php
						echo \TwoDot7\Meta\Navigation::Get(False);
					?>
					<!-- / nav -->

				</div>
				<!-- / nav -->
			</section>
			<footer class="footer hidden-xs footer-show-hack text-center-nav-xs dker">
				
			</footer>
		</section>
	</aside>
	<?php
}
?>