<?php
/**
 * Gedcom date classes
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		gedcom
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

	# Define regular expressions
	# DateParser structures
	define('REG_DATE_EXACT', '/([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{1,4}|[0-9]{4}\/[0-9]{2})/');
	
	/**
 	* GedcomParser class 
 	* @package public
 	* @access public
 	*/
	class DateParser {
		
		function DataParser() {
		
		}
		
		function ParseDate($datestr) {
			if (preg_match($datestr) {
				echo 'match';
			}
		}
	}
?>