<?php
/**
 * Email Form
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @version			1.0
 * @license http://opensource.org/licenses/gpl-license.php
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
 */
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo _("E-mail this to a friend"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?php echo $g_site_root.'/themes/default/styles.css'; ?>" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
</head>
<body>
<?php if (!$_POST) { ?>
<form action="" method="post" name="form1" id="form1" onsubmit="MM_validateForm('emailto','','RisEmail','emailfrom','','RisEmail');return document.MM_returnValue">
<table width="100%" border="0" cellspacing="0" cellpadding="6">
  <tr class="text">
    <td colspan="2"><b><?php echo _("E-mail this to a friend"); ?></b></td>
    </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="text">
    <td width="150" nowrap="nowrap"><?php echo _("Your friend's e-mail"); ?>:</td>
    <td><input name="emailto" type="text" class="textbox" id="emailto" /></td>
  </tr>
  <tr class="text">
    <td nowrap="nowrap"><?php echo _("Your name"); ?>:</td>
    <td><input name="namefrom" type="text" class="textbox" id="namefrom" /></td>
  </tr>
  <tr class="text">
    <td nowrap="nowrap"><?php echo _("Your e-mail"); ?>:</td>
    <td><input name="emailfrom" type="text" class="textbox" id="emailfrom" /></td>
  </tr>
  <tr class="text">
    <td nowrap="nowrap">&nbsp;</td>
    <td><input name="<?php echo _("Send e-mail"); ?>" type="submit" class="text" id="Send2" value="<?php echo _("Send e-mail"); ?>" />
      <input name="<?php echo _("Cancel"); ?>" type="submit" class="text" id="Cancel" onclick="javascript: window.close();" value="<?php echo _("Cancel"); ?>" /></td>
  </tr>
</table>
</form>
<?php } else { 
	$emailto = $_POST['emailto'];
	$emailfrom = $_POST['emailfrom'];
	$namefrom = $_POST['namefrom'];
	$subject = 'Link from '.$namefrom;
	$message = $namefrom.' ('.$emailfrom.") has sent you the following link:\r\n"."http://".$_SERVER['SERVER_NAME'].'/index.php?'.$_SERVER['QUERY_STRING'];
	mail($emailto, $subject, $message, "From: ".$emailfrom);
?>
 <table width="100%" border="0" cellspacing="0" cellpadding="6">
  <tr class="text">
    <td colspan="2"><b><?php echo _("Your message has been sent. "); ?></b></td>
    </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="text">
    <td>&nbsp;</td>
    <td><input name="<?php echo _("Close"); ?>" type="submit" class="text" id="Cancel" onclick="javascript: window.close();" value="<?php echo _("Close"); ?>" /></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
