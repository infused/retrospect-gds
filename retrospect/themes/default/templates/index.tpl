<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$page_title}</title>
<link rel="stylesheet" href="themes/default/styles.css" />
<meta name="copyright" content="{$copyright}" />
<meta name="description" content="{$page_title}" />
<meta name="keywords" content="{$meta_keywords}" />
</head>
<div id="header"><img src="themes/default/images/logo.gif" align="left" alt="Retrospect-GDS"/></div>
<div id="menu">{$g_menu}</div>
<div id="content">
	<div id="utils">
		<a href="{$CURRENT_PAGE}&print=y" target="_blank"><img src="themes/default/images/printbutton.gif" border="0" alt="{translate s="Print"}" /></a>
	</div>
	{include file="$option.tpl"}
</div>
<div id="footer">
	<a href="http://www.infused-solutions.com/retrospect/">Retrospect-GDS v{$RGDS_VERSION}</a> {$RGDS_COPYRIGHT}
</div>
<body>
</body>
</html>