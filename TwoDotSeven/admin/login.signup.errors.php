<?php
namespace TwoDot7\Admin\Template\Login_SignUp_Error;

function _init() {

}

function Head() {
	?>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven Error'); ?></title>

	<link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon-precomposed" href="/assets/images/apple-touch-icon.png" type="image/png" />

	<meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven Configuration Error'); ?>" />
	<meta name="robots" content="index, follow" />
	<meta name="google" content="notranslate" />
	<meta name="author" content="<?php echo $SEOMeta['Author'];?>" />
	<meta name="generator" content="<?php echo $SEOMeta['Generator'];?>" />

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/base.css"	type="text/css" />
	<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/style.css"	type="text/css" />

	<script src="/TwoDotSeven/admin/assets/js/jquery.js"></script>

	<!--[if lt IE 9]>	
		<script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
		<script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
	<![endif]-->
	<?php
}

?>
<!DOCTYPE html>
<html lang="en" class="app bg-dark">

<head>
	<?php atfPutHead(); ?>
</head>

<body>
	<div class="Bg-Gen-Hack-Non-Blur"></div>
	<div class="Bg-Gen-Hack"></div>
	<div class="Bg-Gen-Hack-Red-Tint"></div>
	<div class="Bg-Gen-Hack-Blue-Tint"></div>
	<div class="Bg-Gen-Hack-Green-Tint"></div>
	<?php atfPutPageMood($Data); ?>
	<section id="content" class="m-t-lg wrapper-md animated fadeIn">
		<div class="container aside-xl"> 
			<a class="navbar-brand block" href="index.php">
				<img src="assets/images/logo.png">
			</a>
			<hr style="margin:9px 0 0 0; padding:0">
			<section class="m-b-lg">
				<header class="text-center litetxt"><h3 class=" set-font-Open-Sans">
					<?php echo isset($Data['Brand']) ? $Data['Brand'] : ""; ?>
				</h3></header>
				<h5 class="text-center litetxt Login-Message-Persistant">
					<?php echo isset($Data['Trailer']) ? $Data['Trailer'] : ""; ?>
				</h5>
				<div class="messages">
					<?php atfPutMessages($Data); ?>
				</div>
				<div class="">
					<?php atfGetBody($Data, $__Mode); ?>
				</div>
			</section>
		</div>
	</section>

	<footer id="footer">
		<div class="text-center padder clearfix">
			<p><small><?php atfPutFoot(); ?></small></p>
		</div>
	</footer>
	<script src="assets/js/app/SignInUp.js"></script>
</body>

</html>



?>