<?php
/**
 * Main index file
 *
 * @copyright         Keith Morrison, Infused Solutions        2001-2004
 * @author            Keith Morrison <keithm@infused-solutions.com>
 * @package           core
 * @license           http://opensource.org/licenses/gpl-license.php
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

	# Set flag that this is a parent file
	define( '_RGDS_VALID', 1 );	
	
	# Turn on error reporting
	error_reporting(E_ALL);
	
	# Start or continue a session
	session_start();

	# Define all application paths
	define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME'])); 	# Path to root Retrospect-GDS directory
	define('CORE_PATH', ROOT_PATH.'/core/'); 										# Path to core files
	define('MODULE_PATH', CORE_PATH.'modules/'); 								# Path to module files
	define('THEME_PATH', ROOT_PATH.'/themes/'); 								# Path to themes
	define('LIB_PATH', ROOT_PATH.'/libraries/'); 								# Path to 3rd party libraries
	define('LOCALE_PATH', ROOT_PATH.'/locale/'); 								# Path to gettext locale files
	define('BASE_URL', dirname($_SERVER['PHP_SELF']) == '/' ? '' : dirname($_SERVER['PHP_SELF']) );

	# Load the Restrospect-GDS core
	@require_once(CORE_PATH.'core.php');
	
	# Store the current url w/query string
	$cp = (empty($_SERVER['QUERY_STRING'])) ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	$smarty->assign_by_ref('CURRENT_PAGE', $cp);
	
	$trackback_encoded = urlencode(base64_encode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	$smarty->assign_by_ref('TRACKBACK_ENCODED', $trackback_encoded);

	# Make sure a valid module is set or get the default page
	$module = isset($_GET['m']) ? $_GET['m'] : $options->GetOption('default_page');
	
	# Load the module's script
	@require_once(MODULE_PATH.$module.'.php');
	
	# Assign Smarty variables
	$smarty->assign_by_ref('module', $module);
	$smarty->assign_by_ref('meta_keywords', implode(', ', $keywords));
	$smarty->assign_by_ref('PHP_SELF', $_SERVER['PHP_SELF']);
	$smarty->assign('BASE_URL', BASE_URL);
	$smarty->assign('THEME_URL', BASE_URL.'/themes/'.$g_theme.'/');
	$smarty->assign('allow_lang_change', $options->GetOption('allow_lang_change'));
	if (isset($lang_names)) $smarty->assign_by_ref('lang_names', $lang_names);
	if (isset($lang_codes)) $smarty->assign_by_ref('lang_codes', $lang_codes);
	$smarty->assign_by_ref('lang', $_SESSION['language']);
	
	# Display the appropriate template
	if (isset($_GET['print']) AND $_GET['print'] == strtolower('y')) {
		$smarty->display('index_printable.tpl');
	} else {
		$smarty->display('index.tpl');
	}
?>