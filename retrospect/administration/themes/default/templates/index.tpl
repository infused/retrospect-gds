<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$page_title}</title>
<link rel="stylesheet" href="{$THEME_URL}styles.css" />
{if $REDIRECT}
	<META HTTP-EQUIV="refresh" content="5;URL={$REDIRECT}">
{/if}
<meta name="copyright" content="{$copyright}" />
</head>
{if $module == "login"}
<body onload="self.focus();document.loginform.uid.focus()">
{elseif $module == "useradd"}
<body onload="self.focus();document.useraddform.username.focus()">
{else}
<body>
{/if}
<div id="header"><img src="{$THEME_URL}images/logo.gif" align="left" alt="Retrospect-GDS"/></div>
{if $module != "login"}
	<div id="adminmenu"></div>
	<div id="statusbar">Logged in as {$UID} | <a href="{$PHP_SELF}?auth=logout">Logout</a></div>
	{include file="menu.tpl"}
{/if}
<div id="content">{include file="$module.tpl"}</div>
<div id="footer">
	<a href="http://www.infused-solutions.com/retrospect/">Retrospect-GDS v{$RGDS_VERSION}</a> {$RGDS_COPYRIGHT}
</div>
</body>
</html>