<?php
namespace TwoDOt7\Bit\in_ac_ducic_library\Controller;

function init() {
	switch ($_GET['BitAction']) {
	 	case 'catalogue':
	 		return array(
	 			'Call' => 'Catalogue',
	 			'LOL' => 'LOL');
	 		break;
	 	case 'request':
	 		return array(
	 			'Call' => 'Request',
	 			'data1' => 'LOL'
	 			);
	 	default:
	 		return array(
	 			'Call' => 'FourOFour');
	 		break;
	 }
}

?>