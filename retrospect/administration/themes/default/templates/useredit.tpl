{if $SAVED}
	<div class="content-title">User Manager</div>
	<p><i>{if $SAVED.fullname}{$SAVED.fullname}{else}{$SAVED.username}{/if}</i> has been changed.</p>
	<p>Click <a href="{$PHP_SELF}?m=usermgr">HERE</a> to return to the User Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main administration page.</p>
{else}
<form name="useraddform" action="{$PHP_SELF}?m=useredit" method="post">
<div class="content-title">User Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab"><a href="{$PHP_SELF}?m=usermgr">List Users</a></td>
		<td class="tab"><a href="{$PHP_SELF}?m=useradd">Add User</a></td>
		<td class="tab-selected">Edit User</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
{if $users}
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td width="200" valign="middle"><label for="id">Select a user to edit:</label></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="middle">
				<select name="id" class="listbox">
					{html_options options=$users}
				</select>
			</td>
			<td valign="middle">
				<input name="selectuser" type="submit" class="text" value="Go"> 
			</td>
		</tr>
	</table>
{else}
	<div style="position: relative; top: 0px; right: 20px; float: right;">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="100">Created:</td>
				<td>{$user.created}</td>
			</tr>
			<tr>
				<td>Last Login:</td>
				<td>{if $user.last == null}Never{else}{$user.last}{/if}</td>
			</tr>
		</table>
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="username">Username:</label></td>
			<td class="cfg-opt"><input name="username" class="textbox" maxlength="16" value="{$user.uid}" /></td>
			<td class="cfg-err">{foreach from=$username_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="fullname">Full Name:</label></td>
			<td class="cfg-opt"><input name="fullname" class="textbox" size="40" maxlength="100" value="{$user.fullname}" /></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		<!-- No group support for now
		<tr>
			<td class="cfg-lbl"><label for="group">Group:</label></td>
			<td class="cfg-opt">
				<select name="group" class="listbox">
					{html_options options=$groups selected=$user.group}
				</select>
			</td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		-->
		<tr>
			<td class="cfg-lbl"><label for="email">Email:</label></td>
			<td class="cfg-opt"><input name="email" class="textbox" maxlength="100" value="{$user.email}" /></td>
			<td class="cfg-err">{foreach from=$email_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="password1">New Password:</label></td>
			<td class="cfg-opt"><input name="password1" type="password" class="textbox" maxlength="16" value="" /></td>
			<td class="cfg-err">{foreach from=$password_errors item="error"}{$error}<br />{/foreach}</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="password2">Verify Password:</label></td>
			<td class="cfg-opt"><input name="password2" type="password" class="textbox" maxlength="16" value="" /></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="enabled">Account Enabled:</label></td>
			<td class="cfg-opt"><input class="checkbox" name="enabled" type="checkbox" value="1" {if $user.enabled}checked{/if}></td>
			<td class="cfg-err">&nbsp;</td>
		</tr>
	</table>
{/if}
</div>
<br />
{if !$users}
	<input name="id" type="hidden" value="{$user.id}">
	<input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Cancel" type="button" class="text" value="Cancel" onclick="document.location='{$PHP_SELF}?m=usermgr';">
{/if}
</form>
{/if}