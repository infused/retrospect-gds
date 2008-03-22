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
	
	# process expected get/post variables
	$gname = isset($_GET['gname']) ? $_GET['gname'] : null;
	$smarty->assign('form_gname', $gname);
	$sname = isset($_GET['sname']) ? $_GET['sname'] : null;
	$smarty->assign('form_sname', $sname);
	$soundex = isset($_GET['soundex']) ? true : false;
	$smarty->assign('form_soundex', $soundex);
	
	$begin_month = isset($_GET['begin_month']) ? $_GET['begin_month'] : null;
	$begin_day = isset($_GET['begin_day']) ? $_GET['begin_day'] : null;
	$begin_year = isset($_GET['begin_year']) ? $_GET['begin_year'] : null;
	$smarty->assign('form_begin_month', $begin_month);
	$smarty->assign('form_begin_day', $begin_day);
	$smarty->assign('form_begin_year', $begin_year);
	$end_month = isset($_GET['end_month']) ? $_GET['end_month'] : null;
	$end_day = isset($_GET['end_day']) ? $_GET['end_day'] : null;
	$end_year = isset($_GET['end_year']) ? $_GET['end_year'] : null;
	$smarty->assign('form_end_month', $end_month);
	$smarty->assign('form_end_day', $end_day);
	$smarty->assign('form_end_year', $end_year);
	
	$location = isset($_GET['locat']) ? $_GET['locat'] : null;
	$smarty->assign('form_location', $location);
	$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : null;
	$smarty->assign('form_search_type', $search_type);
	$parts = isset($_GET['parts']) ? $_GET['parts'] : null;
	$smarty->assign('form_parts', $parts);
	$note = isset($_GET['note']) ? $_GET['note'] : null;
	$smarty->assign('form_note', $note);
	
	# set page title
	$smarty->assign('page_title', gtc("Search"));
	$smarty->assign('content_title', gtc("Search"));
	
	# populate keyword array
	keyword_push(gtc("Search"));

?>