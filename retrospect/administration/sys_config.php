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
<span class="notification">
<?php 
	$updated = false;
	
	function config_fail($p_value) {
		notify( sprintf('You must edit core/config.php to change the %s setting.', $p_value) );
	}
	
	if (isset($_POST['Save']) and $_POST['Save'] == 'Save') {
		if ($_POST['default_page_new'] != $_POST['default_page_old']) {
			$updated = $options->OptionUpdate('default_page', $_POST['default_page_new']);
		}
		if ($_POST['default_lang_new'] != $_POST['default_lang_old']) {
			$updated = $options->OptionUpdate('default_lang', $_POST['default_lang_new']);
		}
		if ($_POST['allow_lang_change_new'] != $_POST['allow_lang_change_old']) {
			$updated = $options->OptionUpdate('allow_lang_change', $_POST['allow_lang_change_new']);
		}
		if ($_POST['translate_dates_new'] != $_POST['translate_dates_old']) {
			$updated = $options->OptionUpdate('translate_dates', $_POST['translate_dates_new']);
		}
		if ($_POST['date_format_new'] != $_POST['date_format_old']) {
			$updated = $options->OptionUpdate('date_format', $_POST['date_format_new']);
		}
		if ($_POST['profile_functions_new'] != $_POST['profile_functions_old']) {
			$updated = $options->OptionUpdate('profile_functions', $_POST['profile_functions_new']);
		}
		if ($_POST['meta_copyright_new'] != $_POST['meta_copyright_old']) {
			$updated = $options->OptionUpdate('meta_copyright', $_POST['meta_copyright_new']);
		}
		if ($_POST['meta_keywords_new'] != $_POST['meta_keywords_old']) {
			$updated = $options->OptionUpdate('meta_keywords', $_POST['meta_keywords_new']);
		}
		
		if ($_POST['db_host_new'] != $_POST['db_host_old']) { config_fail('MySQL Hostname'); }
		if ($_POST['db_port_new'] != $_POST['db_port_old']) { config_fail('MySQL Port');	}
		if ($_POST['db_user_new'] != $_POST['db_user_old']) { config_fail('MySQL Username'); }
		if ($_POST['db_pass_new'] != $_POST['db_pass_old']) { config_fail('MySQL Password'); }
		if ($_POST['db_new'] != $_POST['db_old']) { config_fail('MySQL Database'); }
		
		# display status message
		if ($updated == false) { notify('Nothing to save.'); }
		else { notify('Options updated.'); }
		
		# re-initialize options object
		$options->Initialize();
	}
?>
</span>
<table width="100%"  border="0" cellpadding="5" cellspacing="0"> 
  <tr>
    <td align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">Site Configuration</td>
      </tr>
      <tr>
        <td class="section_body"><table width="100%"  border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="250" class="content-label">Default Page:</td>
            <td width="200"><input name="default_page_new" type="text" class="textbox" id="default_page_new" value="<?php echo $options->GetOption('default_page'); ?>">
                <input name="default_page_old" type="hidden" id="default_page_old" value="<?php echo $options->GetOption('default_page'); ?>">
            </td>
            <td>This must be a page that does not require any parameters.</td>
          </tr>
        </table></td>
      </tr>
    </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Database Configuration </td>
        </tr>
        <tr>
          <td class="section_body">The database settings are shown for reference only and can not be changed from this screen. You must edit core/config.php to change these settings.</td>
        </tr>
        <tr>
          <td class="section_body">
            <table  border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="250" class="content-label">MySQL Hostname:</td>
              <td width="200"><input name="db_host_new" type="text" class="textbox" id="db_host_new" value="<?php echo $g_db_host; ?>" readonly="true">
                  <input name="db_host_old" type="hidden" id="db_host_old" value="<?php echo $g_db_host; ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">MySQL Port: </td>
              <td><input name="db_port_new" type="text" class="textbox" id="db_port_new" value="<?php echo $g_db_port; ?>" readonly="true">
                  <input name="db_port_old" type="hidden" id="db_port_old" value="<?php echo $g_db_port; ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">MySQL Username:</td>
              <td><input name="db_user_new" type="text" class="textbox" id="db_user_new" value="<?php echo $g_db_user; ?>" readonly="true">
                  <input name="db_user_old" type="hidden" id="db_user_old" value="<?php echo $g_db_user; ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">MySQL Password: </td>
              <td><input name="db_pass_new" type="password" class="textbox" id="db_pass_new" value="<?php echo $g_db_pass; ?>" readonly="true">
                  <input name="db_pass_old" type="hidden" id="db_pass_old" value="<?php echo $g_db_pass; ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">MySQL Database: </td>
              <td><input name="db_new" type="text" class="textbox" id="db_new" value="<?php echo $g_db_name; ?>" readonly="true">
                  <input name="db_old" type="hidden" id="db_old" value="<?php echo $g_db_name; ?>"></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Language Configuration </td>
        </tr>
        <tr>
          <td class="section_body"><table  border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="250" class="content-label">Default Language:</td>
              <td><select name="default_lang_new" class="listbox" id="default_lang_new">
                  <?php
					 			$sql = "SELECT * FROM ".TBL_LANG;
								$rs = $db->Execute($sql);
								while ($row = $rs->FetchRow()) {
									echo '<option value="'.$row['lang_code'].'"';
									if ($options->GetOption('default_lang') == $row['lang_code']) { echo ' SELECTED'; }
									echo '>'.$row['lang_name'].'</option>';
					 			}
					 		?>
                </select>
                  <input name="default_lang_old" type="hidden" id="default_lang_old" value="<?php echo $options->GetOption('default_lang'); ?>"></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">Allow language changes?</td>
              <td><select name="allow_lang_change_new" class="listbox" id="allow_lang_change_new">
                  <option value="1" <?php if ($options->GetOption('allow_lang_change') == 1) echo 'SELECTED'; ?>><?php echo 'Yes'; ?></option>
                  <option value="0" <?php if ($options->GetOption('allow_lang_change') == 0) echo 'SELECTED'; ?>><?php echo 'No'; ?></option>
                </select>
                  <input name="allow_lang_change_old" type="hidden" id="allow_lang_change_old" value="<?php echo $options->GetOption('allow_lang_change'); ?>">
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td class="content-label">Translate Dates?</td>
              <td><select name="translate_dates_new" class="listbox" id="translate_dates_new">
                  <option value="1" <?php if ($options->GetOption('translate_dates') == 1) echo 'selected'; ?>><?php echo 'Yes'; ?></option>
                  <option value="0" <?php if ($options->GetOption('translate_dates') == 0) echo 'selected'; ?>><?php echo 'No'; ?></option>
                </select>
                  <input name="translate_dates_old" type="hidden" id="translate_dates_old" value="<?php echo $options->GetOption('translate_dates'); ?>"></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Date Format </td>
        </tr>
        <tr>
          <td class="section_body"><table  border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="250" class="content-label">Date Format </td>
              <td><select name="date_format_new" class="listbox" id="date_format_new">
                		<option value="j M Y" <?php if ($options->GetOption('date_format') == 'j M Y') echo 'selected'; ?>>25 Nov 1859</option>
										<option value="M j, Y" <?php if ($options->GetOption('date_format') == 'M j, Y') echo 'selected'; ?>>Nov 25, 1859</option>
              		</select>
                <input type="hidden" name="date_format_old" id="date_format_old" value="<?php echo $options->GetOption('date_format'); ?>" />
							</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Meta Tag Generation </td>
        </tr>
        <tr>
          <td class="section_body"><table  border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="250" class="content-label">Copyright Notice: </td>
              <td><input name="meta_copyright_new" type="text" class="textbox" id="meta_copyright_new" value="<?php echo $options->GetOption('meta_copyright'); ?>" size="50">
                  <input name="meta_copyright_old" type="hidden" id="meta_copyright_old" value="<?php echo $options->GetOption('meta_copyright'); ?>"></td>
            </tr>
            <tr>
              <td class="content-label">Default Keywords: </td>
              <td><input name="meta_keywords_new" type="text" class="textbox" id="meta_keywords_new" value="<?php echo $options->GetOption('meta_keywords'); ?>" size="50">
                  <input name="meta_keywords_old" type="hidden" id="meta_keywords_old" value="<?php echo $options->GetOption('meta_keywords'); ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Testing Configuration </td>
        </tr>
        <tr>
          <td class="section_body"><table  border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td width="250" class="content-label">Profile Functions?</td>
              <td><select name="profile_functions_new" class="listbox" id="profile_functions_new">
                  <option value="1" <?php if ($options->GetOption('profile_functions') == 1) echo 'SELECTED'; ?>><?php echo 'Yes'; ?></option>
                  <option value="0" <?php if ($options->GetOption('profile_functions') == 0) echo 'SELECTED'; ?>><?php echo 'No'; ?></option>
                </select>
                  <input name="profile_functions_old" type="hidden" id="profile_functions_old" value="<?php echo $options->GetOption('profile_functions'); ?>">
              </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
	<tr>
	<td><input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Reset" type="reset" class="text" id="Reset" value="Reset"></td>
	</tr>
</table> 
</form>
