<?php
/**
 * Main index file
 *
 * @copyright         Keith Morrison, Infused Solutions 2001-2005
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

	# Define all application paths
	define('ROOT_PATH', dirname($_SERVER['SCRIPT_FILENAME'])); 	# Path to root Retrospect-GDS directory
	define('THEME_PATH', ROOT_PATH.'/themes/');
	define('CORE_PATH', ROOT_PATH.'/core/');
	define('PLUGIN_PATH', CORE_PATH.'plugins/');
	define('MODULE_PATH', CORE_PATH.'modules/');
	define('LIB_PATH', ROOT_PATH.'/libraries/');
	define('LOCALE_PATH', ROOT_PATH.'/locale/');
	define('MEDIA_PATH', ROOT_PATH.'/media/');
	define('GEDCOM_DIR', ROOT_PATH.'/gedcom/');
	define('BASE_URL', dirname($_SERVER['PHP_SELF']) == '/' ? '' : dirname($_SERVER['PHP_SELF']) );

	# Load the Restrospect-GDS core
	@require_once(ROOT_PATH.'/core/core.php');

?>