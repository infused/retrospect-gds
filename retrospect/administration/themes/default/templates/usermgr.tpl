{if $DELETED}
	<div class="content-title">User Manager</div>
	<p>{$DELETED|@count} {if $DELETED|@count == 1}user has{else}users have{/if} been deleted from the user database.</p>
	<p>Click <a href="{$PHP_SELF}?m=usermgr">HERE</a> to return to the User Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $ENABLED}
	<div class="content-title">User Manager</div>
	<p>{$ENABLED|@count} {if $ENABLED|@count == 1}user has{else}users have{/if} been enabled.</p>
	<p>Click <a href="{$PHP_SELF}?m=usermgr">HERE</a> to return to the User Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $DISABLED}	
	<div class="content-title">User Manager</div>
	<p>{$DISABLED|@count} {if $DISABLED|@count == 1}user has{else}users have{/if} been enabled.</p>
	<p>Click <a href="{$PHP_SELF}?m=usermgr">HERE</a> to return to the User Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{else}
<form action="{$PHP_SELF}?m=usermgr" method="post">
<div class="content-title">User Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">User List</td>
		<td class="tab"><a href="{$PHP_SELF}?m=useradd">Add User</a></td>
		<td class="tab"><a href="{$PHP_SELF}?m=useredit">Edit User</a></td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="list_header" width="25">&nbsp;</td>
			<td class="list_header" width="200">Full Name</td>
			<td class="list_header" width="100">Username</td>
			<td class="list_header" width="150">Group</td>
			<td class="list_header" width="200">Email</td>
			<td class="list_header" width="150">Last Login</td>
			<td align="center" class="list_header" width="100">Enabled</td>
		</tr>
		{foreach from=$users item="user"}
		<tr>
			<td class="list_item">
				<input name="selectitem[]" type="checkbox" class="checkbox" value="{$user.id}">
			</td>
			<td class="list_item" nowrap="nowrap"><a href="{$PHP_SELF}?m=useredit&id={$user.id}">{$user.fullname}</a></td>
			<td class="list_item" nowrap="nowrap">{$user.uid}</td>
			<td class="list_item" nowrap="nowrap">{$user.groupname}</td>
			<td class="list_item" nowrap="nowrap"><a class="decor" href="mailto:{$user.email}">{$user.email}</a></td>
			<td class="list_item" nowrap="nowrap">{if $user.last == null}Never{else}{$user.last}{/if}</td>
			<td align="center" class="list_item" nowrap="nowrap">
				{if $user.enabled == "1"}
					<img src="{$THEME_URL}images/ledgreen.png" alt="Enabled" border="0" />
				{else}
					<img src="{$THEME_URL}images/ledred.png" alt="Disabled" border="0" />
				{/if}
			</td>
		</tr>
		{/foreach}
	</table>
</div>
<table cellpadding="5" cellspacing="0">
	<tr>
		<td valign="middle">
			<select name="task" class="listbox">
				{html_options options=$tasks}
			</select>
		</td>
		<td valign="middle">
			<input type="submit" name="Submit" class="button" value="Go">
		</td>
	</tr>
</table>
</form>
{/if}