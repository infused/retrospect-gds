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
	# Main record structures
	define('REG_NEWREC','/^0/'); 								# New record
	define('REG_HEAD','/^0 HEAD/');							# Beginning of Header record
	define('REG_INDI','/^0 @(.+)@ INDI/'); 			# Beginning of Individual record
	define('REG_FAM','/^0 @(.+)+@ FAM/');				# Beginning of Family record
	define('REG_SOUR','/^0 @(.+)@ SOUR/');			# Beginning of Source record
	define('REG_NOTE','/^0 @(.+)@ NOTE(.*)/');	# Beginning of Note record
	
	# Record substructures
	# Header substructures
	define('REG_HSOUR','/^1 SOUR (.*)/'); 			# Software
	define('REG_HVERS','/^2 VERS (.*)/'); 			# Software version
	define('REG_HNAME','/^2 NAME (.*)/'); 			# Software name
	define('REG_HDATE','/^1 DATE (.*)/'); 			# Submission date
	
	# Individual substructures
	define('REG_NAME','/^1 NAME (.*)/');  			# Name 
	define('REG_GIVN','/^2 GIVN (.*)/'); 				# Given name
	define('REG_SURN','/^2 SURN (.*)/'); 				# Surname
	define('REG_NICK','/^2 NICK (.*)/'); 				# Nickname (aka)
	define('REG_NPFX','/^2 NPFX (.*)/'); 				# Name prefix (ie. Captain)
	define('REG_NSFX','/^2 NSFX (.*)/'); 				# Name suffic (ie. Jr.) 
	define('REG_SEX','/^1 SEX (.?)/'); 					# Sex
	define('REG_TITL','/^1 TITL (.*)/');				# Title (suffix)
	define('REG_NOTEX','/^1 NOTE @(.+)@/'); 		# Note xref
	
	# Family substructures
	define('REG_HUSB','/^1 HUSB @(.+)@/');			# Husband xref
	define('REG_WIFE','/^1 WIFE @(.+)@/');			# Wife xref
	define('REG_MARR','/^1 MARR/');							# Marriage
	
	# Note substructures
	define('REG_CONT','/^1 CONT (.+)/');				# Continuation
	define('REG_CONC','/^1 CONC (.+)/');				# Concatenation
	
	# Event substructures
	define('REG_FAME','/^1 (ANUL|CENS|DIV|DIVF|ENGA|MARR|MARB|MARC|MARL|MARS|EVEN)(.+)/'); # Family Event
	define('REG_DATE','/^2 DATE (.+)/');				# Event date
	define('REG_TYPE','/^2 TYPE (.+)/');				# Event type
	define('REG_PLAC','/^2 PLAC (.+)/');				# Event place
	
	# Miscelaneous 
	define('REG_LEVEL','/^([0-9]{1,2})/');	
	
	$FAM_EVENTS = array(
		'ANUL'=>'Annulment',
		'CENS'=>'Census',
		'DIV'=>'Divorce',
		'DIVF'=>'Divorce Filed',
		'ENGA'=>'Engagement',
		'MARR'=>'Marriage',
		'MARB'=>'Marriage Bann',
		'MARC'=>'Marriage Contract',
		'MARL'=>'Marriage License',
		'MARS'=>'Marriage Settlement'
		);
	
	/**
 	* GedcomParser class 
 	* @package public
 	* @access public
 	*/
	class GedcomParser {
	
		var $filename; 					// filename 
		var $fhandle; 					// file handle
		var $fsize;							// file size
		var $individual_count;	// count of individual records
		var $family_count;			// count of family records
		var $source_count;			// count of source records
		var $note_count;				// count of note records
		var $onote_count;				// count of orphaned note records
		var $rs_indiv;					// indiv adodb recordeset object
		var $rs_note;						// note adodb recordset object
		var $rs_family;					// family adodb recordset object
		var $rs_fact;						// fact adodb recordset object
		var $db;								// local var for $GLOBALS['db']
		
		/**
		* GedcomParser class constructor
		* @access public
		*/
		function GedcomParser() {
			$this->db = &$GLOBALS['db'];
			# get empty indiv recordset
			$sql = 'SELECT * from '.$GLOBALS['g_tbl_indiv'].' where indkey=-1';
			$this->rs_indiv = $GLOBALS['db']->Execute($sql);
			# get empty note recordset
			$sql = 'SELECT * from '.$GLOBALS['g_tbl_note'].' where notekey=-1';
			$this->rs_note = $GLOBALS['db']->Execute($sql);
			# get empty family recordset
			$sql = 'SELECT * from '.$GLOBALS['g_tbl_family'].' where famkey=-1';
			$this->rs_family = $GLOBALS['db']->Execute($sql);
			# get empty fact recordset
			$sql = 'SELECT * from '.$GLOBALS['g_tbl_fact'].' where indfamkey=-1';
			$this->rs_fact = $GLOBALS['db']->Execute($sql);
		}
		
		/**
		* Opens the gedcom file in readonly mode and sets fhandle var.
		* @param $filename
		* @return boolean
		*/
		function OpenReadOnly($filename) {
			if (is_file($filename)) {  // make sure that it's really a file
				$handle = @fopen($filename, 'rb');
				if ($handle == false) {
					return false;
				} else {
					$this->filename = $filename;
					$this->fhandle = $handle;
					return true;
				}
			}
			else {
				return false;
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
				} 
				elseif (preg_match(REG_FAM, $line)) {
					$fcount++;
				} 
				elseif (preg_match(REG_SOUR, $line)) {
					$scount++;
				} 
				elseif (preg_match(REG_NOTE, $line)) {
					$ncount++;
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
		* Please note that this function sends some output to the browser
		*/
		function ParseGedcom() {
			rewind($this->fhandle);
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				if (preg_match(REG_INDI, $line)) {
					$this->_ParseIndividual($line);
				} 
				elseif (preg_match(REG_FAM, $line)) {
					$this->_ParseFamily($line);
				} 
				elseif (preg_match(REG_SOUR, $line)) {

				} 
				elseif (preg_match(REG_NOTE, $line)) {
					$this->_ParseNote($line);
				} 
			}
		}
		
		/**
		* Parse Individual
		* @param string $start_line
		*/
		function _ParseIndividual($start_line) {
			$indiv = array();
			$names = array();  
			preg_match(REG_INDI, $start_line, $match);
			$indiv['indkey'] = $match[1];
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$level = $this->_ExtractLevel($line);
				# dump record to db if reached end of indi record
				if ($level == 0) { 
					$recordset = array_merge($indiv, $names[0]);
					$this->_DB_InsertRecord($this->rs_indiv, $recordset);
					fseek($this->fhandle, $poffset);
					return;
				}
				elseif (preg_match(REG_NAME, $line)) {							// name structure
					$name = $this->_ParseNameStruct($line);
					array_push($names, $name);
				}
				elseif (preg_match(REG_SEX, $line, $match)) {
					$indiv['sex'] = trim($match[1]);
				}
				elseif (preg_match(REG_NOTEX, $line, $match)) {
					$indiv['notekey'] = trim($match[1]);
				}
			}
		}
		
		/**
		* Parse Note record
		* @param string $start_line
		*/
		function _ParseNote($start_line) {	
			$note = array();
			$text = '';
			preg_match(REG_NOTE, $start_line, $match);
			$note['notekey'] = $match[1];
			if (isset($match[2])) {
				$text .= $match[2];
			}
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$level = $this->_ExtractLevel($line);
				# dump record to db if reached end of note record
				if ($level == 0) {
					$note['text'] = trim($text);
					$this->_DB_InsertRecord($this->rs_note, $note);
					fseek($this->fhandle, $poffset);
					return;
				}
				elseif (preg_match(REG_CONC, $line, $match)) {
					$text .= trim($match[1]);
				}
				elseif (preg_match(REG_CONT, $line, $match)) {
					$text .= "\r\n".trim($match[1]);
				}
			}
		}
		
		/**
		* Parse Family record
		* @param string $start_line
		*/
		function _ParseFamily($start_line) {
			$family = array();
			$events = array();
			preg_match(REG_FAM, $start_line, $match);
			$family['famkey'] = $match[1];
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$level = $this->_ExtractLevel($line);
				# dump record to db if reached end of family record
				if ($level == 0) {
					$this->_DB_InsertRecord($this->rs_family, $family);
					foreach ($events as $event) {
						$this->_DB_InsertRecord($this->rs_fact, $event);
					}
					fseek($this->fhandle, $poffset);
					return;
				}
				# create husband link
				elseif (preg_match(REG_HUSB, $line, $match)) {
					$family['spouse1'] = $match[1];
				}
				# create wife link
				elseif (preg_match(REG_WIFE, $line, $match)) {
					$family['spouse2'] = $match[1];
				}
				# create note link
				elseif (preg_match(REG_NOTEX, $line, $match)) {
					$family['notekey'] = trim($match[1]);
				}
				# parse event and populate begin/end status
				elseif (preg_match(REG_FAME, $line)) {
					$event = $this->_ParseFamilyEventDetail($line, $family['famkey']);
					array_push($events, $event);
					switch ($event['type']) {
						case 'Marriage':
							$family['beginstatus'] = 'Married';
							break;
						case 'Friends':
							$family['beginstatus'] = 'Friends';
							break;
						case 'Partners':
							$family['beginstatus'] = 'Partners';
							break;
						case 'Divorce':
							$family['endstatus'] = 'Divorced';
							break;
						case 'Annulment':
							$family['endstatus'] = 'Anulled';
							break;
					}
				}
			}
		}
		
		/**
		* Parse event detail
		* @param string $start_line
		* @param string $indfamkey
		* @return array
		*/
		function _ParseFamilyEventDetail($start_line, $indfamkey) {
			global $FAM_EVENTS;
			$event = array();
			preg_match(REG_FAME, $start_line, $match);
			$key = &$match[1];
			if ($key != 'EVEN') {
				$event['type'] = $FAM_EVENTS[$key];		
			}
			else { 
				echo $start_line.' - '.$match[2].'<br>';
			}
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$level = $this->_ExtractLevel($line);
				# return record to calling function if end of structure
				if ($level <= 1) {
					fseek($this->fhandle, $poffset);
					return $event;
				}
				elseif (preg_match(REG_DATE, $line, $match)) {
					$event['date'] = trim($match[1]);
				}
				elseif (preg_match(REG_TYPE, $line, $match)) {
					$event['type'] = trim($match[1]);
				}
				elseif (preg_match(REG_PLAC, $line, $match)) {
					$event['place'] = trim($match[1]);
				}
			}

		}
		
		/**
		* Parse name structure
		* @param string $start_line
		* return array
		*/
		function _ParseNameStruct($start_line) {
			$name = array();
			$name['givenname'] = '';
			$name['surname'] = '';
			$name['aka'] = '';
			$name['prefix'] = '';
			$name['suffix'] = '';
			
			# process name parts from name tag line
			preg_match(REG_NAME, $start_line, $match); 
			$rawname = $match[1];
			$parts = explode(' ', $rawname);
			foreach ($parts as $part) {
				$part = trim($part);
				if (isset($part[0]) AND $part[0] == '/') {
					$name['surname'] = trim($part, '/');
				}
				else {
					if ($name['givenname'] == '') {
						$name['givenname'] = $part;
					}
					else {
						$name['givenname'] .= ' '.$part;
					}
				}
			}
			# handle any subordinate tags
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$level = $this->_ExtractLevel($line);
				# return record if reached end of name record
				if ($level <= 1) { 
					fseek($this->fhandle, $poffset);
					return $name;
				}
				elseif (preg_match(REG_GIVN, $line, $match)) {	// given name
					$name['givenname'] = trim($match[1]);
				}
				elseif (preg_match(REG_SURN, $line, $match)) {	// surname
					$name['surname'] = trim($match[1]);
				}
				elseif (preg_match(REG_NICK, $line, $match)) {	// nickname (aka)
					$name['aka'] = trim($match[1]);
				}
				elseif (preg_match(REG_NPFX, $line, $match)) {	// prefix
					$name['prefix'] = trim($match[1]);
				}
				elseif (preg_match(REG_NSFX, $line, $match)) {	// suffix
					$name['suffix'] = trim($match[1]);
				}
			}
		}
		
		/**
		* Extracts the level from a given line
		* @param string $line
		* @return string
		*/
		function _ExtractLevel($line) {
			$parts = explode(' ', trim($line), 2);
			$level = $parts[0];
			return $level;
		}
		
		function _DB_InsertRecord($rs, $record) {
			$db = &$this->db;
			$insertSQL = $db->GetInsertSQL($rs, $record);
			//$db->Execute($insertSQL);
			//////echo $insertSQL.'<br>';
		}

 	}
 
?>