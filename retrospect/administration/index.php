<?php
/**
 * Admin - Main Index File
 *
 * This file defines several constants, calls the core,
 * and checks for login status.
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		administration
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
?>
<?php
  
	# Set flag that this is a parent file
	define( '_RGDS_VALID', 1 );	
	
	# Set flag that running in admin mode
	define( '_RGDS_ADMIN', 1 );
	
	# Turn on error reporting
	error_reporting(E_ALL);

	# Start or continue a session
	session_start();
	header('Cache-control: private'); # IE6 fix
	
	# Define all application paths
	define('ADMIN_PATH', dirname($_SERVER['PATH_TRANSLATED']));
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']).'/..'); # Path to root Retrospect-GDS directory
	define('CORE_PATH', ROOT_PATH.'/core/'); # Path to core files
	define('MODULE_PATH', ADMIN_PATH.'/modules/'); # Path to module files
	define('LIB_PATH', ROOT_PATH.'/libraries/'); # Path to 3rd party libraries
	define('LOCALE_PATH', ROOT_PATH.'/locale/'); # Path to gettext locale files
	define('THEME_PATH', ADMIN_PATH.'/themes/'); # Path to themes
	define('BASE_URL', dirname($_SERVER['PHP_SELF']));

	# Load the Restrospect-GDS core and others
	@require_once(CORE_PATH.'core.php');
	@require_once(ADMIN_PATH.'/auth.class.php');
	
	# Store the current url w/query string
	$cp = (empty($_SERVER['QUERY_STRING'])) ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	$smarty->assign('CURRENT_PAGE', $cp);
	
	# check login status and redirect as necessary
	$module = Auth::check() ? ((isset($_GET['m'])) ? $_GET['m'] : 'status') : 'login';
	if (Auth::check()) $smarty->assign('UID', $_SESSION['uid']);

	# Load the module's script
	@require_once(MODULE_PATH.$module.'.php');
	
	# Assign Smarty variables
	$smarty->assign('module', $module);
	$smarty->assign('PHP_SELF', $_SERVER['PHP_SELF']);
	$smarty->assign('THEME_URL', BASE_URL.'/themes/'.$g_admin_theme.'/');
	$smarty->assign('BASE_URL', BASE_URL);
	
	# Display the appropriate template
	if (isset($_GET['print']) AND $_GET['print'] == strtolower('y')) {
		$smarty->display('index_printable.tpl');
	} else {
		$smarty->display('index.tpl');
	}
?>