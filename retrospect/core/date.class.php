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
	define('REG_DATE_GREG1','/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *([\d]{3,4}\/[\d]{2}|[\d]{3,4})$/');
	define('REG_DATE_GREG2','/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([\d]{4}\/[\d]{2}|[\d]{1,4})$/');
	define('REG_DATE_GREG3', '/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|) *([0-9]{1,2}) (JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC) ([\d]{4}\/[\d]{2}|[\d]{1,4})$/');
	define('REG_DATE_PERIOD', '/^FROM (.+) TO (.+)/');
	define('REG_DATE_RANGE', '/^BET (.+) AND (.+)/');
	define('REG_DATE_RANGE2', '/^(ABT|CIR|BEF|AFT|FROM|TO|EST|CAL|BET|) *(.+)-(.+)/');
	
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
	
	$DATE_MODS = array(
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
	
	# define date formats
	$DATE_FMTS = array();
	$DATE_FMTS[1] = array(
		'YMD'=>'j M Y',
		'YM' =>'M Y',
		'Y'  =>'Y'
	);
	$DATE_FMTS[2] = array(
		'YMD'=>'M j, Y',
		'YM' =>'M Y',
		'Y'  =>'Y'
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
			
		/**
		* Returns the date modifer code
		* @param string $string
		* @return string
		*/
		function _get_modifier ($string) {
			global $DATE_MODS;
			if ($string == '') {
				$modifier = DATE_MOD_NONE;
			}
			else {
				$modifier = $DATE_MODS[$string];
			}
				return $modifier;
		}
		
		function FormatDateStr ($date_arr) {
			if ($date_arr['date_str'] == '') return;
			elseif ($date_arr['date_mod'] == 'XX') return $date_arr['date_str'];
			else {
				# format dates and modifier
				$mod = $this->format_date_mod($date_arr['date_mod']);
				$date1 = $this->format_date_str2($date_arr['date1']);
				$date2 = $this->format_date_str2($date_arr['date2']);
				
				# format separator 
				if (($date_arr['date2'] != DATE_EMPTY) AND ($date_arr['date2'] != '')) {
					if ($date_arr['date_mod'] == DATE_MOD_FROM) $sep = gtc("to");
					elseif ($date_arr['date_mod'] == DATE_MOD_BET) $sep = gtc("and");
					else $sep = '-';
				}
				else $sep = '';
				
				$str = $mod.' '.$date1.' '.$sep.' '.$date2;
				return trim($str);
			}
		}
		
		function format_date_str2($date_str) {
			global $DATE_FMTS, $options;
			if ($date_str == DATE_EMPTY or $date_str == '') return;
			else {
				$fmt = $options->GetOption('date_format');
				$date_fmt = $DATE_FMTS[$fmt];
				preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})/', $date_str, $match);
				$year = $match[1];
				$month = $match[2];
				$day = $match[3];
	
				if ($month == '00' and $day == '00') {
					$ts = adodb_mktime(0,0,0, 7, 15, $year);
					$date = adodb_date($date_fmt['Y'], $ts); 
				}
				elseif ($day == '00') {
					$ts = adodb_mktime(0,0,0, $month, 15, $year);
					$date = lang_translate_date(adodb_date($date_fmt['YM'], $ts)); 
				}
				else {
					$ts = adodb_mktime('0','0','0', $month, $day, $year);
					$date = lang_translate_date(adodb_date($date_fmt['YMD'], $ts)); 
					
				}
				return $date;
			}
		}
		
		function format_date_mod($mod_str) {
			global $DATE_MODS;
			if ($mod = array_search($mod_str, $DATE_MODS)) {
				return lang_translate_mod($mod);
			}
			else return;
		}
	}
?>