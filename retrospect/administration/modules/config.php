<?php
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	$smarty->assign('options', $options->option_list);
	$smarty->assign('yesno', array('1'=>'Yes', '0'=>'No'));
	
	# Database options
	$smarty->assign('db_host', DB_HOST);
	$smarty->assign('db_port', DB_PORT);
	$smarty->assign('db_user', DB_USER);
	$smarty->assign('db_pass', DB_PASS);
	$smarty->assign('db_name', DB_NAME);
	
	# Language options 
	$smarty->assign('lang_names', $lang_names);
	$smarty->assign('lang_codes', $lang_codes);
	$smarty->assign('lang', $_SESSION['lang']);
	
	$smarty->assign('date_formats', array('1'=>'25 Nov 1859', '2'=>'Nov 25, 1859'));
	
?>