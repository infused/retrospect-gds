<?php
/**
 * Installation 
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
 * @license http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="install.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
	# Disable error reporting
	error_reporting(0);
	
	/**
	* Root path
	* @global string
	*/
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']));

	/**
	* Location of core files
	* @global string
	*/
	define('CORE_PATH', ROOT_PATH.'/../core/');	
	
	/** 
	* Location of library files
	* @global string
	*/
	define('LIB_PATH', ROOT_PATH.'/../libraries/');
	
	if (file_exists(CORE_PATH.'config.php')) {
		require_once(CORE_PATH.'config.php');
	}
?>
<form name="form1" id="form1" method="post" action="install2.php">
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title">Retrospect-GDS Installation </td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Database Configuration </td>
  </tr>
  <tr>
    <td class="section_body">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td width="200" class="section_item">Database type: </td>
          <td width="200" class="section_item"><select name="frm_db_type" class="listbox" id="frm_db_type">
            <option value="mysql" selected="selected">MySQL</option>
            <option value="postgres7">PostgreSQL 7.x</option>
            <option value="mssql">Microsoft SQL (Native)</option>
            <option value="odbc-mssql">Microsoft SQL (ODBC)</option>
          </select></td>
          <td class="section_item">MySQL is the only database supported in this release. Future versions will have support for more databases. </td>
        </tr>
        <tr>
          <td class="section_item">Host name:</td>
          <td class="section_item"><input name="frm_db_host" type="text" class="textbox" id="frm_db_host" value="<?php echo isset($g_db_host) ? $g_db_host : 'localhost'; ?>"></td>
          <td class="section_item">This is usually &quot;localhost&quot; unless the database is hosted on a remote server. </td>
        </tr>
        <tr>
          <td class="section_item">Server port: </td>
          <td class="section_item"><input name="frm_db_port" type="text" class="textbox" id="frm_db_port" value="<?php echo isset($g_db_port) ? $g_db_port : ''; ?>"/></td>
          <td class="section_item">Leave blank to use the default port.</td>
        </tr>
        <tr>
          <td class="section_item">Database name:</td>
          <td class="section_item"><input name="frm_db_name" type="text" class="textbox" id="frm_db_name" value="<?php echo isset($g_db_name) ? $g_db_name : ''; ?>"/></td>
          <td class="section_item">This database must already exist on the server. </td>
        </tr>
        <tr>
          <td class="section_item">User name: </td>
          <td class="section_item"><input name="frm_db_user" type="text" class="textbox" id="frm_db_user" value="<?php echo isset($g_db_user) ? $g_db_user : ''; ?>"/></td>
          <td class="section_item">Username with read/write permissions to the database. </td>
        </tr>
        <tr>
          <td class="section_item">Password:</td>
          <td class="section_item"><input name="frm_db_pass" type="text" class="textbox" id="frm_db_pass" value="<?php echo isset($g_db_pass) ? $g_db_pass : ''; ?>"/></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Table prefix: </td>
          <td class="section_item"><input name="frm_db_pref" type="text" class="textbox" id="frm_db_pref" value="<?php echo isset($g_db_prefix) ? $g_db_prefix : 'rgds_'; ?>" /></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Drop existing tables? </td>
          <td class="section_item"><input name="frm_db_drop" type="checkbox" id="frm_db_drop" value="checkbox" checked="checked" /></td>
          <td class="section_item">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<p>
  <input name="Submit" type="submit" class="button" value="Continue" />
</p>
</form>
</body>
</html>
