<?php 
/**
 * Surnames Report
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
	$sn = isset($_GET['sn']) ? $_GET['sn'] : null;
	
	/**
	* Get the css class based on the selected alpha character
	* @access public
	* @param string $p_alpha
	*/
	function get_alpha_class($p_alpha) {
		global $g_alpha;
		$p_alpha = strtoupper($p_alpha);
		if ($p_alpha == $g_alpha) { return 'tab selected'; }
		else { return 'tab'; }
	}
		
	/**
	* Create a link based on the selected alpha character
	* @access public
	* @param string $p_alpha
	*/
	function get_alpha_link($p_alpha) {
		global $g_alpha;
		$p_alpha = strtoupper($p_alpha);
		return ($p_alpha == $g_alpha) ? $p_alpha : '<a href="'.$_SERVER['PHP_SELF'].'?option=surnames&alpha='.$p_alpha.'">'._($p_alpha).'</a>';
	}

	//Display list of surnames if one has not been selected
	if ($sn == null) {
		$g_alpha = (isset($_GET['alpha'])) ? $_GET['alpha'] : 'A';

		#title
		$g_title = _("Surname List");
		
		# alphabet menu
		if ($print === false) {
			$g_content = '<div class="content-title">'._("Surname List").'</div>';
			$g_content .= '<div class="tab-row">';
			$alphabet = range('A', 'Z');
			$alphabet[] = 'ALL';
			$alphabet[] = 'TOP100';
			foreach ($alphabet as $alpha) {
				$g_content .= '<div class="'.get_alpha_class($alpha).'">'.get_alpha_link($alpha).'</div>'."\n"; 
			}
			$g_content .= '</div>';
		}
			
		if ($g_alpha == 'ALL') {
			$query = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname GROUP BY surname";		
		}
		elseif ($g_alpha == 'TOP100') {
			$query = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname GROUP BY surname ORDER BY number DESC LIMIT 100";		
		}
		else {
			$query = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname WHERE surname LIKE '$g_alpha%' GROUP BY surname";
		}
		$result = db_query_r($query);
		$max_cols = 4;
		$max_rows = ceil(mysql_num_rows($result) / $max_cols);
		$g_content .= '<p class="text">'._("Number of surnames listed").': '.mysql_num_rows($result).'</p>';
		$g_content .= '<table border="0" cellpadding="0" cellspacing="0">';
		$g_content .= '<tr><td class="text" width="200" valign="top">';
		$count = 0;
		while ($row = mysql_fetch_array($result)) {
			$count++;			
			$letter = strtoupper(substr($row["surname"],0,1));
			$g_content .= "<a href=\"".$_SERVER["PHP_SELF"]."?option=surnames&sn=".$row["surname"]."\">";
			$g_content .= $row["surname"];
			$g_content .= "&nbsp;(".$row["number"].")";
			$g_content .= "</a><br />";
			if ($count % $max_rows == 0) { $g_content .= '</td><td class="text" width="200" valign="top">'; }
		}
		$g_content .= '</td></tr></table>';
}
	
	else {
		
		#title
		$g_title = sprintf(_("%s Surname"), $sn);
		
		# alphabet menu
		$g_content = '<div class="content-title">'.sprintf(_("%s Surname"), $sn).'</div>';
		if (! isset($_GET['print'])) {
			$g_content .= '<div class="tab-row">';
			$alphabet = range('A', 'Z');
			$alphabet[] = 'ALL';
			$alphabet[] = 'TOP100';
			foreach ($alphabet as $alpha) {
				$g_content .= '<div class="'.get_alpha_class($alpha).'">'.get_alpha_link($alpha).'</div>'."\n"; 
			}
			$g_content .= '</div>';
		}
		
		$query = "SELECT indkey FROM $g_tbl_indiv WHERE surname = '$sn' ORDER BY givenname";
		$result = db_query_r($query);
		
		$g_content .= '<p class="text">'._("Number of individuals listed").': '.mysql_num_rows($result).'</p>';
		$g_content .= '<div class="text" style="width: 300px; float: left;"><b>'._("Name").'</b></div>';
		$g_content .= '<div class="text" style="width: 150px; float: left;"><b>'._("Birth").'</b></div>';
		$g_content .= '<div class="text" style="width: 150px;"><b>'._("Death").'</b></div>';

		while($row = mysql_fetch_array($result)) {
			$o = new Person($row['indkey'], 1); 
			$o_link = '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'.$o->sname.', '.$o->gname.'</a>';
			$g_content .= '<div class="text" style="width: 300px; float: left; height: 10pt; overflow:hidden;">'.$o_link.'</div>';
			$g_content .= '<div class="text" style="width: 150px; float: left; height: 10pt; overflow:hidden;">'.$o->birth->date.'</div>';
			$g_content .= '<div class="text" style="width: 150px; height: 10pt; overflow:hidden;">'.$o->death->date.'</div>';
		}
	}
?>