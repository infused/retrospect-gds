<?php 
	/**
	* @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
	$smarty->assign('DB_COUNT_COMMENT', $db->GetOne('SELECT COUNT(*) FROM '.TBL_COMMENT));
	
	# Check admin password
	$sql = 'SELECT pwd_expired FROM '.TBL_USER.' WHERE pwd_expired=1 AND id=1';
	if ($db->GetOne($sql)) {
		$notify[] = 'The administrator account is still using the default password.  You should <a href="?m=useredit">change</a> it as soon as possible.';	
	}	
	
	# Check for install directory
	if (file_exists(ROOT_PATH.'/install/')) {
		$notify[] = 'Now that Retrospect-GDS is up and running, you should remove the /install directory.  If you leave it in place, someone could easily wipe out all your data.';
	}
	
	# Are there any comments that need to be reviewed?
	$sql = 'SELECT COUNT(*) FROM '.TBL_COMMENT.' WHERE reviewed=0';
	if ($db->GetOne($sql)) {
		$notify[] = 'You have <a href="?m=commentmgr">comments</a> pending review.';
	}
	
	$smarty->assign('notify', $notify);
?>