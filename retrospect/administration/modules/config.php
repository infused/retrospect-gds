<?php
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	# Save the options
	if (isset($_POST['Save']) and $_POST['Save'] == 'Save') {
		$saved[] = $options->OptionUpdate('default_page', $_POST['default_page']);
		$saved[] = $options->OptionUpdate('default_lang', $_POST['default_lang']);
		$saved[] = $options->OptionUpdate('allow_lang_change', $_POST['allow_lang_change']);
		$saved[] = $options->OptionUpdate('translate_dates', $_POST['translate_dates']);
		$saved[] = $options->OptionUpdate('date_format', $_POST['date_format']);
		$saved[] = $options->OptionUpdate('sort_children', $_POST['sort_children']);
		$saved[] = $options->OptionUpdate('sort_marriages', $_POST['sort_marriages']);
		$saved[] = $options->OptionUpdate('sort_events', $_POST['sort_events']);
		$saved[] = $options->OptionUpdate('debug', $_POST['debug']);
		$saved[] = $options->OptionUpdate('meta_copyright', $_POST['meta_copyright']);
		$saved[] = $options->OptionUpdate('meta_keywords', $_POST['meta_keywords']);
		
		# Remove blank entries from $saved array
		for ($i = count($saved)-1; $i > -1; $i--) {
			if ($saved[$i] == false) unset($saved[$i]);
		}
		
		$options->Initialize();
		$smarty->assign('SAVED', $saved);
		$smarty->assign('REDIRECT', $_SERVER['PHP_SELF']);
	}
		
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