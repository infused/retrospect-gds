<?php
/**
 * Main index file
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
 * @version			1.1
 *
 */  

	/**
	* Root path
	* @global string
	*/
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']));

	/**
	* Location of core files
	* @global string
	*/
	define('CORE_PATH', ROOT_PATH.'/core/');	
	
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
	
	/**
	* Require core.php
	* @access public
	*/
	require_once(CORE_PATH.'core.php');

	$g_option = isset($_GET['option']) ? $_GET['option'] : $g_opts->default_page;
	
	/**
	* Load the appropriate theme option page
	* @access public
	*/
	include(Theme::getPage($g_theme, $g_option));
	
	/**
	* Load the appropriate theme menu page
	* @access public
	*/
	include(Theme::getPage($g_theme, 'menu'));

	/**
	* Load the appropriate theme template page
	* @access public
	*/
	isset($_GET['print']) ? include(Theme::getPage($g_theme, 'template_print')) : include(Theme::getPage($g_theme, 'template'));
?>