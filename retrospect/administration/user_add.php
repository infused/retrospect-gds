<?php
/**
 * Admin - Add User Module
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
  <table width="100%" border="0" cellpadding="0" cellspacing="5"> 
    <tr> 
      <td align="left" valign="top">&nbsp;</td> 
    </tr> 
    <?php 
		if (isset($_POST['Add']) and $_POST['Add'] == 'Add') {
			echo '<tr><td class="notification">';
			# validate values
			$form_error = false;
			
			if ($_POST['username'] == '' or $_POST['fullname'] =='' or $_POST['email'] == '' or $_POST['password1'] == '' or $_POST['password2'] == '') { 
				echo _("All fields are required.  Please correct the error.").'<br />';
				$form_error = true;
			}
			if (!ereg('[0-9a-zA-Z]{6,16}', $_POST['username'])) {
				echo _("The username must be between 6 and 16 characters long and contain only alphanumeric characters.");
				$form_error = true;
			}
			if ($_POST['password1'] != $_POST['password2']) {
				echo _("Both password fields must be the same.  Please re-type them.").'<br />'; 
				$form_error = true;
			}
			if (!ereg('[0-9a-zA-Z]{6,16}', $_POST['password1'])) {
				echo _("The password must be between 6 and 16 characters long and contain only alphanumeric characters.");
				$form_error = true;
			}
			if ($form_error != true) { 
				if (Auth::UserExists($_POST['username'])) { 
					echo sprintf(_("User %s already exists.  Please use a different username."), $_POST['username']);
				}
				elseif (Auth::AddUser($_POST['username'], $_POST['fullname'], $_POST['email'], $_POST['password1'])) {
					echo sprintf(_("User %s was successfully added."), $_POST['username']).' ';
					redirect_j($_SERVER['PHP_SELF'].'?option=user_list', 2);
				}
			}
	
			echo '</td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
	if (!isset($_POST['Add']) or $form_error == true) {
	?> 
    <tr> 
      <td class="content-subtitle"><?php echo _("Add User"); ?>&nbsp;</td> 
    </tr> 
    <tr> 
      <td bgcolor="#CCCCCC">
				<table border="0" cellpadding="4" cellspacing="0"> 
          <tr> 
            <td width="200" class="content-label"><?php echo _("Username"); ?>:</td> 
            <td><input name="username" type="text" class="textbox" id="username" size="40" maxlength="40" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"> </td> 
          </tr> 
          <tr> 
            <td class="content-label"><?php echo _("Full Name"); ?>:</td> 
            <td><input name="fullname" type="text" class="textbox" id="fullname" size="40" maxlength="40" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>"> </td> 
          </tr> 
          <tr> 
            <td class="content-label"><?php echo _("Email Address"); ?>:</td> 
            <td><input name="email" type="text" class="textbox" id="email" size="40" maxlength="40" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"> </td> 
          </tr> 
          <tr> 
            <td class="content-label"><?php echo _("New Password"); ?>:</td> 
            <td class="text"> <input name="password1" type="password" class="textbox" id="password1" size="40" maxlength="40" value=""> </td> 
          </tr> 
          <tr> 
            <td class="content-label"><?php echo _("Verify Password"); ?>:</td> 
            <td class="text"> <input name="password2" type="password" class="textbox" id="password2" size="40" maxlength="40" value=""> </td> 
          </tr> 
        </table>
			</td> 
    </tr> 
    <tr> 
      <td>
				<input name="Add" type="submit" class="text" id="Add" value="<?php echo _("Add"); ?>"> 
        <input name="Reset" type="reset" class="text" id="Reset" value="<?php echo _("Reset"); ?>">
			</td> 
    </tr> 
  </table> 
</form> 
<?php } ?> 
