<?php 
	/**
	* @copyright 	Keith Morrison, Infused Solutions	2001-2005
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

		# Check for valid username input
		$username = strtolower($_POST['username']);
		if (strlen($username) > 16 OR strlen($username) < 4) { 
			$error = true;
			$username_errors[] = 'The username must be between 4 and 16 characters long.';
		}
		if (preg_match('/^[a-z0-9]+$/i', $username) == 0) {
			$error = true;
			$username_errors[] = 'Username may only contain alphanumeric characters.';
		}
		# Process full name
		$fullname = $_POST['fullname'];
		# Process group
		//$group = $_POST['group'];
		# Check for valid email
		$email = $_POST['email'];
		if ($email != '') {
			if (!rgds_is_email($email)) {
				$error = true;
				$email_errors[] = 'Email address is not valid.';
			}
		}
		# Check for valid passwords
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		if (strcmp($password1, $password2) != 0) {
			$error = true;
			$password_errors[] = 'The passwords do not match.  Please retype them.';
		} elseif (strlen($password1) > 16 OR strlen($password1) < 4) {
			$error = true;
			$password_errors[] = 'The password must be between 4 and 16 characters long.';
		}
		# Process enabled flag
		$enabled = $_POST['enabled'] == '1' ? '1' : '0';
		
		# Save the data unless there are errors
		if (!$error) {
			$fields = array('uid'=>$username,
											'fullname'=>$fullname,
											//'grp'=>$group,
											'enabled'=>$enabled,
											'email'=>$email,
											'pwd'=>md5($password1));
			Auth::AddUser($fields);
			$saved['username'] = $username;
			$saved['fullname'] = $fullname;
			$smarty->assign('SAVED', $saved);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=usermgr');
		} else {
			$smarty->assign_by_ref('username_errors', $username_errors);
			$smarty->assign_by_ref('email_errors', $email_errors);
			$smarty->assign_by_ref('password_errors', $password_errors);
		}
		
	}
?>