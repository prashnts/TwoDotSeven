<?php
namespace TwoDot7\Broadcast;
use \TwoDot7\Util as Util;
use \TwoDot7\Mailer as Mailer;
use \TwoDot7\Database as Database;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Broadcast Origin/Source from a User.
 * const USER 1
 * @example Can be accessed by other Namespaces as \TwoDot7\Broadcast\USER or, (int)1.
 */
const USER = 1;

/**
 * Broadcast Origin/Source from a registered Bit.
 * const BIT 2
 */
const BIT = 2;

/**
 * Broadcast Origin from the System.
 * const BIT 2
 */
const SYSTEM = 3;

/**
 * Action wrapper class for Broadcasts.
 */
class Action {
	public static function Add($Origin, $Target, $Data, $Graph) {
		// Add a broadcast
	}

	public static function Remove() {
		// Deletes a broadcast
	}

	public static function Update() {
		// Updates a broadcast
	}

	public static function CreateFeed() {
		// Creates the Feed.
	}
}

class Utils {
	public static function Pack() {
		// Packs the Raw broadcast data. Packs images and stuff as well.
	}

	public static function Unpack() {
		// Unpacks a Packed broadcast data.
	}
}