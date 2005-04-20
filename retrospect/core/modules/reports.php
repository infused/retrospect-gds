<?php
/**
 * Reports
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
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;

	# get first person information
	$o = new person($g_indiv, 3);
	$smarty->assign('indiv', $o);
	
	# assign other smarty variables
	$smarty->assign_by_ref('page_title', sprintf(gtc("Reports for %s"), $o->name));
	$smarty->assign_by_ref('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign_by_ref('content_title', $content_title);
	
	# populate keyword array
	keyword_push(gtc("Reports"));
	keyword_push($o->name);

?>