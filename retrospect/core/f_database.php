<?php
/**
 * Database Functions.
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		database
 * @license http://opensource.org/licenses/gpl-license.php
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
 */

/**
* Connects to database.
* If the connection fails this function exits the script.
* To ensure security, this function only returns a generic
* "Connection failed with error" message.
* @access public
* @param string $p_host hostname of database server
* @param integer $p_port port of database server
* @param string $p_user isername
* @param string $p_pass password
* @param string $p_db database
*/
function db_connect($p_host, $p_port, $p_user, $p_pass, $p_db) {
	@mysql_connect($p_host, $p_user, $p_pass) or die(_("Connection failed with error").'.');
	@mysql_select_db($p_db) or die(_("DB selection failed with error").'.');
}

/**
* Returns a result set from a query.
* Only returns a valid result set if used with a SELECT,SHOW,EXPLAIN or DESCRIBE query.
* @access public
* @param string $p_query the query string
* @return resource
*/
function db_query_r($p_query) {
	$result = @mysql_query($p_query) or die(_("Query failed with error").':<br />'.mysql_error());
	return $result;
}

/**
* Returns a single valued result from a query.
* Only returns a valid result set if used with a SELECT,SHOW,EXPLAIN or DESCRIBE query.
* @access public
* @param string $p_query the query string
* @return resource
*/
function db_query_r1($p_query) {
	$result = @mysql_query($p_query) or die(_("Query failed with error").':<br />'.mysql_error());
	$out = @mysql_result($result, 0);
	return $out;
}

/**
* Returns affected rows from a query.
* Only returns a valid row count if used with a INSERT, UPDATE or DELETE query.
* @access public
* @param string $p_query query string
* @return integer
*/
function db_query_a($p_query) {
	@mysql_query($p_query) or die(_("Query failed with error").':<br />'.mysql_error());
	$a = mysql_affected_rows();
	return $a;
}

/** 
* Returns nothing from a query.
* Use only if you don't care what the results are
* @access public
* @param string $p_query query string
*/
function db_query_n($p_query) {
	@mysql_query($p_query) or die(_("Query failed with error").':<br />'.mysql_error());
}
?>
