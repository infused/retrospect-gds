<form name="useraddform" action="{$PHP_SELF}?m=useradd" method="post">
<div class="content-title">User Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab"><a href="{$PHP_SELF}?m=usermgr">List Users</a></td>
		<td class="tab-selected">Add User</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="username">Username:</label></td>
			<td class="cfg-opt"><input name="username" class="textbox" id="username" maxlength="16" value="{$smarty.post.username}" /></td>
			<td class="cfg-err">{foreach from=$username_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="fullname">Full Name:</label></td>
			<td class="cfg-opt"><input name="fullname" class="textbox" id="fullname" size="40" maxlength="100" /></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="group">Group:</label></td>
			<td class="cfg-opt">
				<select name="group" class="list" id="group">
					{html_options options=$groups}
				</select>
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="email">Email:</label></td>
			<td class="cfg-opt"><input name="email" class="textbox" id="email" maxlength="100" /></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="npassword">New Password:</label></td>
			<td class="cfg-opt"><input name="npassword" type="password" class="textbox" id="npassword" maxlength="16" /></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="vpassword">Verify Password:</label></td>
			<td class="cfg-opt"><input name="vpassword" type="password" class="textbox" id="vpassword" maxlength="16" /></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
	</table>
</div>
<br />
	<input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Cancel" type="button" class="text" value="Cancel" onclick="document.location='{$PHP_SELF}?m=usermgr';">
</form>