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
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left" valign="top">
		<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">System Alerts </td>
      </tr>
      <tr>
        <td class="section_body">
				<?php 
					if (auth::PasswordExpired($_SESSION['uid'])) { 
						echo '<p>';
						$here = '<a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$_SESSION['uid'].'">here</a>';
						printf('The admin password has expired.  Go %s to change it immediately!', $here);
						echo '</p>';
					} 
					if (file_exists(ROOT_PATH.'/../install')) {
						echo '<p>The install directory should be deleted immediately.</p>';
					}
				?>
				</td>
      </tr>
    </table>
    </td>
    <td width="300" align="right"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Database Records </td>
        </tr>
        <tr>
          <td class="section_body"><table width="300"  border="0" cellpadding="2" cellspacing="0">
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_CHILD; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_CHILD;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_CITATION; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_CITATION;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_COMMENT; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_COMMENT;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_FACT; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_FACT;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_FAMILY; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_FAMILY;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_INDIV; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_INDIV;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_LANG; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_LANG;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_MEDIA; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_MEDIA;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_NOTE; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_NOTE;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_OPTION; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_OPTION;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
            <tr bgcolor="#CCCCCC">
              <td><?php echo TBL_SOURCE; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_SOURCE;
										echo $db->GetOne($sql);
				 					?>
              </td>
            </tr>
            <tr>
              <td><?php echo TBL_USER; ?></td>
              <td><?php 
										$sql = "SELECT COUNT(*) FROM ".TBL_USER;
										echo $db->GetOne($sql);
									?>
              </td>
            </tr>
          </table></td>
        </tr>
      </table>       </td>
  </tr>
</table>
