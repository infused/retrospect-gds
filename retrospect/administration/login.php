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
        <table border="0" cellpadding="0" cellspacing="0" width="400">
          <tr>
            <td><img src="spacer.gif" width="319" height="1" border="0" alt=""></td>
            <td><img src="spacer.gif" width="81" height="1" border="0" alt=""></td>
            <td><img src="spacer.gif" width="1" height="1" border="0" alt=""></td>
          </tr>
          <tr>
            <td colspan="2"><img name="Untitled2_r1_c1" src="images/logo.png" width="400" height="49" border="0" alt=""></td>
            <td><img src="spacer.gif" width="1" height="82" border="0" alt=""></td>
          </tr>
          <tr>
            <td align="left" valign="middle">
							<table border="0" cellpadding="2" cellspacing="0">
                <tr>
                  <td align="right" valign="middle" class="text"><b><?php echo _("User ID"); ?>:</b></td>
                  <td>
                    <input name="uid" type="text" class="textbox" tabindex="1" />
                  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="text"><b><?php echo _("Password"); ?>:</b></td>
                  <td><input name="pwd" type="password" class="textbox" id="password" tabindex="2" />
                  </td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="text"><b><?php echo _("Language"); ?>:</b></td>
                  <td><select name="lang" class="listbox" tabindex="3">
                    <option value="en_US"<?php if ($_SESSION['lang'] == 'en_US') { echo ' SELECTED'; } ?>><?php echo _("English"); ?></option>
                    <option value="es_ES"<?php if ($_SESSION['lang'] == 'es_ES') { echo ' SELECTED'; } ?>><?php echo _("Spanish"); ?></option>
                  </select></td>
                </tr>
                <tr>
                  <td align="right" valign="middle" class="text">&nbsp;</td>
                  <td align="right" valign="middle"><input name="Submit" type="submit" class="text" tabindex="4" value="<?php echo _("Login"); ?>" />
                  </td>
                </tr>
            </table>            </td>
            <td>&nbsp;</td>
            <td><img src="spacer.gif" width="1" height="118" border="0" alt=""></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
