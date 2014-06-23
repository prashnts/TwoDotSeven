<?php
namespace TwoDot7\Util;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

class Crypt {
	/**
	 * This function does a Eager Comparison of the String Candidates.
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
	 * This function Decrypts a Encrypted String Candidate.
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

	public static function Hash($Candidate, $Mode) {
		
	}
}