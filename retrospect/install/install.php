<?php
/**
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

  $g_root_path = dirname($_SERVER['PATH_TRANSLATED']) . '/..';

	/** 
	* Require core.php
	* @access public
	*/
	
	require_once($g_root_path . '/core/core.php');
	/**
	* Require install.class.php
	* @access public
	*/
	require_once('install.class.php');
	
	$fatal_error = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpGene Pro Installation - Step 1</title>
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
          <td class="content-subtitle">Installation Step 1 - Check Dependencies </td> 
        </tr> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr> 
        <tr> 
          <td class="text"><b>Checking PHP version...</b><br /> 
            <?php 
						$version = phpversion();
						echo 'PHP version '.$version.': ';
						if (version_compare($version, '4.0.6') >= 0) {
							echo 'OK<br />';
						}
						else {
							echo 'NOT OK.  Version 4.0.6 is the minimum version required<br />';
							$fatal_error = true;
						}
					?> </td> 
        </tr> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr> 
        <tr> 
          <td class="text"><strong>Checking extension dependencies...</strong><br /> 
            <?php 
						# mysql extension
						echo 'MySQL extension loaded: '.Install::bool2str_fatal(extension_loaded('mysql')).'<br />';
						# gettext extension
						echo 'Gettext extension loaded: '.Install::bool2str_fatal(extension_loaded('gettext')).'<br />';
					?> </td> 
        </tr> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr> 
        <tr> 
          <td class="text"><strong>Checking function dependencies...</strong><br />
          <?php 
				$msg =   'A slower replacement function will be used instead of the built-in PHP function.';
				# html entity decode
				echo 'html_entity_decode exists: '.Install::bool2str_msg(function_exists('html_entity_decode'), $msg).'<br />';
			?></td> 
        </tr> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr>
        <tr>
          <td class="text"><strong>Results...</strong><br />
          <?php 
				if ($fatal_error == true) {
					echo '** YOUR SYSTEM DOES NOT MEET THE MINUMUM REQUIREMENTS **<br />';
					echo 'You will not be able to continue with the installation process until the problem(s) are corrected.<br />';
					echo 'You can refer to the installation guide for help.<br />';
				}
				else {
					echo 'Your system meets the minumum requirements to run phpGene Pro.<br />';
					echo 'Click the NEXT button to continue with the installation.';
				}
			?></td>
        </tr>
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr>
          <td class="text">
						<?php if($fatal_error == false) { ?>
						<form name="install1" id="install1" method="post" action="install2.php">
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
