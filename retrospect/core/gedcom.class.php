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
 
  # Define gedcom tags
	define('TAG_INDI','INDI'); 	# Individual
	define('TAG_FAM','FAM');   	# Family
	define('TAG_NAME','NAME');	# Name
	
	# Define regular expressions
	define('REG_INDI','^0 @[a-zA-Z0-9]*@ INDI'); 	# Beginning of Individual record
	define('REG_FAM','^0 @[a-zA-Z0-9]*@ FAM');		# Beginning of Family record
	define('REG_SOUR','^0 @[a-zA-Z0-9]*@ SOUR');	# Beginning of Source record
	define('REG_NOTE','^0 @[a-zA-Z0-9]*@ NOTE');	# Beginning of Note record
	
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
		
		/**
		* GedcomParser class constructor
		* @access public
		*/
		function GedcomParser() {
			$this->errors = array();
			$this->lasterror = false; 
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
			rewind($handle);
			while (!feof($handle)) {
				$line = fgets($handle);
				if (ereg(REG_INDI, $line)) {
					$icount++;
				} elseif (ereg(REG_FAM, $line)) {
					$fcount++;
				} elseif (ereg(REG_SOUR, $line)) {
					$scount++;
				} elseif (ereg(REG_NOTE, $line)) {
					$ncount++;
				}
			}
			$this->individual_count = $icount;
			$this->family_count = $fcount;
			$this->source_count = $scount;
			$this->note_count = $ncount;
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
 	}
 
?>