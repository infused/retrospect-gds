<?php
/**
 * Installation 
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
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
    <td class="title">Welcome to Retrospect-GDS Installation </td> 
  </tr> 
</table> 
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section"> 
  <tr> 
    <td class="section_head">Pre-Installation Checks</td> 
  </tr> 
  <tr> 
    <td class="section_body">If any of the items below are highlighted in red then please take actions to correct them. Failure to do so could lead to your Retrospect-GDS installation not functioning correctly.<table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
        <tr>
          <td class="section_item">&nbsp;</td>
          <td width="100" nowrap="nowrap" class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr> 
          <td width="400" class="section_item"><span class="item">PHP version</span></td> 
          <td align="center" nowrap="nowrap" class="section_item">
						<?php 
							$php_ver = phpversion();
							echo (version_compare($php_ver, '4.2.3') > 0) ? '<div class="yes">'.$php_ver.'</div>' : '<div class="no">'.$php_ver.'</div>';
						?></td> 
          <td class="section_item">(4.2.3 or greater required)</td>
        </tr> 
        <tr>
          <td class="section_item">Configuration file writable </td>
          <td align="center" class="section_item"><?php echo is_writable( '..' ) ? '<div class="yes">Yes</div>' : '<div="no">No</div>';?></td>
          <td class="section_item">Optional</td>
        </tr>
        <tr>
          <td class="section_item">Misc Extensions:</td>
          <td align="center" class="section_item">&nbsp;</td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr> 
          <td class="section_item"> - Gettext support </td> 
          <td align="center" class="section_item">
						<?php 
							$cfg_filename = CORE_PATH.'config.php';
							@chmod($cfg_filename, 666);
							echo extension_loaded('gettext') ? '<div class="yes">Yes</div>' : '<div class="no-not-req">No</div>';
						?>
					</td> 
          <td class="section_item">Required</td>
        </tr>
        <tr>
          <td class="section_item">- Mmcache </td>
          <td align="center" class="section_item">
					<?php
						echo function_exists('mmcache_cache_page') ? '<div class="yes">Yes</div>' : '<div class="no-not-req">No</div>';
					?>
					</td>
          <td class="section_item">Optional</td>
        </tr>
        <tr>
          <td class="section_item">- Adodb zend extension</td>
          <td align="center" class="section_item">
					<?php 
						echo extension_loaded('ADOdb') ? '<div class="yes">Yes</div>' : '<div class="no-not-req">No</div>';
					?>
					</td>
          <td class="section_item">Optional</td>
        </tr>
    </table></td></tr> 
</table> 
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Database Extensions</td>
  </tr>
  <tr>
    <td class="section_body">At least one of the following supported php database extensions must be loaded. MySQL is the recommended database for use with Retrospect-GDS
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
    <td class="section_body">The following are recommendations only. Retrospect-GDS should still function regardless of the actual setting used.
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
          <td align="center" class="section_item"><?php echo ini_get('safe_mode') ? '<div class="no">On</div>' : '<div class="yes">Off</div>'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Register Globals = Off </td>
          <td align="center" class="section_item"><?php echo ini_get('regiser_globals') ? '<div class="no">On</div>' : '<div class="yes">Off</div>'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">File Uploads = On </td>
          <td align="center" class="section_item"><?php echo ini_get('file_uploads') ? '<div class="yes">On</div>' : '<div class="no">Off</div>'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
        <tr>
          <td class="section_item">Magic Quotes = Off</td>
          <td align="center" class="section_item"><?php echo ini_get('magic_quotes') ? '<div class="no">On</div>' : '<div class="yes">Off</div>'; ?></td>
          <td class="section_item">&nbsp;</td>
        </tr>
      </table> </td>
  </tr>
</table>
<form name="form1" id="form1" method="post" action="install1.php">
  <input name="Submit" type="submit" class="button" value="Continue" />
</form>
</body>
</html>
