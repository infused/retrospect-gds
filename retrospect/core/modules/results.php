<?php
/**
 * Search the database.
 * Supports searching for individuals by given and/or last names.
 * Soundex searching is supported
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
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
	
	# process expected get/post variables
	$gname = isset($_POST['gname']) ? $_POST['gname'] : null;
	$smarty->assign('form_gname', $gname);
	$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
	$smarty->assign('form_sname', $sname);
	$soundex = isset($_POST['soundex']) ? true : false;
	$smarty->assign('form_soundex', $soundex);
	$location = isset($_POST['locat']) ? $_POST['locat'] : null;
	$smarty->assign('form_location', $location);
	$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : null;
	$smarty->assign('form_search_type', $search_type);
	$parts = isset($_POST['parts']) ? $_POST['parts'] : null;
	$smarty->assign('form_parts', $parts);
	$note = isset($_POST['note']) ? $_POST['note'] : null;
	$smarty->assign('form_note', $note);
	
	# format the search parameters as a get string
	$search_params  = '&gname='.$gname;
	$search_params .= '&sname='.$sname;
	if ($soundex) $search_params .= '&soundex='.$soundex;
	$search_params .= '&locat='.$location;
	$search_params .= '&search_type='.$search_type;
	$search_params .= '&parts='.$parts;
	$search_params .= '&note='.$note;
	$smarty->assign('search_params', $search_params);
	
	# set page title
	$smarty->assign('page_title', gtc("Search Results"));
	$smarty->assign('content_title', gtc("Results"));
	
	# populate keyword array
	keyword_push(gtc("Search Results"));
	
	# name searches
	if ($search_type == 'name') {
		if ($soundex === true) {
			$sql = "SELECT * FROM ".TBL_INDIV." WHERE soundex(surname)=soundex(".$db->qstr($sname).") AND givenname LIKE ".$db->qstr('%'.$gname.'%')." ORDER BY surname, givenname";
		}
		else {
			$sql = "SELECT * FROM ".TBL_INDIV." WHERE surname LIKE ".$db->qstr($sname.'%')." AND givenname LIKE ".$db->qstr('%'.$gname.'%')." ORDER BY surname, givenname";
		}	 
	}
	# location searches
	elseif ($search_type == 'location') {
		if ($parts == 'phrase') {
			$sql = 'SELECT DISTINCT '.TBL_INDIV.'.indkey FROM '.TBL_INDIV.', '.TBL_FACT.' ';
			$sql .= 'WHERE '.TBL_INDIV.'.indkey = '.TBL_FACT.'.indfamkey ';
			$sql .= "AND ".TBL_FACT.".place LIKE \"%{$location}%\" ";
		}
		# search part selection of ANY
		elseif ($parts == 'any') {
			$locat_arr = explode(' ', $location);
			
			$sql = 'SELECT DISTINCT '.TBL_INDIV.'.indkey FROM '.TBL_INDIV.', '.TBL_FACT.' ';
			$sql .= 'WHERE '.TBL_INDIV.'.indkey = '.TBL_FACT.'.indfamkey AND ';
			for ($i = 0, $max = count($locat_arr); $i < $max; $i++) {
				$locat_part = $locat_arr[$i];
				if ($i == 0 AND $max > 1) {
					$sql .= '( ';
					$sql .= TBL_FACT.".place LIKE \"%{$locat_part}%\" ";
				}
				elseif ($i == 0) {
					$sql .= TBL_FACT.".place LIKE \"%{$locat_part}%\" ";
				}
				elseif ($i == $max - 1 AND $max > 1) {
					$sql .= 'OR '.TBL_FACT.".place LIKE \"%{$locat_part}%\" ";
					$sql .= ' )';
				}
				else {
					$sql .= 'OR '.TBL_FACT.".place LIKE \"%{$locat_part}%\" ";
				}
			}
		}
		# search part selection of STARTS
		elseif ($parts == 'starts') {
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_FACT." ";
			$sql .= "WHERE ".TBL_INDIV.".indkey = ".TBL_FACT.".indfamkey ";
			$sql .= "AND ".TBL_FACT.".place LIKE \"{$location}%\" ";
		}
		# search part selection of STARTS
		elseif ($parts == 'ends') {
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_FACT." ";
			$sql .= "WHERE ".TBL_INDIV.".indkey = ".TBL_FACT.".indfamkey ";
			$sql .= "AND ".TBL_FACT.".place LIKE \"%{$location}\" ";
		}
		# search part selection of ALL
		else {
			$locat_arr = explode(' ', $location);
			
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_FACT." ";
			$sql .= "WHERE ".TBL_INDIV.".indkey = ".TBL_FACT.".indfamkey ";
			foreach($locat_arr as $locat_part) {
				$sql .= "AND ".TBL_FACT.".place LIKE \"%{$locat_part}%\" ";
			}
		}
	}
	
	# note searches
	elseif ($search_type == 'note') {
		if ($parts == 'phrase') {
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_NOTE." ";
			$sql .= "WHERE ".TBL_INDIV.".notekey = ".TBL_NOTE.".notekey ";
			$sql .= "AND ".TBL_NOTE.".text LIKE \"%{$note}%\" ";
		}
		# search part selection of ANY
		elseif ($parts == 'any') {
			$note_arr = explode(' ', $note);
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_NOTE." ";
			$sql .= "WHERE ".TBL_INDIV.".notekey = ".TBL_NOTE.".notekey AND ";
			for ($i = 0, $max = count($note_arr); $i < $max; $i++) {
				$note_part = $note_arr[$i];
				if ($i == 0 AND $max > 1) {
					$sql .= '( ';
					$sql .= "".TBL_NOTE.".text LIKE \"%{$note_part}%\" ";
				}
				elseif ($i == 0) {
					$sql .= "".TBL_NOTE.".text LIKE \"%{$note_part}%\" ";
				}
				elseif ($i == $max - 1 AND $max > 1) {
					$sql .= "OR ".TBL_NOTE.".text LIKE \"%{$note_part}%\" ";
					$sql .= ' )';
				}
				else {
					$sql .= "OR ".TBL_NOTE.".text LIKE \"%{$note_part}%\" ";
				}
			}
		}
		# search part selection of STARTS
		elseif ($parts == 'starts') {
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_NOTE." ";
			$sql .= "WHERE ".TBL_INDIV.".notekey = ".TBL_NOTE.".notekey ";
			$sql .= "AND ".TBL_NOTE.".text LIKE \"{$note}%\" ";
		}
		# search part selection of STARTS
		elseif ($parts == 'ends') {
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_NOTE." ";
			$sql .= "WHERE ".TBL_INDIV.".notekey = ".TBL_NOTE.".notekey ";
			$sql .= "AND ".TBL_NOTE.".text LIKE \"%{$note}\" ";
		}
		# search part selection of ALL
		else {
			$note_arr = explode(' ', $note);
			
			$sql = "SELECT DISTINCT ".TBL_INDIV.".indkey FROM ".TBL_INDIV.", ".TBL_NOTE." ";
			$sql .= "WHERE ".TBL_INDIV.".notekey = ".TBL_NOTE.".notekey ";
			foreach($note_arr as $note_part) {
				$sql .= "AND ".TBL_NOTE.".text LIKE \"%{$note_part}%\" ";
			}
		}
	}
	$rs = $db->Execute($sql);
	if ($rs->RecordCount() > 0) {
		$individuals = array();
		while ($row = $rs->FetchRow()) {
					$o = new Person($row['indkey'], 1);
					keyword_push($o->name);
					$individuals[] = $o;
		}
		$smarty->assign('individuals', $individuals);
	}
?>
