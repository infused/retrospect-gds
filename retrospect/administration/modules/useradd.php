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
	
	# Load SmartyValidate
	@require_once(LIB_PATH.'smarty/libs/SmartyValidate.class.php');
	SmartyValidate::Connect($smarty);
	
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	# Get list of groups and assign to Smarty variable
	$smarty->assign('groups', $db->GetAssoc('SELECT * FROM '.TBL_USERTYPE));
	
	# Form has been posted
	if (!empty($_POST)) {
		# Validate form fields and save the data if valid
		if (SmartyValidate::is_valid($_POST)) {
			SmartyValidate::disconnect();
			# Save the data
			$fields = array('uid'=>$_POST['username'],
				'fullname'=>$_POST['fullname'],
				'grp'=>$_POST['group'],
				'enabled'=>$_POST['enabled'],
				'email'=>$_POST['email'],
				'pwd'=>md5($_POST['password1']));
			Auth::AddUser($fields);
			$saved['username'] = $_POST['username'];
			$saved['fullname'] = $_POST['fullname'];
			$smarty->assign('SAVED', $saved);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=usermgr');
		}
	}
?>