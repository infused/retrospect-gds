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
  <h2>Step 1 - Checking Configuration</h2>
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

  ?>
  <p>If you have not already done so already, copy core/config-dist.php to core/config.php 
  and enter the details about your database connection.</p>
  
  <p>Congratulations! Your system appears to meet all of the requirements for installing Retrospect-GDS.&nbsp;
  Please <b><a href="index2.php">click here to complete the installation</a></b>.</p>
</body>
</html>