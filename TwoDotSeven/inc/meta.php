<?php
namespace TwoDot7\Meta;

#  _____                      _____ 
# /__   \__      _____       |___  |
#   / /\/\ \ /\ / / _ \         / / 
#  / /    \ V  V / (_) |  _    / /  
#  \/      \_/\_/ \___/  (_)  /_/   

/**
 * Class wrapper for the Navigation Menu related functions. 
 * Implements Add, Remove, Get, and Validation. 
 * @author	Prashant Sinha <firstname,lastname>@outlook.com
 * @since	v0.0 20140719
 * @version	0.0
 */
class Navigation {

	/**
	 * Adds Entry/Enries in the Navigation menu. The addition must be in accordance to the Schema.
	 * @param	String $Node Parent Node for menu addition. Could be New, if adding a new menu.
	 * @param	Array $NavigationAddition Entry to be added.
	 * @param	Array $Options Optional. Overrides the position of entry addition.
	 * @return	Array Contains Success status, and error messages, if required.
	 * @example	How to Call
	 * @example	Creates a Menu Item NEWMENU in Parent.
	 * @example	Add('NEWMENU', array(
	 * @example		'NEWMENU' => array(
	 * @example			SCHEMA
	 * @example			)
	 * @example		), $Options);
	 * @example	
	 * @example	Adds a children Item in EXISTING item.
	 * @example	Add('EXISTING', array(
	 * @example		'CHILD1' => array(
	 * @example			SCHEMA
	 * @example			),
	 * @example		'CHILD2' => array(
	 * @example			SCHEMA
	 * @example			)
	 * @example		), $Options)
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20140720
	 * @version	0.0
	 */
	public static function Add($Node, $NavigationAddition, $Options = array(
		'Override' => False,
		'OFFSET' => 2)) {

		# Validate the options:
		if (!(isset($Options['Override']) && isset($Options['OFFSET']))) {
			throw new \TwoDot7\Exception\InvalidArgument('Invalid call of function Meta\navigation::Add()');
		}

		# Validate New Navigation Additions.
		if (!self::ValidateNavigation($NavigationAddition)) {
			# Nope. Cannot proceed.
			return array(
				'Success' => False,
				'Error' => 'Bad input navigation array.'
				);
		}

		$DatabaseHandle = new \TwoDot7\Database\Handler;

		$NavigationNode_OLD = json_decode($DatabaseHandle::Exec(
			'SELECT Value FROM _meta WHERE Node=:Node',
			array(
				'Node' => 'Navigation'
				))->fetch()['Value'], True);

		# Validate Old Navigation.
		if (!self::ValidateNavigation($NavigationNode_OLD)) {
			# Force Override the Node.
			$Options['Override'] = True;
		}

		# Create new Navigation:
		$NavigationNode_NEW = array();

		if (!$Options['Override']) {

			/**
			 * @internal # Validate the NavigationAddition.
			 * @internal # Determine where to add it:
			 * @internal ## If $Node doesn't already exists, add it after the OFFSET.
			 * @internal ## If $Node Exist, add it as a Children element of the $Node.
			 * @internal #### Also check if the Children element's identifier is same as the $Node.
			 * @internal #### If it is, don't proceed. It's a repeated request.
			 * @internal ### If the children element is array, Merge it with old array.
			 * @internal ### Else, put it as a children element.
			*/

			if (!array_key_exists($Node, $NavigationNode_OLD)) {
				$NavigationNode_NEW =
					array_slice($NavigationNode_OLD, 0, $Options['OFFSET'], true) +
					$NavigationAddition +
					array_slice($NavigationNode_OLD, $Options['OFFSET'], count($NavigationNode_OLD)-$Options['OFFSET'], true);
			}
			else {
				if (array_key_exists($Node, $NavigationAddition)) {
					return array(
						'Success' => False,
						'Error' => 'Key already exists. Unique Key is needed.'
						);
				}
				if (is_array($NavigationNode_OLD[$Node]['Children'])) {
					$NavigationNode_OLD[$Node]['Children'] = array_merge($NavigationNode_OLD[$Node]['Children'], $NavigationAddition);
				}
				else {
					$NavigationNode_OLD[$Node]['Children'] = $NavigationAddition;
				}
				$NavigationNode_NEW = $NavigationNode_OLD;
			}
		}
		else {
			$NavigationNode_NEW = $NavigationAddition;
		}

		# Validate the Resultant menu if it Conforms to the Schema.
		if (!self::ValidateNavigation($NavigationNode_NEW)) {
			return array(
				'Success' => False,
				'Error' => 'Bad Resultant Navigation array.'
				);
		}

		$NavigationQuery = "INSERT INTO _meta (Node, Value) VALUES (:Node, :Value) ON DUPLICATE KEY UPDATE Value=:Value";

		$DatabaseHandle->Query($NavigationQuery, array(
			'Node' => 'Navigation',
			'Value' => json_encode($NavigationNode_NEW)
			));
		return array(
			'Success' => True);
	}

	/**
	 * Removes Entry/Entries in the Navigation menu. The removal should be of a Registered Token.
	 * @param	String $Node The location from where the '$Hook' is to be removed.
	 * @param	String $Hook The token of the registered Navigation Item, which is to be removed.
	 * @param	Array $Options Overrides. Turn on Recursive parameter to remove all instances of the Token.
	 * @return	Bool Contains success status.
	 * @throws	InvalidArgument Exception.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @throws	InvalidArgument Exception.
	 * @since	v0.0 20140720
	 * @version	0.0
	 */
	public static function Remove($Node, $Hook, $Options = array(
		'Recursive' => False)) {

		# Validate the options:
		if (!(isset($Options['Recursive']))) {
			throw new \TwoDot7\Exception\InvalidArgument('Invalid call of function Meta\navigation::Add()');
		}

		$DatabaseHandle = new \TwoDot7\Database\Handler;

		$NavigationNode_OLD = json_decode($DatabaseHandle::Exec(
			'SELECT Value FROM _meta WHERE Node=:Node',
			array(
				'Node' => 'Navigation'
				))->fetch()['Value'], True);

		if ($Options['Recursive']) {
			/**
			 * @internal	Find and Remove all the instances of $Hook. Disregard $Node parameter.
			 */
			# First clean up the PARENT Node.
			unset($NavigationNode_OLD[$Hook]);
			
			# Now go to ALL child nodes, and remove them as well.

			foreach ($NavigationNode_OLD as $Menu => $Meta) {
				unset($NavigationNode_OLD[$Menu]['Children'][$Hook]);
				if (is_array($NavigationNode_OLD[$Menu]['Children']) &&
					count($NavigationNode_OLD[$Menu]['Children']) == 0) {
					$NavigationNode_OLD[$Menu]['Children'] = False;
				}
			}

			# Finally, exit the Block.
		}
		else {
			if ($Node == 'PARENT' || !$Node) {
				unset($NavigationNode_OLD[$Hook]);
			}
			else {
				unset($NavigationNode_OLD[$Node]['Children'][$Hook]);
				if (is_array($NavigationNode_OLD[$Node]['Children']) &&
					count($NavigationNode_OLD[$Node]['Children']) == 0) {
					$NavigationNode_OLD[$Node]['Children'] = False;
				}
			}
		}

		$NavigationNode_NEW = $NavigationNode_OLD;

		# Validate the Resultant menu if it Conforms to the Schema.
		if (!self::ValidateNavigation($NavigationNode_NEW)) {
			return array(
				'Success' => False,
				'Error' => 'Bad Resultant Navigation array.'
				);
		}

		$NavigationQuery = "INSERT INTO _meta (Node, Value) VALUES (:Node, :Value) ON DUPLICATE KEY UPDATE Value=:Value";

		$DatabaseHandle->Query($NavigationQuery, array(
			'Node' => 'Navigation',
			'Value' => json_encode($NavigationNode_NEW)
			));

		return array(
			'Success' => True);
	}

	/**
	 * Returns the Navigation HTML structure.
	 * @param	Array|Bool $Data Optional. String overrides and specifiers.
	 * @return	String The Navigation Menu formatted, and autogenerated HTML.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140720
	 * @version	0.0
	 */
	public static function Get($Data = False) {

		$NavigationNode = json_decode(\TwoDot7\Database\Handler::Exec(
			'SELECT Value FROM _meta WHERE Node=:Node', array(
				'Node' => 'Navigation'))->fetch()['Value'], True);

		if (!self::ValidateNavigation($NavigationNode)) {
			\TwoDot7\Util\Log('Bad Navigation Menu | JSON: '.json_encode($NavigationNode), 'ALERT');
			return '<kbd>ERROR::Navigation Menu Error/REBUILD THE MENU/</kbd>';
		}

		$Navigation  = '<nav class="nav-primary hidden-xs">'."\n";
		$Navigation .= '<ul class="nav nav-main" data-ride="collapse">'."\n";

		foreach ($NavigationNode as $Menu => $Meta) {

			if (\TwoDot7\User\Session::Exists()) {
				if (!$Meta['Visible']['LOGGEDIN']) {
					continue;
				}
			}
			else {
				if (!$Meta['Visible']['NOTLOGGEDIN']) {
					continue;
				}
			}
			if (is_array($Meta['Tokens'])) {
				$Flag = False;
				foreach ($Meta['Tokens'] as $Domain) {
					if (!\TwoDot7\User\Access::Check(array(
							'UserName' => \TwoDot7\User\Session::Data()['UserName'],
							'Domain' => $Domain
							))) {
						$Flag = True;
					}
				}
				if ($Flag) {
					continue;
				}
			}

			if (isset($Data['Page']) && $Data['Page'] == $Menu) {
				$Navigation .= '<li class="active">'."\n";
			}
			else {
				$Navigation .= '<li>'."\n";
			}

			$Navigation .= '<a href="'.$Meta['Target'].'" class="auto">'."\n";
			$Navigation .= '<i class="'.$Meta['Icon'].'"></i>'."\n";

			$Navigation .= '<span>'.$Meta['Name'].'</span>'."\n";

			if ($Meta['Badge']) {
				$Navigation .= '<b class="badge '.$Meta['Badge']['Class'].' pull-right">0</b>';
			}

			if (is_array($Meta['Children'])) {
				$Navigation .= '<span class="pull-right text-muted">'."\n";
				$Navigation .= '<i class="fa fa-angle-down text"></i>'."\n";
				$Navigation .= '<i class="fa fa-angle-up text-active"></i>'."\n";
				$Navigation .= '</span>'."\n";
			}

			$Navigation .= '</a>'."\n";

			if (is_array($Meta['Children'])) {

				$Navigation .= '<ul class="nav dk">'."\n";

				foreach ($Meta['Children'] as $Menu => $Meta) {
					if (\TwoDot7\User\Session::Exists()) {
						if (!$Meta['Visible']['LOGGEDIN']) {
							continue;
						}
					}
					else {
						if (!$Meta['Visible']['NOTLOGGEDIN']) {
							continue;
						}
					}
					if (is_array($Meta['Tokens'])) {
						$Flag = False;
						foreach ($Meta['Tokens'] as $Domain) {
							if (!\TwoDot7\User\Access::Check(array(
									'UserName' => \TwoDot7\User\Session::Data()['UserName'],
									'Domain' => $Domain
									))) {
								$Flag = True;
							}
						}
						if ($Flag) {
							continue;
						}
					}

					if (isset($Data['Page']) && $Data['Page'] == $Menu) {
						$Navigation .= '<li class="active">'."\n";
					}
					else {
						$Navigation .= '<li>'."\n";
					}
					
					$Navigation .= '<a href="'.$Meta['Target'].'" class="auto">'."\n";

					if ($Meta['Badge']) {
						$Navigation .= '<b class="badge '.$Meta['Badge']['Class'].' pull-right">4</b>'."\n";
					}

					$Navigation .= '<i class="'.$Meta['Icon'].'"></i>'."\n";
					$Navigation .= '<span>'.$Meta['Name'].'</span>'."\n";
					$Navigation .= '</a>'."\n";
					$Navigation .= '</li>'."\n";
				}
				$Navigation .= '</ul>';
			}

			$Navigation .= '</li>'."\n";
		}

		$Navigation .= '</ul>'."\n";
		$Navigation .= '</nav>'."\n";

		return $Navigation;
	}

	public static function GetUserNavInfo() {
		if (!\TwoDot7\User\Session::Exists()) {
			return '';
		}

		$DBResponse = \TwoDot7\Database\Handler::Exec("SELECT * FROM _user WHERE UserName=:UserName", array(
			'UserName' => \TwoDot7\User\Session::Data()['UserName']
			))->fetch();

		$Badge = (\TwoDot7\User\Status::Profile($DBResponse['UserName'])['Response'] > 0) ? 'on' : 'off';

		$NavInfo = '<div class="clearfix wrapper dker nav-user hidden-xs spl-user-info">';
		$NavInfo .= '	<div class="dropdown">';
		$NavInfo .= '		<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
		$NavInfo .= '			<span class="thumb avatar pull-left m-r">';
		$NavInfo .= '				<img src="/assetserver/userNameIcon/'.$DBResponse['UserName'][0].'">';
		$NavInfo .= '				<i class="'.$Badge.' md b-black"></i>';
		$NavInfo .= '			</span>';
		$NavInfo .= '			<span class="hidden-nav-xs clear">';
		$NavInfo .= '				<span class="block m-t-xs">';
		$NavInfo .= '					<strong class="font-bold text-lt">'.$DBResponse['UserName'].'</strong>';
		$NavInfo .= '					<b class="caret"></b>';
		$NavInfo .= '				</span> ';
		$NavInfo .= '				<span class="text-muted text-xs block">'.$DBResponse['EMail'].'</span>';
		$NavInfo .= '			</span>';
		$NavInfo .= '		</a>';
		$NavInfo .= '		<ul class="dropdown-menu">';
		$NavInfo .= '			<li> <a href="#">Settings</a> ';
		$NavInfo .= '			</li>';
		$NavInfo .= '			<li> <a href="profile.php">Profile</a> ';
		$NavInfo .= '			</li>';
		$NavInfo .= '			<li> <a href="#">Help/Support</a> ';
		$NavInfo .= '			</li>';
		$NavInfo .= '			<li> <a href="/twodot7/logout">Logout</a> ';
		$NavInfo .= '			</li>';
		$NavInfo .= '		</ul>';
		$NavInfo .= '	</div>';
		$NavInfo .= '</div>';

		return $NavInfo;
	}

	/**
	 * Validates the Navigation menu Array, or parts so that it conforms to the Schema.
	 * @param	Array $Data Pointer. The Array.
	 * @return	Bool True if conforms to the Schema.
	 * @author	Prashant Sinha <firstname,lastname>@outlook.com
	 * @since	v0.0 20140720
	 * @version	0.0
	 */
	private static function ValidateNavigation (&$Data) {
		$Valid = True;

		if (!is_array($Data)) {
			$Valid = False;
		}
		else {
			foreach ($Data as $Menu => $Meta) {
				if (!isset($Meta['Name']))
					$Valid = False;
				if (!isset($Meta['Icon']))
					$Valid = False;
				if (!isset($Meta['Badge']))
					$Valid = False;
				if (!isset($Meta['Visible']))
					$Valid = False;
				if (!isset($Meta['Tokens']))
					$Valid = False;
				if (!isset($Meta['Children']))
					$Valid = False;
				if (!isset($Meta['Target']))
					$Valid = False;

				if (!$Valid)
					break;

				if (is_array($Meta['Badge'])) {
					if (!isset($Meta['Badge']['Class']))
						$Valid = False;
				}
				if (is_array($Meta['Visible'])) {
					if (!isset($Meta['Visible']['LOGGEDIN']))
						$Valid = False;
					if (!isset($Meta['Visible']['NOTLOGGEDIN']))
						$Valid = False;
				}
				else{
					$Valid = False;
				}
				if (is_array($Meta['Children'])) {
					foreach ($Meta['Children'] as $Menu => $Meta) {
						if (!isset($Meta['Name']))
							$Valid = False;
						if (!isset($Meta['Icon']))
							$Valid = False;
						if (!isset($Meta['Badge']))
							$Valid = False;
						if (!isset($Meta['Visible']))
							$Valid = False;
						if (!isset($Meta['Tokens']))
							$Valid = False;
						if (!isset($Meta['Children']))
							$Valid = False;
						if (!isset($Meta['Target']))
							$Valid = False;
						if (is_array($Meta['Badge'])) {
							if (!isset($Meta['Badge']['Class']))
								$Valid = False;
						}
						if (is_array($Meta['Visible'])) {
							if (!isset($Meta['Visible']['LOGGEDIN']))
								$Valid = False;
							if (!isset($Meta['Visible']['NOTLOGGEDIN']))
								$Valid = False;
						}
						else{
							$Valid = False;
						}
						if ($Meta['Tokens'] && !is_array($Meta['Tokens'])) {
							$Valid = False;
						}
					}
				}
				if ($Meta['Tokens'] && !is_array($Meta['Tokens'])) {
					$Valid = False;
				}
			}
		}

		return $Valid;
	}
}
?>