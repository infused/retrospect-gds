<?php
/**
 * Admin - User List Module
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
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="5" cellpadding="0">
	<tr>
	  <td align="left" valign="top" colspan="4">&nbsp;</td>
  </tr>
	<tr>
    <td align="left" valign="top" colspan="4" class="content-subtitle"><?php echo _("User List"); ?></td>
  </tr>
	<tr>
	  <td align="left" valign="top" colspan="4">&nbsp;</td>
  </tr>
	<tr>
	  <td align="left" valign="top" class="content-label"><?php echo _("Username"); ?></td>
    <td align="left" valign="top" class="content-label"><?php echo _("Full Name"); ?></td>
    <td align="left" valign="top" class="content-label"><?php echo _("Email"); ?></td>
	  <td align="left" valign="top" class="content-label"><?php echo _("Last Login"); ?></td>
	</tr>
	<?php
		$sql = "SELECT * FROM $g_tbl_user";
		$rs = $db->Execute($sql);
		while ($row = $rs->FetchRow()) {
			$uid = stripslashes($row['uid']);
			$fullname = stripslashes($row['fullname']);
			$email = stripslashes($row['email']);
			echo '<tr>';
			echo '<td class="text" width="200"><a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$row['id'].'">'.$uid.'</a></td>';
			echo '<td class="text" width="200">'.$fullname.'</td>';
			echo '<td class="text">'.$email.'</td>';
			$last = ($row['last'] == '0000-00-00 00:00:00') ? _("Never") : $row['last'];
			echo '<td class="text">'.$last.'</td>';
			echo '</tr>';
		}
	?>
</table>
