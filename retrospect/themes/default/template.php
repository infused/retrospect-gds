<?php
/**
 * Main template
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @license http://opensource.org/licenses/gpl-license.php
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details. *
 */
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $g_title; unset($g_title); ?></title>
<link rel="stylesheet" href="themes/default/styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_setTextOfTextfield(objName,x,newText) { //v3.0
  var obj = MM_findObj(objName); if (obj) obj.value = newText;
}
//-->
</script>
</head>
<body>
<div id="header"><img src="themes/default/images/logo.png" align="left" /></div>
<div id="content">
	<div id="utils">
		<a href="#" onclick="MM_openBrWindow('<?php echo CURRENT_PAGE.'&print=y'; ?>','','scrollbars=yes,resizable=yes,width=640,height=480')"><img src="themes/default/images/printbutton.gif" border="0" alt="<?php echo _("Print"); ?>" /></a>
		<a href="#" onclick="MM_openBrWindow('<?php echo Theme::getPage($g_theme, 'email').'?'.$_SERVER['QUERY_STRING']; ?> ','','scrollbars=yes,resizable=yes,width=400,height=225')"><img src="themes/default/images/emailbutton.gif" border="0" alt="<?php echo _("E-mail this to a friend"); ?>" /></a>
	</div>
	<?php echo $g_content; unset($g_content); ?>
</div>
<div id="navAlpha">
<?php 
	if (isset($g_menu)) {
		echo $g_menu; 
		unset($g_menu); 
	}
	if (isset($g_custom_menu)) {
		echo $g_custom_menu; 
		unset($g_custom_menu); 
	}
?>
</div>
<div id="footer">
	<a href="http://www.infused-solutions.com/retrospect" target="_blank">Retrospect-GDS</a> &copy; 2003 Keith Morrison, Infused Solutions<br />
 	<?php 
		$end = time_get_micro();
		$time = $end - $start;
		echo 'Processing time: '.$time.' sec(s)<br />';
		// memory_get_usage only available in PHP > 4.3.2
		// works on unix-like systems only
		if (function_exists('memory_get_usage')) {
			echo 'Memory Usage: '.number_format(memory_get_usage()).' bytes';
		}
	?>  
<br />&nbsp;</div>
</body>
</html>