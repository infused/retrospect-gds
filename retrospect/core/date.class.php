<?php
/**
 * Gedcom parser class
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
	# Gedcom compliant structures
	define('REG_DATE_GREG1','/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *([0-9]{3,4}\/[0-9]{2}|[0-9]{3,4})$/');
	define('REG_DATE_GREG2','/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{4}\/[0-9]{2}|[0-9]{1,4})$/');
	define('REG_DATE_GREG3', '/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([0-9]{4}\/[0-9]{2}|[0-9]{1,4})$/');
	define('REG_DATE_PERIOD', '/^FROM (.+) TO (.+)/');
	define('REG_DATE_RANGE', '/^BET (.+) AND (.+)/');
	define('REG_DATE_RANGE2', '/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|BET|) *(.+)-(.+)/');
	
	# Gedcom non-compliant structures
	define('REG_DATE_DYMO', '/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)$/');
	
	# Define some aliases
	define('REG_DATE_YEAR', REG_DATE_GREG1);
	define('REG_DATE_EXACT', REG_DATE_GREG3);
	define('REG_DATE_MOYR', REG_DATE_GREG2);
	
	# Define modifiers
	define('DATE_MOD_NONE', '00');
	define('DATE_MOD_ABT',  '10');
	define('DATE_MOD_CIR',  '20');
	define('DATE_MOD_BEF',  '30');
	define('DATE_MOD_AFT',  '40');
	define('DATE_MOD_BET',  '50');
	define('DATE_MOD_FROM', 'F0');
	define('DATE_MOD_TO',   'T0');
	define('DATE_MOD_EST',  'G0');
	define('DATE_MOD_CAL',  'H0');
	define('DATE_MOD_INVALID', 'XX');
	define('DATE_EMPTY', '00000000');
	
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
		'DEC'=>'12'
	);
	
	$modifiers = array(
		'ABT'=>DATE_MOD_ABT,
		'CIR'=>DATE_MOD_CIR,
		'BEF'=>DATE_MOD_BEF,
		'AFT'=>DATE_MOD_AFT,
		'FROM'=>DATE_MOD_FROM,
		'TO'=>DATE_MOD_TO,
		'EST'=>DATE_MOD_EST,
		'CAL'=>DATE_MOD_CAL,
		'BET'=>DATE_MOD_BET
	);
	
	/**
 	* GedcomParser class
	* 
 	* @package public
 	* @access public
 	*/
	class DateParser {
		var $pdate;							// array containing mod, date1, date2
		var $sdate;							// the lastest date string passed to ParseDate()
		var $mod;
		var $date1;
		var $date2;
		
		/**
		* ParseDate 
		* @param string $string
		*/
		function ParseDate ($string) {
			# reset variables
			$this->pdate = null;
			$this->mod = null;
			$this->date1 = null;
			$this->date2 = null;
			$this->sdate = $string;
			
			# convert date string to uppercase
			$datestr = strtoupper(trim($string));
			# process exact dates
			if (preg_match(REG_DATE_YEAR, $datestr, $match)) {
				$year = $this->_get_greg1($match[2]);
				$this->pdate['mod'] = $this->_get_modifier($match[1]);
				$this->pdate['date1'] = $year . '0000';
				$this->pdate['date2'] = DATE_EMPTY;
			}
			elseif (preg_match(REG_DATE_MOYR, $datestr, $match)) {
				$date = $this->_get_greg2($match);
				$this->pdate['mod'] = $this->_get_modifier($match[1]);
				$this->pdate['date1'] = $date;
				$this->pdate['date2'] = DATE_EMPTY;
			}
			elseif (preg_match(REG_DATE_EXACT, $datestr, $match)) {
				$date = $this->_get_greg3($match);
				$this->pdate['mod'] = $this->_get_modifier($match[1]);
				$this->pdate['date1'] = $date;
				$this->pdate['date2'] = DATE_EMPTY;
			}
			elseif (preg_match(REG_DATE_PERIOD, $datestr, $match)) {
				$date = $this->_get_period($match);
				$this->pdate = $date;
			}
			elseif (preg_match(REG_DATE_RANGE, $datestr, $match)) {
				$date = $this->_get_range($match);
				$this->pdate = $date;
			}
			elseif (preg_match(REG_DATE_RANGE2, $datestr, $match)) {
				$date = $this->_get_range2($match);
				$this->pdate = $date;
			}
			elseif (preg_match(REG_DATE_DYMO, $datestr, $match)) {
				$date = $this->_get_dymo($match);
				$this->pdate['mod'] = $this->_get_modifier($match[1]);
				$this->pdate['date1'] = $date;
				$this->pdate['date2'] = DATE_EMPTY;
			}
			else {
				$this->pdate['mod'] = DATE_MOD_INVALID;
				$this->pdate['date1'] = '';
				$this->pdate['date2'] = '';
				$this->mod = DATE_MOD_INVALID;
				$this->date1 = '';
				$this->date2 = '';
			}
			$this->mod = $this->pdate['mod'];
			$this->date1 = $this->pdate['date1'];
			$this->date2 = $this->pdate['date2'];
		}
		
		function _parse_date_string ($string) {
			# convert date string to uppercase
			$datestr = strtoupper(trim($string));
			# process exact dates
			if (preg_match(REG_DATE_YEAR, $datestr, $match)) {
				$year = $this->_get_greg1($match[2]);
				$modifier = $this->_get_modifier($match[1]);
				return $year . '0000';
			}
			elseif (preg_match(REG_DATE_MOYR, $datestr, $match)) {
				$date = $this->_get_greg2($match, false);
				return $date;
			}
			elseif (preg_match(REG_DATE_EXACT, $datestr, $match)) {
				$date = $this->_get_greg3($match, false);
				return $date;
			}
			elseif (preg_match(REG_DATE_DYMO, $datestr, $match)) {
				$date = $this->_get_dymo($match, false);
				return $date;
			}
		}
		
		function _get_period ($date_arr) {
			$date['mod'] = DATE_MOD_FROM;
			$date['date1'] = $this->_parse_date_string($date_arr[1]);
			$date['date2'] = $this->_parse_date_string($date_arr[2]);
			return $date;
		}
		
		function _get_range ($date_arr) {
			$date['mod'] = DATE_MOD_BET;
			$date['date1'] = $this->_parse_date_string($date_arr[1]);
			$date['date2'] = $this->_parse_date_string($date_arr[2]);
			return $date;
		}
		
		function _get_range2 ($date_arr) {
			$modifier = $this->_get_modifier($date_arr[1]);
			if ($modifier != '') {
				$date['mod'] = $this->_get_modifier($date_arr[1]);
			}
			else {
				$date['mod'] = DATE_MOD_FROM;
			}
			$date['date1'] = $this->_parse_date_string($date_arr[2]);
			$date['date2'] = $this->_parse_date_string($date_arr[3]);
			return $date;
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
		* @param bool $return_modifier whether to return the modifier prepended to the date string
		* @return string
		*/
		function _get_greg2 ($date_arr) {
			global $months;
			$day = '00';
			$month_str =& $date_arr[2];
			$year_str =& $date_arr[3];
			# get the month and pad to 2 digits
			$month = str_pad($months[$month_str], 2, '0', STR_PAD_LEFT);
			# get the year
			$year = $this->_get_greg1($year_str);
			$date = $year.$month.$day;
			# validate date (fake the day!) 
			if (checkdate($month, '01', $year)) {
				return $date;
			}
			else {
				return false;
			}
		}
	
		/**
		* Parses an exact date in the form of: <DAY> <MONTH> <YEAR>
		* Returns a date code for a valid date 
		* Returns false for an invalid date
		* @param array $preg_match [1]=>day, [2]=>month, [3]=>year
		* @param bool $return_modifier whether to return the modifier prepended to the date string
		* @return string
		*/
		function _get_greg3 ($date_arr) {
			global $months;
			$day_str =& $date_arr[2];
			$month_str =& $date_arr[3];
			$year_str =& $date_arr[4];
			# get the day and pad to 2 digits
			$day = str_pad($day_str, 2, '0', STR_PAD_LEFT);
			# get the month and pad to 2 digits
			$month = str_pad($months[$month_str], 2, '0', STR_PAD_LEFT);
			# get the year
			$year = $this->_get_greg1($year_str);
			$date = $year.$month.$day;
			if (checkdate($month, $day, $year)) {
				return $date;
			}
			else {
				return false;
			}
		}
		
		function _get_dymo ($date_arr) {
			global $months;
			$day_str =& $date_arr[2];
			$month_str =& $date_arr[3];
			# get the day and pad to 2 digits
			$day = str_pad($day_str, 2, '0', STR_PAD_LEFT);
			# get the month and pad to 2 digits
			$month = str_pad($months[$month_str], 2, '0', STR_PAD_LEFT);
			$year = '0000';
			$date = $year.$month.$day;
			if (checkdate($month, $day, '0001')) {
				return $date;
			}
			else {
				return false;
			}
		}
			
		/**
		* Returns the date modifer code
		* @param string $string
		* @return string
		*/
		function _get_modifier ($string) {
			global $modifiers;
			if ($string == '') {
				$modifier = DATE_MOD_NONE;
			}
			else {
				$modifier = $modifiers[$string];
			}
				return $modifier;
		}
	}
?>