<?php
/**
 * Stats Report
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
	
	# set title
	$smarty->assign('page_title', gtc("Statistics"));
	$smarty->assign('content_title', gtc("Statistics"));
	
	# surnames
	$sql = "SELECT COUNT(DISTINCT surname) FROM ".TBL_INDIV;
	$smarty->assign('cnt_surnames', $db->GetOne($sql));
	
	# individuals
	$sql = "SELECT COUNT(*) FROM ".TBL_INDIV;
	$cnt_indiv = $db->GetOne($sql);
	$smarty->assign('cnt_indiv', $cnt_indiv);
	
	# individuals - male
	$sql = "SELECT COUNT(*) FROM ".TBL_INDIV." WHERE sex='M'";
	$cnt_indiv_male = $db->GetOne($sql);
	$smarty->assign('cnt_indiv_male', $cnt_indiv_male);
	
	# individuals - female
	$sql = "SELECT COUNT(*) FROM ".TBL_INDIV." WHERE sex='F'";
	$cnt_indiv_female = $db->GetOne($sql);
	$smarty->assign('cnt_indiv_female', $cnt_indiv_female);
	
	# individuals - unknown
	$cnt_indiv_unknown = $cnt_indiv - $cnt_indiv_male - $cnt_indiv_female;
	$smarty->assign('cnt_indiv_unknown', $cnt_indiv_unknown);
	
	# families
	$sql = "SELECT COUNT(*) FROM ".TBL_FAMILY;
	$smarty->assign('cnt_families',$db->GetOne($sql));
	
	# events
	$sql = "SELECT COUNT(*) FROM ".TBL_FACT;
	$cnt_events = $db->GetOne($sql);
	$smarty->assign('cnt_events', $cnt_events);
	
	# events - birth
	$sql = "SELECT COUNT(*) FROM ".TBL_FACT." WHERE type='Birth'";
	$cnt_events_birth = $db->GetOne($sql);
	$smarty->assign('cnt_events_birth', $cnt_events_birth);
	
	# events - death
	$sql = "SELECT COUNT(*) FROM ".TBL_FACT." WHERE type='Death'";
	$cnt_events_death = $db->GetOne($sql);	
	$smarty->assign('cnt_events_death', $cnt_events_death);
	
	# events - marriage
	$sql = "SELECT COUNT(*) FROM ".TBL_FACT." WHERE type='Marriage'";
	$cnt_events_marriage = $db->GetOne($sql);	
	$smarty->assign('cnt_events_marriage', $cnt_events_marriage);	
	
	# facts - other
	$cnt_events_other = $cnt_events-$cnt_events_birth-$cnt_events_death-$cnt_events_marriage;
	$smarty->assign('cnt_events_other', $cnt_events_other);
	
	# notes 
	$sql = "SELECT COUNT(*) FROM ".TBL_NOTE;
	$smarty->assign('cnt_notes', $db->GetOne($sql));
	
	# sources
	$sql = "SELECT COUNT(*) FROM ".TBL_SOURCE;
	$smarty->assign('cnt_sources', $db->GetOne($sql));
	
	# source citations
	$sql = "SELECT COUNT(*) FROM ".TBL_CITATION;
	$smarty->assign('cnt_citations', $db->GetOne($sql));
	
	# comments
	$sql = "SELECT COUNT(*) FROM ".TBL_COMMENT;
	$smarty->assign('cnt_comments', $db->GetOne($sql));
	
	# populate keyword array
	keyword_push(gtc("Statistics"));
?>