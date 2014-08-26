<?php
namespace TwoDot7\Mailer;
use \TwoDot7\Util as Util;

#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

function Send($Data) {
	Util\Log(json_encode($Data));
	_Import($_SERVER['DOCUMENT_ROOT']."/TwoDotSeven/inc/external/PHPMailer/PHPMailerAutoload.php");
	date_default_timezone_set('Etc/UTC');
	$mail = new \PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "prashantinq@gmail.com";
	$mail->Password = "para-xylene";
	$mail->setFrom('from@example.com', 'First Last');
	$mail->addReplyTo('replyto@example.com', 'First Last');
	$mail->addAddress('prashantsinha@outlook.com', 'John Doe');
	$mail->Subject = 'PHPMailer GMail SMTP test';
	$mail->msgHTML("Hello World.");
	$mail->AltBody = 'This is a plain-text message body';

	if (!$mail->send()) {
	    //echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    //echo "Message sent!";
	}
}