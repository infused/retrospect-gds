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
	
	# Get list of groups and assign to Smarty variable
	$smarty->assign('groups', $db->GetAssoc('SELECT * FROM '.TBL_USERTYPE));
	
	# Form has been posted
	if (isset($_POST['Save']) and $_POST['Save'] == 'Save') {
		# Check for valid input
		$username = strtolower($_POST['username']);
		if (strlen($username) > 16 OR strlen($username) < 4) { 
			$error = true;
			$username_errors[] = 'Username must be between 4 and 16 characters long.';
		}
		if (preg_match('/^[a-z0-9]+$/', $username) == 0) {
			$error = true;
			$username_errors[] = 'Username may only contain alphanumeric characters.';
		}
		
		# 
		if ($error) {
			$smarty->assign('username_errors', $username_errors);
		}
		
	}
	else {
	
		
	}
	
	
?>