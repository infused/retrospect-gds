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
        <td class="section_head">System Alerts</td>
      </tr>
      <tr>
        <td class="section_body">
				<?php 
					/* Password Expired! */
					if (auth::PasswordExpired($_SESSION['uid'])) { 
						echo '<p>';
						$here = '<a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$_SESSION['uid'].'">here</a>';
						printf('The admin password has expired.  Go %s to change it immediately!', $here);
						echo '</p>';
					} 
					
					/* Install directory exists! */
					if (file_exists(ROOT_PATH.'/../install')) {
						echo '<p>The install directory should be deleted immediately.</p>';
					}
				?>
				</td>
      </tr>
    </table>
    </td>
    <td width="300" align="right">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Database Statistics</td>
        </tr>
        <tr>
          <td class="section_body">
						<table width="300"  border="0" cellpadding="2" cellspacing="0">
							<?php
								/* Print table record counts */
								$tables = $db->MetaTables('TABLES');
								$row = 1;
								foreach ($tables as $table) {
									$row++;
									$sql = 'SELECT COUNT(*) FROM '.$table;
									$count = $db->GetOne($sql);
									if ($row % 2 == 0) { echo '<tr bgcolor="#CCCCCC">'; }
									else { echo '<tr>'; }
									echo '<td>'.$table.'</td>';
									echo '<td>'.$count.'</td>';
									echo '</tr>';
								}
							?>
	          </table>
					</td>
        </tr>
      </table>
		</td>
  </tr>
</table>
