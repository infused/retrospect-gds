<?php 
function optimize_table($p_table) {
	$sql = "OPTIMIZE TABLE $p_table";
	if ($result = db_query_r($sql)) {
		$row = mysql_fetch_array($result);
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
