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
	define('REG_DATE_EXACT', '/^([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{4}\/[0-9]{2}|[0-9]{1,4})/');
	define('REG_DATE_YEAR','/^([0-9]{3,4}\/[0-9]{2}|[0-9]{3,4})/');
	
	$months = array(
		'JAN'=>'01',
		'FEB'=>'02',
		'MAR'=>'03',
		'APR'=>'04',
		'MAY'=>'05',
		'JUN'=>'06',
		'JUL'=>'07',
		'AUG'=>'08',
		'SEP'=>'09',
		'OCT'=>'10',
		'NOV'=>'11',
		'DEC'=>'12');
	
	/**
 	* GedcomParser class
	* 
 	* @package public
 	* @access public
 	*/
	class DateParser {
		var $pdate;							// the latest parsed date returned from ParseDate()
		var $sdate;							// the lastest date string passed to ParseDate()
		
		function ParseDate($string) {
			# reset variables
			$this->pdate = null;
			$this->sdate = $string;
			# convert date string to uppercase
			$datestr = strtoupper($string);
			# process exact dates
			if (preg_match(REG_DATE_YEAR, $datestr, $match)) {
				$year = $this->_get_year($match[1]);
				$this->pdate = '000000'.$year.'0000000000';
			}
			elseif (preg_match(REG_DATE_EXACT, $datestr, $match)) {
				$date = $this->_get_date_exact($match);
				$this->pdate = $date;
			}
		}
		
		function _get_date_exact ($preg_match) {
			global $months;
			# get the day and pad to 2 digits
			$day .= str_pad($preg_match[1], 2, '0', STR_PAD_LEFT);
			# get the month and pad to 2 digits
			$month = str_pad($months[$preg_match[2]], 2, '0', STR_PAD_LEFT);
			# get the year
			$year = $this->_get_year($preg_match[3]);
			$date = '00'.$day.$month.$year.'0000000000';
			return $date;
		}
		
		function _get_year($yearstr) {
			if (strpos($yearstr, '/') === false) {
				$year = str_pad($yearstr, 4, '0', STR_PAD_LEFT);
			}
			else {
				$old_sys_year = explode('/', $yearstr);
				$new_sys_year = $old_sys_year[0] + 1;
				$year = str_pad($new_sys_year, 4, '0', STR_PAD_LEFT);
			}
			return $year;
		}
		
		//function _get_day ($daystring
	}
?>