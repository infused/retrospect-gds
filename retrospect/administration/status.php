<?php
/**
 * Admin - User List Module
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
<?
	# gather table statistcs
	
	# individuals
	$sql = "SELECT COUNT(*) FROM $g_tbl_indiv";
	$cnt_indiv = $db->GetOne($sql);
?>


<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="content-subtitle">System Status </td>
    <td class="content-subtitle">Database Status</td>
  </tr>
  <tr>
    <td><?php 
							if (auth::PasswordExpired($_SESSION['uid'])) { 
								$here = '<a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$_SESSION['uid'].'">here</a>';
								printf(_("You password has expired.  Go %s to change it immediately!"), $here);
							} 
						?>
    </td>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#CCCCCC">
        <td>Table</td>
        <td>Records</td>
        <td>Something</td>
      </tr>
      <tr>
        <td><?php echo $g_tbl_child; ?></td>
        <td>
					<?php 
						$sql = "SELECT COUNT(*) FROM $g_tbl_child";
						echo $db->GetOne($sql);
				 	?>
				</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $g_tbl_citation; ?></td>
        <td>
					<?php 
						$sql = "SELECT COUNT(*) FROM $g_tbl_citation";
						echo $db->GetOne($sql);
				 	?>
				</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $g_tbl_comment; ?></td>
        <td>
					<?php 
						$sql = "SELECT COUNT(*) FROM $g_tbl_comment";
						echo $db->GetOne($sql);
				 	?>
				</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $g_tbl_fact; ?></td>
        <td>
					<?php 
						$sql = "SELECT COUNT(*) FROM $g_tbl_fact";
						echo $db->GetOne($sql);
				 	?>
				</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><?php echo $g_tbl_family; ?></td>
        <td>
					<?php 
						$sql = "SELECT COUNT(*) FROM $g_tbl_family";
						echo $db->GetOne($sql);
					?>
					</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>      
     </td>
  </tr>
</table>
