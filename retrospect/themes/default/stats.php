<?php
/**
 * Stats Report
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
 
	function display_col1($p_string) {
		$out = '<div class="col1">'.$p_string.':</div>';
		return $out;
	}
	
	function display_col2($p_string) {
		$out = '<div class="col2-2">'.number_format($p_string).'</div>';
		return $out;
	}
	
	# surnames
	$sql = "SELECT COUNT(DISTINCT surname) FROM $g_tbl_indiv";
	$cnt_surnames = $db->GetOne($sql);
	
	# individuals
	$sql = "SELECT COUNT(*) FROM $g_tbl_indiv";
	$cnt_indiv = $db->GetOne($sql);
	# individuals - male
	$sql = "SELECT COUNT(*) FROM $g_tbl_indiv WHERE sex='M'";
	$cnt_indiv_male = $db->GetOne($sql);
	# individuals - female
	$sql = "SELECT COUNT(*) FROM $g_tbl_indiv WHERE sex='F'";
	$cnt_indiv_female = $db->GetOne($sql);
	# individuals - unknown
	$cnt_indiv_unknown = $cnt_indiv - $cnt_indiv_male - $cnt_indiv_female;
	
	# families
	$sql = "SELECT COUNT(*) FROM $g_tbl_family";
	$cnt_families = $db->GetOne($sql);
	
	# facts
	$sql = "SELECT COUNT(*) FROM $g_tbl_fact";
	$cnt_facts = $db->GetOne($sql);
	# facts - birth
	$sql = "SELECT COUNT(*) FROM $g_tbl_fact WHERE type='Birth'";
	$cnt_facts_birth = $db->GetOne($sql);
	# facts - death
	$sql = "SELECT COUNT(*) FROM $g_tbl_fact WHERE type='Death'";
	$cnt_facts_death = $db->GetOne($sql);	
	# facts - marriage
	$sql = "SELECT COUNT(*) FROM $g_tbl_fact WHERE type='Marriage'";
	$cnt_facts_marriage = $db->GetOne($sql);		
	# facts - other
	$cnt_facts_other = $cnt_facts - $cnt_facts_birth - $cnt_facts_death - $cnt_facts_marriage;
	
	# notes 
	$sql = "SELECT COUNT(*) FROM $g_tbl_note";
	$cnt_notes = $db->GetOne($sql);
	
	# sources
	$sql = "SELECT COUNT(*) FROM $g_tbl_source";
	$cnt_sources = $db->GetOne($sql);
	
	# source citations
	$sql = "SELECT COUNT(*) FROM $g_tbl_citation";
	$cnt_citations = $db->GetOne($sql);
	
 	# set title
	$g_title = _("Statistics");
	
	# display results
	echo '<p class="content-title">'._("Statistics").'</p>';
	echo display_col1(_("Surnames")).display_col2($cnt_surnames);
	echo display_col1(_("Individuals")).display_col2($cnt_indiv);
	echo display_col1('- '._("Male")).display_col2($cnt_indiv_male);
	echo display_col1('- '._("Female")).display_col2($cnt_indiv_female);
	echo display_col1('- '._("Unknown")).display_col2($cnt_indiv_unknown);
	echo display_col1(_("Families")).display_col2($cnt_families);
	echo display_col1(_("Facts")).display_col2($cnt_facts);
	echo display_col1('- '._("Birth")).display_col2($cnt_facts_birth);
	echo display_col1('- '._("Death")).display_col2($cnt_facts_death);
	echo display_col1('- '._("Marriage")).display_col2($cnt_facts_marriage);
	echo display_col1('- '._("Other")).display_col2($cnt_facts_other);
	echo display_col1(_("Notes")).display_col2($cnt_notes);
	echo display_col1(_("Sources")).display_col2($cnt_sources);
	echo display_col1('- '._("Citations")).display_col2($cnt_citations);
	
?>