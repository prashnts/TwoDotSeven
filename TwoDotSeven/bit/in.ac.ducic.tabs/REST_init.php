<?php
namespace TwoDOt7\Bit\in_ac_ducic_tabs\REST;

function init() {
	switch ($_GET['BitAction']) {
	 	case 'catalogue':
	 		return array(
	 			'Call' => 'Catalogue',
	 			'LOL' => 'Lkj,nlkmlOL');
	 		break;
	 	case 'requesst':
	 		return array(
	 			'Call' => 'Request',
	 			'data1' => 'LOL'
	 			);
	 	default:
	 		var_dump(array(
	 			'Call' => 'FourOFour'));
	 		break;
	 }
}
?>