<?php
/**
 * Admin - Login Page
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
<title><?php echo _("phpGene Pro Administration Login"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">

		function setFocus() {
			document.loginform.uid.select();
			document.loginform.uid.focus();
		}

</script>
</head>
<body onload="setFocus();">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
      <form name="loginform" id="loginform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table width="400" border="1" cellpadding="0" cellspacing="0" bordercolor="#0066CC">
          <tr>
            <td><img src="images/logo.gif" width="600" height="59" /></td>
          </tr>
          <tr>
            <td align="center" valign="middle">						<table width="100%"  border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td align="center" valign="middle"><table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td align="right" valign="middle" class="text"><?php echo _("Username"); ?>:</td>
                    <td>
                      <input name="uid" type="text" class="textbox" tabindex="1" />
                    </td>
                    <td width="200" rowspan="3" align="center" valign="bottom"><input name="Submit" type="submit" class="text" tabindex="4" value="<?php echo _("Login"); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" class="text"><?php echo _("Password"); ?>:</td>
                    <td><input name="pwd" type="password" class="textbox" id="password" tabindex="2" />
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" class="text"><?php echo _("Language"); ?>:</td>
                    <td>
											<?php 
												echo '<select name="lang" size="1" class="listbox" id="lang" onChange="document.forms.form_change_lang.submit();">';
												foreach ($g_langs as $the_lang) {
													$code = $the_lang['lang_code'];
													$name = $the_lang['lang_name'];
													echo '<option value="'.$code.'"';
													if ($_SESSION['lang'] == $code) {
														echo ' SELECTED';
													}
													echo '>'._($name).'</option>';
												}
												echo '</select>';
											?>
										</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
