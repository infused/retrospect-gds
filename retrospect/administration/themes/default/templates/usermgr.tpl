<div class="content-title">User Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">List Users</td>
		<td class="tab"><a href="{$PHP_SELF}?m=useradd">Add User</a></td>
		<td class="tab"><a href="{$PHP_SELF}?m=useredit">Edit User</a></td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="list_header" width="200">Full Name</td>
			<td class="list_header" width="100">Username</td>
			<td class="list_header" width="100">Group</td>
			<td class="list_header" width="200">Email</td>
			<td class="list_header" width="200">Last Visit</td>
			<td align="center" class="list_header" width="100">Enabled</td>
		</tr>
		{foreach from=$users item="user"}
		<tr>
			<td class="list_item"><a href="{$PHP_SELF}?m=useredit&id={$user.id}">{$user.fullname}</a></td>
			<td class="list_item">{$user.uid}</td>
			<td class="list_item">{$user.group}</td>
			<td class="list_item"><a class="decor" href="mailto:{$user.email}">{$user.email}</a></td>
			<td class="list_item">{$user.last}</td>
			<td align="center" class="list_item">
			<a href="{$PHP_SELF}?m=usermgr&t=toggle&id={$user.id}">
				{if $user.enabled == "1"}
					<img src="{$THEME_URL}images/tick.png" alt="Enabled" border="0" />
				{else}
					<img src="{$THEME_URL}images/redx.png" alt="Disabled" border="0" />
				{/if}
			</a>
			</td>
		</tr>
		{/foreach}
	</table>
</div>