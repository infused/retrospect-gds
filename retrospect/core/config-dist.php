<?php 
/**
 * Contains global configuration variables.
 *
 * This is the first required file loaded by the core. It contains all the
 * necessary information to establish a database connection, sets global table
 * names, and sets global page names.
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		config
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

# --- Database vars ------------

/**
* Database type.
* One of following supported database type strings:
* mysql, mssql, postgres7, odbc-mssql
*/
$g_db_type = 'mysql';

/**
* Database hostname.
* This is usually set to 'localhost' but could be remote hostname or ip address
* @global string $g_db_host
*/
$g_db_host = 'localhost';

/**
* Database port.
* The default port that your database software uses.
* Leave this blank if you don't know.
* @global integer $g_db_port
*/
$g_db_port = '';

/**
* Database name.
* The name of the database to connect to
* @global string $g_db_name
*/
$g_db_name   = 'database';

/**
* Database table prefix.
* Don't change this unless you really need to.
* @global string $g_db_prefix
*/
$g_db_prefix = 'rgds_';

/** 
* Database username.
* Username authorized to login to the database specified in {@link $g_db}
* @global string $g_db_user
*/
$g_db_user = 'username';

/** 
* Database password.
* Password for {@link $g_db_user} authorized to login to the database specified in {@link $g_db}
* @global string $g_db_pass
*/
$g_db_pass = 'password';

/** 
* Default theme.
* Specifies the default theme for page display.
* Don't change this unless you really need to.
* @global string $g_theme
*/
$g_theme	= 'default';

?>