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
 */
 
 /**
 * $Id$
 */
	
	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	# Define some RGDS strings
	define('RGDS_COPYRIGHT', '©2003-2004 Keith Morrison, Infused Solutions');
	define('RGDS_VERSION', '2.0.b2');
	
	# Load the configuration file
	if (file_exists(CORE_PATH.'config.php')) @require_once(CORE_PATH.'config.php');
	else exit('Could not read configuration file.'); 

	# Define database parameters
	define('DB_TYPE', $g_db_type);
	define('DB_HOST', $g_db_host);
	define('DB_PORT', $g_db_port);
	define('DB_NAME', $g_db_name);
	define('DB_USER', $g_db_user);
	define('DB_PASS', $g_db_pass);
	
	# Unset original config vars for enhanced security
	unset($g_db_type, $g_db_host, $g_db_port, $g_db_name, $g_db_user, $g_db_pass);
	
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
	
	# Load all other functions, classes, and libraries
	@require_once(CORE_PATH.'f_misc.php'); # miscellaneous functions
	@require_once(CORE_PATH.'options.class.php'); # options class
	@require_once(CORE_PATH.'f_language.php'); # language functions
	@require_once(CORE_PATH.'genealogy.class.php'); # genealogy classes
	@require_once(CORE_PATH.'theme.class.php'); # theme class
	@require_once(CORE_PATH.'date.class.php'); # date-parser class
	@require_once(LIB_PATH.'adodb/adodb.inc.php'); # ADODB database library
	@require_once(LIB_PATH.'smarty/libs/Smarty.class.php'); # Smarty template engine

	# Establish the database connection
	$db =& AdoNewConnection(DB_TYPE);
	if (DB_TYPE == 'odbc_mssql') {
		# Microsoft SQL ODBC connection
		$dsn = 'Driver={SQL Server};Server='.DB_HOST.';Database='.DB_NAME.';';
		$db->Connect($dsn, DB_USER, DB_PASS);
	} else {
		# All other database types
		$host = (DB_PORT != '') ? DB_HOST.':'.DB_PORT : DB_HOST;
		$db->Connect($host, DB_USER, DB_PASS, DB_NAME);
	}
	# Make sure that RecordSets are always returned as associative arrays
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	
	# Start Smarty template engine
	$theme = (defined('_RGDS_ADMIN')) ? $g_admin_theme : $g_theme;
	$smarty =& new Smarty;
	$smarty->php_handling = SMARTY_PHP_REMOVE;
	$smarty->template_dir = THEME_PATH.$theme.'/templates/';
	$smarty->compile_dir = THEME_PATH.$theme.'/templates_c/';
	$smarty->config_dir = THEME_PATH.$theme.'/configs/';
	$smarty->register_function('translate', 'lang_translate_smarty');
	$smarty->assign('RGDS_COPYRIGHT', RGDS_COPYRIGHT);
	$smarty->assign('RGDS_VERSION', RGDS_VERSION);

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
	$smarty->assign('copyright', $copyright);
	unset($copyright);
	
	# Load profiler and initialize
	$profile = $options->profile_functions;
	if ($profile == true) {
		@require_once(LIB_PATH.'profiler/profiler.inc.php');
		$profiler =& new Profiler( true, false );
		$profiler->startTimer( 'all' );
	}

	# Initialize the gettext engine unless running in admin mode
	if (!defined('_RGDS_ADMIN')) {
		lang_init_gettext();
		if ($options->GetOption('allow_lang_change') == 1) {
			$g_langs = lang_get_langs();
			foreach ($g_langs as $lang) {
				$lang_name = $lang['lang_name'];
				$lang_names[] = gtc($lang_name);
				$lang_codes[] = $lang['lang_code'];
			}
		}
	}
?>