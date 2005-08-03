<?php 
/**
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
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
 */
 
 /**
 * $Id$
 */
 
 	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
 
/**
* Theme class
* @package themes
* @subpackage classes
*/
class Theme {
	
	function BuildUrl ($parameters) {
		$baseurl = $_SERVER['PHP_SELF'];
		$params = '';  
		$sep = '?';
		if (is_array($parameters)) {
			foreach($parameters as $key => $value) {
				$params .= $sep.urlencode($key).'='.urlencode($value);
				$sep = '&amp;';
			}
		}
		return $params;
	}
	
	function BuildLink ($url, $text) {
		if (is_string($url)) return '<a href="'.$url.'">'.$text.'</a>';
		elseif (is_array($url)) return '<a href="'.Theme::BuildUrl($url).'">'.$text.'</a>';
		else return null;
	}
}
?>