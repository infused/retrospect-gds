<?php 
/**
 * Installation index file
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
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
 *
 * $Id$
 *
 */  
	
	$g_root_path = dirname($_SERVER['PATH_TRANSLATED']) . '/..'
	
	/**
	* Require core.php
	* @access public
	*/
	require_once($g_root_path . '/core/core.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpGene Pro Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../administrator/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50" background="/administrator/images/adminlogo3.gif" class="text">&nbsp;</td>
  </tr>
  <tr>
    <td class="text">
			<table width="100%" border="0" cellspacing="4" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="content-subtitle">Installation Introduction </td>
        </tr>
        <tr>
          <td class="text"><p>The automated installation of Retrospect-GDS consists
              of the following steps. Please read  below for important information... </p>
            <p><strong>Step 1. Check dependencies</strong><br />
              During this step, the installer checks to see that PHP is at least
                4.0.6 or later and that required extensions and functions are
            installed. </p>
            <p>              <strong>Step 2. Check config.php</strong><br />
              The core/config.php file must be edited by hand before running
                this installer. During this step, you will review the configuration
                before proceeding to step 3. For further information refer to
                the installation manual. </p>
            <p>              <strong>Step 3. Create database tables</strong><br />
            This step creates the required tables in the database.<br />
            WARNING:  If the tables already exist, they will be dropped and recreated. </p>
            <p>              <strong>Step 4. Set Admin password</strong><br />
              You will choose an Admin password. The admin account will be used
            to log in to the administation module.</p>
            <p><br />
            </p></td>
        </tr>
        <tr>
          <td><form name="form1" id="form1" method="post" action="/install/install.php">
            <input name="Next" type="submit" class="text" id="Next" value="Next" />
          </form>            <p class="content-label">&nbsp;            </p>          </td>
        </tr>
      </table>
			<p class="content-label">&nbsp;</p>
		</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
