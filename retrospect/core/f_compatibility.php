<?php 
/**
 * Compatibility Functions.
 * Replacement functions to support older versions of PHP.
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		compatibility
 * @version			1.0
 * @license http://opensource.org/licenses/gpl-license.php
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
 */

if (!function_exists('html_entity_decode')) {
	/**
	* html_entity_decode. 
	* This function is available in PHP4 > 4.3.0
	* @access public
	* @param string $string string to decode
	* @return string the decoded string
	*/
	function html_entity_decode($string) {
  	$string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES)));
    $string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string);
    return $string;
	}	 
}
?>