<?php
namespace TwoDot7\Validate;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Validates Identifiers, Including Group IDs, Namespaces.
 * @param	string $Candidate The testing candidate.
 * @param	string $LengthMin optional Specify to put a Min length restriction. 
 * @param	string $LengthMax optional Specify to put a Max length restriction.
 * @return	Boolean.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 25062014
 * @version	0.0
 */
function Alphanumeric($Candidate, $LengthMin = 0, $LengthMax = 0) {
	$PatternTail = "";
	
	if ($LengthMin >= 0 && $LengthMax > $LengthMin) $PatternTail = "\{$LengthMin, $LengthMin}";
	if ($LengthMin == 0 && $LengthMax == 0) $PatternTail = "*"; 
	if ($LengthMin > 0 && $LengthMax == 0) $PatternTail = "\{$LengthMin,}";
	
	$Pattern = "/^[A-Za-z0-9_~\.-]$PatternTail$/";

	return (bool)(preg_match($Pattern, $Candidate));
}

/**
 * This function validates an Email ID.
 * @param	$Candidate -string- Email ID.
 * @param	$_Override -bool- Overrides the return.
 * @return	$_Override -true- Default. Returns the EMail ID if found valid, else returns False.
 * @return	$_Override -false- -bool- True if Valid.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 25062014
 * @version	0.0
 */
function EMail($Candidate, $_Override = True) {
	/**
	 * EMail RegEx pattern. Modified to span in multiple lines.
	 * @copyright Michael Rushton 2009-10 http://squiloople.com/
	 * @link	http://lxr.php.net/xref/PHP_5_4/ext/filter/logical_filters.c#501
	 */

	$PatternEMail = 
		'/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?))'.
		'{255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x'.
		'22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\'.
		'x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B'.
		'\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27'.
		'\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x0'.
		'8\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F])'.
		')*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*'.
		'\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]'.
		'+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:'.
		'.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]\{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f'.
		'0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::['.
		'a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]'.
		'{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5'.
		'])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:'.
		'2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
	
	$Result = (bool)(preg_match($PatternEMail, $Candidate));

	if($_Override)
		return $Result ? $Candidate : False;
	else
		return $Result;
}

/**
 * This function validates a Password.
 * @param	$Candidate -string- Password.
 * @param	$_Override -bool- Overrides the return.
 * @return	$_Override -true- Returns the Password if found valid, else returns False.
 * @return	$_Override -false- -bool- Default. True if Valid.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 25062014
 * @version	0.0
 */
function Password($Candidate, $_Override = False) {
	if($_Override)
		return (bool)(strlen($Candidate) > 5) ? $Candidate : False;
	else
		return (bool)(strlen($Candidate) > 5);
}

/**
 * This function validates a Username. Username specification in example.
 * @param	$Candidate -string- Username.
 * @param	$_Override -bool- Overrides the return.
 * @return	$_Override -true- Default. Returns the lowercase Username if found valid, else returns False.
 * @return	$_Override -false- -bool- True if Valid.
 * @example	Valid Usernames are between 5-32 characters long. May contain A-Z, 0-9, _(Underscore), ~(Tilde). Usernames are case insensetive. System will support 3.44e50 unique lowercase Usernames in total.
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 25062014
 * @version	0.0
 */
function UserName($Candidate, $_Override = True) {
	$Pattern = "/^[A-Za-z]{1}[A-Za-z0-9_]{4,32}$/";
	$Result = (bool)(preg_match($Pattern, $Candidate));
	if($_Override)
		return $Result ? strtolower($Candidate) : False;
	else
		return $Result;
}

/**
 * This function decides whether the user is on a Mobile device and disables
 * the Editing feature on Template pages.
 * @return	-bool- True if User is on a Mobile Device.
 * @author	Chad Smith, https://twitter.com/chadsmith
 * @link	http://detectmobilebrowsers.com/
 * @since	v0.0 25062014
 * @version	0.0
 */
function isUserOnMobile() {
	$UserAgent=$_SERVER['HTTP_USER_AGENT'];
	$Pattern1 =	
		"/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hipto".
		"p|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob".
		"|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(brows".
		"er|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i";
	$Pattern2 = 
		"/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co".
		")|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb".
		"|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd".
		")|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(i".
		"c|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|".
		"un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw".
		"|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro".
		"|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-".
		"[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|m".
		"mef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n5".
		"0(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p".
		"800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt".
		"\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma".
		"|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0".
		"|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)".
		"|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)".
		"|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83".
		"|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i";
	return (preg_match($Pattern1,$UserAgent)||preg_match($Pattern2,substr($UserAgent,0,4))) ? true : false;
}
