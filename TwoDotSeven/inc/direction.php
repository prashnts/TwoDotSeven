<?php
namespace TwoDot7\Direction;
use \TwoDot7\Util as Util;
use \TwoDot7\Database as Database;
#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 26062014
 * @version	0.0
 */
class User {

	const Pagination = 5;

	public static function GetAll($Page= 1) {
		$DatabaseHandle = new \TwoDot7\Database\Handler;
		$Limit = self::Pagination;
		$Offset = ($Page-1)*self::Pagination;
		$Query = "SELECT ID, UserName, EMail, Hash, Tokens, Status FROM _user LIMIT {$Limit} OFFSET {$Offset}";
		$Response = array();
		$Response['Table'] = array();

		$Response['Total'] = $DatabaseHandle->Query("SELECT count(*) AS count FROM _user")->fetch()['count'];
		$Response['PageMax'] = ceil(($Response['Total']/self::Pagination));
		$Response['Page'] = (($Page <= $Response['PageMax']) && $Page > 0) ? $Page : ceil(($Response['Total']/self::Pagination));

		$Response['Previous'] = (($Page > 1) && ($Page <= $Response['PageMax'])) ? $Page-1 : 1;
		$Response['Next'] = (($Page > 0) && ($Page < $Response['PageMax'])) ? $Page+1 : $Response['PageMax'];
		
		foreach ($DatabaseHandle->Query($Query)->fetchAll() as $Meta) {

			$SysAdmin = Util\Token::Exists(array(
				'JSON' => $Meta['Tokens'],
				'Token' => 'SYSADMIN'
				));

			$UserNameExtra = Util\Token::Exists(array(
				'JSON' => $Meta['Tokens'],
				'Token' => 'ADMIN')) ? ' (Admin) ' : '';
			$UserNameExtra .=  $SysAdmin ? ' (System Admin) ' : '';
			$UserNameExtra .= (\TwoDot7\User\Session::Data()['UserName'] == $Meta['UserName']) ? ' (You) ' : '';

			array_push($Response['Table'], array(
				'ID' => $Meta['ID'],
				'UserName' => $Meta['UserName'],
				'UserNameExtra' => $UserNameExtra,
				'EMail' => $Meta['EMail'],
				'SessionCount' => Util\Token::Count(array(
					'JSON' => $Meta['Hash']
					)),
				'AccessTokens' => Util\Token::Get(array(
					'JSON' => $Meta['Tokens']
					)),
				'AccessTokensCount' => Util\Token::Count(array(
					'JSON' => $Meta['Tokens']
					)),
				'SysAdmin' => $SysAdmin,
				'EMailStatus' => \TwoDot7\User\Status::EMail($Meta['UserName'])['Response'],
				'ProfileStatus' => \TwoDot7\User\Status::Profile($Meta['UserName'])['Response']
				));
		}

		return $Response;
	}
}