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
	
	# The form was posted, so let's process the request
	if (isset($_POST['Submit'])) {
		$task = $_POST['task'];
		$selected = $_POST['selectitem'];
		# Process user deletions
		if ($task == 'delete') {
			foreach ($selected as $id) {
				if ($id != '1') {
					$sql = 'DELETE FROM '.TBL_USER.' WHERE id='.$db->Qstr($id);
					$db->Execute($sql);
					$deleted[] = $id;
				}
			}
			$smarty->assign('DELETED', $deleted);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=usermgr');
		} 
		# Process user enables
		elseif ($task == 'enable') {
			foreach ($selected as $id) {
				if ($id != '1') {
					Auth::Enable($id);
					$enabled[] = $id;
				}
			}
			$smarty->assign('ENABLED', $enabled);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=usermgr');
		} 
		# Process user disables
		elseif ($task == 'disable') {
			foreach ($selected as $id) {
				if ($id != '1') {
					Auth::Disable($id);
					$disabled[] = $id;
				}
			}
			$smarty->assign('DISABLED', $disabled);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=usermgr');
		}
	}
	
	# Build a list of users
	$sql  = 'SELECT * from '.TBL_USER.' ';
	$sql .= 'ORDER BY id';
	$users = $db->GetAll($sql);
	
	$sql = 'SELECT * FROM '.TBL_USERTYPE;
	$groups = $db->GetAssoc($sql);
	
	for ($i=0; $i<count($users); $i++) {
		$gid = $users[$i]['grp'];
		$users[$i]['groupname'] = $groups[$gid];
	}
	
	# create task list 
	$tasks = array('na'=>'With selected:','delete'=>'Delete','enable'=>'Enable','disable'=>'Disable');
	
	# Assign Smarty vars
	$smarty->assign('users', $users);
	$smarty->assign('groups', $groups);
	$smarty->assign('tasks', $tasks);
	
?>