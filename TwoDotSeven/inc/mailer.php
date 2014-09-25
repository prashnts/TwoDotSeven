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
	try {
		$Mailer = new \PHPMailer();

		if (\TwoDot7\Config\USE_SMTP) {
			$Mailer->isSMTP();
			$Mailer->SMTPDebug = 1;
			$Mailer->Host = \TwoDot7\Config\SMTP_HOST;
			$Mailer->Port = \TwoDot7\Config\SMTP_PORT;
			$Mailer->SMTPSecure = \TwoDot7\Config\SMTP_SECURE;
			$Mailer->SMTPAuth = \TwoDot7\Config\SMTP_AUTH;
			$Mailer->Username = \TwoDot7\Config\SMTP_USERNAME;
			$Mailer->Password = \TwoDot7\Config\SMTP_PASSWORD;
		} else {
			$Mailer->isSendmail();
		}

		$Mailer->setFrom(\TwoDot7\Config\EMAIL, 'TwoDot7');
		$Mailer->addReplyTo(\TwoDot7\Config\EMAIL, 'TwoDot7');
		$Mailer->addAddress($Data['To']);

		$Mailer->Subject = 'PHPMailer GMail SMTP test';
		$Mailer->msgHTML("<pre>".json_encode($Data, JSON_PRETTY_PRINT)."</pre>");

		$Mailer->send();
	} catch (Exception $e) {
		\TwoDot7\Util\Log("Failed to send a Email. Data: ".\TwoDot7\Util\Crypt::Encrypt(json_encode($Data)), "ALERT");
	}
}