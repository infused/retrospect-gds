<h1>User Manager</h1>
{if $SAVED}
	<p><i>{if $SAVED.fullname}{$SAVED.fullname}{else}{$SAVED.username}{/if}</i> has been added to the user database.</p>
	<p>Click <a href="{$PHP_SELF}?m=usermgr">HERE</a> to return to the User Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main administration page.</p>
{else}
<div id="tabs">
	<ul>
		<li><a href="{$PHP_SELF}?m=usermgr">List Users</a></li>
		<li id="selected"><a>Add User</a></li>
		<li><a href="{$PHP_SELF}?m=useredit">Edit User</a></li>
	</ul>
</div>
<div class="tab-page">
<form name="useraddform" action="{$PHP_SELF}?m=useradd" method="post">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="username">Username:</label></td>
			<td class="cfg-opt"><input name="username" class="textbox" maxlength="16" value="{$smarty.post.username}" /></td>
			<td class="cfg-err">{foreach from=$username_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="fullname">Full Name:</label></td>
			<td class="cfg-opt"><input name="fullname" class="textbox" size="40" maxlength="100" value="{$smarty.post.fullname}" /></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		<!--
		<tr>
			<td class="cfg-lbl"><label for="group">Group:</label></td>
			<td class="cfg-opt">
				<select name="group" class="listbox">
					{html_options options=$groups}
				</select>
			</td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		-->
		<tr>
			<td class="cfg-lbl"><label for="email">Email:</label></td>
			<td class="cfg-opt"><input name="email" class="textbox" maxlength="100" value="{$smarty.post.email}" /></td>
			<td class="cfg-err">{foreach from=$email_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="password1">New Password:</label></td>
			<td class="cfg-opt"><input name="password1" type="password" class="textbox" maxlength="16" value="{$smarty.post.password1}" /></td>
			<td class="cfg-err">{foreach from=$password_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="password2">Verify Password:</label></td>
			<td class="cfg-opt"><input name="password2" type="password" class="textbox" maxlength="16" value="{$smarty.post.password2}" /></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="enabled">Account Enabled:</label></td>
			<td class="cfg-opt"><input class="checkbox" name="enabled" type="checkbox" value="1" checked></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
	</table>

<br />
	<input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Cancel" type="button" class="text" value="Cancel" onclick="document.location='{$PHP_SELF}?m=usermgr';">
</form>
</div>
{/if}