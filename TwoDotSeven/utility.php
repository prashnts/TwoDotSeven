<?php
namespace TwoDot7\Util;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   
/**
 * Class wrapper for Cryptic functions.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20072014
 * @version	0.0
 */
class Crypt {
	/**
	 * This function does a Eager Comparison of two String Candidates in Length-Constant time.
	 * @param	$Str1, $Str2: String, Comparison strings.
	 * @return	Boolean.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 23072014
	 * @version	0.0
	 */
	public static function EagerCompare($Str1, $Str2) {
		$Diff = strlen($Str1) ^ strlen($Str2);
		for ($i=0; $i < strlen($Str1) && $i < strlen($Str2) ; $i++) { 
			$Diff |= ord($Str1[$i]) ^ ord($Str2[$i]);
		}
		return $Diff === 0;
	}

	/**
	 * This function Encrypts a String Candidate.
	 * @param	$Candidate: String, To-Be encrypted.
	 * @param	$KeyOverride: Array, Overrides Keys set in Configuration.
	 * @return	String, Encrypted String.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 23072014
	 * @version	0.0
	 */
	public static function Encrypt($Candidate, $KeyOverride=False) {
		$Method = "AES-256-CBC";
		$Keys = $KeyOverride ? $KeyOverride : array(\TwoDot7\Config\SHA_PRIVATE, \TwoDot7\Config\SHA_INITIAL_VECTOR);
		$Key = hash('sha256', $Keys[0]);
		$Vector = substr(hash('sha256', $Keys[1]), 0, 16);
		return base64_encode(openssl_encrypt($Candidate, $Method, $Key, 0, $Vector));
	}

	/**
	 * This function Decrypts an Encrypted String Candidate.
	 * @param	$Candidate: String, To-Be decrypted.
	 * @param	$KeyOverride: Array, Overrides Keys set in Configuration.
	 * @return	String, Decrypted String.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 23072014
	 * @version	0.0
	 */
	public static function Decrypt($Candidate, $KeyOverride=False) {
		$Method = "AES-256-CBC";
		$Keys = $KeyOverride ? $KeyOverride : array(\TwoDot7\Config\SHA_PRIVATE, \TwoDot7\Config\SHA_INITIAL_VECTOR);
		$Key = hash('sha256', $Keys[0]);
		$Vector = substr(hash('sha256', $Keys[1]), 0, 16);
		return openssl_decrypt(base64_decode($Candidate), $Method, $Key, 0, $Vector);
	}
}

/**
 * Class wrapper for PBKDF2
 * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
 * Copyright (c) 2013, Taylor Hornby
 * All rights reserved.
 * @author	Taylor Hornby
 * @since	v0.0 20072014
 * @version	0.0
 */ 
class PBKDF2 {
	/**
	 * Initialization Constants. Can be changed without any effect to existing Hashes.
	 * @copyright (c) 2013, Taylor Hornby
	 */
	private static $PBKDF2_HASH_ALGORITHM ="sha256";
	private static $PBKDF2_ITERATIONS = 1000;
	private static $PBKDF2_SALT_BYTE_SIZE = 24;
	private static $PBKDF2_HASH_BYTE_SIZE = 24;

	private static $HASH_SECTIONS = 4;
	private static $HASH_ALGORITHM_INDEX = 0;
	private static $HASH_ITERATION_INDEX = 1;
	private static $HASH_SALT_INDEX = 2;
	private static $HASH_PBKDF2_INDEX = 3;

	public static function CreateHash($Password) {
		// format: Algorithm:iterations:Salt:hash
		$Salt = base64_encode(mcrypt_create_iv(self::$PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
		return self::$PBKDF2_HASH_ALGORITHM . ":" . self::$PBKDF2_ITERATIONS . ":" .  $Salt . ":" .
			base64_encode(self::PBKDF2(
				self::$PBKDF2_HASH_ALGORITHM,
				$Password,
				$Salt,
				self::$PBKDF2_ITERATIONS,
				self::$PBKDF2_HASH_BYTE_SIZE,
				true
			));
	}

	public static function ValidatePassword($Password, $CorrectHash) {
		$params = explode(":", $CorrectHash);
		if(Count($params) < self::$HASH_SECTIONS)
		   return false;
		$PBKDF2 = base64_decode($params[self::$HASH_PBKDF2_INDEX]);
		return Crypt::EagerCompare(
			$PBKDF2,
			self::PBKDF2(
				$params[self::$HASH_ALGORITHM_INDEX],
				$Password,
				$params[self::$HASH_SALT_INDEX],
				(int)$params[self::$HASH_ITERATION_INDEX],
				strlen($PBKDF2),
				true
			)
		);
	}

	/**
	 * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
	 * @param	$Algorithm - The hash Algorithm to use. Recommended: SHA256
	 * @param	$Password - The Password.
	 * @param	$Salt - A Salt that is unique to the Password.
	 * @param	$Count - Iteration Count. Higher is better, but slower. Recommended: At least 1000.
	 * @param	$KeyLength - The length of the derived key in bytes.
	 * @param	$RawOutput - If true, the key is returned in raw binary format. Hex encoded otherwise.
	 * @return	A $KeyLength-byte key derived from the Password and Salt.
	 *
	 * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
	 *
	 * This implementation of PBKDF2 was originally created by https://defuse.ca
	 * With improvements by http://www.variations-of-shadow.com
	 */
	private static function PBKDF2($Algorithm, $Password, $Salt, $Count, $KeyLength, $RawOutput = false) {
		$Algorithm = strtolower($Algorithm);
		if(!in_array($Algorithm, hash_algos(), true))
			trigger_error('PBKDF2 ERROR: Invalid hash Algorithm.', E_USER_ERROR);
		if($Count <= 0 || $KeyLength <= 0)
			trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

		if (function_exists("hash_self::PBKDF2")) {
			// The output length is in NIBBLES (4-bits) if $RawOutput is false!
			if (!$RawOutput) {
				$KeyLength = $KeyLength * 2;
			}
			return hash_self::PBKDF2($Algorithm, $Password, $Salt, $Count, $KeyLength, $RawOutput);
		}

		$hash_length = strlen(hash($Algorithm, "", true));
		$block_Count = ceil($KeyLength / $hash_length);

		$output = "";
		for($i = 1; $i <= $block_Count; $i++) {
			// $i encoded as 4 bytes, big endian.
			$last = $Salt . pack("N", $i);
			// first iteration
			$last = $xorsum = hash_hmac($Algorithm, $last, $Password, true);
			// perform the other $Count - 1 iterations
			for ($j = 1; $j < $Count; $j++) {
				$xorsum ^= ($last = hash_hmac($Algorithm, $last, $Password, true));
			}
			$output .= $xorsum;
		}

		if($RawOutput)
			return substr($output, 0, $KeyLength);
		else
			return bin2hex(substr($output, 0, $KeyLength));
	}
}

/**
 * Puts a Log entry in logs folder.
 * @param	$Message - Logging message.
 * @param	$__Arg - Target Log file.
 * @return	null
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 25072014
 * @version	0.0
 */
function Log($Message, $__Arg = "SILENT") {
	# Time Offset puts the Local Time.
	$UTC			=	time();
	$FormattedTime	=	date("{D,d-M-Y, H:i:s}",$UTC+TIMEOFFSET);

	# This finds the Log folder, and eliminates the multiple Log File locations.
	$AbsPath		=	$_SERVER['DOCUMENT_ROOT'];
	$AbsPath		.=	is_dir($AbsPath."/TwoDotSeven/logs") ? "/TwoDotSeven/logs" : is_dir($AbsPath."/".ROOTDIR."/TwoDotSeven/logs") ? "/".ROOTDIR."/TwoDotSeven/logs" : "" ;

	switch ($__Arg) {
		case "SILENT"	: fWrite(fopen("$AbsPath/InfoLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case "DEBUG"	: fWrite(fopen("$AbsPath/DebugLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case "ALERT"	: fWrite(fopen("$AbsPath/AlertLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n");			break;
		case "DIE"		: fWrite(fopen("$AbsPath/FatalLog.log",	"a+"),	"$FormattedTime ($UTC)\t$Message\n"); die();	break;
		default			: fWrite(fopen("$AbsPath/DebugLog.log",	"a+"),	"$FormattedTime ($UTC)\tBad Usage of function Log. Bad Argument\n");
	}
}

?>