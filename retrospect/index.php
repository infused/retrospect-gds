<?php
/**
 * Main index file
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
 * @license 		http://opensource.org/licenses/gpl-license.php
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
 *
 * $Id$
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