<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo _("phpGene Pro Administration"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="50"><table border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><img src="images/logo.png" width="400" height="49" /></td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td height="20"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
          <td class="text"><div id="myMenuID"></div></td>
          <td>&nbsp;</td>
          <td align="right" class="text"><?php echo sprintf(_("Logged in as %s"), $_SESSION['uid']);?> :: <a href="<?php echo $_SERVER['PHP_SELF'].'?auth=logout'; ?>"><?php echo _("Logout"); ?></a><img src="images/spacer.gif" width="5" height="1" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
		<?php 
			if (isset($_GET['option']) and file_exists($_GET['option'].'.php')) {
				include($_GET['option'].'.php');
			}
		?>
		</td>
  </tr>
  <tr>
    <td height="20" align="center">&nbsp;</td>
  </tr>
</table>
<?php include('menubar.php'); ?>
</body>
</html>