<?php 
/**
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		themes
 * @license http://opensource.org/licenses/gpl-license.php
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
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
 * Theme class
 * @package themes
 */
class Theme {
		
	/**
	* Returns arguaments used to call the page
	* @param string $p_option
	* @param array $p_args
	* @return string
	*/
	function getArgs($p_option, $p_args = null) {
		if (empty($p_option)) return false;
		else {
			$arg_string = $_SERVER['PHP_SELF'].'?option='.$p_option;
			if (is_array($p_args)) {
				foreach($p_args as $arg => $val) {
					$arg_string .= '&'.$arg.'='.$val;
				}
			}
			return htmlentities($arg_string);
		}
	}
}
?>