<?php 
/**
 * SQL Generation Tool
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
 
 	/**
	* Generates the SQL commands necessary to create all tables
	* @param string $db_type Database type for which to generate SQL 
	* @return array Array of SQL commands or false if error
	*/
	function GetTableCreationSQL($db_type, $tbl_prefix) {
		$db = NewAdoConnection($db_type);
		$schema = new adoSchema( $db );
		$schema->setPrefix( $tbl_prefix );
		if ($sql = $schema->ParseSchema('create.xml')) {
			return $sql;
		} else {
			return false;
		}
	}
	
	if ($_POST['Submit']) {
		require_once('../libraries/adodb/adodb.inc.php');
		require_once('../libraries/adodb/adodb-xmlschema.inc.php');
		$sql_str = '';
		$db_type = $_POST['dbtype'];
		$tbl_prefix = trim($_POST['prefix'],'_');
		if ($sql_arr = GetTableCreationSQL($db_type, $tbl_prefix)) {
			foreach ($sql_arr as $sql) {
				$sql_str .= $sql.";\n\n";
			}
		}
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - SQL Generator</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="install.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form name="form1" id="form1" method="post" action="">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">SQL Generator </td>
  </tr>
  <tr>
    <td class="section_body"><p>Select a database type:<br />
          <select name="dbtype" class="listbox" id="select">
            <option value="mysql">MySQL</option>
            <option value="postgres7">PostreSQL 7.x</option>
            <option value="mssql">Microsoft SQL (Native)</option>
            <option value="odbc-mssql">Microsoft SQL (ODBC)</option>
            <option value="sqlite">SQLite</option>
          </select>
    </p>
      <p>Enter a table prefix:<br />
        <input name="prefix" type="text" class="textbox" id="prefix" value="rgds" />
</p>
      <p>
        <input name="Submit" type="submit" class="button" value="Submit" />
      </p>
      <p>
        <textarea name="textarea" cols="100" rows="25" class="textbox"><?php echo $sql_str; ?></textarea>  
          </p></td>
  </tr>
</table>
</form>
</body>
</html>
