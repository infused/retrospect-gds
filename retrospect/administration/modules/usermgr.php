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
	
	# Enable / Disable account
	if ($_GET['t'] == 'toggle' AND isset($_GET['id'])) {
		$id = $_GET['id'];
		if (Auth::UserIdExists($id)) {
			Auth::ToggleEnabled($id);
		}
	}
	
	$sql = 'SELECT * from '.TBL_USER;
	$users = $db->GetAll($sql);

	
	$sql = 'SELECT * FROM '.TBL_USERTYPE;
	$groups = $db->GetAssoc($sql);
	
	for ($i=0; $i<count($users); $i++) {
		$gid = $users[$i]['group'];
		$users[$i]['groupname'] = $groups[$gid];
	}
	
	$tasks = array('na'=>'With Selected:','delete'=>'Delete','enable'=>'Enable','disable'=>'Disable');
	
	# Assign Smarty vars
	$smarty->assign('users', $users);
	$smarty->assign('groups', $groups);
	$smarty->assign('tasks', $tasks);
	
?>