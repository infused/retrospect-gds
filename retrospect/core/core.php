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
 *     <li>Load adodb library and establish connection</li>
 *     <li>Load additional configuration options from database</li>
 *     <li>Initialize gettext functions with the default or user selected language</li>
 *     <li>Load genealogy classes</li>
 *		 <li>Load theme functions</li>
 * </ol>
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

	$g_version = '1.3.1';
	
	# Turn on error reporting
	error_reporting(E_ALL);	

	# Create clean content and menu vars
	$g_menu = '';
	$g_custom_menu = '';
	$g_content = '';
	
	/** 
	* Require datetime functions.
	* Used only during development
	*/
	require_once(CORE_PATH.'f_datetime.php');
	$start =  time_get_micro();

	# Start output buffering 
	ob_start();
	
	# Start or continue a session
	session_start();
	header("Cache-control: private"); # IE6 fix
	
	/**
	* Load the configuration file.
	* If a development configuration file exists (config-dev.php),
	* it will be used instead of the default file (config.php).
	*/
	require_once(CORE_PATH.'config.php');

	/** 
	* Location of FPDF font definitions
	* @global string
	*/
	define('FPDF_FONTPATH', LIB_PATH.'fpdf/font/');
	
	/**
	* Location of media files
	* @global string
	*/
	define('_MEDIA_FILES','media/files/');
	
	/**
	* Location of media thumbnails
	* @global string
	*/
	define('_MEDIA_THUMBS','media/thumbs/');
	
	# Initialize table vars
	
	/**
	* Individual table.
	* @global string $g_tbl_indiv
	*/
	$g_tbl_indiv  			= $g_db_prefix . 'indiv';
	
	/**
	* Fact table.
	* @global string $g_tbl_fact
	*/
	$g_tbl_fact   			= $g_db_prefix . 'fact';
	
	/**
	* Family table.
	* @global string $g_tbl_family
	*/
	$g_tbl_family 			= $g_db_prefix . 'family';
	
	/**
	*
	* Citation table.
	* @global string $g_tbl_citation
	*/
	$g_tbl_citation 		= $g_db_prefix . 'citation';
	
	/**
	* Source table.
	* @global string $g_tbl_source
	*/
	$g_tbl_source   		= $g_db_prefix . 'source';
	
	/**
	* Note table.
	* @global string $g_tbl_note
	*/
	$g_tbl_note					= $g_db_prefix . 'note';
	
	/**
	* Child table.
	* @global string $g_tbl_child
	*/
	$g_tbl_child				= $g_db_prefix . 'children';
	
	/**
	* User table.
	* @global string $g_tbl_user
	* */
	$g_tbl_user					= $g_db_prefix . 'user';
	
	/**
	* Language table.
	* @global string $g_tbl_lang
	*/
	$g_tbl_lang					= $g_db_prefix . 'language';
	
	/**
	* Options table.
	* @global string $g_tbl_option
	*/
	$g_tbl_option 			= $g_db_prefix . 'options';
	
	/**
	* Media table.
	* @global string $g_tbl_media
	*/
	$g_tbl_media				= $g_db_prefix  . 'media';

	/** 
	* Require PHP compatibility functions
	*/
	require_once(CORE_PATH.'f_compatibility.php');
	
	/**
	* Require database functions and establish connection.
	* Use the appropriate connection method based on the database type.
	*/
	require_once(LIB_PATH.'adodb/adodb.inc.php');
	$db = AdoNewConnection($g_db_type);
	if ($g_db_type == 'odbc_mssql') {
		# Microsoft SQL ODBC connection
		$dsn = 'Driver={SQL Server};Server='.$g_db_host.';Database='.$g_db_name.';';
		$db->Connect($dsn, $g_db_user, $g_db_pass);
	} else {
		# MySQL, PostrgreSQL, etc...
		$host = ($g_db_port != '') ? $g_db_host.':'.$g_db_port : $g_db_host;
		$db->Connect($host, $g_db_user, $g_db_pass, $g_db_name);
	}
	$db->SetFetchMode(ADODB_FETCH_ASSOC);

	/**
	* Require options file and instantiate options
	*/
	require_once(CORE_PATH.'options.class.php');
	$g_opts = new Options();

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
	* Require theme functions
	*/
	require_once(CORE_PATH.'theme.class.php');
?>