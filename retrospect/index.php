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

	# Turn on error reporting
	error_reporting(E_ALL);
	
	# Start output buffering
	ob_start();	

	# Start or continue a session
	session_start();
	header('Cache-control: private'); # IE6 fix

	# Define all application paths
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED'])); # Path to root Retrospect-GDS directory
	define('CORE_PATH', ROOT_PATH.'/core/'); # Path to core files
	define('LIB_PATH', ROOT_PATH.'/libraries/'); # Path to 3rd party libraries
	define('LOCALE_PATH', ROOT_PATH.'/locale/'); # Path to gettext locale files
	define('FPDF_FONTPATH', LIB_PATH.'fpdf/font/'); # FPDF font path

	# Load the Restrospect-GDS core
	@require_once(CORE_PATH.'core.php');
	
	/**
	* Store the current url w/query string
	*/
	$current_page = $_SERVER['PHP_SELF'];
	if (!empty($_SERVER['QUERY_STRING'])) $current_page .= '?'.$_SERVER['QUERY_STRING'];
	define('CURRENT_PAGE', $current_page);
	$smarty->assign('CURRENT_PAGE', CURRENT_PAGE);
	unset($current_page);

	/**
	* Load the appropriate theme option page
	*/
	$g_option = isset($_GET['option']) ? $_GET['option'] : $options->GetOption('default_page');
	include(Theme::getPage($g_theme, $g_option));

	/**
	* Load the appropriate theme menu page
	*/
	//include(Theme::getPage($g_theme, 'menu'));
	// THIS NEEDS FIXING!
	//$smarty->assign('g_menu', $g_menu);

	/**
	* Load the appropriate theme template page
	*/
	//isset($_GET['print']) ? include(Theme::getPage($g_theme, 'template_print')) : include(Theme::getPage($g_theme, 'template'));
	
	$smarty->assign('option', $g_option);
	$smarty->assign('meta_keywords', implode(', ', $keywords));
	$smarty->assign('php_self', $_SERVER['PHP_SELF']);
	$smarty->assign('lang_names', $lang_names);
	$smarty->assign('lang_codes', $lang_codes);
	$smarty->assign('lang', $_SESSION['lang']);
	if (isset($_GET['print'])) {
		$smarty->display('index_printable.tpl');
	} else {
		$smarty->display('index.tpl');
	}

?>