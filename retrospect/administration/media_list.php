<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="5" cellpadding="0">
	<tr>
	  <td align="left" valign="top" colspan="5">&nbsp;</td>
  </tr>
	<tr>
    <td align="left" valign="top" colspan="5" class="content-subtitle"><?php echo _("Media List"); ?></td>
  </tr>
	<tr>
	  <td align="left" valign="top" colspan="5">&nbsp;</td>
  </tr>
	<tr>
	  <td width="100" align="left" valign="top" class="content-label"><a style="text-decoration: underline;" href="<?php echo $_SERVER['PHP_SELF'].'?option=media_list'; ?>"><?php echo _("Individual"); ?></a></td>
    <td width="150" align="left" valign="top" class="content-label"><a style="text-decoration: underline;" href="<?php echo $_SERVER['PHP_SELF'].'?option=media_list&orderby=filename'; ?>"><?php echo _("Filename"); ?></a></td>
    <td width="150" align="left" valign="top" class="content-label"><?php echo _("Caption"); ?></td>
	  <td align="left" valign="top" class="content-label"><?php echo _("Description"); ?></td>
		<td align="left" valign="top" class="content-label"><?php echo _("Thumbnail"); ?></td> 
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
		$result = db_query_r($sql);
		while ($row = mysql_fetch_array($result)) {
			echo '<tr>';
			echo '<td class="text"><a target="_blank" href="../index.php?option=family&indiv='.stripslashes($row['indfamkey']).'">'.stripslashes($row['indfamkey']).'</a></td>';
			echo '<td class="text">'.stripslashes($row['filename']).'</td>';
			echo '<td class="text">'.stripslashes($row['caption']).'</td>';
			echo '<td class="text">'.stripslashes($row['description']).'</td>';
			echo '<td class="text">ok</td>';
			echo '</tr>';
		}
	?>
</table>