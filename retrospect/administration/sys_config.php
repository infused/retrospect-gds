<?php
/**
 * Admin - System Configuration Module
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
<form name="config_form" method="post" action="">
<table width="100%"  border="0" cellpadding="0" cellspacing="5"> 
  <tr> 
    <td class="notification" align="left" valign="top">
			<?php 
				$updated = false;
				
				function config_fail($p_value) {
					echo sprintf(_("You must edit core/config.php to change the %s setting."), $p_value).'<br />';
				}
				
				if (isset($_POST['Save']) and $_POST['Save'] == 'Save') {
					//echo '<tr><td class="notification">';
					if ($_POST['default_page_new'] != $_POST['default_page_old']) {
						$updated = $options->OptionUpdate($_POST['default_page_new'], $_POST['default_page_old'], 'default_page');
					}
					if ($_POST['default_lang_new'] != $_POST['default_lang_old']) {
						$updated = $options->OptionUpdate($_POST['default_lang_new'], $_POST['default_lang_old'], 'default_lang');
					}
					if ($_POST['allow_lang_change_new'] != $_POST['allow_lang_change_old']) {
						$updated = $options->OptionUpdate($_POST['allow_lang_change_new'], $_POST['allow_lang_change_old'], 'allow_lang_change');
					}
					if ($_POST['translate_dates_new'] != $_POST['translate_dates_old']) {
						$updated = $options->OptionUpdate($_POST['translate_dates_new'], $_POST['translate_dates_old'], 'translate_dates');
					}
					if ($_POST['db_host_new'] != $_POST['db_host_old']) { config_fail(_("MySQL Hostname")); }
					if ($_POST['db_port_new'] != $_POST['db_port_old']) { config_fail(_("MySQL Port"));	}
					if ($_POST['db_user_new'] != $_POST['db_user_old']) { config_fail(_("MySQL Username")); }
					if ($_POST['db_pass_new'] != $_POST['db_pass_old']) { config_fail(_("MySQL Password")); }
					if ($_POST['db_new'] != $_POST['db_old']) { config_fail(_("MySQL Database")); }
					if ($updated == false) { echo _("Nothing to save."); }
					else { echo _("Options updated."); }
					//echo '</td></tr>';
					//echo '<tr><td>&nbsp;</td></tr>';
					
					# re-initialize options object
					$options->Initialize();
				}
			?>
		</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Site Configuration"); ?></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top"> <table width="100%"  border="0" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC"> 
        <tr> 
          <td width="250" class="content-label"><?php echo _("Default Page"); ?>:</td> 
          <td width="200"><input name="default_page_new" type="text" class="textbox" id="default_page_new" value="<?php echo $options->GetOption('default_page'); ?>">
          <input name="default_page_old" type="hidden" id="default_page_old" value="<?php echo $options->GetOption('default_page'); ?>">          </td> 
          <td>This must be a page that does not require any parameters.</td>
        </tr> 
      </table></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Database Configuration"); ?></td> 
  </tr>
  <tr> 
    <td align="left" valign="top" bgcolor="#CCCCCC"><table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><span class="text"><?php echo _("The database settings are shown for reference only and can not be changed from this screen. You must edit core/config.php to change these settings."); ?></span></td>
      </tr>
    </table>
    <table  border="0" cellspacing="0" cellpadding="2"> 
        <tr> 
          <td width="250" class="content-label"><?php echo _("MySQL Hostname"); ?>:</td> 
          <td width="200"><input name="db_host_new" type="text" class="textbox" id="db_host_new" value="<?php echo $g_db_host; ?>" readonly="true">
            <input name="db_host_old" type="hidden" id="db_host_old" value="<?php echo $g_db_host; ?>"></td> 
          <td>&nbsp;</td>
        </tr> 
        <tr> 
          <td class="content-label"><?php echo _("MySQL Port"); ?>: </td> 
          <td><input name="db_port_new" type="text" class="textbox" id="db_port_new" value="<?php echo $g_db_port; ?>" readonly="true">
          <input name="db_port_old" type="hidden" id="db_port_old" value="<?php echo $g_db_port; ?>"></td> 
          <td>&nbsp;</td>
        </tr> 
        <tr> 
          <td class="content-label"><?php echo _("MySQL Username"); ?>:</td> 
          <td><input name="db_user_new" type="text" class="textbox" id="db_user_new" value="<?php echo $g_db_user; ?>" readonly="true">
          <input name="db_user_old" type="hidden" id="db_user_old" value="<?php echo $g_db_user; ?>"></td> 
          <td>&nbsp;</td>
        </tr> 
        <tr> 
          <td class="content-label"><?php echo _("MySQL Password"); ?>: </td> 
          <td><input name="db_pass_new" type="password" class="textbox" id="db_pass_new" value="<?php echo $g_db_pass; ?>" readonly="true">
          <input name="db_pass_old" type="hidden" id="db_pass_old" value="<?php echo $g_db_pass; ?>"></td> 
          <td>&nbsp;</td>
        </tr> 
        <tr> 
          <td class="content-label"><?php echo _("MySQL Database"); ?>: </td> 
          <td><input name="db_new" type="text" class="textbox" id="db_new" value="<?php echo $g_db_name; ?>" readonly="true">
          <input name="db_old" type="hidden" id="db_old" value="<?php echo $g_db_name; ?>"></td> 
          <td>&nbsp;</td>
        </tr> 
      </table>
		</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Language Configuration"); ?></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" bgcolor="#CCCCCC"><table  border="0" cellspacing="0" cellpadding="0"> 
        <tr bgcolor="#CCCCCC"> 
          <td width="250" class="content-label"><?php echo _("Default Language"); ?>: </td> 
          <td>
						<select name="default_lang_new" class="listbox" id="default_lang_new"> 
              <?php
					 			$sql = "SELECT * FROM $g_tbl_lang";
								$rs = $db->Execute($sql);
								while ($row = $rs->FetchRow()) {
									echo '<option value="'.$row['lang_code'].'"';
									if ($options->GetOption('default_lang') == $row['lang_code']) { echo ' SELECTED'; }
									echo '>'.$row['lang_name'].'</option>';
					 			}
					 		?> 
            </select>
						<input name="default_lang_old" type="hidden" id="default_lang_old" value="<?php echo $options->GetOption('default_lang'); ?>"></td> 
        </tr>
        <tr bgcolor="#CCCCCC">
          <td class="content-label"><?php echo _("Allow language changes"); ?>?</td>
          <td>
						<select name="allow_lang_change_new" class="listbox" id="allow_lang_change_new">
            	<option value="1" <?php if ($options->GetOption('allow_lang_change') == 1) echo 'SELECTED'; ?>><?php echo _("Yes"); ?></option>
            	<option value="0" <?php if ($options->GetOption('allow_lang_change') == 0) echo 'SELECTED'; ?>><?php echo _("No"); ?></option>
          	</select>
						<input name="allow_lang_change_old" type="hidden" id="allow_lang_change_old" value="<?php echo $options->GetOption('allow_lang_change'); ?>">
					</td>
        </tr>
        <tr bgcolor="#CCCCCC">
          <td class="content-label"><?php echo _("Translate Dates"); ?>?</td>
          <td><select name="translate_dates_new" class="listbox" id="translate_dates_new">
            <option value="1" <?php if ($options->GetOption('translate_dates') == 1) echo 'SELECTED'; ?>><?php echo _("Yes"); ?></option>
            <option value="0" <?php if ($options->GetOption('translate_dates') == 0) echo 'SELECTED'; ?>><?php echo _("No"); ?></option>
          </select>
            <input name="translate_dates_old" type="hidden" id="translate_dates_old" value="<?php echo $options->GetOption('translate_dates'); ?>"></td>
        </tr> 
      </table>		</td> 
  </tr> 
	<tr>
	<td><input name="Save" type="submit" class="text" id="Save" value="<?php echo _("Save"); ?>"> 
	<input name="<?php echo _("Reset"); ?>" type="reset" class="text" id="<?php echo _("Reset"); ?>" value="<?php echo _("Reset"); ?>"></td>
	</tr>
</table> 
</form>
