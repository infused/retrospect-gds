<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$page_title}</title>
<link rel="stylesheet" href="themes/default/styles.css" />
<meta name="copyright" content="{$copyright}" />
<meta name="description" content="{$page_title}" />
<meta name="keywords" content="{$meta_keywords}" />
{literal}
<script language="JavaScript" type="text/JavaScript">
<!--

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
{/literal}
</head>
<div id="header"><img src="themes/default/images/logo.gif" align="left" alt="Retrospect-GDS"/></div>
<div id="menu">{include file="menu.tpl"}</div>
<div id="content">
	<div id="utils">
		{if $CURRENT_PAGE == $PHP_SELF}
			<a href="{$CURRENT_PAGE}?print=y" target="_blank"><img src="themes/default/images/printbutton.gif" border="0" alt="{php}t("Print"){/php}" /></a>
		{else}
			<a href="{$CURRENT_PAGE}&print=y" target="_blank"><img src="themes/default/images/printbutton.gif" border="0" alt="{php}t("Print"){/php}" /></a>
		{/if}
	</div>
	{include file="$module.tpl"}
</div>
<div id="footer">
	<a href="http://www.infused-solutions.com/retrospect/">Retrospect-GDS v{$RGDS_VERSION}</a> {$RGDS_COPYRIGHT}
</div>
<body>
</body>
</html>