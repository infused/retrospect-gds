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
 */

 /**
 * $Id$
 */

 	# Disable error reporting
	error_reporting(E_ALL);

	# Set flag that this is a parent file
	define( '_RGDS_VALID', 1 );	

	# Define all application paths
	define('ROOT_PATH', realpath(dirname(__FILE__).'/..'));
	define('CORE_PATH', ROOT_PATH.'/core/');
	define('LIB_PATH', ROOT_PATH.'/libraries/');
	$cfg_filename = CORE_PATH.'config.php';
	
	# Load adodb library w/xmlschema
  require_once(LIB_PATH . 'adodb/adodb.inc.php');
  require_once(LIB_PATH . 'adodb/adodb-xmlschema.inc.php');

	require_once('installer.class.php');
	
	$inst = new Installer();
	$yes = '<span class="yes">Yes</span>';
	$no = '<span class="no">No</span>';
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
  <h2>Step 1 - Checking System</h2>
  <?php 
    # Check for appropriate version of PHP
    if (version_compare(phpversion(), '4.2.3') < 0) 
      die ('<p>The version of PHP you are using is older than version 4.2.3.  You will need to upgrade PHP before you can use Retrospect-GDS.</p>');
    
    # Check for at least one database driver
    $db_drivers[] = extension_loaded('mysql'); 
    $db_drivers[] = extension_loaded('mysqli');
    $db_drivers[] = extension_loaded('mssql');
    $db_drivers[] = extension_loaded('oracle');
    $db_drivers[] = extension_loaded('oci8');
    $db_drivers[] = extension_loaded('pgsql');
    $db_drivers[] = extension_loaded('sqlite');
    if (!in_array(true, $db_drivers))
      die('<p>No supported database extensions are configured in PHP.  You will need to install a supported database driver before you can use Retrospect-GDS.</p>');
  
    # Correct file permissions
    if (!$inst->make_writable(ROOT_PATH.'/gedcom/') 
        or !$inst->make_writable(ROOT_PATH.'/themes/summerbreeze/templates_c/')
        or !$inst->make_writable(ROOT_PATH.'/administration/themes/default/templates_c/')) {
          echo '<p>The web server must be able to write to the following directories.  Please correct ';
          echo 'the permission on these directories and then refresh this page.</p>';
          echo '<p>';
          echo ROOT_PATH.'/gedcom/<br />';
          echo ROOT_PATH.'/themes/summerbreeze/templates_c/<br />';
          echo ROOT_PATH.'/administration/themes/default/templates_c/';
          die();
    }

  if (!file_exists(CORE_PATH.'config.php')) { ?>
    <p>Your configuration file could not be found.<br />
       Please open up the <b>config-dist.php</b> in the <b>core</b> directory and fill in your database details.
       Then save the file and rename it to <b>config.php</b>.</p>
  <?php } else { ?>
    <p>Congratulations! Your system appears to meet all of the requirements for installing Retrospect-GDS.</p>
    
    <h2>Step 2 - Testing Database Connection</h2>
    
    <?php 
      # Load the user configuration
      require_once(CORE_PATH.'config.php');
      
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
      
      # Do we have a good database connection?
      # MetaTables will return an empty array if no tables exist in the database, otherwise
      # the array will contain a list of the existing tables.  We use the call to MetaTables
      # because checking $db is not always a reliable means to test for a valid connection.
      if ( is_array($db->MetaTables()) or $db == true )
        echo 'No errors were encountered.';
      else
        die('A database connection could not be established.  Please check your settings in <b>config.php</b> and run the installer again.');
    ?>
    
    <h2>Step 3 - Checking For Previous Versions</h2>
    
    <?php
      # New install or upgrade?
      if (in_array($g_db_prefix.'user',$db->MetaTables())) { ?>
      
        <p>A previous version of Retrospect-GDS was found.</p>
        <p>Please choose one of the following options:
          <ul>
            <li>If you are upgrading from <b>version 2.0.0 or above</b> you can 
        <a href="upgrade.php">upgrade your database</a>.</li>
            <li>If you are upgrading from a <b>version older than 2.0.0</b> or you would just like to overwrite 
        your old database continue with a 
        <a href="install.php">normal installation</a>.</li>
          </ul>
        </p>
    <?php } else { ?>
      <p>No previous versions were found.</p>
      <p><b><a href="install.php">Click here to continue with the installation...</a></b></p>
    <?php } ?>
    
  <?php } ?>
  
</body>
</html>