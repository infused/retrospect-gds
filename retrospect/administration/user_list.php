<?php
/**
 * Admin - Status Module
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
	  <td colspan="4" align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">User List</td>
      </tr>
      <tr>
        <td class="section_body"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>Username</td>
            <td>Full Name </td>
            <td>Email</td>
            <td>Last Login</td>
          </tr>
						<?php
							$sql = "SELECT * FROM $g_tbl_user";
							$rs = $db->Execute($sql);
							while ($row = $rs->FetchRow()) {
								$uid = $row['uid'];
								$fullname = $row['fullname'];
								$email = $row['email'];
								$pwd_expired = $row['pwd_expired'];
								echo '<tr>';
								echo '<td class="text" width="200"><a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$uid.'">'.$uid.'</a></td>';
								echo '<td class="text" width="200">'.$fullname.'</td>';
								echo '<td class="text">'.$email.'</td>';
								$last = ($row['last'] == '0000-00-00 00:00:00') ? 'Never' : $row['last'];
								echo '<td class="text">'.$last.'</td>';
								echo '</tr>';
							}
						?>
        </table></td>
      </tr>
    </table></td>
  </tr>

</table>
