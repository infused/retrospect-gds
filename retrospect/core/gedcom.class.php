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
 */
 
 /**
 * $Id$
 */
 
	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	# Define regular expressions
	# Main record structures
	define('REG_NEWREC','/^0/'); 									# New record
	define('REG_HEAD','/^0 HEAD/');								# Beginning of Header record
	define('REG_INDI','/^0 @(.+)@ INDI/'); 				# Beginning of Individual record
	define('REG_FAM','/^0 @(.+)+@ FAM/');					# Beginning of Family record
	define('REG_SOUR','/^0 @(.+)@ SOUR/');				# Beginning of Source record
	define('REG_NOTE','/^0 @(.+)@ NOTE(.*)/');		# Beginning of Note record
	
	# Record substructures
	# Header substructures
	define('REG_HSOUR','/^1 SOUR (.*)/'); 				# Software
	define('REG_HVERS','/^2 VERS (.*)/'); 				# Software version
	define('REG_HNAME','/^2 NAME (.*)/'); 				# Software name
	define('REG_HDATE','/^1 DATE (.*)/'); 				# Submission date
	
	# Individual substructures
	define('REG_NAME','/^1 NAME (.*)/');  				# Name 
	define('REG_GIVN','/^2 GIVN (.*)/'); 					# Given name
	define('REG_SURN','/^2 SURN (.*)/'); 					# Surname
	define('REG_NICK','/^2 NICK (.*)/'); 					# Nickname (aka)
	define('REG_NPFX','/^2 NPFX (.*)/'); 					# Name prefix (ie. Captain)
	define('REG_NSFX','/^2 NSFX (.*)/'); 					# Name suffic (ie. Jr.) 
	define('REG_SEX','/^1 SEX (.?)/'); 						# Sex
	define('REG_TITL','/^1 TITL (.*)/');					# Title (suffix)
	define('REG_NOTEX','/^1 NOTE @(.+)@/'); 			# Note xref
	define('REG_NOTEO','/^1 NOTE (.*)/');					# Orphaned note
	define('REG_REFN','/^1 REFN (.*)/');					# Reference number
	
	# Family substructures
	define('REG_HUSB','/^1 HUSB @(.+)@/');				# Husband xref
	define('REG_WIFE','/^1 WIFE @(.+)@/');				# Wife xref
	define('REG_MARR','/^1 MARR/');								# Marriage
	define('REG_CHIL','/^1 CHIL @(.+)@/');				# Child
	
	# Note substructures
	define('REG_NOTEO2','/^[\d]{1,2} NOTE (.+)/'); # Another note form
	define('REG_CONT','/^[\d]{1,2} CONT (.+)/');	# Continuation
	define('REG_CONC','/^[\d]{1,2} CONC (.+)/');	# Concatenation
	
	# Event substructures
	define('REG_FAME','/^1 (ANUL|CENS|DIV|DIVF|ENGA|MARR|MARB|MARC|MARL|MARS|EVEN)(.*)/'); # Family Event
	define('REG_INDE','/^1 (BIRT|CHR|DEAT|BURI|CREM|ADOP|BAPM|BARM|BASM|BLES|CHRA|CONF|FCOM|ORDN|NATU|EMIG|IMMI|CENS|PROB|WILL|GRAD|RETI|RESI|OCCU|CAST|DSCR|EDUC|IDNO|NATI|PROP|RELI|SSN|EVEN)(.*)/'); # Individual Event
	define('REG_DATE','/^2 DATE (.+)/');					# Event date
	define('REG_TYPE','/^2 TYPE (.+)/');					# Event type
	define('REG_PLAC','/^2 PLAC (.+)/');					# Event place
	define('REG_SOURX','/^[\d]{1,2} SOUR @(.+)@/');  # Source citation
	
	# Source substuctures
	define('REG_AUTH','/^1 AUTH (.+)/');					# Author
	define('REG_PUBL','/^1 PUBL (.+)/');					# Publication
	define('REG_TEXT','/^1 TEXT (.+)/');					# Text
	define('REG_PAGE','/^[\d]{1,2} PAGE (.+)/');	# Page
	define('REG_QUAY','/^[\d]{1,2} QUAY (\d)/'); # Quality Assesment
	
	# Miscelaneous 
	define('REG_LEVEL','/^([\d]{1,2})/');	
	
	$FAM_EVENTS = array(
		'ANUL'=>'Annulment',
		'CENS'=>'Census',
		'DIV' =>'Divorce',
		'DIVF'=>'Divorce Filed',
		'ENGA'=>'Engagement',
		'MARR'=>'Marriage',
		'MARB'=>'Marriage Bann',
		'MARC'=>'Marriage Contract',
		'MARL'=>'Marriage License',
		'MARS'=>'Marriage Settlement'
		);
	$IND_EVENTS = array(
		'BIRT'=>'Birth',
		'CHR' =>'Christening',
		'DEAT'=>'Death',
		'BURI'=>'Burial',
		'CREM'=>'Cremation',
		'ADOP'=>'Adoption',
		'BAPM'=>'Baptism',
		'BARM'=>'Bar Mitzvah',
		'BASM'=>'Bas Mitzvah',
		'BLES'=>'Blessing',
		'CHRA'=>'Adult Christening',
		'CONF'=>'Confirmation',
		'FCOM'=>'First Communion',
		'ORDN'=>'Ordination',
		'NATU'=>'Naturalization',
		'EMIG'=>'Emigration',
		'IMMI'=>'Immigration',
		'CENS'=>'Census',
		'PROB'=>'Probate',
		'WILL'=>'Will',
		'GRAD'=>'Graduation',
		'RETI'=>'Retirement',
		'RESI'=>'Residence',
		'OCCU'=>'Occupation',
		'CAST'=>'Caste',
		'DSCR'=>'Physical Description',
		'EDUC'=>'Education',
		'IDNO'=>'National ID Number',
		'NATI'=>'Nationality',
		'PROP'=>'Possessions',
		'RELI'=>'Religion',
		'SSN'=>'Social Security Number'
		);
	
	/**
 	* GedcomParser class 
 	* @package gedcom
 	* @access public
 	*/
	class GedcomParser {
	
		var $filename; 					// filename 
		var $fhandle; 					// file handle
		var $fsize;							// file size
		var $lines;							// number of lines in file
		var $individual_count;	// count of individual records
		var $family_count;			// count of family records
		var $source_count;			// count of source records
		var $note_count;				// count of note records
		var $onote_count;				// count of orphaned note records
		var $rs_indiv;					// indiv adodb recordeset object
		var $rs_note;						// note adodb recordset object
		var $rs_family;					// family adodb recordset object
		var $rs_fact;						// fact adodb recordset object
		var $rs_child;					// child adodb recordset object
		var $rs_source;					// source adodb recordset object
		var $rs_citation;				// citation adodb recordset object
		var $db;								// local var for $GLOBALS['db']
		var $factkey;
		var $date_parser;				// date parser object
		var $file_end_offset;   // end offset of gedcom file
		
		/**
		* GedcomParser class constructor
		* @access public
		*/
		function GedcomParser() {
			$this->db = &$GLOBALS['db'];
			$this->date_parser = new DateParser;
			# get empty indiv recordset
			$sql = 'SELECT * from '.TBL_INDIV.' where indkey=-1';
			$this->rs_indiv = $GLOBALS['db']->Execute($sql);
			# get empty note recordset
			$sql = 'SELECT * from '.TBL_NOTE.' where notekey=-1';
			$this->rs_note = $GLOBALS['db']->Execute($sql);
			# get empty family recordset
			$sql = 'SELECT * from '.TBL_FAMILY.' where famkey=-1';
			$this->rs_family = $GLOBALS['db']->Execute($sql);
			# get empty fact recordset
			$sql = 'SELECT * from '.TBL_FACT.' where indfamkey=-1';
			$this->rs_fact = $GLOBALS['db']->Execute($sql);
			# get empty child recordset
			$sql = 'SELECT * from '.TBL_CHILD.' where famkey=-1';
			$this->rs_child = $GLOBALS['db']->Execute($sql);
			# get empty source recordset
			$sql = 'SELECT * from '.TBL_SOURCE.' where srckey=-1';
			$this->rs_source = $GLOBALS['db']->Execute($sql);
			# get empty citation recordset
			$sql = 'SELECT * from '.TBL_CITATION.' where factkey=-1';
			$this->rs_citation = $GLOBALS['db']->Execute($sql);
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
			$lines = 0;
			rewind($handle);
			while (!feof($handle)) {
				$lines++;
				$line = fgets($handle);
				$line = trim($line);
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
			$this->lines = $lines;
		}
		
		/**
		* Parse the gedcom file
		* Please note that this function sends some output to the browser
		* @param integer Optional file offset at which to begin parsing
		* @param integer Optional time limit in seconds
		*/
		function ParseGedcom($offset = 0, $time_limit = 5) {
			# establish start time
			$start = time();
			
			# establish the end of the file
			# used for calculating the % of processing complete
			fseek($this->fhandle, 0, SEEK_END);
			$this->file_end_offset = ftell($this->fhandle);
			
			# seek to offset or rewind to beginning of file
			fseek($this->fhandle, $offset);
			# scan through file looking for records
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				
				# stop parsing and return the file offset if time limit is reached
				$time = time();
				if ($time - $start >= $time_limit) return $poffset;
				
				$line = fgets($this->fhandle);
				$line = trim($line);
				if (preg_match(REG_INDI, $line, $match)) {
					$this->_ParseIndividual($match);
				} 
				elseif (preg_match(REG_FAM, $line, $match)) {
					$this->_ParseFamily($match);
				} 
				elseif (preg_match(REG_SOUR, $line, $match)) {
					$this->_ParseSource($match);
				} 
				elseif (preg_match(REG_NOTE, $line)) {
					$this->_ParseNote($line);
				} 
			}
			return true;
		}
		
		/**
		* Parse Individual
		* @param string $start_line
		*/
		function _ParseIndividual($match) {
			$indiv = array();
			$names = array();  
			$events = array();
			$indiv['indkey'] = $match[1];
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				# dump record to db if reached end of indi record
				# if the name array contains more than 1 name structure
				# only the first one is used.
				if ($level == 0) { 
					$recordset = array_merge($indiv, $names[0]);
					//$this->_DB_InsertRecord($this->rs_indiv, $recordset);
					$this->_DB_Insert_Indiv($recordset);
					foreach ($events as $event) {
						//$this->_DB_InsertRecord($this->rs_fact, $event);
						$this->_DB_Insert_Fact($event);
					}
					fseek($this->fhandle, $poffset);
					return;
				}
				elseif (preg_match(REG_NAME, $line)) {	// name structure
					$name = $this->_ParseNameStruct($line);
					array_push($names, $name);
				}
				elseif (preg_match(REG_SEX, $line, $match)) {
					$indiv['sex'] = trim($match[1]);
				}
				elseif (preg_match(REG_NOTEX, $line, $match)) {
					$indiv['notekey'] = trim($match[1]);
				}
				elseif (preg_match(REG_NOTEO, $line, $match)) {
					$this->_ParseNote($line, $indiv['indkey']);
					$indiv['notekey'] = 'N'.$indiv['indkey'];
				}
				# parse event and populate begin/end status
				elseif (preg_match(REG_INDE, $line, $match)) {
					$event = $this->_ParseIndivEventDetail($match, $indiv['indkey']);
					array_push($events, $event);
				}
				elseif (preg_match(REG_REFN, $line, $match)) {
					$indiv['refn'] = trim($match[1]);
				}
			}
		}
		
		/**
		* Parse Source record
		* @param string $start_line
		*/
		function _ParseSource($match) {
			$source = array();
			$text = '';
			$source['srckey'] = $match[1];
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				if ($level == 0) {
					$source['text'] = $text;
					$this->_DB_InsertRecord($this->rs_source, $source);
					fseek($this->fhandle, $poffset);
					return;
				}
				elseif (preg_match(REG_TITL, $line, $match)) {
					$begin_level = $this->_ExtractLevel($line);
					$text .= $this->_ParseTextStruct($match[1], $begin_level);
				}
				elseif (preg_match(REG_AUTH, $line, $match) OR
								preg_match(REG_PUBL, $line, $match) OR
								preg_match(REG_TEXT, $line, $match)) {
					$begin_level = $this->_ExtractLevel($line);
					$text .= "\r\n".$this->_ParseTextStruct($match[1], $begin_level);
				}
				elseif (preg_match(REG_NOTEX, $line, $match)) {
					$source['notekey'] = $match[1];
				}
				elseif (preg_match(REG_NOTEO, $line, $match)) {
					$this->_ParseNote($line, $source['srckey']);
					$source['notekey'] = 'N'.$source['srckey'];
				}
			}
		}
		
		/**
		* Parse text structure
		* @param string $first_line
		* @return string
		*/
		function _ParseTextStruct($first_line, $begin_level) {
			$text = trim($first_line);
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				if ($level <= $begin_level) {
					fseek($this->fhandle, $poffset);
					return $text;
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
		* Parse Note record
		* @param string $start_line
		*/
		function _ParseNote($start_line, $notekey = null) {	
			$note = array();
			$text = '';
			if ($notekey) { 
				preg_match(REG_NOTEO2, $start_line, $match);
				$note['notekey'] = 'N'.$notekey;
				$text .= $match[1];
			} 
			else {
				preg_match(REG_NOTE, $start_line, $match);
				$note['notekey'] = $match[1];
			}
			if (isset($match[2])) {
				$text .= $match[2];
			}
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
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
		function _ParseFamily($match) {
			$family = array();
			$events = array();
			$family['famkey'] = $match[1];
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				# dump record to db if reached end of family record
				if ($level == 0) {
					//$this->_DB_InsertRecord($this->rs_family, $family);
					$this->_DB_Insert_Family($family);
					foreach ($events as $event) {
						//$this->_DB_InsertRecord($this->rs_fact, $event);
						$this->_DB_Insert_Fact($event);
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
				# format and dump child record to db
				elseif (preg_match(REG_CHIL, $line, $match)) {
					$child = array();
					$child['famkey'] = $family['famkey'];
					$child['indkey'] = $match[1];
					//$this->_DB_InsertRecord($this->rs_child, $child);
					$this->_DB_Insert_Child($child);
				}
				# create note link
				elseif (preg_match(REG_NOTEX, $line, $match)) {
					$family['notekey'] = trim($match[1]);
				}
				elseif (preg_match(REG_NOTEO, $line, $match)) {
					$this->_ParseNote($line, $family['famkey']);
					$family['notekey'] = 'N'.$family['famkey'];
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
							$family['endstatus'] = 'Divorce';
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
			$this->factkey++;
			$event = array();
			$event['indfamkey'] = $indfamkey;
			$event['factkey'] = $this->factkey;
			preg_match(REG_FAME, $start_line, $match);
			$key = &$match[1];
			if ($key != 'EVEN') {
				$event['type'] = $FAM_EVENTS[$key];		
			}
			else { 
				$comment = trim($match[2]);
				if (!empty($comment)) {
					$event['comment'] = $comment;
				}
			}
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				# return record to calling function if end of structure
				if ($level <= 1) {
					fseek($this->fhandle, $poffset);
					return $event;
				}
				elseif (preg_match(REG_DATE, $line, $match)) {
					$this->date_parser->ParseDate($match[1]);
					$event['date_str'] = trim($match[1]);
					$event['date_mod'] = $this->date_parser->pdate['mod'];
					$event['date1'] = $this->date_parser->pdate['date1'];
					$event['date2'] = $this->date_parser->pdate['date2'];
				}
				elseif (preg_match(REG_TYPE, $line, $match)) {
					$event['type'] = trim($match[1]);
				}
				elseif (preg_match(REG_PLAC, $line, $match)) {
					$event['place'] = trim($match[1]);
				}
				elseif (preg_match(REG_SOURX, $line)) {
					$this->_ParseCitation($line, $this->factkey);
				}
			}
		}
		
		/**
		* Parse event detail
		* @param string $start_line
		* @param string $indfamkey
		* @return array
		*/
		function _ParseIndivEventDetail($match, $indfamkey) {
			global $IND_EVENTS;
			$this->factkey++;
			$event = array();
			$event['indfamkey'] = $indfamkey;
			$event['factkey'] = $this->factkey;
			//preg_match(REG_INDE, $start_line, $match);
			$key =& $match[1];
			if ($key != 'EVEN') $event['type'] = $IND_EVENTS[$key];
			# get the comment if available
			if (!empty($match[2])) $event['comment'] = trim($match[2]);
			
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				# return record to calling function if end of structure
				if ($level <= 1) {
					fseek($this->fhandle, $poffset);
					return $event;
				}
				elseif (preg_match(REG_DATE, $line, $match)) {
					$this->date_parser->ParseDate($match[1]);
					$event['date_str'] = trim($match[1]);
					$event['date_mod'] = $this->date_parser->pdate['mod'];
					$event['date1'] = $this->date_parser->pdate['date1'];
					$event['date2'] = $this->date_parser->pdate['date2'];
				}
				elseif (preg_match(REG_TYPE, $line, $match)) {
					$event['type'] = trim($match[1]);
				}
				elseif (preg_match(REG_PLAC, $line, $match)) {
					$event['place'] = trim($match[1]);
				}
				elseif (preg_match(REG_SOURX, $line)) {
					$this->_ParseCitation($line, $this->factkey);
				}
			}
		}
		
		/** 
		* Parse source citation
		* @param string $start_line
		* @param integer $factkey
		*/
		function _ParseCitation($start_line, $factkey) {
			$citation = array();
			$citation['factkey'] = $factkey;
			# grab the source xref
			preg_match(REG_SOURX, $start_line, $match);
			$citation['srckey'] = $match[1];
			$begin_level = $this->_ExtractLevel($start_line);
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
				$level = $this->_ExtractLevel($line);
				if ($level <= $begin_level) {
					//$this->_DB_InsertRecord($this->rs_citation, $citation);
					$this->_DB_Insert_Citation($citation);
					fseek($this->fhandle, $poffset);
					return;
				}
				elseif (preg_match(REG_PAGE, $line, $match)) {
					$citation['source'] = trim($match[1]);
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
			if (strpos($rawname, '/') !== false) {
				preg_match('/^(.*)\/(.+)\/(.*)/', $rawname, $match);
				$fname1 = isset($match[1]) ? trim($match[1]) : '';
				$fname2 = isset($match[3]) ? trim($match[3]) : '';
				$name['surname'] = isset($match[2]) ? trim($match[2]) : '';
				$name['givenname'] = trim($fname1.' '.$fname2);
			}
			else {
				$name['surname'] = '';
				$name['givenname'] = trim($rawname);
			}
			
			# handle any subordinate tags
			while (!feof($this->fhandle)) {
				$poffset = ftell($this->fhandle);
				$line = fgets($this->fhandle);
				$line = trim($line);
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
			$insertSQL = $GLOBALS['db']->GetInsertSQL($rs, $record);
			$GLOBALS['db']->Execute($insertSQL);
			//echo $insertSQL.'<br>';
		}
		
		function _DB_Insert_Indiv($record) {
			$indkey = $GLOBALS['db']->Quote($record['indkey']);
			$surname = $GLOBALS['db']->Quote($record['surname']);
			$givenname = $GLOBALS['db']->Quote($record['givenname']);
			$aka = $GLOBALS['db']->Quote($record['aka']);
			$prefix = $GLOBALS['db']->Quote($record['prefix']);
			$suffix = $GLOBALS['db']->Quote($record['suffix']);
			$sex = $GLOBALS['db']->Quote($record['sex']);
			$refn = isset($record['refn']) ? $GLOBALS['db']->Quote($record['refn']) : "''";
			$notekey = isset($record['notekey']) ? $GLOBALS['db']->Quote($record['notekey']) : "''";
			$sql = 'INSERT INTO '.TBL_INDIV.' (indkey,surname,givenname,aka,prefix,suffix,sex,refn,notekey) ';
			$sql .= 'VALUES ('.$indkey.','.$surname.','.$givenname.','.$aka.','.$prefix.','.$suffix.',';
			$sql .= $sex.','.$refn.','.$notekey.')';
			$GLOBALS['db']->Execute($sql);
		}
		
		function _DB_Insert_Fact($record) {
			$indfamkey = $GLOBALS['db']->Quote($record['indfamkey']);
			$type = isset($record['type']) ? $GLOBALS['db']->Quote($record['type']) : "''";
			$date_mod = isset($record['date_mod']) ? $GLOBALS['db']->Quote($record['date_mod']) : "''";
			$date1 = isset($record['date1']) ? $GLOBALS['db']->Quote($record['date1']) : "''";
			$date2 = isset($record['date2']) ? $GLOBALS['db']->Quote($record['date2']) : "''";
			$date_str = isset($record['date_str']) ? $GLOBALS['db']->Quote($record['date_str']) : "''";
			$place = isset($record['place']) ? $GLOBALS['db']->Quote($record['place']) : "''";
			$comment = isset($record['comment']) ? $GLOBALS['db']->Quote($record['comment']) : "''";
			$factkey = $GLOBALS['db']->Quote($record['factkey']);
			$sql = 'INSERT INTO '.TBL_FACT.' (indfamkey,type,date_mod,date1,date2,date_str,place,comment,factkey) ';
			$sql .= 'VALUES ('.$indfamkey.','.$type.','.$date_mod.','.$date1.','.$date2.',';
			$sql .= $date_str.','.$place.','.$comment.','.$factkey.')';
			$GLOBALS['db']->Execute($sql);
		}
		
		function _DB_Insert_Child($record) {
			$famkey = $GLOBALS['db']->Quote($record['famkey']);
			$indkey = $GLOBALS['db']->Quote($record['indkey']);
			$sql = 'INSERT INTO '.TBL_CHILD.' (famkey,indkey) VALUES ('.$famkey.','.$indkey.');';
			$GLOBALS['db']->Execute($sql);
		}
		
		function _DB_Insert_Citation($record) {
			$factkey = $GLOBALS['db']->Quote($record['factkey']);
			$srckey = $GLOBALS['db']->Quote($record['srckey']);
			$source = isset($record['source']) ? $GLOBALS['db']->Quote($record['source']) : "''";
			$citekey = "''";
			$sql = 'INSERT INTO '.TBL_CITATION.' (factkey,srckey,source,citekey) ';
			$sql .= 'VALUES ('.$factkey.','.$srckey.','.$source.','.$citekey.')';
			$GLOBALS['db']->Execute($sql);		
		}
		
		function _DB_Insert_Family($record) {
			$famkey = $GLOBALS['db']->Quote($record['famkey']);
			$spouse1 = isset($record['spouse1']) ? $GLOBALS['db']->Quote($record['spouse1']) : "''";
			$spouse2 = isset($record['spouse2']) ? $GLOBALS['db']->Quote($record['spouse2']) : "''";
			$beginstatus = isset($record['beginstatus']) ? $GLOBALS['db']->Quote($record['beginstatus']) : "''";
			$endstatus = isset($record['endstatus']) ? $GLOBALS['db']->Quote($record['endstatus']) : "''";
			$notekey = isset($record['notekey']) ? $GLOBALS['db']->Quote($record['notekey']) : "''";
			$sql = 'INSERT INTO '.TBL_FAMILY.' (famkey,spouse1,spouse2,beginstatus,endstatus,notekey) ';
			$sql .= 'VALUES ('.$famkey.','.$spouse1.','.$spouse2.','.$beginstatus.',';
			$sql .= $endstatus.','.$notekey.')';
			$GLOBALS['db']->Execute($sql);
		}

 	}
 
?>