<?php 
/**
 * Print Template
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @version			1.0
 *
 */
?>
<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $g_title; unset($g_title); ?></title>
<link rel="stylesheet" href="themes/default/styles.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<div style="margin: 10px;">
	<div style="position: relative; top: 0px; right: 0px; float: right;">
		<a href="#" onclick="window.print(); return false;"><img src="themes/default/images/printbutton.gif" border="0" alt="<?php echo _("Print"); ?>" /></a>
	</div>
	<?php echo $g_content; unset($g_content); ?>
</div>
</body>
</html>
