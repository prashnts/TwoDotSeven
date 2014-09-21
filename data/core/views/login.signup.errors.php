<?php
namespace TwoDot7\Admin\Template\Login_SignUp_Error;
use TwoDot7\Admin\Template\Login_SignUp_Error as Node;

#  _____                      _____ 
# /__   \__      _____       |___  |     _   ___              
#   / /\/\ \ /\ / / _ \         / /     | | / (_)__ _    _____
#  / /    \ V  V / (_) |  _    / /      | |/ / / -_) |/|/ (_-<
#  \/      \_/\_/ \___/  (_)  /_/       |___/_/\__/|__,__/___/

/**
 * _init throws the actual Markup.
 * @param	$Data -array- Override Dataset.
 * @param	$Data['Call'] -string- REQUIRED. Specifies function call.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 28062014
 * @version	0.0
 */
function _init($Data = False) {
	?>
	<!DOCTYPE html>
	<html lang="en" class="app bg-dark">
	<head>
		<?php Node\Head($Data); ?>
	</head>
	<body>
		<div class="BG-Primary"></div>
		<div class="BG-Secondary"></div>
		<div class="BG-Secondary-Red-Tint"></div>
		<div class="BG-Secondary-Blue-Tint"></div>
		<div class="BG-Secondary-Green-Tint"></div>
		<div class="BG-Secondary-No-Tint"></div>
		<?PHP Node\Mood($Data); ?>
		<div id="AutogenContainer" class="fill">
			<?php
				if(method_exists("TwoDot7\Admin\Template\Login_SignUp_Error\Render", isset($Data['Call']) ? $Data['Call'] : False)) {
					Node\Render::$Data['Call']($Data);
				}
				else {
					echo "<h1>FATAL ERROR.</h1>";
				}
			?>
		</div>
	</body>
	</html>
	<?php
}

function Head(&$Data) {
	?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven'); ?></title>

	<link rel="shortcut icon" href="/data/core/static/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" href="/data/core/static/images/2.7/apple-touch-icon-precomposed.png" type="image/png" />

	<meta name="msapplication-TileImage" content="/data/core/static/images/2.7/icon-Windows8-tile.png"/>
	<meta name="msapplication-TileColor" content="#343434"/>

	<meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven'); ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="google" content="notranslate" />
	<meta name="generator" content="TwoDotSeven" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" href="/data/core/static/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/font.css" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/app.css" type="text/css" />
	<link rel="stylesheet" href="/assetserver/css/backgroundstyles" type="text/css" />
	<link rel="stylesheet" href="/data/core/static/css/style.css" type="text/css" />

	<script src="/data/core/static/js/jquery.min.js"></script>

	<!--[if lt IE 9]>	
		<script src="/data/core/static/js/ie/html5shiv.js"></script>
		<script src="/data/core/static/js/ie/respond.min.js"></script>
		<script src="/data/core/static/js/ie/excanvas.js"></script>
	<![endif]-->
	<?php
}

function Messages(&$Data) {
	if (gettype($Data)=='array' & isset($Data['Messages'])) { 
		foreach ($Data['Messages'] as $Message) {
			$Class = (function($Message) {
				switch ($Message['Class']) {
					case 'ERROR':
						return 'alert alert-danger alert-block';
					default:
						return 'alert alert-info alert-block';
				}
			});
			printf ('<div class="%s">',$Class($Message));
			printf 	('<p>%s</p>', @$Message['Message']);
			echo '</div>';
		}
	}
	else;
}

function JS() {
	echo '<script src="/data/core/static/js/jquery.min.js"></script>';
	echo '<script src="/data/core/static/js/bootstrap.js"></script>';
	echo '<script src="/data/core/static/js/app.js"></script>';
	echo '<script src="/data/core/static/js/app-direction.js"></script>';
	echo '<script src="/data/core/static/js/slimscroll/jquery.slimscroll.min.js"></script>';
	//echo '<script src="/data/core/static/js/app/SignInUp.js"></script>';
	//echo '<script src="/data/core/static/js/charts/sparkline/jquery.sparkline.min.js"></script>';
}

function Mood(&$Data) {
	if (isset($Data['Mood'])) {
		echo '<!-- Autogenerated Block -->';
		switch ($Data['Mood']) {
			case 'RED':
				echo '<div class="BG-Secondary-Red-Tint" style="display: block; display: initial"></div>';
				break;
			case 'BLUE':
				echo '<div class="BG-Secondary-Blue-Tint" style="display: block; display: initial"></div>';
				break;
			case 'GREEN':
				echo '<div class="BG-Secondary-Green-Tint" style="display: block; display: initial"></div>';
				break;
			case 'WHITE':
				echo '<div class="BG-Secondary-No-Tint" style="display: block; display: initial"></div>';
				break;
		}
	}
}

class Render {
	static function Error(&$Data) {
		$ImageDir = function($Code) {
			switch ($Code) {
				case 404:
					return '2.7-404.png';
				case 403:
					return '2.7-403.png';
				case 500:
					return '2.7-500.png';
				default:
					return '2.7-000.png';
			}
		}
		?>
		<style type="text/css">
			@media(min-width: 768px) {
				.error-autogen {
					width: 100%;
					background-color: transparent;
					position: relative;
					top: 50%;
					-webkit-transform: translateY(-50%);
					-ms-transform: translateY(-50%);
					transform: translateY(-50%);
					text-align: right;
					color: #FFFFFF;
				}
				.error-img-autogen {
					height: 150px;
				}
				.error-msg-autogen {
					text-align: left;
				}
			}
			@media(max-width: 767px) {
				.error-autogen {
					width: 100%;
					height: 150px;
					background-color: transparent;

					top:0;
					bottom: 0;
					left: 0;
					right: 0;
					
					margin: 30% 0 auto 0;

					text-align: center;
					color: #FFFFFF;
				}
				.error-img-autogen {
					height: 100px;
				}
				.error-msg-autogen {
					text-align: center;
				}
			}
			.fill-error {
				height: 100%;
			}
		</style>
		<div class="row error-autogen animated fadeIn">
			<div class="col-sm-4">
				<a href="/" title="TwoDotSeven Home"><img src="/data/core/static/images/2.7<?php echo $ImageDir(@$Data['Code']); ?>" alt="TwoDotSeven Admin" class="error-img-autogen"></a>
			</div>
			<div class="col-sm-8 error-msg-autogen">
				<h2>
					<?php echo isset($Data['ErrorMessageHead']) ? $Data['ErrorMessageHead'] : "Unexpected"; ?>
					<br>
					<small><?php echo isset($Data['ErrorMessageFoot']) ? $Data['ErrorMessageFoot'] : "Unexpected Error Occured"; ?></small>
				</h2>
				<h5>If you see a developer playing around, show them this: <kbd>/TwoDot7:<?php echo isset($Data['ErrorCode']) ? $Data['ErrorCode'] : "Unexpected"; ?>/</kbd></h5>
				<?php echo isset($Data['HideBottomErrorNav']) ? '' : '<h6><a href="/" title="TwoDotSeven Home"><span class="text-white">TwoDotSeven Home</span></a> | <a href="/contact"><span class="text-white">Contact</span></a></h6>'; ?>
			</div>
		</div>
		<?php
	}

	static function Login(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl">
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<form method="POST">
						<div class="list-group">
							<div class="list-group-item Field-Override-Hack">
								<input type="text" placeholder="UserName" name="UserName" class="form-control no-border" required id="Mode1F1">
							</div>
							<div class="list-group-item Field-Override-Hack">
								<input type="password" placeholder="Password" name="Password" class="form-control no-border" required id="Mode1F2">
							</div>
							<div class="list-group-item Field-Override-Hack">
								<div class="checkbox i-checks" style="margin-left:10px;">
									<label>
										<input type="checkbox" checked name="Remember" id="Mode1F3">
										<i></i> Remember me
									</label>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-lg btn-success btn-block">
							Sign in
						</button>
					</form>
					<div class="text-center m-t m-b">
						<a href="/twodot7/recovery/start" id="MoodBlur">
							<small>Forgot password?</small>
						</a
>					</div>
					<p class="text-muted text-center litetxt">
						<small id="MoodBlur">No Account?</small>
					</p>
					<a href="/twodot7/register" class="btn btn-sm btn-primary btn-block">Create an account</a>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function Permission(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl">
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<section class="m-t-lg m-b-lg">
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<section class="panel row panel-default">
						<header class="panel-heading" style="background: #EDEDED">
							<img src="/assetserver/admin/assets/images/generic/icons/extappx120.png"
								width="240px"
								class="img-responsive text-center"
								style="margin: 10px auto;">
						</header>
						<section class="chat-list panel-body">
							<h5>
								<strong><?php echo isset($Data['AppInfo']) ? $Data['AppInfo'] : "UNKNOWN APP" ?></strong>
								 wants to be able to: 
								<?php echo isset($Data['AppPermissions']) ? $Data['AppPermissions'] : "UNKNOWN." ?></h5>
							<hr>
							<img src="/assetserver/admin/assets/images/generic/icons/shieldx120.png" width="50px" style="float:left" class="m-r-sm">
							<h5>Your password will not be shared with this app. You'll be able to remove this app from your User Preferences. </h5>
						</section>
						<footer class="panel-footer" style="background: #EDEDED; border-top: 2px #CBCBCB solid">
							<div class="text-right">
								<a href="<?php echo isset($Data['ProceedButtonURI']) ? $Data['ProceedButtonURI'] : "#" ?>" class="btn btn-primary">Grant Access</a>
								<a href="#" class="btn btn-default">Deny</a>
							</div>
						</footer>
					</section>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function SignUp(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group" id="SignUpForm">
						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required  class="form-control Input-Field-Override-Hack" name="UserName" placeholder="UserName" id="Mode2F1">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F1fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item Field-Override-Hack">
							<div id="EM" class="form-group input-group Field-Margin-Override">
								<input type="email" required class="form-control Input-Field-Override-Hack" name="EMail" placeholder="EMail ID" id="Mode2F2">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F2fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="password" required class="form-control Input-Field-Override-Hack" name="Password" placeholder="Create a Password." id="Mode2F3">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F3fa" class="fa fa-ellipsis-h"></i> </span>
							</div>
							<hr class="No-Margin-Padding-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="password" required class="form-control Input-Field-Override-Hack" name="ConfPass" placeholder="Confirm Password." id="Mode2F4">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F4fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-lg btn-success btn-block" id="Mode2Btn">
						Sign Up
					</button>
					<div class="text-center m-t m-b litetxt">
						<small>By Clicking Sign Up, you agree to the <a href="#">Terms of Use</a>.</small>
					</div>
					<p class="text-center litetxt">
						Already got an Account?
					</p>
					<a href="/admin/login" class="btn btn-sm btn-primary btn-block">Login</a>
				</section>
				<section class="m-b-lg" id="SignUpLoader" style="display:none">
					<div class="loader text-center m-t-lg">
						<img src="/data/core/static/images/loader.gif" alt="TwoDotSeven Admin">
					</div>
					<h3 class="text-center litetxt m-t">
						Please Wait
					</h3>	
					<p class="text-center litetxt m-t-lg">
						Having Trouble?
					</p>
				</section>
				<section class="m-b-lg" id="SignUpOK" style="display:none">
					<div class="loader text-center m-t-lg">
						<img src="/data/core/static/images/tick.png" alt="TwoDotSeven Admin">
					</div>
					<h3 class="text-center litetxt m-t">
						You're In! Redirecting.
					</h3>	
					<p class="text-center litetxt m-t-lg">
						<a href="#">Please click here if you're not redirected automatically.</a>
					</p>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function OK(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
						<div class="text-center litetxt">
							<img src="/data/core/static/images/Okay.png" class="Img-Make-Responsive"><br>
							<a href="/admin/login" class="btn btn-md btn-block btn-primary">Login</a>
						</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function PasswordRecovery(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group">
						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required  class="form-control Input-Field-Override-Hack" name="RecoveryEMail" placeholder="EMail ID" id="Mode4F1">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode4F1fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item go-right">
							<button type="submit" class="btn btn-danger" id="Mode4Btn">
								Send Recovery Link
							</button>
						</div>
					</div>
					<div class="text-center m-t m-b">
						<small><a href="#" class="litetxt" id="MoodBlur">Need Help? Click Here</a></small>
					</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function ResendEmail(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group">
						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required  class="form-control Input-Field-Override-Hack" name="RecoveryEMail" placeholder="EMail ID" id="Mode4F1">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode4F1fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item go-right">
							<button type="submit" class="btn btn-danger" id="Mode4Btn">
								Send Recovery Link
							</button>
						</div>
					</div>
					<div class="text-center m-t m-b">
						<small><a href="#" class="litetxt" id="MoodBlur">Need Help? Click Here</a></small>
					</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function NewPassword(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group">
						<div class="list-group-item Field-Override-Hack">
							<div style="display: none">
								<input type="text" id="Auth" value="<?php echo $Data['Hidden']; ?>">
							</div>
							<div class="form-group input-group Field-Margin-Override">
								<input type="password" required class="form-control Input-Field-Override-Hack" name="Password" placeholder="Create a new Password." id="Mode5F1">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode5F1fa" class="fa fa-ellipsis-h"></i> </span>
							</div>
							<hr class="No-Margin-Padding-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="password" required class="form-control Input-Field-Override-Hack" name="ConfPass" placeholder="Confirm Password." id="Mode5F2">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode5F2fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item go-right">
							<button type="submit" class="btn btn-success" id="Mode5Btn">
								Change &amp; Proceed
							</button>
						</div>
					</div>
					<div class="text-center m-t m-b">
						<small><a href="#" class="litetxt">Need Help? Click Here</a></small>
					</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function EmailVerifyCode(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group">
						<div class="list-group-item Field-Override-Hack">
							<input type="text" required name="UserName" id="Mode3F1" value="<?php echo isset($Data['UserName']) ? $Data['UserName'] : ""; ?>" style="display:none">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required class="form-control Input-Field-Override-Hack" name="VerificationCode" placeholder="Verification Code" id="Mode3F2">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode3F2fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item go-right">
							<button type="submit" class="btn btn-success" id="Mode3Btn">
								Verify &amp; Proceed
							</button>
						</div>
					</div>
					<div class="text-center m-t m-b">
						<small><a href="#" class="litetxt">Need Help? Click Here</a></small>
					</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}

	static function EmailVerify(&$Data) {
		?>
		<section id="content" class="m-t-lg wrapper-md animated fadeIn">
			<div class="container aside-xl"> 
				<div class="logo-container-35px">
					<a href="/" title="Home">
						<img src="/data/core/static/images/2.7/logo-composed.png" alt="TwoDotSeven Admin" width="157px" height="70px">
					</a>
				</div>
				<hr style="margin:9px 0 0 0; padding:0">
				<section class="m-b-lg">
					<header class="text-center litetxt">
						<h3 class="set-font-Open-Sans">
							<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
						</h3>
					</header>
					<h5 class="text-center litetxt Login-Message-Persistant">
						<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
					</h5>
					<div class="messages">
						<?php Node\Messages($Data); ?>
					</div>
					<div class="list-group">
						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required  class="form-control Input-Field-Override-Hack" name="UserName" placeholder="UserName" id="Mode4F1">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode4F1fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>

						<div class="list-group-item Field-Override-Hack">
							<div class="form-group input-group Field-Margin-Override">
								<input type="text" required  class="form-control Input-Field-Override-Hack" name="VerificationCode" placeholder="Verification Code" id="Mode4F2">
								<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode4F2fa" class="fa fa-ellipsis-h"></i></span>
							</div>
						</div>
						<div class="list-group-item go-right">
							<button type="submit" class="btn btn-success" id="Mode4Btn">
								Verify &amp; Proceed
							</button>
						</div>
					</div>
					<div class="text-center m-t m-b">
						<small><a href="#" class="litetxt">Need Help? Click Here</a></small>
					</div>
				</section>
			</div>
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small>Developed in the <a href="http://ducic.ac.in/Hub-IT-Innovations-Lab">IT Innovations Lab</a> | <a href="http://ducic.ac.in/">Cluster Innovation Centre</a>, <a href="http://du.ac.in">University of Delhi</a></small></p>
			</div>
		</footer>
		<script src="/data/core/static/js/app/SignInUp.js"></script>
		<?php
	}
}

?>