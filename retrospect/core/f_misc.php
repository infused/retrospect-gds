<?php 
/**
 * Miscellaneous Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
 * @license http://opensource.org/licenses/gpl-license.php
 *
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
	* Push item onto keyword array and enforce size limit.
	* Only unique keywords are added to the array
	* @param string $keyword
	*/
	function keyword_push($keyword) {
		global $keywords;
		$max_size = 32;
		if (count($keywords) < $max_size AND array_search($keyword, $keywords) === false) {
			$keywords[] = $keyword;
		}
	}	
	
	/**
	* Format file size
	* @param integer $size Size in bytes
	* @return string
	*/
	function filesize_format($size) {
		$sizes = Array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
		$ext = $sizes[0];
		for ($i=1; (($i < count($sizes)) && ($size >= 1024)); $i++) {
		 $size = $size / 1024;
		 $ext  = $sizes[$i];
		}
		return round($size, 2).$ext;
	}
?>