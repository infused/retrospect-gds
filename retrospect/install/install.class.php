<?php 
/**
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
 * @license http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details.
 *
 * $Id$
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