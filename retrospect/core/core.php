<?php
/**
 * Core
 *
 * This file loads all the other required modules and initializes 
 * global configuration variables, etc. 
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
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
 *
 * $Id$
 *
 */
	
	$g_version = '1.3.77';
	
	# Turn on error reporting
	error_reporting(E_ALL);	

	# Start or continue a session
	session_start();
	header('Cache-control: private'); # IE6 fix
	
	/**
	* Load the configuration file
	*/
	if (file_exists(CORE_PATH.'config.php')) {
		require_once(CORE_PATH.'config.php');
	}
	else {
		echo 'Could not find configuration file.'; 
		exit;
	}

	/**
	* Load global variables
	*/
	require_once(CORE_PATH.'globals.php');
	
	/** 
	* Require PHP compatibility functions
	*/
	require_once(CORE_PATH.'f_compatibility.php');
	
	/**
	* Require miscellaneous functions
	*/
	require_once(CORE_PATH.'f_misc.php');
	
	/**
	* Require database functions and establish connection.
	* Use the appropriate connection method based on the database type.
	*/
	require_once(LIB_PATH.'adodb/adodb.inc.php');
	$db =& AdoNewConnection($g_db_type);
	if ($g_db_type == 'odbc_mssql') {
		# Microsoft SQL ODBC connection
		$dsn = 'Driver={SQL Server};Server='.$g_db_host.';Database='.$g_db_name.';';
		$db->Connect($dsn, $g_db_user, $g_db_pass);
	} else {
		# All other database types
		$host = ($g_db_port != '') ? $g_db_host.':'.$g_db_port : $g_db_host;
		$db->Connect($host, $g_db_user, $g_db_pass, $g_db_name);
	}
	$db->SetFetchMode(ADODB_FETCH_ASSOC);

	/**
	* Require options file and instantiate options
	*/
	require_once(CORE_PATH.'options.class.php');
	$options =& new Options();
	$keywords = explode(',', $options->GetOption('meta_keywords'));
	
	/**
	* Load profiler and initialize
	*/
	if ($options->profile_functions == true) {
		$profile = true;
		require_once(LIB_PATH.'profiler/profiler.inc.php');
		$profiler = new Profiler( true, false );
		$profiler->startTimer( 'all' );
	} else {
		$profile = false;
	}

	/**
	* Require language functions and initialize gettext
	*/
	require_once(CORE_PATH.'f_language.php');
	lang_init_gettext();
	
	/**
	* Require genealogy classes
	*/
	require_once(CORE_PATH.'genealogy.class.php');
	
	/**
	* Require html class
	*/
	require_once(CORE_PATH.'html.class.php');
	
	/**
	* Require theme functions
	*/
	require_once(CORE_PATH.'theme.class.php');
?>