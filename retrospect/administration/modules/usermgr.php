<?php 
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	$sql = 'SELECT * from '.TBL_USER;
	$users = $db->GetAll($sql);
	$smarty->assign('users', $users);
	
?>