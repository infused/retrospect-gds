<?php
/**
 * Search the database.
 * Supports searching for individuals by given and/or last names.
 * Soundex searching is supported
 *
 * @copyright 	Infused Solutions	2001-2003
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
	$g_content .= '<p class="content-title">'._("Search").'</p>';
	if ($print === false) {
		$g_content .= '<div class="tab-row">';
		$g_content .= '<div class="tab ';
		if ($submitted == false) { 
			$g_content .= 'selected';
			$g_content .= '">'._("Search").'</div>';
		}
		else {
			$search_params = '?option=search';
			if ($gname != null) { $search_params .= '&gname='.$gname; }
			if ($sname != null) { $search_params .= '&sname='.$sname; }
			if ($soundex == true) { $search_params .= '&soundex=1'; }
			$g_content .= '"><a href="'.$_SERVER['PHP_SELF'].$search_params.'">'._("Search").'</a></div>';

		}
		$g_content .= '<div class="tab ';
		if ($submitted == true) $g_content .= 'selected';
		$g_content .= '">'._("Results").'</div>';
		$g_content .= '</div>';
	}
	
	# search form
	if ($submitted == false) {
		$g_content .= '<form name="form_search" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		$g_content .= '<input name="option" type="hidden" value="search">';
		$g_content .= '<table border="0" cellspacing="2" cellpadding="2">';
		$g_content .= '<tr>';
		$g_content .= '<td class="text">&nbsp;</td>';
		$g_content .= '<td class="text">&nbsp;</td>';
		$g_content .= '</tr>';
		$g_content .= '<tr>';
		$g_content .= '<td class="text">'._("Given Name").'</td>';
		$g_content .= '<td class="text">'._("Surname").'</td>';
		$g_content .= '</tr>';
		$g_content .= '<tr>';
		$g_content .= '<td><input name="gname" type="text" class="textbox" id="gname" value="'.$gname.'"></td>';
		$g_content .= '<td><input name="sname" type="text" class="textbox" id="sname" value="'.$sname.'"></td>';
		$g_content .= '</tr>';
		$g_content .= '<tr>';
		$g_content .= '<td>&nbsp;</td>';
		$g_content .= '<td class="text">';
		$g_content .= '<input name="soundex" type="checkbox" id="soundex" value="1" ';
			if ($soundex == '1') { $g_content .= 'checked'; }
		$g_content .= '>Use Soundex?';
		$g_content .= '</td>';
		$g_content .= '</tr>';
		$g_content .= '<tr>';
		$g_content .= '<td>&nbsp;</td>';
		$g_content .= '<td>&nbsp;</td>';
		$g_content .= '</tr>';
		$g_content .= '<tr>';
		$g_content .= '<td colspan="2">';
		$g_content .= '<input name="Submit" type="submit" class="text" value="'._("Submit").'"> ';
		$g_content .= '<input name="Reset" type="reset" class="text" value="'._("Reset").'"> ';
		$g_content .= '<input name="Clear" type="button" class="text" value="'._("Clear").'" onMouseDown="MM_setTextOfTextfield(\'gname\',\'\',\'\');MM_setTextOfTextfield(\'sname\',\'\',\'\')">';
		$g_content .= '</td>';
		$g_content .= '</tr>';
		$g_content .= '</table>';
		$g_content .= '</form>';
		$g_content .= '<br /><br /><br /><br /><br /><br /><br />';
		$g_content .= '<br /><br /><br /><br /><br /><br /><br />';
	}
	
	# show results
	else {
		$gname = mysql_real_escape_string($gname);
		$sname = mysql_real_escape_string($sname);
		
		# give error if no search parameters
		if ($gname == null and $sname == null) {
			$g_content .= '<p class="text">'._("No search parameters were spedfgcified.").'</p>';
		}
		# else display the results
		else {
			if ($soundex === true) {
				$sql = "SELECT * FROM $g_tbl_indiv WHERE soundex(surname)=soundex('$sname') AND givenname LIKE '%$gname%' ORDER BY surname, givenname";
			}
			else {
				$sql = "SELECT * FROM $g_tbl_indiv WHERE surname LIKE '$sname%' AND givenname LIKE '%$gname%' ORDER BY surname, givenname";
			}	 
			$result = db_query_r($sql);

			# display list of individual
			if (mysql_num_rows($result) > 0) {
				$g_content .= '<p class="text">'._("Number of individuals listed").': '.mysql_num_rows($result).'</p>';
				$g_content .= '<table border="0" cellspacing="2" cellpadding="0">';
				$g_content .= '<tr>';
				$g_content .= '<td class="text" width="250"><b>'._("Name").'</b></td>';
				$g_content .= '<td class="text" width="150"><b>'._("Birth").'</b></td>';
				$g_content .= '<td class="text" width="150"><b>'._("Death").'</b></td>';
				$g_content .= '</tr>';
				while ($row = mysql_fetch_array($result)) {
					$o = new Person($row['indkey'], 1);
					$g_content .= '<tr>';
					$g_content .= '<td class="text">';
					$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'.$o->name.'</a>';
					$g_content .= '</td>';
					$g_content .= '<td class="text">'.$o->birth->date.'</td>';
					$g_content .= '<td class="text">'.$o->death->date.'</td>';
					$g_content .= '</tr>';
				}
				$g_content .= '</table>';
			}
			else {
				$g_content .= '<p class="text">'._("No matching records were found.").'</p>';
			}
		}
	}

?>
