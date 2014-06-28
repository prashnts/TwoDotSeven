<?php

include '../../usercontent/bg/bgconfig.php';
header("Content-type: text/css; charset: UTF-8");
?>

@media (min-width: 768px) {
	.spl-header {
		width: 46px;
	}
	.spl-header > section > header {
		visibility: hidden;
	}
	.spl-logo {
		visibility: hidden;
	}
	.spl-logo-alt {
		position: absolute;
		top: 25px;
		left: 3px;
		z-index: 100;
		visibility: visible;
		display: all;
		width: 38px;
	}
	.spl-user-info {
		display: none;
	}
	.bg-hack-pre {
		width: 100%;
		height: 100%;
		z-index: 1;
		position: relative;
		margin: inherit;
		margin-bottom: 10px;
		border-radius: 7px;
	}
	.bg-hack-post {
		width: 100%;
		height: 100%;
	
		position: absolute;
		top: 0px;
		z-index: 0;
		border-radius: 5px;
	}
	.cic-title > .head {
		font-family: collegeregular;
		padding-top: 10px;
		font-size: 45px;
		line-height: 45px;
		margin: 0 0 5px 0;
	}
	.cic-title > .foot {
		font-family: collegeregular;
		font-size: 30px;
		letter-spacing: 6px;
		line-height: 30px;
	}
	.one-logo {
		width: 100%;
		top: 22px;
		position: relative;
	}
}
@media (max-width: 767px) {
	.spl-logo {
		visibility: visible;
	}
	.spl-logo-alt {
		display: none;
	}
	.spl-user-info {
		display: all;
	}
	.bg-hack-pre {
		width: 100%;
		height: 100%;
		z-index: 1;
		position: relative;
		margin: inherit;
		margin-bottom: 10px;
		border-radius: 7px;
	}
	.cic-title > .head {
		font-family: collegeregular;
		padding-top: 10px;
		font-size: 25px;
		line-height: 25px;
		margin: 0 0 5px 0;
	}
	.cic-title > .foot {
		font-family: collegeregular;
		font-size: 12px;
		letter-spacing: 2px;
		line-height: 12px;
	}
	.one-logo {
		top: 5px;
		height: 35px;
		margin:5px;
	}
}
.bg-hack {
	background: url(../../usercontent/bg/<?php echo $BG['Default'] ?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-blue {
	background: url(../../usercontent/bg/tintBlue.png), url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-red {
	background: url(../../usercontent/bg/tintRed.png),	url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-green {
	background: url(../../usercontent/bg/tintGreen.png),	url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-teal {
	background: url(../../usercontent/bg/tintTeal.png),	url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-light {
	background: url(../../usercontent/bg/tintLight.png),	url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}
.bg-hack-blur-dark {
	background: url(../../usercontent/bg/tintDark.png),	url(../../usercontent/bg/<?php echo $BG['Blur'];?>) no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
}