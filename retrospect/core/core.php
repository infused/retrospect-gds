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
	
	# Define some RGDS strings
	define('RGDS_COPYRIGHT', '©2003-2004 Keith Morrison, Infused Solutions');
	define('RGDS_VERSION', '1.5.5');
	
	/**
	* Load the configuration file
	*/
	if (file_exists(CORE_PATH.'config.php')) @require_once(CORE_PATH.'config.php');
	else {
		exit('Could not find configuration file.'); 
	}

	# Define all database table names
	define('TBL_INDIV', $g_db_prefix.'indiv');
	define('TBL_FACT', $g_db_prefix.'fact');
	define('TBL_FAMILY', $g_db_prefix.'family');
	define('TBL_CITATION', $g_db_prefix.'citation');
	define('TBL_SOURCE', $g_db_prefix.'source');
	define('TBL_NOTE', $g_db_prefix.'note');
	define('TBL_CHILD', $g_db_prefix.'children');
	define('TBL_USER', $g_db_prefix.'user');
	define('TBL_LANG', $g_db_prefix.'language');
	define('TBL_OPTION', $g_db_prefix.'options');
	define('TBL_MEDIA', $g_db_prefix.'media');
	define('TBL_COMMENT', $g_db_prefix.'comment');
	
	# Require PHP compatibility functions
	@require_once(CORE_PATH.'f_compatibility.php');
	# Require miscellaneous functions
	@require_once(CORE_PATH.'f_misc.php');
	# Require ADODB database library
	@require_once(LIB_PATH.'adodb/adodb.inc.php');
	# Require options class
	@require_once(CORE_PATH.'options.class.php');
	# Require language functions
	@require_once(CORE_PATH.'f_language.php');
	# Require genealogy classes
	@require_once(CORE_PATH.'genealogy.class.php');
	# Require HTML class
	@require_once(CORE_PATH.'html.class.php');
  # Require theme class
	@require_once(CORE_PATH.'theme.class.php');
	# Require date-parser class
	@require_once(CORE_PATH.'date.class.php');

	# Establish the database connection and use
	# the appropriate connection method based on the database type
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
	# Make sure that RecordSets are always returned as associative arrays
	$db->SetFetchMode(ADODB_FETCH_ASSOC);

	# Create options object
	$options =& new Options();
	
	# Get general keywords that will be added to the meta keyword list on each page
	$keywords = explode(',', $options->GetOption('meta_keywords'));
	
	# Generate the copyright info for all pages
	# The $copyright var is a combination of the RGDS_COPYRIGHT constant
	# and the administrator configurable copyright string
	$copyright = htmlentities(trim(RGDS_COPYRIGHT));
	if ($options->GetOption('meta_copyright')) {
		$copyright .= '; '.htmlentities($options->GetOption('meta_copyright'));
	}
	
	# Load profiler and initialize
	if ($options->profile_functions == true) {
		$profile = true;
		@require_once(LIB_PATH.'profiler/profiler.inc.php');
		$profiler = new Profiler( true, false );
		$profiler->startTimer( 'all' );
	} else {
		$profile = false;
	}

	# Initialize the gettext engine
	lang_init_gettext();
?>