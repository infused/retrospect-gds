<?php
/**
 * Search the database.
 * Supports searching for individuals by given and/or last names.
 * Soundex searching is supported
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
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
 *
 * $Id$
 *
 */

	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$submitted = isset($_GET['Submit']) ? true : false;
	$gname = isset($_GET['gname']) ? $_GET['gname'] : null;
	$sname = isset($_GET['sname']) ? $_GET['sname'] : null;
	$soundex = isset($_GET['soundex']) ? true : false;
	$location = isset($_GET['locat']) ? $_GET['locat'] : null;
	$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : null;
	$parts = isset($_GET['parts']) ? $_GET['parts'] : null;
	$note = isset($_GET['note']) ? $_GET['note'] : null;
	
	# set page title
	$g_title = gtc("Search");
	
	# populate keyword array
	keyword_push(gtc("Search"));
	
	# content title and psuedo menu
	echo '<p class="content-title">'.gtc("Search").'</p>';
	if ($print === false) {
		echo '<table class="tab-row" cellpadding="0" cellspacing="0">';
		echo '<tr>';
		echo '<td class="tab';
		if ($submitted == false) { 
			echo '-selected';
			echo '">'.gtc("Search").'</td>';
		}
		else {
			$search_params = '?option=search';
			if ($gname != null) { $search_params .= '&gname='.$gname; }
			if ($sname != null) { $search_params .= '&sname='.$sname; }
			if ($soundex == true) { $search_params .= '&soundex=1'; }
			if ($location != null) { $search_params .= '&locat='.$location; }
			if ($note != null) { $search_params .= '&note='.$note; }
			if ($parts != null) { $search_params .= '&parts='.$parts; }
			echo '"><a href="'.$_SERVER['PHP_SELF'].htmlentities($search_params).'">'.gtc("Search").'</a></td>';

		}
		echo '<td class="tab';
		if ($submitted == true) echo '-selected';
		echo '">'.gtc("Results").'</td>';
		echo '<td class="tab-last">&nbsp;</td>';
		echo '</tr>';
		echo '</table>';
	}
	
	# search form
	if ($submitted == false) {
		echo '<div class="tab-page">';
		
		# name search form
		echo '<form name="form_search_name" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input name="option" type="hidden" value="search" />';
		echo '<input name="search_type" type="hidden" value="name" />';
		echo '<table class="section" width="100%" cellspacing="0" cellpadding="0"><tr><td>';
		echo '<table border="0" cellspacing="2" cellpadding="2">';
		echo '<tr>';
		echo '<td colspan="2" class="text"><b>'.gtc("Name Search").'</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text">'.gtc("Given Name").':</td>';
		echo '<td class="text">'.gtc("Surname").':</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><input name="gname" type="text" class="textbox" id="gname" value="'.$gname.'" /></td>';
		echo '<td><input name="sname" type="text" class="textbox" id="sname" value="'.$sname.'" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td class="text">';
		echo '<input name="soundex" type="checkbox" id="soundex" value="1" ';
			if ($soundex == '1') { echo 'checked'; }
		echo ' />Use Soundex?';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2">';
		echo '<input name="Submit" type="submit" class="text" value="'.gtc("Search").'" /> ';
		echo '<input name="Reset" type="reset" class="text" value="'.gtc("Reset").'" /> ';
		echo '<input name="Clear" type="button" class="text" value="'.gtc("Clear").'" onmousedown="MM_setTextOfTextfield(\'gname\',\'\',\'\');MM_setTextOfTextfield(\'sname\',\'\',\'\');" />';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</td></tr></table>';
		echo '</form>';
		
		# location search form
		echo '<form name="form_search_location" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input name="option" type="hidden" value="search" />';
		echo '<input name="search_type" type="hidden" value="location" />';
		echo '<table class="section" width="100%" cellspacing="0" cellpadding="0"><tr><td>';
		echo '<table border="0" cellspacing="2" cellpadding="2">';
		echo '<tr>';
		echo '<td colspan="2" class="text"><b>'.gtc("Location Search").'</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2" class="text">'.gtc("Keywords").':</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><input name="locat" size="40" type="text" class="textbox" id="locat" value="'.$location.'" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text">'.gtc("Match Keywords").':</td>';
		echo '<td>';
		echo '<select name="parts" class="listbox">';
		echo '<option value="all"'; if ($parts == 'all') echo ' selected'; echo '>'.gtc("All").'</option>';
		echo '<option value="any"'; if ($parts == 'any') echo ' selected'; echo '>'.gtc("Any").'</option>';
		echo '<option value="phrase"'; if ($parts == 'phrase') echo ' selected'; echo '>'.gtc("Phrase").'</option>';
		echo '<option value="starts"'; if ($parts == 'starts') echo ' selected'; echo '>'.gtc("Starts with").'</option>';
		echo '<option value="ends"'; if ($parts == 'ends') echo ' selected'; echo '>'.gtc("Ends with").'</option>';
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2">';
		echo '<input name="Submit" type="submit" class="text" value="'.gtc("Search").'" /> ';
		echo '<input name="Reset" type="reset" class="text" value="'.gtc("Reset").'" /> ';
		echo '<input name="Clear" type="button" class="text" value="'.gtc("Clear").'" onmousedown="MM_setTextOfTextfield(\'locat\',\'\',\'\')" />';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</td></tr></table>';
		echo '</form>';		
		
		# note search form
		echo '<form name="form_search_note" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input name="option" type="hidden" value="search" />';
		echo '<input name="search_type" type="hidden" value="note" />';
		echo '<table class="section" width="100%" cellspacing="0" cellpadding="0"><tr><td>';
		echo '<table border="0" cellspacing="2" cellpadding="2">';
		echo '<tr>';
		echo '<td colspan="2" class="text"><b>'.gtc("Note Search").'</b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2" class="text">'.gtc("Keywords").':</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2"><input name="note" size="40" type="text" class="textbox" id="note" value="'.$note.'" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text">'.gtc("Match Keywords").':</td>';
		echo '<td>';
		echo '<select name="parts" class="listbox">';
		echo '<option value="all"'; if ($parts == 'all') echo ' selected'; echo '>'.gtc("All").'</option>';
		echo '<option value="any"'; if ($parts == 'any') echo ' selected'; echo '>'.gtc("Any").'</option>';
		echo '<option value="phrase"'; if ($parts == 'phrase') echo ' selected'; echo '>'.gtc("Phrase").'</option>';
		echo '<option value="starts"'; if ($parts == 'starts') echo ' selected'; echo '>'.gtc("Starts with").'</option>';
		echo '<option value="ends"'; if ($parts == 'ends') echo ' selected'; echo '>'.gtc("Ends with").'</option>';
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2">';
		echo '<input name="Submit" type="submit" class="text" value="'.gtc("Search").'" /> ';
		echo '<input name="Reset" type="reset" class="text" value="'.gtc("Reset").'" /> ';
		echo '<input name="Clear" type="button" class="text" value="'.gtc("Clear").'" onmousedown="MM_setTextOfTextfield(\'note\',\'\',\'\')" />';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</td></tr></table>';
		echo '</form>';
		
		echo '</div>';
	}
	
	# show results
	else {
		echo '<div class="tab-page">';
		# give error if no search parameters
		if ($gname == null AND $sname == null AND $location == null AND $note == null) {
			echo '<p class="text">'.gtc("No search parameters were specified.").'</p>';
		}
		# else display the results
		else {
			# name searches
			if ($search_type == 'name') {
				if ($soundex === true) {
					$sql = "SELECT * FROM {$g_tbl_indiv} WHERE soundex(surname)=soundex(".$db->Quote($sname).") AND givenname LIKE ".$db->Quote('%'.$gname.'%')." ORDER BY surname, givenname";
				}
				else {
					$sql = "SELECT * FROM {$g_tbl_indiv} WHERE surname LIKE ".$db->Quote($sname.'%')." AND givenname LIKE ".$db->Quote('%'.$gname.'%')." ORDER BY surname, givenname";
				}	 
			}
			# location searches
			elseif ($search_type == 'location') {
				if ($parts == 'phrase') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_fact} ";
					$sql .= "WHERE {$g_tbl_indiv}.indkey = {$g_tbl_fact}.indfamkey ";
					$sql .= "AND {$g_tbl_fact}.place LIKE \"%{$location}%\" ";
				}
				# search part selection of ANY
				elseif ($parts == 'any') {
					$locat_arr = explode(' ', $location);
					
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_fact} ";
					$sql .= "WHERE {$g_tbl_indiv}.indkey = {$g_tbl_fact}.indfamkey AND ";
					for ($i = 0, $max = count($locat_arr); $i < $max; $i++) {
						$locat_part = $locat_arr[$i];
						if ($i == 0 AND $max > 1) {
							$sql .= '( ';
							$sql .= "{$g_tbl_fact}.place LIKE \"%{$locat_part}%\" ";
						}
						elseif ($i == 0) {
							$sql .= "{$g_tbl_fact}.place LIKE \"%{$locat_part}%\" ";
						}
						elseif ($i == $max - 1 AND $max > 1) {
							$sql .= "OR {$g_tbl_fact}.place LIKE \"%{$locat_part}%\" ";
							$sql .= ' )';
						}
						else {
							$sql .= "OR {$g_tbl_fact}.place LIKE \"%{$locat_part}%\" ";
						}
					}
				}
				# search part selection of STARTS
				elseif ($parts == 'starts') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_fact} ";
					$sql .= "WHERE {$g_tbl_indiv}.indkey = {$g_tbl_fact}.indfamkey ";
					$sql .= "AND {$g_tbl_fact}.place LIKE \"{$location}%\" ";
				}
				# search part selection of STARTS
				elseif ($parts == 'ends') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_fact} ";
					$sql .= "WHERE {$g_tbl_indiv}.indkey = {$g_tbl_fact}.indfamkey ";
					$sql .= "AND {$g_tbl_fact}.place LIKE \"%{$location}\" ";
				}
				# search part selection of ALL
				else {
					$locat_arr = explode(' ', $location);
					
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_fact} ";
					$sql .= "WHERE {$g_tbl_indiv}.indkey = {$g_tbl_fact}.indfamkey ";
					foreach($locat_arr as $locat_part) {
						$sql .= "AND {$g_tbl_fact}.place LIKE \"%{$locat_part}%\" ";
					}
				}
			}
			
			# note searches
			elseif ($search_type == 'note') {
				if ($parts == 'phrase') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_note} ";
					$sql .= "WHERE {$g_tbl_indiv}.notekey = {$g_tbl_note}.notekey ";
					$sql .= "AND {$g_tbl_note}.text LIKE \"%{$note}%\" ";
				}
				# search part selection of ANY
				elseif ($parts == 'any') {
					$note_arr = explode(' ', $note);
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_note} ";
					$sql .= "WHERE {$g_tbl_indiv}.notekey = {$g_tbl_note}.notekey AND ";
					for ($i = 0, $max = count($note_arr); $i < $max; $i++) {
						$note_part = $note_arr[$i];
						if ($i == 0 AND $max > 1) {
							$sql .= '( ';
							$sql .= "{$g_tbl_note}.text LIKE \"%{$note_part}%\" ";
						}
						elseif ($i == 0) {
							$sql .= "{$g_tbl_note}.text LIKE \"%{$note_part}%\" ";
						}
						elseif ($i == $max - 1 AND $max > 1) {
							$sql .= "OR {$g_tbl_note}.text LIKE \"%{$note_part}%\" ";
							$sql .= ' )';
						}
						else {
							$sql .= "OR {$g_tbl_note}.text LIKE \"%{$note_part}%\" ";
						}
					}
				}
				# search part selection of STARTS
				elseif ($parts == 'starts') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_note} ";
					$sql .= "WHERE {$g_tbl_indiv}.notekey = {$g_tbl_note}.notekey ";
					$sql .= "AND {$g_tbl_note}.text LIKE \"{$note}%\" ";
				}
				# search part selection of STARTS
				elseif ($parts == 'ends') {
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_note} ";
					$sql .= "WHERE {$g_tbl_indiv}.notekey = {$g_tbl_note}.notekey ";
					$sql .= "AND {$g_tbl_note}.text LIKE \"%{$note}\" ";
				}
				# search part selection of ALL
				else {
					$note_arr = explode(' ', $note);
					
					$sql = "SELECT DISTINCT {$g_tbl_indiv}.indkey FROM {$g_tbl_indiv}, {$g_tbl_note} ";
					$sql .= "WHERE {$g_tbl_indiv}.notekey = {$g_tbl_note}.notekey ";
					foreach($note_arr as $note_part) {
						$sql .= "AND {$g_tbl_note}.text LIKE \"%{$note_part}%\" ";
					}
				}
			}
			$rs = $db->Execute($sql);

			# display list of individual
			if ($rs->RecordCount() > 0) {
				echo '<p class="text">'.gtc("Number of individuals listed").': '.$rs->RecordCount().'</p>';
				echo '<table border="0" cellspacing="2" cellpadding="0">';
				echo '<tr>';
				echo '<td class="text" width="250"><b>'.gtc("Name").'</b></td>';
				echo '<td class="text" width="150"><b>'.gtc("Birth").'</b></td>';
				echo '<td class="text" width="150"><b>'.gtc("Death").'</b></td>';
				echo '</tr>';
				while ($row = $rs->FetchRow()) {
					$o = new Person($row['indkey'], 1);
					# populate keyword array
					keyword_push($o->name);
					
					echo '<tr>';
					echo '<td class="text">';
					echo '<a href="'.$_SERVER['PHP_SELF'].'?option=family&amp;indiv='.$o->indkey.'">'.$o->name.'</a>';
					echo '</td>';
					echo '<td class="text">'.$o->birth->date.'</td>';
					echo '<td class="text">'.$o->death->date.'</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			else {
				echo '<p class="text">'.gtc("No matching records were found.").'</p>';
			}
		}
		echo '</div>';
	}

?>
