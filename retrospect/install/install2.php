<?php 
/**
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
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

  $g_root_path = dirname($_SERVER['PATH_TRANSLATED']) . '/..';
	
	/**
	* Require core.php
	* @access public
	*/
	require_once($g_root_path . '/core/core.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpGene Pro Installation - Step 2</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../administrator/styles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
    <td height="50" background="/administrator/images/adminlogo3.gif">&nbsp;</td> 
  </tr> 
  <tr> 
    <td><table width="100%"  border="0" cellspacing="4" cellpadding="0"> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr> 
        <tr> 
          <td class="content-subtitle">Installation Step 2 - Check Configuration</td> 
        </tr> 
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr>
          <td class="text">Verify that the following information is correct before proceeding. If anything
            is incorrect, edit the core/config.php file and then refresh this screen to see the changes.
            Once the settings are correct, click NEXT to continue. </td>
        </tr>
        <tr> 
          <td class="text">
						<?php 
							$loaded = include('../core/config.php'); 
							if ($loaded == false) { 
								echo 'The config file could not be found.  Please check that you have uploaded all the files for phpGene Pro.'; 
								$fatal_error = true;
							}
							else {
						?>
						<table  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" class="content-label">&nbsp;</td>
                <td width="300" class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="content-label">MySQL Hostname: </td>
                <td class="text"><?php echo $g_db_host; ?></td>
              </tr>
              <tr>
                <td class="content-label">MySQL Port: </td>
                <td class="text"><?php echo $g_db_port; ?></td>
              </tr>
              <tr>
                <td class="content-label">MySQL Username: </td>
                <td class="text"><?php echo $g_db_user; ?></td>
              </tr>
              <tr>
                <td class="content-label">MySQL Password: </td>
                <td class="text"><?php echo $g_db_pass; ?></td>
              </tr>
              <tr>
                <td class="content-label">MySQL Database: </td>
                <td class="text"><?php echo $g_db; ?></td>
              </tr>
            </table>
						<?php } ?>
					</td> 
        </tr> 
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr>
          <td class="text">
						<?php if ($fatal_error == false) { ?>
						<form name="install1" id="install1" method="post" action="install3.php">
            	<input name="Next" type="submit" class="text" id="Next" value="Next" />
	          </form>
						<?php } ?>
					</td>
        </tr> 
    </table></td> 
  </tr> 
</table> 
<p class="content-label">&nbsp;</p> 
<p class="content-label">&nbsp;</p> 
<p> </p> 
<table width="100%"  border="0" cellspacing="5" cellpadding="0"> 
  <tr> 
    <td class="text"> </td> 
  </tr> 
</table> 
</body>
</html>
