<?php
/**
 * Admin - Database Optimization Module
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
<?php 
function optimize_table($p_table) {
	global $db;
	$sql = "OPTIMIZE TABLE $p_table";
	if ($rs = $db->Execute($sql)) {
		$row = $rs->FetchRow();
		return $row['Msg_text'];
	}
	else {
		return false;
	}
}
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="content-subtitle"><?php echo _("Optimize Tables"); ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="150" class="content-label">Table</td>
    <td class="content-label">Status</td>
  </tr>
  <?php 
		$tables = array($g_tbl_indiv, $g_tbl_fact, $g_tbl_family, $g_tbl_relation, $g_tbl_citation, $g_tbl_source, $g_tbl_note, $g_tbl_child, $g_tbl_user, $g_tbl_lang, $g_tbl_option, $g_tbl_media);
		foreach($tables as $table) {
			$result = optimize_table($table);
			?>
			<tr>
    	<td class="text"><?php echo $table; ?></td>
	    <td class="text"><?php echo $result; ?></td>
  		</tr>
	<?php } ?>
</table>
<?php 
	redirect_j($_SERVER['PHP_SELF'], 3);
?>
