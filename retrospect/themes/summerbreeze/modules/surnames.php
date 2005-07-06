<?php 
/**
 * Surnames Report
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
	$sn = isset($_GET['sn']) ? $_GET['sn'] : null;
	if ($sn == null) {
	  $g_alpha = (isset($_GET['alpha'])) ? $_GET['alpha'] : 'TOP100';
	}
	$smarty->assign('sn', $sn);
	
	# populate keyword array
	keyword_push(gtc("Surname List"));
	
	/**
	* Get the css class based on the selected alpha character
	* @access public
	* @param string $p_alpha
	*/
	function get_alpha_class($p_alpha) {
		global $g_alpha;
		$p_alpha = strtoupper($p_alpha);
		if ($p_alpha == $g_alpha) { return 'selected'; }
		else { return ''; }
	}
		
	/**
	* Create a link based on the selected alpha character
	* @access public
	* @param string $p_alpha
	*/
	function get_alpha_link($p_alpha) {
		global $db, $g_alpha;
		$p_alpha = strtoupper($p_alpha);
		return ($p_alpha == $g_alpha) ? '<a>'.$p_alpha.'</a>' : '<a href="'.$_SERVER['PHP_SELF'].'?m=surnames&amp;alpha='.$p_alpha.'">'.gtc($p_alpha).'</a>';
	}

	$alphabet = range('A', 'Z');
	$alphabet[] = 'ALL';
	$alphabet[] = 'TOP100';
	$tabs = array();
	for ($i = 0; $i < count($alphabet); $i++) {
		$tabs[$i]['class'] = get_alpha_class($alphabet[$i]);
		$tabs[$i]['link'] = get_alpha_link($alphabet[$i]);
	}
	$smarty->assign('page_title', gtc("Surname List"));
	$smarty->assign('tabs', $tabs);
	unset($alphabet, $tabs);

	# if no surname is selected
	if ($sn == null) {
		$smarty->assign('content_title', gtc("Surname List"));
		$sql = "SELECT surname, count(surname) AS number FROM ".TBL_INDIV;
		if ($g_alpha == 'ALL') {
			$sql .= " surname GROUP BY surname";		
			$rs = $db->Execute($sql);
		}
		elseif ($g_alpha == 'TOP100') {
			$sql .= " surname GROUP BY surname ORDER BY number DESC";		
			$rs = $db->SelectLimit($sql, 100);
		}
		else {
			$sql .= " surname WHERE surname LIKE '$g_alpha%' GROUP BY surname";
			$rs = $db->Execute($sql);
		}
		$max_cols = 5;
		$max_rows = ceil($rs->RecordCount() / $max_cols);
		$smarty->assign('max_cols', $max_cols);
		$smarty->assign('max_rows', $max_rows);
		$surnames = array();
		$count = 0;
		while ($row = $rs->FetchRow()) {
			if (!empty($row['surname'])) {
				$surnames[$count]['surname'] = $row['surname'];
				$surnames[$count]['count'] = $row['number'];
				$count++;
			}
		}
		$smarty->assign('surnames', $surnames);
		unset($surnames, $max_cols);
	}
	
	# if a surname has been selected
	else {
		$smarty->assign('content_title', sprintf(gtc("%s Surname"), $sn));
		$sql = 'SELECT indkey FROM '.TBL_INDIV.' WHERE surname="'.addslashes($sn).'" ORDER BY givenname';
		$rs = $db->Execute($sql);
		$individuals = array();
		while ($row = $rs->FetchRow()) {
			$o = new Person($row['indkey'], 3); 
			$individuals[] = $o;
		}
		$smarty->assign('individuals', $individuals);
	}
	
?>