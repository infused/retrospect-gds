<?php
/**
 * Gedcom classes
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
	define('REG_NEWREC','/^0/'); # New record
	define('REG_INDI','/^0 @(.+)@ INDI/'); 	# Beginning of Individual record
	define('REG_FAM','/^0 @[a-zA-Z0-9]+@ FAM/');		# Beginning of Family record
	define('REG_SOUR','/^0 @.+@ SOUR/');	# Beginning of Source record
	define('REG_NOTE1','/^0 (@.+@) NOTE(.*)/');	# Note record
	define('REG_NOTE2','/^[0-9]{1,2} NOTE [^@](.*)/');	# Alternate note record form
	define('REG_NAME','/^[0-9]{1,2} NAME (.*)/');  # Name with no surname
	define('REG_TITL','/^[0-9]{1,2} TITL (.*)/'); # Title (suffix)
	define('REG_SEX','/^[0-9]{1,2} SEX (.?)/'); # Sex
	
	
	/**
 	* GedcomParser class
 	* @package public
 	* @access public
 	*/
	class GedcomParser {
	
		var $filename; 
		var $fhandle;
		var $fsize;
		var $errors;
		var $lasterror;
		var $lines;
		var $individual_count;
		var $family_count;		
		var $source_count;
		var $note_count;
		var $onote_count;
		
		/**
		* GedcomParser class constructor
		* @access public
		*/
		function GedcomParser() {
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->startTimer('class_gedcomparser_constructor');
			}
			$this->errors = array();
			$this->lasterror = false; 
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->stopTimer('class_gedcomparser_constructor');
			}
		}
		
		/**
		* Opens the gedcom file in readonly mode and sets fhandle var.
		* @param $filename
		* @return boolean
		*/
		function OpenReadOnly($filename) {
			$handle = @fopen($filename, 'rb');
			if ($handle == false) {
				$this->_LogError('There was a problem opening the gedcom file');
				return false;
			} else {
				$this->filename = $filename;
				$this->fhandle = $handle;
				return true;
			}
		}
		
		/**
		* Alias for OpenReadOnly
		* @param $filename
		* @return boolean
		*/
		function Open($filename) {
			$tmp = $this->OpenReadOnly($filename);
			return $tmp;
		}
		
		/**
		* Close the gedcom file
		*/
		function Close() {
			@fclose($this->fhandle);
		}
		
		/**
		* Gather various statistics about the gedcom file
		*/
		function GetStatistics() {
			$handle = &$this->fhandle;
			$this->fsize = sprintf("%u", filesize($this->filename));
			$this->lines = $this->_CountLines();
			$icount = 0;
			$fcount = 0;
			$scount = 0;
			$ncount = 0;
			$ocount = 0;
			rewind($handle);
			while (!feof($handle)) {
				$line = fgets($handle);
				if (preg_match(REG_INDI, $line)) {
					$icount++;
				} elseif (preg_match(REG_FAM, $line)) {
					$fcount++;
				} elseif (preg_match(REG_SOUR, $line)) {
					$scount++;
				} elseif (preg_match(REG_NOTE1, $line)) {
					$ncount++;
				} elseif (preg_match(REG_NOTE2, $line)) {
					$ocount++;
				}
			}
			$this->individual_count = $icount;
			$this->family_count = $fcount;
			$this->source_count = $scount;
			$this->note_count = $ncount;
			$this->onote_count = $ocount;
		}
		
		/**
		* Parse the gedcom file
		*/
		function ParseGedcom() {
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->startTimer('class_GedcomParser_ParseGedcom');
			}
			$this->fsize = sprintf("%u", filesize($this->filename));
			$this->lines = $this->_CountLines();
			$icount = 0;
			$fcount = 0;
			$scount = 0;
			$ncount = 0;
			$ocount = 0;
			rewind($this->fhandle);
			while (!feof($this->fhandle)) {
				$line = fgets($this->fhandle);
				if (preg_match(REG_INDI, $line, $match)) {
					$icount++;
					$this->ParseIndividual($line, $match);
				} elseif (preg_match(REG_FAM, $line)) {
					$fcount++;
				} elseif (preg_match(REG_SOUR, $line)) {
					$scount++;
				} elseif (preg_match(REG_NOTE1, $line)) {
					$ncount++;
				} elseif (preg_match(REG_NOTE2, $line)) {
					$ocount++;
				}
			}
			# update counts
			$this->individual_count = $icount;
			$this->family_count = $fcount;
			$this->source_count = $scount;
			$this->note_count = $ncount;
			$this->onote_count = $ocount;
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->stopTimer('class_GedcomParser_ParseGedcom');
			}
		}
		
		/**
		* Parse Individual
		*/
		function ParseIndividual($line, $match) {
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->startTimer('class_GedcomParser_ParseIndividual');
			}
			# init vars
			$name_count = -1;
			$name_list = array();
			$end = false;
			$title = '';
			$gname = '';
			$sname = '';
			$sex = '';
			
			$indkey = $match[1];
			# let's get the rest of the record
			while (!feof($this->fhandle)) {
				$offset = ftell($this->fhandle); // get offset so we can back up at end of record
				$line = fgets($this->fhandle);
				# process name tags
				if (preg_match(REG_NAME, $line, $match)) {  
					$name_count++;
					$name = $match[1];
					$name_array = explode(' ', $name);
					foreach($name_array as $n) {
						if (strpos($n,'/') !== false) {
							$sname = trim(trim($n),'/');  
							
						}
						else {
							$gname .= trim($n).' ';
						}
					}
					# stuff the name strings you know where
					$name_list[$name_count]['sname'] = $sname;
					$name_list[$name_count]['gname'] = trim($gname);
				} 
				elseif (preg_match(REG_TITL, $line, $match)) {
					# obviously any alternate title will overwrite the last
					$title = $match[1];
				}
				elseif (preg_match(REG_SEX, $line, $match)) {
					$sex = $match[1];
				}
				# detect end of record
				elseif (preg_match(REG_NEWREC, $line)) {
					$end = true;
				} 
				if ($end) {
					# dump record details
					# ignore alternate names (for now)
					echo '"'.$indkey.'","'.$name_list[0]['sname'].'","'.$name_list[0]['gname'].'","'.$sex.'"<br>';
					fseek($this->fhandle, $offset);
					break;
				}
			}
			if ($GLOBALS['profile'] == true) {
				$GLOBALS['profiler']->stopTimer('class_GedcomParser_ParseIndividual');
			}
		}
		
		/**
		* Count the total number of lines in the file
		*/
		function _CountLines() {
			$handle = &$this->fhandle;
			$lines = -1;
			rewind($handle);
			while (!feof($handle)) {
				fgets($handle);
				$lines++;
			}
			return $lines;
		}
		
		/**
		* Logs errors into $errors array and $lasterror
		*/
		function _LogError($message) {
			$this->lasterror = $message;
			$this->errors[] = $message;
		}
		
		function _IsXREF($text) {
			return ereg('^@[a-zA-Z0-9]*@', $text);
		}
		
 	}
 
?>