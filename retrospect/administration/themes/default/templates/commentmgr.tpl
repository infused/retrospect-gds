<h1>Comment Manager</h1>
{if $DELETED}
	<p>{$DELETED|@count} {if $DELETED|@count == 1}comment has{else}comments have{/if} been deleted from the database.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $VISIBLE}
	<p>{$VISIBLE|@count} {if $VISIBLE|@count == 1}comment has{else}comments have{/if} been made visible.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{elseif $HIDDEN}
	<p>{$HIDDEN|@count} {if $HIDDEN|@count == 1}comment has{else}comments have{/if} been hidden.</p>
	<p>Click <a href="{$CURRENT_PAGE}">HERE</a> to return to the Comment Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main Administration page.</p>
{else}
<div id="tabs">
  <ul>
    {if $task == "pending"}
      <li id="selected"><a>Pending ({$pending_count})</a></li>
      <li><a href="{$PHP_SELF}?m=commentmgr&t=r">Reviewed ({$reviewed_count})</a></li>
    {else}
      <li><a href="{$PHP_SELF}?m=commentmgr">Pending ({$pending_count})</a></li>
      <li id="selected"><a>Reviewed ({$reviewed_count})</a></li>
    {/if}
  </ul>
</div>
<div class="tab-page">
<form action="{$CURRENT_PAGE}" method="post">
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
			
			
			<td class="list_item"><a href="{$BASE_URL}/../?m=family&amp;id={$comment.indkey}" target="_blank">{$comment.indkey}</a></td>
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

<table cellpadding="5" cellspacing="0" style="margin-top: 20px;">
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
</div>
{/if}