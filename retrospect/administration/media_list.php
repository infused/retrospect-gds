<?php
/**
 * Admin - Media List Module
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
<table width="100%"  border="0" cellspacing="5" cellpadding="0">
	<tr>
	  <td colspan="4" align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">Media Manager &nbsp;</td>
      </tr>
      <tr>
        <td class="section_body"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150" align="left" valign="top" class="content-label"><a style="text-decoration: underline;" href="<?php echo $_SERVER['PHP_SELF'].'?option=media_list&orderby=filename'; ?>">Filename</a></td>
            <td width="150" align="left" valign="top" class="content-label">Caption</td>
            <td align="left" valign="top" class="content-label">Description</td>
            <td align="left" valign="top" class="content-label">Thumbnail</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
	<?php
		$sql = "SELECT * FROM $g_tbl_media ";
		if (isset($_GET['orderby'])) {
			$orderby = $_GET['orderby'];
			if ($orderby == 'filename') { 
				$sql .= "ORDER BY filename";
			}
			else {
				$sql .= "ORDER BY indfamkey";
			}
		}
		$rs = $db->Execute($sql);
		while ($row = $rs->FetchRow()) {
			echo '<tr>';
			echo '<td class="text">'.$row['filename'].'</td>';
			echo '<td class="text">'.$row['caption'].'</td>';
			echo '<td class="text">'.$row['description'].'</td>';
			echo '<td class="text">ok</td>';
			echo '</tr>';
		}
	?>
</table>
