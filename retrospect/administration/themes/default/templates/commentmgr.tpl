{if $DELETED}
	<div class="content-title">Comment Manager</div>
	<p>{$DELETED|@count} {if $DELETED|@count == 1}comment has{else}comments have{/if} been deleted from the database.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $VISIBLE}
	<div class="content-title">Comment Manager</div>
	<p>{$VISIBLE|@count} {if $VISIBLE|@count == 1}comment has{else}comments have{/if} been made visible.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $HIDDEN}
	<div class="content-title">Comment Manager</div>
	<p>{$HIDDEN|@count} {if $HIDDEN|@count == 1}comment has{else}comments have{/if} been hidden.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{else}
<form action="{$CURRENT_PAGE}" method="post">
<div class="content-title">Comment Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		{if $task == "pending"}
		<td class="tab-selected">Pending ({$pending_count})</td>
		<td class="tab"><a href="{$PHP_SELF}?m=commentmgr&t=r">Reviewed ({$reviewed_count})</a></td>
		{else}
		<td class="tab"><a href="{$PHP_SELF}?m=commentmgr">Pending ({$pending_count})</a></td>
		<td class="tab-selected">Reviewed ({$reviewed_count})</td>
		{/if}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="list_header" width="25">&nbsp;</td>
			<td class="list_header" width="50">ID</td>
			<td class="list_header" width="150">Received</td>
			<td class="list_header" width="250">Email</td>
			<td class="list_header">Comment</td>
			{if $task != "pending"}<td align="center" class="list_header">Visible</td>{/if}
		</tr>
		{foreach from=$comments item="comment"}
		<tr>
			<td class="list_item">
				<input name="selectitem[]" type="checkbox" class="checkbox" value="{$comment.id}">
			</td>
			<td class="list_item">{$comment.indkey}</td>
			<td class="list_item">{$comment.received|date_format:"%b %e, %Y %H:%M"}</td>
			<td class="list_item">{$comment.email}</td>
			<td class="list_item">{$comment.comment|nl2br}</td>
			{if $task != "pending"}
			<td align="center" class="list_item">
				{if $comment.visible == "1"}
					<img src="{$THEME_URL}images/ledgreen.png" alt="Enabled" border="0" />
				{else}
					<img src="{$THEME_URL}images/ledred.png" alt="Disabled" border="0" />
				{/if}
			</td>
			{/if}
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