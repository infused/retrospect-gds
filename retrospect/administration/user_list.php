<link href="styles.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" cellspacing="5" cellpadding="0">
	<tr>
	  <td align="left" valign="top" colspan="4">&nbsp;</td>
  </tr>
	<tr>
    <td align="left" valign="top" colspan="4" class="content-subtitle"><?php echo _("User List"); ?></td>
  </tr>
	<tr>
	  <td align="left" valign="top" colspan="4">&nbsp;</td>
  </tr>
	<tr>
	  <td align="left" valign="top" class="content-label"><?php echo _("Username"); ?></td>
    <td align="left" valign="top" class="content-label"><?php echo _("Full Name"); ?></td>
    <td align="left" valign="top" class="content-label"><?php echo _("Email"); ?></td>
	  <td align="left" valign="top" class="content-label"><?php echo _("Last Login"); ?></td>
	</tr>
	<?php
		$sql = "SELECT * FROM $g_tbl_user";
		$result = db_query_r($sql);
		while ($row = mysql_fetch_array($result)) {
			$uid = stripslashes($row['uid']);
			$fullname = stripslashes($row['fullname']);
			$email = stripslashes($row['email']);
			echo '<tr>';
			echo '<td class="text" width="200"><a href="'.$_SERVER['PHP_SELF'].'?option=user_edit&id='.$row['id'].'">'.$uid.'</a></td>';
			echo '<td class="text" width="200">'.$fullname.'</td>';
			echo '<td class="text">'.$email.'</td>';
			$last = ($row['last'] == '0000-00-00 00:00:00') ? _("Never") : $row['last'];
			echo '<td class="text">'.$last.'</td>';
			echo '</tr>';
		}
	?>
</table>
