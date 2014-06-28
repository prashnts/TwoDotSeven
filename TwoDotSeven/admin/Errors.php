<?php
namespace TwoDot7\Admin\Template\Errors;

_Throw();

function _Throw($Data = False) {
	?>

	<!DOCTYPE html>
	<html lang="en" class="bg-dark">

	<head>
		<meta charset="utf-8" />
		<title><?php echo (isset($Data['Title']) ? $Data['Title'].' | ' : '').('TwoDotSeven Error'); ?></title>
		<meta name="description" content="<?php echo (isset($Data['MetaDescription']) ? $Data['MetaDescription'] : 'TwoDotSeven Configuration Error'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="/TwoDotSeven/admin/assets/css/base.css" type="text/css" />
		<!--[if lt IE 9]>
			<script src="/TwoDotSeven/admin/assets/js/ie/html5shiv.js"></script>
			<script src="/TwoDotSeven/admin/assets/js/ie/respond.min.js"></script>
			<script src="/TwoDotSeven/admin/assets/js/ie/excanvas.js"></script>
		<![endif]-->
	</head>

	<body class="">
		<section id="content">
			<!--div class="img" >
				<img src="<?php //echo afGetImage($Code) ?>" style="position:fixed; z-index:-1; left:0; bottom:0; max-width:100%;width:400px">
			</div-->
			<div class="row m-n">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="text-center m-b-lg">
						<h1 class="h text-white animated fadeInDownBig" style="color:#C2E6E7"><?php //echo $Codes;?></h1>
						<p class="text-white animated" style="color:#C2E6E7">
							<span style="font-size:2em"><?php echo "@##";?></span>
							<br />
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
		</section>
		<footer id="footer">
			<div class="text-center padder clearfix">
				<p><small><?php echo (isset($Data['Footer']) ? $Data['Footer'] : 'TwoDotSeven');?></small></p>
			</div>
		</footer>
	</body>

	</html>
	<?php
}
?>