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
	
	# Get count of comments pending review
	$sql = 'SELECT COUNT(*) FROM '.TBL_COMMENT.' WHERE reviewed='.$db->qstr('0');
	$pending_count = $db->GetOne($sql);
	$smarty->assign('pending_count', $pending_count);
	
	# Get count of comments already reviewed
	$sql = 'SELECT COUNT(*) FROM '.TBL_COMMENT.' WHERE reviewed='.$db->qstr('1');
	$reviewed_count = $db->GetOne($sql);
	$smarty->assign('reviewed_count', $reviewed_count);
	
	# create task list 
	$tasks = array(	'na'=>'With selected:',
									'visible'=>'Make Visible',
									'hidden'=>'Make Hidden',
									'delete'=>'Delete');
	
	# The form was posted, so let's process the request
	if (isset($_POST['Submit'])) {
		$task = $_POST['task'];
		$selected = $_POST['selectitem'];
		# Process comment deletions
		if ($task == 'delete') {
			foreach ($selected as $id) {
				$sql = 'DELETE FROM '.TBL_COMMENT.' WHERE id='.$db->Qstr($id);
				$db->Execute($sql);
				$deleted[] = $id;
			}
			$smarty->assign('DELETED', $deleted);
			$smarty->assign('REDIRECT', CURRENT_PAGE);
		} 
		# Make comments visible
		elseif ($task == 'visible') {
			foreach ($selected as $id) {
				$sql = 'SELECT * FROM '.TBL_COMMENT.' WHERE id='.$db->qstr($id);
				$rs = $db->Execute($sql);
				$fields['visible'] = '1';
				$fields['reviewed'] = '1';
				$sql = $db->GetUpdateSQL($rs, $fields);
				$db->Execute($sql);
				$visible[] = $id; 
			}
			$smarty->assign('VISIBLE', $visible);
			$smarty->assign('REDIRECT', CURRENT_PAGE);
		}
		# Hide comments
		elseif ($task == 'hidden') {
			foreach ($selected as $id) {
				$sql = 'SELECT * FROM '.TBL_COMMENT.' WHERE id='.$db->qstr($id);
				$rs = $db->Execute($sql);
				$fields['visible'] = '0';
				$fields['reviewed'] = '1';
				$sql = $db->GetUpdateSQL($rs, $fields);
				$db->Execute($sql);
				$hidden[] = $id; 
			}
			$smarty->assign('HIDDEN', $hidden);
			$smarty->assign('REDIRECT', CURRENT_PAGE);
		}
	}
	
	# Get all the reviewed comments
	if (isset($_GET['t']) AND $_GET['t'] == 'r') {
		$task = 'reviewed';
		$sql = 'SELECT * FROM '.TBL_COMMENT.' WHERE reviewed='.$db->qstr('1');
	}
	# Get all the unreviewed comments
	else {
		$task = 'pending';
		$sql = 'SELECT * FROM '.TBL_COMMENT.' WHERE reviewed='.$db->qstr('0');
	}
	
	$comments = $db->GetAll($sql);
	$smarty->assign('comments', $comments);
									
	# Assign Smarty vars
	$smarty->assign('task', $task);
	$smarty->assign('tasks', $tasks);
	
?>