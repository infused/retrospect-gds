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
	
	# set page title
	$g_title = _("Search");
	
	# content title and psuedo menu
	echo '<p class="content-title">'._("Search").'</p>';
	if ($print === false) {
		echo '<div class="tab-row">';
		echo '<div class="tab ';
		if ($submitted == false) { 
			echo 'selected';
			echo '">'._("Search").'</div>';
		}
		else {
			$search_params = '?option=search';
			if ($gname != null) { $search_params .= '&gname='.$gname; }
			if ($sname != null) { $search_params .= '&sname='.$sname; }
			if ($soundex == true) { $search_params .= '&soundex=1'; }
			echo '"><a href="'.$_SERVER['PHP_SELF'].$search_params.'">'._("Search").'</a></div>';

		}
		echo '<div class="tab ';
		if ($submitted == true) echo 'selected';
		echo '">'._("Results").'</div>';
		echo '</div>';
	}
	
	# search form
	if ($submitted == false) {
		echo '<form name="form_search" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		echo '<input name="option" type="hidden" value="search">';
		echo '<table border="0" cellspacing="2" cellpadding="2">';
		echo '<tr>';
		echo '<td class="text">&nbsp;</td>';
		echo '<td class="text">&nbsp;</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="text">'._("Given Name").'</td>';
		echo '<td class="text">'._("Surname").'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><input name="gname" type="text" class="textbox" id="gname" value="'.$gname.'"></td>';
		echo '<td><input name="sname" type="text" class="textbox" id="sname" value="'.$sname.'"></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td class="text">';
		echo '<input name="soundex" type="checkbox" id="soundex" value="1" ';
			if ($soundex == '1') { echo 'checked'; }
		echo '>Use Soundex?';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="2">';
		echo '<input name="Submit" type="submit" class="text" value="'._("Search").'"> ';
		echo '<input name="Reset" type="reset" class="text" value="'._("Reset").'"> ';
		echo '<input name="Clear" type="button" class="text" value="'._("Clear").'" onMouseDown="MM_setTextOfTextfield(\'gname\',\'\',\'\');MM_setTextOfTextfield(\'sname\',\'\',\'\')">';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</form>';
		echo '<br /><br /><br /><br /><br /><br /><br />';
		echo '<br /><br /><br /><br /><br /><br /><br />';
	}
	
	# show results
	else {
		$gname = mysql_real_escape_string($gname);
		$sname = mysql_real_escape_string($sname);
		
		# give error if no search parameters
		if ($gname == null and $sname == null) {
			echo '<p class="text">'._("No search parameters were specified.").'</p>';
		}
		# else display the results
		else {
			if ($soundex === true) {
				$sql = "SELECT * FROM $g_tbl_indiv WHERE soundex(surname)=soundex('$sname') AND givenname LIKE '%$gname%' ORDER BY surname, givenname";
			}
			else {
				$sql = "SELECT * FROM $g_tbl_indiv WHERE surname LIKE '$sname%' AND givenname LIKE '%$gname%' ORDER BY surname, givenname";
			}	 
			$rs = $db->Execute($sql);

			# display list of individual
			if ($rs->RecordCount() > 0) {
				echo '<p class="text">'._("Number of individuals listed").': '.$rs->RecordCount().'</p>';
				echo '<table border="0" cellspacing="2" cellpadding="0">';
				echo '<tr>';
				echo '<td class="text" width="250"><b>'._("Name").'</b></td>';
				echo '<td class="text" width="150"><b>'._("Birth").'</b></td>';
				echo '<td class="text" width="150"><b>'._("Death").'</b></td>';
				echo '</tr>';
				while ($row = $rs->FetchRow()) {
					$o = new Person($row['indkey'], 1);
					echo '<tr>';
					echo '<td class="text">';
					echo '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'.$o->name.'</a>';
					echo '</td>';
					echo '<td class="text">'.$o->birth->date.'</td>';
					echo '<td class="text">'.$o->death->date.'</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
			else {
				echo '<p class="text">'._("No matching records were found.").'</p>';
			}
		}
	}

?>
