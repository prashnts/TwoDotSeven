<?php

#	Data flow:
#	tSignInUpLayout($Data, ...)
#		|----> atfGetBody($Data, ...)
#		|			|---->atfGetRegistrationMarkup($Data)
#		|			|---->atfGetLoginMarkup()
#		|----> atfPutpageMood($Data)

function tSignInUpLayout($Data, $__Mode='DEFAULT') {
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
	<?php
}

function atfGetRegisterMarkup($Data) {
	switch ($Data['Step']) {
		case	1:	# Step 1 Markup START.
					?>
						<form action="<?php echo $Data['FormURI']; ?>" method="POST">
							<div class="list-group">
								<div class="list-group-item Field-Override-Hack">
									<div class="form-group input-group Field-Margin-Override">
										<input type="text" required  class="form-control Input-Field-Override-Hack" name="UserName" placeholder="UserName" id="Mode2F1">
										<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F1fa" class="fa fa-ellipsis-h"></i></span>
									</div>
								</div>
								<div class="list-group-item Field-Override-Hack">
									<div id="EM" class="form-group input-group Field-Margin-Override">
										<input type="email" required class="form-control Input-Field-Override-Hack" name="EMail" placeholder="EMail ID" id="Mode2F2">
										<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F2fa" id="EM-fa" class="fa fa-ellipsis-h"></i></span>
									</div>
								</div>
								<div class="list-group-item Field-Override-Hack">
									<div class="form-group input-group Field-Margin-Override">
										<input type="password" required class="form-control Input-Field-Override-Hack" name="Password" placeholder="Create a Password." id="Mode2F3">
										<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F3fa" id="PWD-fa" class="fa fa-ellipsis-h"></i> </span>
									</div>
									<hr class="No-Margin-Padding-Override-Hack">
									<div class="form-group input-group Field-Margin-Override">
										<input type="password" required class="form-control Input-Field-Override-Hack" name="ConfPass" placeholder="Confirm Password." id="Mode2F4">
										<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode2F4fa" id="PWD-C-fa" class="fa fa-ellipsis-h"></i></span>
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
							<a href="login.php" class="btn btn-sm btn-primary btn-block">Login</a>
						</form>
					<?php
					# Step 1 Markup END.
					break;
		case	2:	# Step 2 Markup START.
					?>
						<form action="<?php echo $Data['FormURI']; ?>" method="POST">
							<div class="list-group">
								<div class="list-group-item Field-Override-Hack">
									<div class="form-group input-group Field-Margin-Override">
										<input type="text" required  class="form-control Input-Field-Override-Hack" name="VerificationCode" placeholder="Verification Code" id="Mode3F1">
										<span class="input-group-addon Input-Field-Override-Hack" ><i id="Mode3F1fa" class="fa fa-ellipsis-h"></i></span>
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
							<a href="" class="btn btn-sm btn-primary btn-block">Resend EMail verification code</a>
						</form>
					<?php
					# Step 2 Markup END.
					break;
		case	3:	# Step 3 Markup START.
					?>
						<div class="text-center litetxt">
							<img src="assets/images/Okay.png" class="Img-Make-Responsive"><br>
							<a href="login.php" class="btn btn-md btn-block btn-primary">Login</a>
						</div>
					<?php
					# Step 3 Markup END.
					break;
		case	4:	# Step 4 Markup START.
					?>
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
					<?php
					# Step 4 Markup END.
					break;
		case	5:	# Step 5 Markup START.
					?>
						<form action="<?php echo $Data['FormURI']; ?>" method="POST">
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
						</form>
					<?php
					# Step 5 Markup END.
					break;
	}
}

function atfGetLoginMarkup() {
	?>
	<form action="login.php" method="POST">
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
		<div class="text-center m-t m-b">
			<a href="<?php echo AbsURI_PasswordRecovery; ?>" id="MoodBlur">
				<small>Forgot password?</small>
			</a>
		</div>
		<p class="text-muted text-center litetxt">
			<small id="MoodBlur">No Account?</small>
		</p>
		<a href="register.php" class="btn btn-sm btn-primary btn-block">Create an account</a>
	</form>
	<?php
}

function atfGetBody($Data, $__Mode) {
	switch ($__Mode) {
		case	'LOGIN'		:	atfGetLoginMarkup();			break;
		case	'REGISTER'	:	atfGetRegisterMarkup($Data);	break;
		default:				echo "Perhaps, Something's broken. Developers are working. Give them time!";
	}
}

?>