<div class="content-title">User Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">List Users</td>
		<td class="tab"><a href="{$PHP_SELF}?m=useradd">Add User</a></td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="list_header" width="100">Username</td>
			<td class="list_header" width="200">Full Name</td>
			<td class="list_header" width="100">Group</td>
			<td class="list_header" width="200">Email</td>
			<td class="list_header" width="200">Last Visit</td>
			<td class="list_header" width="100">Enabled</td>
		</tr>
		{foreach from=$users item="user"}
		<tr>
			<td>{$user.uid}</td>
			<td>{$user.fullname}</td>
			<td>{$user.group}</td>
			<td><a href="mailto:{$user.email}">{$user.email}</a></td>
			<td>{$user.last}</td>
			<td>{$user.disabled}</td>
			
		</tr>
		{/foreach}
	</table>
</div>