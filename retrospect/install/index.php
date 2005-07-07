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
	error_reporting(0);
	
	# Set flag that this is a parent file
	define( '_RGDS_VALID', 1 );	

	# Define all application paths
	define('ROOT_PATH', realpath(dirname($_SERVER['SCRIPT_FILENAME']).'/..'));
	define('CORE_PATH', ROOT_PATH.'/core/');
	define('LIB_PATH', ROOT_PATH.'/libraries/');
	$cfg_filename = CORE_PATH.'config.php';
	
	require_once('installer.class.php');
	$inst = new Installer();
	$yes = '<div class="yes">Yes</div>';
	$no = '<div class="no">No</div>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="install.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
    <td class="title">Retrospect-GDS Installation </td> 
  </tr> 
</table> 
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section"> 
  <tr> 
    <td class="section_head">Pre-Installation Checks</td> 
  </tr> 
  <tr> 
    <td class="section_body">If any of the items in this section are listed as No, you will need to correct the problem before proceeding. Retrospect-GDS will not function otherwise. 
      <table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
        <tr>
          <td class="section_item">&nbsp;</td>
          <td width="100" nowrap="nowrap" class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr> 
          <td width="400" class="section_item"><span class="item">PHP version greater than 4.2.3 </span></td> 
          <td align="center" nowrap="nowrap" class="section_item">
						<?php 
							$php_ver = phpversion();
							echo (version_compare($php_ver, '4.2.3') > 0) ? '<div class="yes">Yes</div>' : '<div class="no">No</div>';
						?>
					</td> 
          <td class="section_item">&nbsp;</td>
        </tr> 
        <tr> 
          <td class="section_item"> Gettext support </td> 
          <td align="center" class="section_item"><?php echo $inst->ext_Gettext() ? '<div class="yes">Yes</div>' : '<div class="no-not-req">No</div>'; ?>
					</td> 
          <td class="section_item">&nbsp;</td>
        </tr>
    </table></td></tr> 
</table> 
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Database Extensions</td>
  </tr>
  <tr>
    <td class="section_body">At least one of the following  database extensions must be supported by your PHP installation. MySQL is the preferred database back-end for running Retrospect-GDS.
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="section_item">&nbsp;</td>
          <td width="100" align="center" class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td width="400" class="section_item">MySQL</td>
          <td align="center" class="section_item"><?php echo extension_loaded('mysql') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.mysql.php">http://www.php.net/manual/en/ref.mysql.php</a></td>
        </tr>
        <tr>
          <td class="section_item">MySQLi</td>
          <td align="center" class="section_item"><?php echo extension_loaded('mysqli') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.mysqli.php" target="_blank">http://www.php.net/manual/en/ref.mysqli.php</a></td>
        </tr>
        <tr>
          <td class="section_item">Microsoft SQL</td>
          <td align="center" class="section_item"><?php echo extension_loaded('mssql') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.mssql.php" target="_blank">http://www.php.net/manual/en/ref.mssql.php</a></td>
        </tr>
        <tr>
          <td class="section_item">Oracle</td>
          <td align="center" class="section_item"><?php echo extension_loaded('oracle') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.oracle.php" target="_blank">http://www.php.net/manual/en/ref.oracle.php</a></td>
        </tr>
        <tr>
          <td class="section_item">Oracle 8</td>
          <td align="center" class="section_item"><?php echo extension_loaded('oci8') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.oci8.php" target="_blank">http://www.php.net/manual/en/ref.oci8.php</a></td>
        </tr>
        <tr>
          <td class="section_item">PostgreSQL</td>
          <td align="center" class="section_item"><?php echo extension_loaded('pgsql') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.pgsql.php" target="_blank">http://www.php.net/manual/en/ref.pgsql.php</a></td>
        </tr>
        <tr>
          <td class="section_item">SQLite</td>
          <td align="center" class="section_item"><?php echo extension_loaded('sqlite') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>'; ?></td>
          <td class="section_item"><a href="http://www.php.net/manual/en/ref.sqlite.php" target="_blank">http://www.php.net/manual/en/ref.sqlite.php</a></td>
        </tr>
    </table>      </td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Recommended PHP Settings </td>
  </tr>
  <tr>
    <td class="section_body">Certain functions may not work correctly if any of the following recommendations are not met.
You should correct these if possible before proceeding.
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td width="400" class="section_item"><strong>Recommended Setting</strong></td>
          <td width="100" align="center" class="section_item"><strong>Current Setting </strong></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Safe Mode = Off </td>
          <td align="center" class="section_item"><?php echo ini_get('safe_mode'); ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Register Globals = Off </td>
          <td align="center" class="section_item"><?php echo ini_get('register_globals') ? 'On' : 'Off'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">File Uploads = On </td>
          <td align="center" class="section_item"><?php echo ini_get('file_uploads') ? 'On' : 'Off'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
      </table> </td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Directory Permissions </td>
  </tr>
  <tr>
    <td class="section_body">The following directories must be writeable by the web server.
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="section_item">&nbsp;</td>
            <td class="section_item">&nbsp;</td>
            <td class="section_item">&nbsp;</td>
          </tr>
          <tr>
            <td width="400" class="section_item"><strong>File or Directory </strong></td>
            <td width="100" align="center" class="section_item"><strong>Writable</strong></td>
            <td class="section_item">&nbsp;</td>
          </tr>
          <tr>
            <td class="section_item">core/config.php</td>
            <td align="center" class="section_item">
							<?php
								touch(ROOT_PATH.'/core/config.php');
								echo $inst->make_writable(ROOT_PATH.'/core/config.php') ? $yes : $no;
							?>
						</td>
            <td class="section_item">&nbsp;</td>
          </tr>
          <tr>
            <td class="section_item">gedcom/</td>
            <td align="center" class="section_item">
							<?php
							 	echo $inst->make_writable(ROOT_PATH.'/gedcom/') ? $yes : $no;
							?>
						</td>
            <td class="section_item">&nbsp;</td>
          </tr>
          <tr>
            <td class="section_item">themes/summerbreeze/templates_c/</td>
            <td align="center" class="section_item">
							<?php
							 	echo is_writable(ROOT_PATH.'/themes/summerbreeze/templates_c/') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>';
							?>
						</td>
            <td class="section_item">&nbsp;</td>
          </tr>
          <tr>
            <td class="section_item">administration/themes/default/templates_c/</td>
            <td align="center" class="section_item">
							<?php
							 	echo is_writable(ROOT_PATH.'/administration/themes/default/templates_c/') ? '<div class="yes">Yes</div>' : '<div class="no">No</div>';
							?>
						</td>
            <td class="section_item">&nbsp;</td>
          </tr>
      </table></td>
  </tr>
</table>
<br />
<form name="form1" id="form1" method="post" action="install1.php">
  <input name="Submit" type="submit" class="button" value="Continue" />
</form>
</body>
</html>