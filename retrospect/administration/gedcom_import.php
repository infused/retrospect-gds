<?php
/**
 * Admin - System Configuration Module
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
<link href="styles.css" rel="stylesheet" type="text/css">
<form action="<?php echo CURRENT_PAGE.'2'; ?>" method="post" enctype="multipart/form-data" name="gedcom_import_form" id="gedcom_import_form">
<table width="100%"  border="0" cellpadding="0" cellspacing="5"> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr>
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Import Gedcom"); ?></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top"> <table width="100%"  border="0" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC"> 
        <tr>
          <td colspan="2" valign="middle" class="content-label">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" valign="middle" class="content-label">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="2" valign="middle" class="content-label">Upload Max File Size: <?php echo ini_get('upload_max_filesize'); ?></td>
        </tr>
        <tr> 
          <td width="125" valign="middle" class="content-label"><?php echo _("Gedcom File"); ?>:</td> 
          <td valign="middle"><input name="file" type="file" class="textbox"></td> 
          </tr> 
      </table></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr> 
	<tr>
	<td>
		<input name="Import" type="submit" class="text" id="Import" value="<?php echo _("Import"); ?>"> 
		<input name="<?php echo _("Reset"); ?>" type="reset" class="text" id="<?php echo _("Reset"); ?>" value="<?php echo _("Reset"); ?>"></td>
	</tr>
</table> 
</form>
