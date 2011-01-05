<?php
/**
 * Search the database.
 * Supports searching for individuals by given and/or last names.
 * Soundex searching is supported
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
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
 */
 
 /**
 * $Id$
 */

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	# Name search POST variables
	$gname = isset($_POST['gname']) ? $_POST['gname'] : null;
	$smarty->assign('form_gname', $gname);
	$sname = isset($_POST['sname']) ? $_POST['sname'] : null;
	$smarty->assign('form_sname', $sname);
	$soundex = isset($_POST['soundex']) ? true : false;
	$smarty->assign('form_soundex', $soundex);
	
	# Birthdate search POST variables
	$begin_month = isset($_POST['begin_month']) ? $_POST['begin_month'] : null;
	$begin_day = isset($_POST['begin_day']) ? $_POST['begin_day'] : null;
	$begin_year = isset($_POST['begin_year']) ? $_POST['begin_year'] : null;
	$smarty->assign('form_begin_month', $begin_month);
	$smarty->assign('form_begin_day', $begin_day);
	$smarty->assign('form_begin_year', $begin_year);
	$begin_date = $begin_year . str_pad($begin_month, 2 , "0", STR_PAD_LEFT) . str_pad($begin_day, 2 , "0", STR_PAD_LEFT);
	$end_month = isset($_POST['end_month']) ? $_POST['end_month'] : null;
	$end_day = isset($_POST['end_day']) ? $_POST['end_day'] : null;
	$end_year = isset($_POST['end_year']) ? $_POST['end_year'] : null;
	$smarty->assign('form_end_month', $end_month);
	$smarty->assign('form_end_day', $end_day);
	$smarty->assign('form_end_year', $end_year);
	$end_date = $end_year . str_pad($end_month, 2 , "0", STR_PAD_LEFT) . str_pad($end_day, 2 , "0", STR_PAD_LEFT);
	
	# Location search POST variables
	$location = isset($_POST['locat']) ? $_POST['locat'] : null;
	$smarty->assign('form_location', $location);
	$search_type = isset($_POST['search_type']) ? $_POST['search_type'] : null;
	$smarty->assign('form_search_type', $search_type);
	$parts = isset($_POST['parts']) ? $_POST['parts'] : null;
	$smarty->assign('form_parts', $parts);
	
	# Note search POST variables
	$note = isset($_POST['note']) ? $_POST['note'] : null;
	$smarty->assign('form_note', $note);
	
	# format the search parameters as a get string
	$search_params  = '&gname='.$gname;
	$search_params .= '&sname='.$sname;
	if ($soundex) $search_params .= '&soundex='.$soundex;
	
	$search_params .= '&begin_month='.$begin_month;
	$search_params .= '&begin_day='.$begin_day;
	$search_params .= '&begin_year='.$begin_year;
	$search_params .= '&end_month='.$end_month;
	$search_params .= '&end_day='.$end_day;
	$search_params .= '&end_year='.$end_year;
	
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
		
		$sql = "SELECT * FROM " . TBL_INDIV . " WHERE ";
		
		# set the surname where clause based on soundex selection
		if ($soundex === true) $surname_search_string = "soundex(surname)=soundex(" . $db->qstr($sname) . ")";
    else $surname_search_string = "surname LIKE " . $db->qstr($sname.'%');
		  
	  # search by givenname and surname
	  if ($gname != null and $sname != null) {
			$sql .= $surname_search_string . " AND givenname LIKE ".$db->qstr('%'.$gname.'%')." ORDER BY surname, givenname";
	  }
	  
	  # search by surname only
	  elseif ($gname == null and $sname != null) {
	    $sql .= $surname_search_string . " ORDER BY surname";
	  }
	  
	  # search by givenname only
	  else {
	    $sql .= "givenname LIKE " . $db->qstr('%'.$gname.'%') . " ORDER BY givenname";
	  }
	}
	
	# birthdate search
	elseif ($search_type == 'birthdate') {
		$individuals = TBL_INDIV;
		$facts = TBL_FACT;
		
		$sql = "SELECT *, $facts.date1 " .
					 "FROM $individuals " .
					 "INNER JOIN $facts " .
					 "ON $individuals.indkey = $facts.indfamkey " .
					 "AND $facts.type = 'Birth' " .
					 "AND $facts.date1 BETWEEN '$begin_date' AND '$end_date'";
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
					keyword_push($o->full_name());
					$individuals[] = $o;
		}
		$smarty->assign('individuals', $individuals);
	}
?>
