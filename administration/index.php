<?php
/**
 * Admin - Main Index File
 *
 * This file defines several constants, calls the core,
 * and checks for login status.
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
	
	# Define all application paths
	define('ADMIN_PATH', realpath(dirname(__FILE__)));
	define('ROOT_PATH', realpath(dirname(__FILE__) . '/..')); # Path to root Retrospect-GDS directory
	define('CORE_PATH', ROOT_PATH.'/core/'); # Path to core files
	define('MODULE_PATH', ADMIN_PATH.'/modules/'); # Path to module files
	define('LIB_PATH', ROOT_PATH.'/libraries/'); # Path to 3rd party libraries
	define('LOCALE_PATH', ROOT_PATH.'/locale/'); # Path to gettext locale files
	define('THEME_PATH', ADMIN_PATH.'/themes/'); # Path to themes
	define('BASE_URL', dirname($_SERVER['PHP_SELF']));
	define('BASE_SCRIPT', $_SERVER['PHP_SELF']);
	define('GEDCOM_DIR', ROOT_PATH.'/gedcom/');

	# Load the Restrospect-GDS core and others
	require_once(CORE_PATH.'core.php');
?>