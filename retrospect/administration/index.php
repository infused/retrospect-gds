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
	define('_CORE', ROOT_PATH.'/../core/');	
	
	/** 
	* Location of library files
	* @global string
	*/
	define('_LIB', ROOT_PATH.'/libraries/');
	
	/**
	* Current url w/query string
	* @global string
	*/
	define('_CURRENT_PAGE', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
	
	require_once(_CORE.'core.php');
	require_once(ROOT_PATH.'/auth.class.php');
	require_once(ROOT_PATH.'/f_admin.php');
	
	# check login status and redirect as necessary
	include(Auth::check() ? 'admin.php' : 'login.php');
?>