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
	define('REG_DATE_GREG1','/^([0-9]{3,4}\/[0-9]{2}|[0-9]{3,4})/');
	define('REG_DATE_GREG2','/^(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{4}\/[0-9]{2}|[0-9]{1,4})/');
	define('REG_DATE_GREG3', '/^([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{4}\/[0-9]{2}|[0-9]{1,4})/');
	define('REG_DATE_PERIOD', '/^(FROM|TO) (.+)/');
	
	# Define some aliases
	define('REG_DATE_YEAR', REG_DATE_GREG1);
	define('REG_DATE_EXACT', REG_DATE_GREG3);
	define('REG_DATE_MOYR', REG_DATE_GREG2);
	
	# Define modifiers
	define('DATE_FROM', '01');
	define('DATE_TO', '02');
	define('DATE_BEF', '03');
	define('DATE_AFT', '04');
	define('DATE_BET', '05');
	
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
		
		function ParseDate ($string) {
			# reset variables
			$this->pdate = null;
			$this->sdate = $string;
			# convert date string to uppercase
			$datestr = strtoupper($string);
			# process exact dates
			if (preg_match(REG_DATE_YEAR, $datestr, $match)) {
				$year = $this->_get_greg1($match[1]);
				$this->pdate = '000000'.$year.'0000000000';
			}
			elseif (preg_match(REG_DATE_MOYR, $datestr, $match)) {
				$date = $this->_get_greg2($match);
				$this->pdate = $date.'0000000000';
			}
			elseif (preg_match(REG_DATE_EXACT, $datestr, $match)) {
				$date = $this->_get_greg3($match);
				$this->pdate = $date.'0000000000';
			}
			elseif (preg_match(REG_DATE_PERIOD, $datestr, $match)) {
				$date = $this->_get_period($match);
				$this->pdate = $date;
			}
		}
		
		/**
		* Parses an exact date in the form of: <DAY> <MONTH> <YEAR>
		* Returns a date code for a valid date 
		* Returns false for an invalid date
		* @param array $preg_match [1]=>day, [2]=>month, [3]=>year
		* @return string
		*/
		function _get_greg3 ($date_arr) {
			global $months;
			# get the day and pad to 2 digits
			$day .= str_pad($date_arr[1], 2, '0', STR_PAD_LEFT);
			# get the month and pad to 2 digits
			$month = str_pad($months[$date_arr[2]], 2, '0', STR_PAD_LEFT);
			# get the year
			$year = $this->_get_greg1($date_arr[3]);
			$date = '00'.$day.$month.$year;
			if (checkdate($month, $day, $year)) {
				return $date;
			}
			else {
				return false;
			}
		}
		
		/**
		* Parses the year and converts dual years to new system years.
		* - 1750/51 become 1751
		* - 1733 stays 1733 (assumed new system)
		* - Years are padded to 4 digits, so 809 becomes 0809
		* @param string $yearstring
		* @return string
		*/
		function _get_greg1 ($yearstr) {
			if (strpos($yearstr, '/') === false) {
				$year = str_pad($yearstr, 4, '0', STR_PAD_LEFT);
			}
			else {
				$old_sys_year = explode('/', $yearstr);
				$new_sys_year = $old_sys_year[0] + 1;
				# pad the year to 4 digits
				$year = str_pad($new_sys_year, 4, '0', STR_PAD_LEFT);
			}
			return $year;
		}
		
		/**
		* Parses dates in the form of: <MONTH> <YEAR>
		* @param array $date_arr
		* @return string
		*/
		function _get_greg2 ($date_arr) {
			global $months;
			$day = '00';
			# get the month and pad to 2 digits
			$month = str_pad($months[$date_arr[1]], 2, '0', STR_PAD_LEFT);
			# get the year
			$year = $this->_get_greg1($date_arr[2]);
			$date = '00'.$day.$month.$year;
			# validate date (fake the day!) 
			if (checkdate($month, '01', $year)) {
				return $date;
			}
			else {
				return false;
			}
		}
		
		/** 
		* Parses date period in the following forms:
		* FROM <DATE>
		* TO <DATE>
		* FROM <DATE> TO <DATE>
		* @param array $date_arr
		* @return string
		*/
		function _get_period ($date_arr) {
			$date_str =& $date_arr[2];
			if ($date_arr[1] == 'FROM') {
				echo $date_str;
			}
			elseif ($date_arr[1] == 'TO') {
				if (preg_match(REG_DATE_EXACT, $date_str, $match)) {
					$date = $this->_get_greg3($match);
					echo $date;
				}
			}
		}
	}
?>