<?php 
/**
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
 * @version			1.0
 *
 */  
 
/**
* Installation class
* @package installation
* @access public
*/
class Install {
	
	function CreateAllTables() {
		
	}
	
	function bool2str_fatal($p_bool) {
		global $fatal_error;
		if ($p_bool == true) {
			return 'YES';
		}
		else {
			$fatal_error = true;
			return 'NO';
		}
	}
	
	function bool2str_msg($p_bool, $p_msg) {
		if ($p_bool == true) {
			return 'YES';
		}
		else {
			return 'NO. '.$p_msg;
		}
	}
}
?>