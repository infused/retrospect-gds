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
		global $db, $g_alpha;
		$p_alpha = strtoupper($p_alpha);
		return ($p_alpha == $g_alpha) ? $p_alpha : '<a href="'.$_SERVER['PHP_SELF'].'?option=surnames&alpha='.$p_alpha.'">'._($p_alpha).'</a>';
	}

	//Display list of surnames if one has not been selected
	if ($sn == null) {
		$g_alpha = (isset($_GET['alpha'])) ? $_GET['alpha'] : 'A';

		#title
		$g_title = _("Surname List");
		
		# alphabet menu
		echo '<div class="content-title">'._("Surname List").'</div>';
		if ($print === false) {
			echo '<table class="tab-row" cellpadding="0" cellspacing="0">';
			echo '<tr>';
			$alphabet = range('A', 'Z');
			$alphabet[] = 'ALL';
			$alphabet[] = 'TOP100';
			foreach ($alphabet as $alpha) {
				echo '<td class="'.get_alpha_class($alpha).'">'.get_alpha_link($alpha).'</td>'."\n"; 
			}
			echo '<td class="tab-last">&nbsp;</td>';
			echo '</tr>';
			echo '</table>';
		}
			
		if ($g_alpha == 'ALL') {
			$sql = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname GROUP BY surname";		
			$rs = $db->Execute($sql);
		}
		elseif ($g_alpha == 'TOP100') {
			$sql = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname GROUP BY surname ORDER BY number DESC";		
			$rs = $db->SelectLimit($sql, 100);
		}
		else {
			$sql = "SELECT surname, count(surname) AS number FROM $g_tbl_indiv surname WHERE surname LIKE '$g_alpha%' GROUP BY surname";
			$rs = $db->Execute($sql);
			
		}
		$max_cols = 4;
		$max_rows = ceil($rs->RecordCount() / $max_cols);
		
		echo '<p class="text">'._("Number of surnames listed").': '.$rs->RecordCount().'</p>';
		echo '<table border="0" cellpadding="0" cellspacing="0">';
		echo '<tr><td class="text" width="200" valign="top">';
		$count = 0;
		while ($row = $rs->FetchRow()) {
			$count++;			
			$letter = strtoupper(substr($row["surname"],0,1));
			echo "<a href=\"".$_SERVER["PHP_SELF"]."?option=surnames&sn=".$row["surname"]."\">";
			echo $row["surname"];
			echo "&nbsp;(".$row["number"].")";
			echo "</a><br />";
			if ($count % $max_rows == 0) { echo '</td><td class="text" width="200" valign="top">'; }
		}
		echo '</td></tr></table>';
}
	
	else {
		
		#title
		$g_title = sprintf(_("%s Surname"), $sn);
		
		# alphabet menu
		echo '<div class="content-title">'.sprintf(_("%s Surname"), $sn).'</div>';
		if ($print === false) {
			echo '<table class="tab-row" cellpadding="0" cellspacing="0">';
			echo '<tr>';
			$alphabet = range('A', 'Z');
			$alphabet[] = 'ALL';
			$alphabet[] = 'TOP100';
			foreach ($alphabet as $alpha) {
				echo '<td class="'.get_alpha_class($alpha).'">'.get_alpha_link($alpha).'</td>'."\n"; 
			}
			echo '<td class="tab-last">&nbsp;</td>';
			echo '</tr>';
			echo '</table>';
		}
		
		$sql = "SELECT indkey FROM $g_tbl_indiv WHERE surname = '$sn' ORDER BY givenname";
		$rs = $db->Execute($sql);
		
		echo '<p class="text">'._("Number of individuals listed").': '.$rs->RecordCount().'</p>';
		echo '<div class="text" style="width: 300px; float: left;"><b>'._("Name").'</b></div>';
		echo '<div class="text" style="width: 150px; float: left;"><b>'._("Birth").'</b></div>';
		echo '<div class="text" style="width: 150px;"><b>'._("Death").'</b></div>';

		while ($row = $rs->FetchRow()) {
			$o = new Person($row['indkey'], 3); 
			$o_link = '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'.$o->sname.', '.$o->gname.'</a>';
			echo '<div class="text" style="width: 300px; float: left; height: 10pt; overflow:hidden;">'.$o_link.'</div>';
			echo '<div class="text" style="width: 150px; float: left; height: 10pt; overflow:hidden;">'.$o->birth->date.'</div>';
			echo '<div class="text" style="width: 150px; height: 10pt; overflow:hidden;">'.$o->death->date.'</div>';
		}
	}
?>