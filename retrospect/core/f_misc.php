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
	
	function format_date_str($date) {
		global $modifiers;
		# return false if no date
		if ($date['date_str'] == '') return false;

		$date_mod = $date['date_mod'];
		$date1 = $date['date1'];
		$date2 = $date['date2'];
		$date_str = $date['date_str'];
		
		
		
		$str = '';
		if (!empty($date['date_mod'])) {
			if ($mod = array_search($date['date_mod'], $modifiers)) {
				$str .= gtc($mod);
		  }
		}
		return $str;
	}
	
	function explode_yyyymmdd($datestr) {
		if (($datestr == DATE_EMPTY) OR ($datestr == '')) return false;
		else {
			$date = array();
			preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})/', $datestr, $match);
			$date['year'] = $match[1];
			$date['month'] = $match[2];
			$date['day'] = $match[3];
			return $date;
		}
	}
	
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