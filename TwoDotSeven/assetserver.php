<?php
namespace TwoDot7\Admin\AssetServer;
#  _____                      _____                         
# /__   \__      _____       |___  |    ___               __    ____                    
#   / /\/\ \ /\ / / _ \         / /    / _ | ___ ___ ___ / /_  / __/__ _____  _____ ____
#  / /    \ V  V / (_) |  _    / /    / __ |(_-<(_-</ -_) __/ _\ \/ -_) __/ |/ / -_) __/
#  \/      \_/\_/ \___/  (_)  /_/    /_/ |_/___/___/\__/\__/ /___/\__/_/  |___/\__/_/   

/**
 * This serves the dynamic styles, JS and images.
 * @author Prashant Sinha <prashantsinha@outlook.com>
 * @since 0.0
 */

require "cssconfig.php";
require "styles.php";

# Parse incoming URI and then process it.
$URI = explode('/', preg_replace("/[\/]+/", "/", $_SERVER['REQUEST_URI']));

const BASE = 2;

switch(strtolower(isset($URI[BASE]) ? $URI[BASE] : False)) {
	case 'css':
		$_GET = array(
			'File' => isset($URI[BASE+1]) ? $URI[BASE+1] : False);
		CSS\init();
		break;
	case 'usernameicon':
		$Icon = isset($URI[BASE+1]) ? strtolower($URI[BASE+1])[0] : False;
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/assets/images/generic/alphabet/'.$Icon.'.png')) {
			header('HTTP/1.0 200 OK', true, 200);
			header('Content-Type: Image/PNG');
			echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/assets/images/generic/alphabet/'.$Icon.'.png');
			die();
		}
		else {
			header('HTTP/1.0 200 OK', true, 200);
			header('Content-Type: Image/PNG');
			echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/admin/assets/images/generic/alphabet/!.png');
			die();
		}
		break;
	case 'bit':
		$Bit = isset($URI[BASE+1]) ? $URI[BASE+1] : False;
		$File = "";
		for ($i = BASE+2; $i < count($URI); $i++) {
			$File .= $URI[$i]."/";
		}
		$File = rtrim($File, "\/");
		if (is_dir($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/bit/'.$Bit.'/'.$File)) {
			header("HTTP/1.0 403 Unauthorized");
			echo "403 Unauthorized";
			die();
		}
		elseif (file_exists($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/bit/'.$Bit.'/'.$File)) {
			header("Content-type: ".MIMETYPE($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/bit/'.$Bit.'/'.$File));
			readfile($_SERVER['DOCUMENT_ROOT'].'/TwoDotSeven/bit/'.$Bit.'/'.$File);
			die();
		}
		else {
			header("HTTP/1.0 404 Not Found");
			echo "404 Not Found";
			die();
		}
}
function MIMETYPE($filename) {

    $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $ext = strtolower(array_pop(explode('.',$filename)));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    }
    elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mimetype;
    }
    else {
        return 'application/octet-stream';
    }
}