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
<title>Retrospect-GDS Admin Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">

		function setFocus() {
			document.loginform.uid.select();
			document.loginform.uid.focus();
		}

</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-size: 18pt;
	font-weight: bold;
}
.style2 {
	color: #FFFFFF;
	font-size: 12pt;
}
-->
</style>
</head>
<body onload="setFocus();">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
      <form name="loginform" id="loginform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table width="450" border="1" cellpadding="0" cellspacing="0" bordercolor="#0066CC">
          <tr>
            <td height="29" align="center" valign="bottom" nowrap="nowrap" background="images/logo.gif" bgcolor="#0066CC"><span class="style1">Retrospect-GDS</span><br />            </td>
            <td rowspan="2" align="right" valign="bottom" background="images/logo.gif" bgcolor="#0066CC" class="vertext">(v<?php echo RGDS_VERSION; ?>)&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="center" valign="bottom" nowrap="nowrap" background="images/logo.gif" bgcolor="#0066CC"><span class="style2">Administration</span></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="middle">						<table width="100%"  border="0" cellspacing="0" cellpadding="20">
              <tr>
                <td align="center" valign="middle"><table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td align="right" valign="middle" class="text">Username:</td>
                    <td>
                      <input name="uid" type="text" class="textbox" tabindex="1" />
                    </td>
                    </tr>
                  <tr>
                    <td align="right" valign="middle" class="text">Password:</td>
                    <td><input name="pwd" type="password" class="textbox" id="password" tabindex="2" />
                    </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" class="text">&nbsp;</td>
                    <td><input name="Submit" type="submit" class="text" tabindex="4" value="Login" /></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
      </form>
			<br/>
			 <?php echo htmlentities(RGDS_COPYRIGHT); ?>
    </td>
  </tr>
</table>
</body>
</html>
