<?php 
	/**
	* @copyright 	Keith Morrison, Infused Solutions	2001-2004
	* @author			Keith Morrison <keithm@infused-solutions.com>
	* @package 		Administration
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
	
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	# Database stats
	$smarty->assign('DB_COUNT_INDIV', $db->GetOne('SELECT COUNT(*) FROM '.TBL_INDIV));
	$smarty->assign('DB_COUNT_FAMILY', $db->GetOne('SELECT COUNT(*) FROM '.TBL_FAMILY));
	$smarty->assign('DB_COUNT_FACT', $db->GetOne('SELECT COUNT(*) FROM '.TBL_FACT));
	$smarty->assign('DB_COUNT_NOTE', $db->GetOne('SELECT COUNT(*) FROM '.TBL_NOTE));
	$smarty->assign('DB_COUNT_SOURCE', $db->GetOne('SELECT COUNT(*) FROM '.TBL_SOURCE));
	$smarty->assign('DB_COUNT_CITATION', $db->GetOne('SELECT COUNT(*) FROM '.TBL_CITATION));
?>