<?php
/**
 * Admin - Gedcom Import Module - Step 2
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
				# Load the gedcom classes
				require_once(CORE_PATH.'gedcom.class.php');
				
				# Set some variables
				$gedcomdir = ROOT_PATH . '/../gedcom/';
	
				# Check if gedcom directory is writable
				if (!is_writable($gedcomdir)) { 
					echo _("The gedcom directory is not writable. Check your server configuration.");
				}
				
				$gedcomfile = $gedcomdir.$_POST['selectedfile'];
				$gedcom = new GedcomParser();
				$gedcom->Open($gedcomfile);
			?>
			&nbsp;
		</td> 
  </tr> 
  <tr> 
    <td align="left" valign="top" class="content-subtitle"><?php echo _("Import Gedcom"); ?></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top"> <table width="100%"  border="0" cellpadding="2" cellspacing="0" bgcolor="#CCCCCC"> 
        <tr>
          <td valign="middle" class="content-label">Emptying tables... </td>
        </tr>
        <tr>
          <td valign="middle" class="text">Individual table... 
						<?php
							$sql = 'delete from '.$g_tbl_indiv;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Family table... 
						<?php
							$sql = 'delete from '.$g_tbl_family;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Child table... 
						<?php 
							$sql = 'delete from '.$g_tbl_child;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Fact table... 
						<?php 
							$sql = 'delete from '.$g_tbl_fact;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Note table... 
						<?php 
							$sql = 'delete from '.$g_tbl_note;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Source table... 
						<?php 
							$sql = 'delete from '.$g_tbl_citation;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Citation table... 
						<?php 
							$sql = 'delete from '.$g_tbl_source;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">&nbsp;</td>
        </tr>
        <tr>
          <td valign="middle" class="content-label">Processing gedcom...</td>
        </tr>
        <tr>
          <td valign="middle" class="text">
						<?php
							$gedcom->ParseGedcom();
						?>
						&nbsp;
					</td>
        </tr>
        <tr>
          <td valign="middle" class="text">Processing complete. </td>
        </tr> 
      </table></td> 
  </tr> 
  <tr> 
    <td align="left" valign="top">&nbsp;</td> 
  </tr> 
	<tr>
	<td>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input name="Continue" type="submit" class="text" id="Continue" value="<?php echo _("Continue"); ?>"> 
		</form>
	</td>
	</tr>
</table> 