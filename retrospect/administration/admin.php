<?php
/**
 * Admin - Template
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		administration
 * @license 		http://opensource.org/licenses/gpl-license.php
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
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo _("Retrospect-GDS Administration"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
  <tr> 
    <td height="50" rowspan="2" align="left" valign="top" bgcolor="#0066CC"><img src="images/logo.gif" width="600" height="59" /></td> 
    <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#0066CC" class="vertext">(v<?php echo $g_version; ?>)</td> 
    <td width="5" align="center" valign="bottom" nowrap="nowrap" bgcolor="#0066CC" class="vertext">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0066CC"><form name="form_change_lang" id="form_change_lang" method="post" action="<?php echo CURRENT_PAGE; ?>">
      <select name="lang" class="listbox" id="lang" onchange="document.forms.form_change_lang.submit();">
        <?php 
					foreach ($g_langs as $the_lang) {
						$code = $the_lang['lang_code'];
						$name = $the_lang['lang_name'];
						echo '<option value="'.$code.'"';
						if ($_SESSION['lang'] == $code) {
							echo ' SELECTED';
						}
						echo '>'._($name).'</option>';
					}
				?>
      </select>
    </form></td>
    <td align="center" valign="middle" nowrap="nowrap" bgcolor="#0066CC">&nbsp;</td>
  </tr> 
  <tr> 
    <td height="20" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC"> 
        <tr> 
          <td class="text"><div id="myMenuID"></div></td> 
          <td>&nbsp;</td> 
          <td align="right" class="text">
						<?php 
							printf(_("Logged in as %s"), $_SESSION['uid']);
							echo ' :: ';
							echo '<a href="'.$_SERVER['PHP_SELF'].'?auth=logout">'._("Logout").'</a>';
							echo '<img src="images/spacer.gif" width="5" height="1" />';
						?> 
					</td>
          <td width="5" align="right" class="text">&nbsp;</td>
        </tr> 
      </table>
		</td> 
  </tr> 
  <tr> 
    <td colspan="3" align="left" valign="top">
			<?php 
				$g_option = (isset($_GET['option'])) ? $_GET['option'] : 'status';
				if (file_exists($g_option.'.php')) {
					include($g_option.'.php');
				}
			?> 
		</td> 
  </tr> 
  <tr> 
    <td height="20" colspan="3" align="center">&nbsp;</td>
  </tr> 
</table> 
<?php include('menubar.php'); ?> 
<?php
	# print profile info
	if ($profile == true) {
		$profiler->stopTimer( 'all' );
		echo '<center><table><tr><td>';
		$profiler->printTimers(true);
		echo '</td></tr></table></center>';
	}
?>
</body>
</html>
