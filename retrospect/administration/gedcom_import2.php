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
<table width="100%"  border="0" cellpadding="0" cellspacing="5"> 
  <tr> 
    <td align="left" valign="top" class="notification">
			<?php 
				if (isset($_POST['Import'])) {
					echo $_POST['selectedfile'];
				}
			?>
		</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Import Gedcom"); ?></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top"> <table width="100%"  border="0" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC"> 
        <tr> 
          <td valign="middle" class="content-label">Original Filename: <?php echo $_FILES['file']['name']; ?></td> 
        </tr>
        <tr>
          <td valign="middle" class="content-label">Temp Filename: <?php echo $_FILES['file']['tmp_name']; ?></td>
        </tr>
        <tr>
          <td valign="middle" class="content-label">Size: <?php echo $_FILES['file']['size'] ?></td>
        </tr> 
      </table></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr> 
	<tr>
	<td>
		<input name="Continue" type="submit" class="text" id="Continue" value="<?php echo _("Continue"); ?>"> 
	</td>
	</tr>
</table> 