<?php

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	/**
	* Require RelCalculator class
	*/
	require_once(CORE_PATH.'relcalculator.class.php');
		
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;
	$g_other_indiv = isset($_GET['other_id']) ? $_GET['other_id'] : false;
	$g_max_gens = isset($_GET['g']) ? intval(trim($_GET['g'])) : 250;

	$pos = strpos($g_other_indiv, "I");
	if (($pos === false || $pos != 0) && strlen($g_other_indiv) > 0) {
		$g_other_indiv = "I" . $g_other_indiv;
	}

  if ($g_other_indiv) {
		$other_indiv = new Person($g_other_indiv);
		$calculator = new RelCalculator($g_indiv, $g_max_gens);
		$results = $calculator->calculate($g_other_indiv);
  } else {
		$results = array();
		$other_indiv = false;
	}

  # get first person information
  $indiv = new person($g_indiv);

	$smarty->assign('indiv', $indiv);
	$smarty->assign('other_indiv', $other_indiv);
	$smarty->assign('relationship', $results['relationship']);
	$smarty->assign('common_ancestors', $results['common_ancestors']);

    if ($other_indiv) {
    	$smarty->assign_by_ref('page_title', sprintf(gtc("Relationship Calculator for %s and %s"), $indiv->name, $other_indiv->name));
    } else {
    	$smarty->assign_by_ref('page_title', sprintf(gtc("Relationship Calculator for %s"), $indiv->name));
    }
	$smarty->assign_by_ref('surname_title', sprintf(gtc("%s Surname"), $indiv->sname));
	$content_title = $indiv->prefix.' '.$indiv->full_name();
	if ($indiv->suffix) $content_title .= ', '.$indiv->suffix;
	$smarty->assign_by_ref('content_title', $content_title);

?>