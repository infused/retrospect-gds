<?php
/**
 * Installation 
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
 */

 /**
 * $Id$
 */
  
  # Disable error reporting
  error_reporting(E_ALL);

  # Define all application paths
	define('ROOT_PATH', realpath(dirname(__FILE__).'/..'));
	define('CORE_PATH', ROOT_PATH.'/core/');
	define('LIB_PATH', ROOT_PATH.'/libraries/');
  
  # Load the user configuration
  require_once(CORE_PATH.'config.php');
  
  # Load adodb library w/xmlschema
  require_once(LIB_PATH . 'adodb/adodb.inc.php');
  require_once(LIB_PATH . 'adodb/adodb-xmlschema.inc.php');
  
  # Load the upgrader class
  require_once('upgrade.class.php');
  
  # Establish the database connection
  # Connections to MSSQL via ODBC require a special connection string!
  # Always return recordsets as associative arrays
  $db =& AdoNewConnection($g_db_type);
  if ($g_db_type == 'odbc_mssql') {
  	$dsn = 'Driver={SQL Server};Server='.$g_db_host.';Database='.$g_db_name.';';
  	$db->Connect($dsn, $g_db_user, $g_db_pass);
  } else {
  	$host = ($g_db_port) ? $g_db_host : $g_db_host.':'.$g_db_port;
  	$db->Connect($host, $g_db_user, $g_db_pass, $g_db_name);
  }
  $db->SetFetchMode(ADODB_FETCH_ASSOC);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="install.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <h1>Retrospect-GDS Installer</h1>
  
  <h2>Step 4 - Upgrading Tables</h2>
  
  <?php
  		# update tables and indexes
  		$schema = new adoSchema( $db );
  		$schema->setPrefix( $g_db_prefix );
  		$sql = $schema->ParseSchema('upgrade.xml');
  		$result = $schema->ExecuteSchema( $sql );
  		$error = $db->ErrorMsg(); 
      if ($result != true) 
        die('The following error was encountered while creating the database tables:<br/> '.$error);
      else 
        echo 'No error were encountered.';
    ?> 
    
    <h2>Step 5 - Updating Records</h2>

    <?php
      $upgrader = new Upgrader;
      $upgrader->upgrade_languages();
      $upgrader->upgrade_options();
    ?>
    
    <h2>Step 6 - Verifying Data</h2>

    <?php
      # Verifying tables
      $tables_in_db = $db->MetaTables('TABLES');
      $tables = array('language' => 9,
                      'options' => 14);
      foreach ($tables as $table => $records) {
        $sql = 'SELECT COUNT(*) FROM '.$g_db_prefix.$table;
        $count = $db->GetOne($sql);
        if ($count != $records) 
          die('The '.$g_db_prefix.$table.' table does not contain the correct number of records. Found '.$count.', but there should be '.$records.'.');
      }
    ?>
    No errors were encountered.

    <h2>Installation Complete!</h2>
    <p>You should now <a href="../administration/">login to the admin area</a> 
       to check your configuration.
    </p>

  </body>
  </html>