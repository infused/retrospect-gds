<?php
	/**
	* Core
	*
	* This file loads all the other required modules and initializes 
	* global configuration variables, etc. 
	*
	* @copyright 	Keith Morrison, Infused Solutions	2001-2005
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
	
	# Turn on error reporting
	error_reporting(0);
	
	# Start or continue a session
	session_start();
	
	# Define some RGDS strings
	define('RGDS_VERSION', '2.0.b7');
	
	# Load the configuration file
	if (file_exists(CORE_PATH.'config.php')) @require_once(CORE_PATH.'config.php');
	else exit('Could not read configuration file.'); 

	# Define database parameters
	define('RGDS_DB_TYPE', $g_db_type);
	define('RGDS_DB_HOST', $g_db_host);
	define('RGDS_DB_PORT', $g_db_port);
	define('RGDS_DB_NAME', $g_db_name);
	define('RGDS_DB_USER', $g_db_user);
	define('RGDS_DB_PASS', $g_db_pass);
	
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
	define('TBL_USERTYPE', $g_db_prefix.'usertype');
	define('TBL_LANG', $g_db_prefix.'language');
	define('TBL_OPTION', $g_db_prefix.'options');
	define('TBL_MEDIA', $g_db_prefix.'media');
	define('TBL_COMMENT', $g_db_prefix.'comment');
	
	# Load all other functions, classes, and libraries
	require_once(CORE_PATH.'f_misc.php');
	require_once(CORE_PATH.'options.class.php');
	require_once(CORE_PATH.'f_language.php');
	require_once(CORE_PATH.'genealogy.class.php');
	require_once(CORE_PATH.'theme.class.php');
	require_once(CORE_PATH.'date.class.php');
	require_once(CORE_PATH.'auth.class.php');
	require_once(LIB_PATH.'adodb/adodb.inc.php');
	require_once(LIB_PATH.'smarty/libs/Smarty.class.php');

	# Establish the database connection
	# Connections to MSSQL via ODBC require a special connection string!
	# Always return recordsets as associative arrays
	$db =& AdoNewConnection(RGDS_DB_TYPE);
	if (RGDS_DB_TYPE == 'odbc_mssql') {
		$dsn = 'Driver={SQL Server};Server='.RGDS_DB_HOST.';Database='.RGDS_DB_NAME.';';
		$db->Connect($dsn, RGDS_DB_USER, RGDS_DB_PASS);
	} else {
		$host = (RGDS_DB_PORT) ? RGDS_DB_HOST : RGDS_DB_HOST.':'.RGDS_DB_PORT;
		$db->Connect($host, RGDS_DB_USER, RGDS_DB_PASS, RGDS_DB_NAME);
	}
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	
	# Create options object
	$options =& new Options();

	# Catch any directory permission problems before starting Smarty
	$theme = (defined('_RGDS_ADMIN')) ? $g_admin_theme : $g_theme;
	if (!is_writable(THEME_PATH.$theme.'/templates_c/')) 
	  die (THEME_PATH.$theme.'/templates_c/ is not writable!');
	if (!is_writable(ROOT_PATH.'/administration/themes/default/templates_c/')) 
	  die (ROOT_PATH.'/administration/themes/default/templates_c is not writable!' );
	if (!is_writable(ROOT_PATH.'/gedcom/')) 
	  die (ROOT_PATH.'/gedcom/ is not writable!' );
	
	# Start Smarty template engine
	$smarty =& new Smarty;
	if ($options->GetOption('debug') == 1) $smarty->debugging = true;
	$smarty->php_handling = SMARTY_PHP_REMOVE;
	$smarty->template_dir = THEME_PATH.$theme.'/templates/';
	$smarty->compile_dir = THEME_PATH.$theme.'/templates_c/';
	$smarty->config_dir = THEME_PATH.$theme.'/configs/';
	$smarty->register_function('translate', 'lang_translate_smarty');
	
	# Get general keywords that will be added to the meta keyword list on each page
	$keywords = explode(',', $options->GetOption('meta_keywords'));
	
	# Generate the site copyright info for all pages
	$smarty->assign('SITE_COPYRIGHT', $options->GetOption('meta_copyright'));

	# Initialize the gettext engine
	lang_init_gettext();
	lang_init_arrays();
	$smarty->assign('CHARSET', $charset);
	
	# Store the current url w/query string
	$qs = $_SERVER['QUERY_STRING'];
	$current_page = (empty($qs)) ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF'].'?'.$qs;
	define('CURRENT_PAGE', $current_page);

	$trackback_encoded = urlencode(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	$smarty->assign_by_ref('TRACKBACK_ENCODED', $trackback_encoded);

	# If a valid module is not selected then show the default page
	if (!defined('_RGDS_ADMIN')) {
		$module = isset($_GET['m']) ? $_GET['m'] : $options->GetOption('default_page');
	} else {
		$module = Auth::check() ? ((isset($_GET['m'])) ? $_GET['m'] : 'status') : 'login';
		if (Auth::check()) $smarty->assign('UID', $_SESSION['uid']);
	}

	# Load the module's controller script
	# If a theme module exists, it will be used instead of the default module
	if (file_exists(THEME_PATH.$theme.'/modules/'.$module.'.php')) {
	  require_once(THEME_PATH.$theme.'/modules/'.$module.'.php');
	} else {
	  require_once(MODULE_PATH.$module.'.php');
	}

	# Assign Smarty variables
	$smarty->assign('RGDS_VERSION', RGDS_VERSION);
	$smarty->assign('BASE_URL', BASE_URL);
	$smarty->assign('THEME_URL', BASE_URL.'/themes/'.$theme.'/');
	$smarty->assign('allow_lang_change', $options->GetOption('allow_lang_change'));
	$smarty->assign('allow_comments', $options->GetOption('allow_comments'));
	$smarty->assign_by_ref('module', $module);
	$smarty->assign_by_ref('meta_keywords', implode(', ', $keywords));
	$smarty->assign_by_ref('PHP_SELF', $_SERVER['PHP_SELF']);
	$smarty->assign_by_ref('CURRENT_PAGE', $current_page);
	if (isset($lang_names)) $smarty->assign_by_ref('lang_names', $lang_names);
	if (isset($lang_codes)) $smarty->assign_by_ref('lang_codes', $lang_codes);
	$smarty->assign_by_ref('lang', $_SESSION['language']);

	# Load the gallery plugin if available
	$smarty->assign('gallery_plugin', $options->GetOption('gallery_plugin'));
	if ($options->GetOption('gallery_plugin')) {
		require(PLUGIN_PATH.$options->GetOption('gallery_plugin'));
		if (isset($_GET['id'])) {
			$gp = new GalleryPlugin;
			$smarty->assign('media_count', $gp->media_count($_GET['id']));
			$smarty->assign('media_link', $gp->media_link($_GET['id']));
		}
	}
	
	# Check for comments
	if (isset($_GET['id'])) {
		$smarty->assign('comment_count', count_comments($_GET['id']));
	}

	# Display the appropriate template
	if ($module != 'gedcom_analyze' AND $module != 'gedcom_process') {
		if (isset($_GET['print']) AND $_GET['print'] == strtolower('y')) {
			$smarty->display('index_printable.tpl');
		} else {
			$smarty->display('index.tpl');
		}
	}
?>