<?php
  
	/**
	* Root path
	* @global string
	*/
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']));

	/**
	* Location of core files
	* @global string
	*/
	define('CORE_PATH', ROOT_PATH.'/../core/');	
	
	/** 
	* Location of library files
	* @global string
	*/
	define('LIB_PATH', ROOT_PATH.'/libraries/');
	
	/**
	* Current url w/query string
	* @global string
	*/
	define('CURRENT_PAGE', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	
	require_once(CORE_PATH.'core.php');
	require_once(ROOT_PATH.'/auth.class.php');
	require_once(ROOT_PATH.'/f_admin.php');
	
	# check login status and redirect as necessary
	include(Auth::check() ? 'admin.php' : 'login.php');
?>