<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$CHARSET}" />
<title>{$page_title}</title>
<link rel="stylesheet" href="{$THEME_URL}styles.css" />
<meta name="copyright" content="{$SITE_COPYRIGHT}" />
<meta name="description" content="{$page_title}" />
<meta name="keywords" content="{$meta_keywords}" />
</head>
<body>
<div id="header"><img src="{$THEME_URL}images/logo.gif" align="left" alt="Retrospect-GDS"/></div>
<div id="menu">{include file="menu.tpl"}</div>
<div id="content">{include file="$module.tpl"}</div>
<div id="footer">
	{if $SITE_COPYRIGHT != ""}{$SITE_COPYRIGHT}<br />{/if}
	Powered by 
	<a href="http://www.infused-solutions.com/retrospect/">Retrospect-GDS v{$RGDS_VERSION}</a> |
	<a href="{$BASE_URL}/administration/">Administration</a>
</div>
</body>
</html>