<?php
/**
 * Admin - User Edit Module
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
<form name="user_add_form" method="post" action="">
	<?php 
		if (isset($_POST['Save'])) {
			# validate values
			$form_error = false;
			
			if ($_POST['uid'] == '' or $_POST['fullname'] =='' or $_POST['email'] == '') { 
				notify('All fields are required.  Please correct the error.');
				$form_error = true;
			}
			if ($_POST['password1'] != $_POST['password2']) {
				notify('Both password fields must be the same.  Please re-type them.'); 
				$form_error = true;
			}
			if ($form_error != true) { 
				$result = Auth::UpdateUser($_POST['uid'], $_POST['fullname'], $_POST['email'], $_POST['password1']);
				if ($result == true) {
					notify( sprintf('User %s was successfully modified.', $_POST['uid']) );
					redirect_j($_SERVER['PHP_SELF'].'?option=user_list', 2);
				}
				else {
					notify( sprintf('User %s was not modified.', $_POST['username']) );
					redirect_j($_SERVER['PHP_SELF'].'?option=user_list', 2);
				}
			}
			echo '</td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
		elseif (isset($_POST['Delete'])) {
			$uid = $_POST['username'];
			$sql = "DELETE FROM $g_tbl_user WHERE uid='$uid'";
			$db->Execute($sql);
			notify( sprintf('User %s was deleted.', $_POST['username']) );
			redirect_j($_SERVER['PHP_SELF'].'?option=user_list', 2);
		}
		else {
			$id = $_GET['id'];
			$sql = "SELECT * FROM $g_tbl_user WHERE uid='$id'";
			$rs = $db->Execute($sql);
			$u = $rs->FetchRow($rs);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td colspan="2" align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">Edit User </td>
      </tr>
      <tr>
        <td class="section_body"><table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td width="200" class="content-label">Username:<br>
            </td>
            <td><input name="uid" type="text" class="textbox" id="uid" size="40" maxlength="40" value="<?php echo $u['uid']; ?>">
            </td>
          </tr>
          <tr>
            <td class="content-label">Full Name: </td>
            <td><input name="fullname" type="text" class="textbox" id="fullname" size="40" maxlength="40" value="<?php echo $u['fullname']; ?>">
            </td>
          </tr>
          <tr>
            <td class="content-label">Email Address: </td>
            <td><input name="email" type="text" class="textbox" id="email" size="40" maxlength="40" value="<?php echo $u['email']; ?>">
            </td>
          </tr>
          <tr>
            <td class="content-label">New Password:<br></td>
            <td class="text"><input name="password1" type="password" class="textbox" id="password1" size="40" maxlength="40" value="">
            </td>
          </tr>
          <tr>
            <td class="content-label">Verify Password: <br>
            </td>
            <td class="text"><input name="password2" type="password" class="textbox" id="password2" size="40" maxlength="40" value="">
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><input name="Save" type="submit" class="text" id="Save" value="Save">
    <input name="Reset" type="reset" class="text" id="Reset" value="Reset"></td>
    <td align="right"><input name="Delete" type="submit" class="text" id="Delete" value="Delete"></td>
  </tr>
</table>
</form>
<?php } ?>