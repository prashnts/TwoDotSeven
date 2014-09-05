<?php
namespace TwoDot7\Admin\Template\Dash_Broadcasts_Bits;
use TwoDot7\Admin\Template\Dash_Broadcasts_Bits as Node;

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
		<section class="hbox stretch">
			<aside class="<?php echo isset($Data['NavbarMood']) ? $Data['NavbarMood'] : "bg-black";?> aside" id="nav">
				<section class="vbox">
					<header class="header header-md navbar navbar-fixed-top-xs bg" style="z-index:900">
						<div class="navbar-header">
							<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
								<i class="fa fa-bars"></i> 
							</a>
							<a href="/" class="navbar-brand">
								<!--img src="/TwoDotSeven/admin/assets/images/2.7/2.7-box.png" class="m-r-sm" height="25px"-->
								<img src="/data/core/images/1/logoinv.png" class="m-r-sm" height="25px">
							</a>
							<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
								<i class="fa fa-cog"></i> 
							</a>
						</div>
					</header>
					<section class="w-f scrollable">
						<?php 
							echo \TwoDot7\Meta\Navigation::GetUserNavInfo();
						?>
						<!-- nav -->
						<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
							<?php
								if(isset($Data['Navigation'])) {
									echo $Data['Navigation'];
								}
								else {
									echo \TwoDot7\Meta\Navigation::Get();
								}
							?>
						</div>
					</section>
					<footer class="footer hidden-xs text-center-nav-xs dker">
						<a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
							<i class="fa fa-angle-left text"></i>
							<i class="fa fa-angle-right text-active"></i>
						</a>
					</footer>
				</section>
			</aside>
			<section id="content">
				<?php
					if(method_exists("TwoDot7\Admin\Template\Dash_Broadcasts_Bits\Render", isset($Data['Call']) ? $Data['Call'] : False)) {
						Node\Render::$Data['Call']($Data);
					}
					else {
						echo "<h1>FATAL ERROR.</h1>";
					}
				?>
			</section>
		</section>
		<?php JS(); ?>
	</body>
	</html>
	<?php
}

function Head(&$Data) {
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
	<link rel="stylesheet" href="/data/core/static/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/font.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/app.css" type="text/css" />
	<link rel="stylesheet" href="/assetserver/css/backgroundstyles" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/style.css" type="text/css" />

	<script src="/data/core/static/js/jquery.min.js"></script>
	<!--[if lt IE 9]>	
		<script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
	<![endif]-->
	<?php
}

function JS() {
	echo '<script src="/data/core/static/js/bootstrap.js"></script>';
	echo '<script src="/data/core/static/js/app.js"></script>';
	echo '<script src="/data/core/static/js/masonry.pkgd.min.js"></script>';
	echo '<script src="/data/core/static/js/app-direction.js"></script>';
	echo '<script src="/data/core/static/js/app-broadcast.js"></script>';
	echo '<script src="/data/core/static/js/slimscroll/jquery.slimscroll.min.js"></script>';
	//echo '<script src="/data/core/static/js/app/SignInUp.js"></script>';
	//echo '<script src="/data/core/static/js/charts/sparkline/jquery.sparkline.min.js"></script>';
}

class Render {
	public static function Broadcast($Data) {
		?>
		<section class="scrollable padder bg-light  fill" id="broadcast">
			<div class="m-b-md row padder">
				<div class="col-lg-6">
				</div>
				<div class="col-lg-6">
				</div>
			</div>
			<div class="row m-b-lg">
				<div class="col-lg-8">
					<div class="broadcast-post m-b-lg" id="p">
						<div class="clear row No-Margin-Padding-Override-Hack">
							<textarea type="text" class="form-control m-b-sm" placeholder="Input your comment here" id="broadcast-post-area"></textarea>
							<button class="btn btn-success m-t-xs " type="button">Tag People</button>
							<button class="btn btn-primary m-t-xs pull-right" type="button" id="broadcast-post-btn">Broadcast to Everyone</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					<section class="panel broadcast-clear">
						<ul class="list-group" id="broadcast-container">
						</ul>
						<div>LOADING</div>
					</section>
				</div>
			</div>
		</section>
		<?php
	}
	public static function Dashboard($Data) {
		?>
		<section class="scrollable padder bg-dark  fill">
			<div class="m-b-md row padder">
				<div class="col-lg-6">
					<h3 class="m-b-none">TwoDot7 Dashboard</h3>
				</div>
				<div class="col-lg-6">
				</div>
			</div>
		</section>
		<?php
	}
	public static function UserManagement(&$Data) {
		?>
		<section class="hbox stretch">
			<section class="vbox">
				<section class="scrollable padder">
					<div class="m-b-md row padder">
						<div class="col-lg-6">
							<h3 class="m-b-none">User Management</h3>
							<small>View and Manage the registered Users and their Sessions.</small>
						</div>
						<div class="col-lg-6">
							<div class="text-right m-b-n m-t-sm">

							</div>
						</div>
						<hr>
					</div>
					<div class="container-xs-height m-b-md ">
						<div class="row padder row-xs-height">
							<div class="col-md-3 col-md-height bg-dark lt text-white r-r">
								<div class="wrapper">
									<img src="/TwoDotSeven/admin/assets/images/generic/icons/waitx120.png" class="pull-left m-b m-r-xs">
									<h2 class="text-muted">Warning</h2>
									<h4>Changes made on this Page are <strong>Persistent</strong> and <strong>immediate</strong>.<br>
									<small class="text-white">Please take appropriate care while executing actions.</small></h4>
								</div>
							</div>
							<div class="col-md-9 col-md-height col-top bg-primary lt text-white r-r" style="height:100%">
								<h2 class="text-muted">Quick Stats</h2>
								<p>TODO</p>
							</div>
						</div>
					</div>
					<section class="panel panel-default">
						<div class="table-responsive">
							<table class="table table-striped b-t b-light">
								<thead>
									<th width="5%">ID</th>
									<th width="65%">User</th>
									<th width="30%">Status</th>
								</thead>
								<tbody id="REST_UserManagementTable">
									<tr id="TableToggle1" class="Blur">
										<td>1</td>
										<td>
											<span class="thumb-sm avatar pull-left m-r-sm">
												<img src="/assetserver/userNameIcon/p">
											<span>
											<strong>Loading</strong>
											<p>loading@example.com</p
											<div class="line line-dashed b-b pull-in"></div>
											<div class="row padder">
												<span class="text-primary">Quick Edit</span> |
												<a href="#"><span class="text-success">View Profile</span></a> |
												<a href="#"><span class="text-warning">Send Message</span></a> |
												<a href="#"><span class="text-danger">Delete</span></a>
											</div>
										</td>
										<td>
											<strong class="text-default"><i class="fa fa-envelope-square"></i> Email</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
											<strong class="text-default"><i class="fa fa-user"></i> Profile</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
											<strong class="text-default"><i class="fa fa-power-off"></i> Active Sessions</strong>: <span class="text-success">Loading</span><br>
										</td>
									</tr>
									<tr id="TableToggle1" class="Blur">
										<td>1</td>
										<td>
											<span class="thumb-sm avatar pull-left m-r-sm">
												<img src="/assetserver/userNameIcon/p">
											<span>
											<strong>Loading</strong>
											<p>loading@example.com</p
											<div class="line line-dashed b-b pull-in"></div>
											<div class="row padder">
												<span class="text-primary">Quick Edit</span> |
												<a href="#"><span class="text-success">View Profile</span></a> |
												<a href="#"><span class="text-warning">Send Message</span></a> |
												<a href="#"><span class="text-danger">Delete</span></a>
											</div>
										</td>
										<td>
											<strong class="text-default"><i class="fa fa-envelope-square"></i> Email</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
											<strong class="text-default"><i class="fa fa-user"></i> Profile</strong>: <span class="text-success"><i class="fa fa-check-circle"></i> Loading </span><br>
											<strong class="text-default"><i class="fa fa-power-off"></i> Active Sessions</strong>: <span class="text-success">Loading</span><br>
										</td>
									</tr>
								</tbody>
							</table>
							<div class="AJAXLoader" id="UserListAJAXLoader">
								<h2><img src="/TwoDotSeven/admin/assets/images/generic/728.gif"></h2>
								<h4>Loading</h4>
							</div>
							<div class="AJAXLoadError" id="UserListAJAXLoadError">
								<h2><img src="/TwoDotSeven/admin/assets/images/generic/alertx128.png" width="100px"></h2>
								<h4>Whoops.</h4>
								<h5>A fatal error occured. Please click reload below, or try again later.<br>
								<small>If you think this is an Error, please review the Error Logs.</small></h5>
								<button onclick="GetUserListMarkup()" class="btn btn-primary">Reload</button>
							</div>
						</div>
						<footer class="panel-footer">
							<div class="row">
								<div class="col-sm-4 text-center">
								</div>
								<div class="col-sm-12 text-center text-center-xs">
									<div id="REST_UserManagementPagination">
										<ul class="pagination pagination-sm m-t-none m-b-none">
											<li><a href="#"><i class="fa fa-chevron-left"></i></a>
											</li>
											<li class="active"><a href="#">-</a>
											</li>
											<li><a href="#"><i class="fa fa-chevron-right"></i></a>
											</li>
										</ul>
									</div>
									<small class="text-muted inline m-t-sm m-b-sm" id="REST_UserManagementPageLocation">Page - of -</small> 
								</div>
							</div>
						</footer>
					</section>
				</section>
			</section>
		</section>

		<style>

		</style>
		<?php
	}
	public static function Bit($Data) {
		if (function_exists($Data['View'])) {
			$Data['View']($Data['ViewData']);
			//call_user_func($Data['View']);
		}
		else {
			$Data = array(
				'Mood'=>"RED",
				'ErrorMessageHead' => 'Invalid Path.',
				'ErrorMessageFoot' => 'The path specified in the URL is not handeled by current bit setup.',
				'ErrorCode' => 'UserError: Invalid Bit Action specified.',
				'Code' => 404,
				'Title' => '404 Bit ID not found',
				);

			\TwoDot7\Admin\Template\Login_SignUp_Error\Mood($Data);
			echo '<section class="scrollable padder fill">';

			//echo '<div style="position:relative; height:100%; width:100%" class="scrollable">';
				\TwoDot7\Admin\Template\Login_SignUp_Error\Render::Error($Data);
			//echo '</div>';
			echo '</section>';

		}
	}
	public static function Profile($Data) {
		?>
		<section class="hbox stretch">
			<aside class="col-lg-6 bg-light lt b-r no-padder">
				<section class="vbox">
					<section class="scrollable">
						<div class="wrapper">
							<section class="panel panel-default">
							<div class="panel-heading no-border">
								<div class="clearfix m-b-sm">
									<a href="#" class="pull-left thumb-md avatar b-3x m-r">
										<img src="/assetserver/userNameIcon/p">
									</a>
									<div class="clear">
										<div class="h3 m-t-xs m-b-xs">
											Prashant Sinha
										</div>
									<a href="#" class="btn btn-small btn-default btn-sm pull-right">Edit Profile</a>
										<h5>Student &bullet; B.Tech. IT &bullet; 1<SUP>st</SUP> year</h5> 
									</div>
								</div>
								<hr class="m-t-sm m-b-sm">
								<div class="paffe">
									<div id="epiceditor">
									</div>
										<h3>Academia</h3>
										<h4>Research Interest:</h4>
										<p>Machine learning, Computational Linguistics, Computational Biology</p>
										<h4>Skills and Competence</h4>
										<p>GD, WD etc</p>
										<h3>Projects and Internships</h3>
										<h4>Semester Projects</h4>
										<p>LOL?</p>
										<h4>Innovation Projects</h4>
										<p>Yeahh</p>
									<h3>Personal Info</h3>
									<dl class="dl-horizontal">
										<dt>Mobile</dt>
										<dd>9910134045</dd>
										<dt>Public Email</dt>
										<dd>prashant@ducic.ac.in</dd>
										<dt>Date of Birth</dt>
										<dd>August 11, 1996</dd>
										<dt>Address</dt>
										<dd>108, ITIL, Cluster Innovation Centre, University of Delhi</dd>
									</dl>
								<hr class="m-t-sm m-b-sm">
							</div>
						</section>
						</div>
					</section>
				</section>
			</aside>
			<aside class="col-lg-6 b-l no-padder">
				<section class="vbox">
					<section class="scrollable">
						<div class="wrapper">
							<section class="panel panel-default">
								<form>
									<textarea class="form-control no-border" rows="3" placeholder="What are you doing..."></textarea>
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
								<h4 class="padder">Latest Tweets</h4>
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
		<script type="text/javascript" src="/data/core/static/js/markdown/js/epiceditor.min.js"></script>
		<script type="text/javascript">
			var opts = {
				container: 'epiceditor',
				textarea: null,
				basePath: '/data/core/static/js/markdown',
				clientSideStorage: true,
				localStorageName: 'epiceditor',
				useNativeFullscreen: false,
				parser: marked,
				file: {
					name: 'epiceditor',
					defaultContent: '',
					autoSave: 100
				},
				theme: {
					base: '/themes/base/epiceditor.css',
					preview: '/themes/preview/github.css',
					editor: '/themes/editor/epic-light.css'
				},
				button: {
					preview: true,
					fullscreen: true,
					bar: "auto"
				},
				focusOnLoad: false,
				shortcut: {
					modifier: 18,
					fullscreen: 70,
					preview: 80
				},
				string: {
					togglePreview: 'Toggle Preview Mode',
					toggleEdit: 'Toggle Edit Mode',
					toggleFullscreen: 'Enter Fullscreen'
				},
				autogrow: true
			}
			var editor = new EpicEditor(opts).load();
		</script>
		<?php
	}
}