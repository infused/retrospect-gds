<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$page_title}</title>
<link rel="stylesheet" href="{$THEME_URL}styles.css" />
<meta name="copyright" content="{$copyright}" />
<meta name="description" content="{$page_title}" />
<meta name="keywords" content="{$meta_keywords}" />
</head>
<div id="content_printable">
	<div id="utils">
		<a href="#" onclick="window.print(); return false;"><img src="{$THEME_URL}images/printbutton.gif" border="0" alt="{translate s="Print"}" /></a>
	</div>
	{include file = "$module.tpl"}
</div>
<div id="footer">
	<a href="http://www.infused-solutions.com/retrospect/">Retrospect-GDS v{$RGDS_VERSION}</a> {$RGDS_COPYRIGHT}
</div>
<body>
</body>
</html>