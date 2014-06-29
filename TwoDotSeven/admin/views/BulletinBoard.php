<?php

function tBulletin() {
	global $SiteTitle, $SiteSubTitle;
	$BG=array('Blur'=>'1b.png');
	?>

	<!DOCTYPE html>
	<html lang="en" class="app bg-light">

	<head>
		<meta charset="utf-8" />
		<title>Bulletin Board | <?php echo $SiteTitle . " | " . $SiteSubTitle ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="stylesheet" href="assets/css/app.v1.css" type="text/css" />
		<link rel="stylesheet" href="assets/js/datepicker/datepicker.css" type="text/css" />
		<link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
		<link rel="stylesheet" href="assets/css/bgHack.php" type="text/css"/>
		<script src="assets/js/jquery.js"></script>
		<style type="text/css">
			.container-custom {
				padding: 10px;
				border-radius: 5px;
			}
			.Col-Head {
				font-size: 30px;
			}
			.slider-img {
				max-height: 100%;
			}
			.slider {
				height: 300px;
				overflow: auto;
			}

			.imgQR {
				padding: 20px;
				width: 90%;
				max-width: 100%;
			}
			.row-fix {
				border-radius: 7px;
				margin-right: 0px;
				margin-left: 0px;
				margin-top: 5px;
				margin-bottom: 5px;
				padding: 10px;
			}
			.row-col-fix {
				margin-left: 15px;
			}
		</style>
		<!--[if lt IE 9]> <script src="assets/js/ie/html5shiv.js"></script> <script src="assets/js/ie/respond.min.js"></script> <script src="assets/js/ie/excanvas.js"></script> <![endif]-->
	</head>

	<body class="">
		<section class="hbox stretch">
			<!-- .aside -->
			<?php tShowBar(array('Collapse'=>true, 'Page'=>'Bulletin'));?>
			<!-- /.aside -->
			<section id="content">

				<section class="vbox">
					<section class="scrollable">
						<section class="hbox stretch">
							<aside class="col-lg-4 bg-dark lter lt" style="padding-right:0px;">
								<section class="vbox">
									<section class="scrollable">
										<div class="wrapper">
											<section class="comment-list block ">
												<article id="comment-id-1" class="comment-item">
													<a class="pull-left thumb-sm avatar">
														<img src="usercontent/images/prashant.jpg" class="img-circle img-orb">
													</a>
													<section class="comment-body panel panel-default">
														<header class="panel-heading bg-white">
															<a href="#">Prashant Sinha</a>
															<label class="label bg-primary m-l-xs">B.Tech Innovation. 2nd Sem.</label>
															<span class="text-muted m-l-sm pull-right">
																<i class="fa fa-globe text-primary"></i> 1:44 AM
															</span> 
														</header>
														<div class="panel-body" style="-webkit-filter: blur(0px);">
															<div>Here you'll see Broadcasts promoted to the Bulletin Board.<br>Broadcast is a new way to connect with everyone instantly. The days of EMails are going to e over soon!</div>
															<div class="comment-action m-t-sm" style="display:none">
																<a href="#" data-toggle="class" class="btn btn-default btn-xs pull-right">
																	<i class="fa fa-star-o text-muted text"></i>
																	<i class="fa fa-exclaimation text-active"></i>
																	<t>Report</t>
																</a>
															</div>
														</div>
													</section>
												</article>
												<article id="comment-id-1" class="comment-item">
													<a class="pull-left thumb-sm avatar">
														<img src="usercontent/images/bot.png" class="img-circle img-orb">
													</a>
													<section class="comment-body panel panel-default">
														<header class="panel-heading bg-white">
															<a href="#">CIC One Bot</a>
															<label class="label bg-info m-l-xs">Bot</label>
															<span class="text-muted m-l-sm pull-right">
																<i class="fa fa-globe text-primary"></i> 10:15 AM
															</span> 
														</header>
														<div class="panel-body">
															<div>
																<p>Our home-grown web-bot notifies you of evrything you might forget, or you should be knowing.</p>
																<p>For example, your class schedules.</p>
																<p>Classes scheduled at 10:35 AM</p>
																<ul>
																	<li>B.Tech IT (2nd Sem): F24, II.1 (Shobha Bagai)</li>
																	<li>B.Tech IT (4th Sem): T9, IV.3 (Amit S.)</li>
																	<li>(DEMO)</li>
																</ul>
																<p>PS: No B.Tech IT (7th Sem) classes today.</p>
																<p>PPS: There's two kinds of people in the world. Those who can extrapolate from incomplete data sets.</p>
															</div>
															<div class="comment-action m-t-sm" style="display:none">
																<a href="#" data-toggle="class" class="btn btn-default btn-xs pull-right">
																	<i class="fa fa-star-o text-muted text"></i>
																	<i class="fa fa-exclaimation text-active"></i>
																	<t>Report</t>
																</a>
															</div>
														</div>
													</section>
												</article>

												<article id="comment-id-1" class="comment-item">
													<a class="pull-left thumb-sm avatar">
														<img src="usercontent/images/simmi.jpg" class="img-circle img-orb">
													</a>
													<section class="comment-body panel panel-default">
														<header class="panel-heading bg-white">
															<a href="#">Simmi Mourya</a>
															<label class="label bg-primary m-l-xs">B.Tech Innovation. 2nd Sem.</label>
															<span class="text-muted m-l-sm pull-right">
																<i class="icon i i-bar2"></i> 1:44 AM
															</span> 
														</header>
														<div class="panel-body">
															<div>Lost my Library Card in canteen. If you've seen it, somewhere, please contact me!</div>
															<div>The broadcasts are quick and efficient. Coming soon, for everyone at CIC.</div>
															<div class="comment-action m-t-sm">
																<a href="#" data-toggle="class" class="btn btn-default btn-xs pull-right">
																	<i class="fa fa-star-o text-muted text"></i>
																	<i class="fa fa-exclaimation text-active"></i>
																	<t>Report</t>
																</a>
															</div>
														</div>
													</section>
												</article>
												<!-- .comment-reply -->
												<article id="comment-id-2" class="comment-item comment-reply">
													<a class="pull-left thumb-sm avatar">
														<img src="usercontent/images/shobhamaam.jpg">
													</a> <span class="arrow left"></span>
													<section class="comment-body panel panel-default text-sm">
														<div class="panel-body"> 
															<span class="text-muted m-l-sm pull-right"> 10m ago </span>  
															Shobha Bagai
															<label class="label bg-success m-l-xs">Faculty</label>
															Take it from my cabin, I found it lying on th table!
														</div>
													</section>
												</article>
												<!-- comment form -->
												<article class="comment-item media" id="comment-form">
													<a class="pull-left thumb-sm avatar">
														<img src="usercontent/images/shashank.jpg">
													</a>
													<section class="media-body">
														<form action="#" class="m-b-none">
															<div class="input-group">
																<input type="text" class="form-control" placeholder="Input your comment here">
																<span class="input-group-btn">
																	<button class="btn btn-primary" type="button">POST</button>
																</span> 
															</div>
														</form>
													</section>
												</article>
											</section>
										</div>
									</section>
								</section>
							</aside>
							<aside class="col-lg-8 no-padder bg-hack">
								<section class="vbox">
									<section class="scrollable">
										<div class="wrapper">
											<section class="row bg-hack-pre darktxt bg-hack-blur-teal">
												<section class="col-sm-9 cic-title go-center">
													<p class="head">Cluster Innovation Centre</p>
													<p class="foot">University of Delhi</p>
												</section>
												<section class="col-sm-3 cic-title go-center">
													<img src="assets/images/logoinv.png" class=" one-logo">
												</section>
											</section>
											
											<div class="row row-fix bg-hack-blur-light">
												<div class="col-lg-8 darktxt">
													<h2 class="">Help us build this Bulletin-Board!</h2>
													<h4>Contribute in the development of CIC One, the central hub for all of CIC.<br>
														Suggest Ideas over what you want to see on this Screen.<br><br>
														Go to http://bit.ly/CICOneBB and fill the form.<br>
													</h4>
													<h4>Or, You can also scan this QR code to reach the survey.</h4>
													<h5>Thanks!<br>Team CIC Webcentral.</h5>
												</div>
												<div class="col-lg-4 go-center">
													<img class="imgQR" src="dev/getqr/<?php echo fCrypt(serialize(array('Content'=> 'http://bit.ly/CICOneBB')),"ENCRYPT")?>">
												</div>
											</div>
											<div class="row darktxt">
											
												<div class="col-lg-4 row-fix row-col-fix bg-hack-blur-red">
													<H4><div class="countdown styled go-center"></div></H4>
													<h4>End Semester Examination Dates</h4>
													<p>End semester examination Starts May 1, 2014!</p>
												</div>

											</div>
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
		<script src="assets/js/countdown/RobertCountDown.js"></script>
		<script type="text/javascript">
			$(function() {
				var endDate = "May 1, 2014 10:00:00";

				$('.countdown.styled').countdown({
					date: endDate,
					render: function(data) {
					$(this.el).html("<div>" + this.leadingZeros(data.days, 2) + " <span>days</span></div><div>" + this.leadingZeros(data.hours, 2) + " <span>hrs</span></div><div>" + this.leadingZeros(data.min, 2) + " <span>min</span></div><div>" + this.leadingZeros(data.sec, 2) + " <span>sec</span></div>");
					}
				});

			});
			$("#OptionStudent").click(function(){
				$("#Basis").attr('class', "panel no-border bg-primary dker");
				$("#StudentDetail").attr('style', "display:all");
				$("#FacultyDetail").attr('style', "display:none");
			});
			$("#OptionFaculty").click(function(){
				$("#Basis").attr('class', "panel no-border bg-success dker");
				$("#StudentDetail").attr('style', "display:none");
				$("#FacultyDetail").attr('style', "display:all");
			});
			var flag=true;
			$(".overlay-transparent").hover(
				function(){
					if(flag)
					$("#overlay").filter(':not(:animated)').fadeIn('fast');
				},
				function(){
					if(flag)
					$("#overlay").fadeOut('fast');
				}
			);

			$(".overlay-transparent").click(function(){
				$(".overlay-transparent")
				flag=false;
			});
		</script>
	</body>

	</html>

	<?php
}
?>