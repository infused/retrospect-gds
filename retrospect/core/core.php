<?php
/**
 * Core
 *
 * This file loads all the other required modules and initializes 
 * global configuration variables, etc. 
 *
 * Detailed list of operations handled by the core (in order):
 * <ol><li>Gets start time for timing the script</li>
 *		 <li>Set error reporting level</li>
 *     <li>Start output buffering</li>
 *     <li>Start or resume a session</li>
 *     <li>Load configuration options from config file</li>
 *     <li>Establish database connection</li>
 *     <li>Load additional configuration options from database</li>
 *     <li>Initialize gettext functions with the default or user selected language</li>
 *     <li>Load genealogy classes</li>
 *		 <li>Load theme functions</li>
 * </ol>
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
 * @version			1.0
 * @license http://opensource.org/licenses/gpl-license.php
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
	
	# Create clean content and menu vars
	$g_menu = '';
	$g_custom_menu = '';
	$g_content = '';
	
	/** 
	* Require datetime functions.
	* Used only during development
	*/
	require_once(_CORE.'f_datetime.php');
	$start =  time_get_micro();
	
	# Turn on error reporting
	error_reporting(E_ALL);

	# Start output buffering 
	ob_start();
	
	# Start or continue a session
	session_start();
	header("Cache-control: private"); # IE6 fix
	
	/**
	* Load the configuration file.
	* If a development configuration file exists,
	* it will be used instead of the default file.
	*/
	if (file_exists(_CORE.'config-dev.php')) {
		require_once(_CORE.'config-dev.php');
	}
	else {
		require_once(_CORE.'config.php');
	}

	/** 
	* Require PHP compatibility functions
	*/
	require_once(_CORE.'f_compatibility.php');
	
	/**
	* Require database functions and establish connection
	*/
	require_once(_CORE.'f_database.php');
	db_connect($g_db_host, $g_db_port, $g_db_user, $g_db_pass, $g_db);

	/**
	* Require options file and instantiate options
	*/
	require_once(_CORE.'options.class.php');
	$g_opts = new Options();

	/**
	* Require language functions and initialize gettext
	*/
	require_once(_CORE.'f_language.php');
	lang_init_gettext();
	
	/**
	* Require genealogy classes
	*/
	require_once(_CORE.'genealogy.class.php');
	
	/**
	* Require theme functions
	*/
	require_once(_CORE.'theme.class.php');
?>