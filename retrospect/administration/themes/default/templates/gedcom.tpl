<form action="{$PHP_SELF}?m=gedcom" method="post">
<div class="content-title">Gedcom Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">Gedcom List</td>
		<td class="tab"><a href="{$PHP_SELF}?m=gedcom_upload">Upload</a></td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="list_header" width="25">&nbsp;</td>
			<td class="list_header" width="150">Filename</td>
			<td class="list_header" width="100">Size</td>
			<td class="list_header" width="200">Timestamp</td>
			<td class="list_header" width="75">&nbsp;</td>
			<td class="list_header" width="75">&nbsp;</td>
			<td class="list_header">&nbsp;</td>
			
		</tr>
		{foreach from=$gedcoms item="gedcom"}
		<tr>
			<td class="list_item">
				<input name="selectitem[]" type="checkbox" class="checkbox" value="{$gedcom.filename}">
			</td>
			<td class="list_item">{$gedcom.filename}</td>
			<td class="list_item">{$gedcom.size}</td>
			<td class="list_item">{$gedcom.timestamp}</td>
			<td class="list_item"><a href="{$gedcom.filepath}">view</a></td>
			<td class="list_item"><a href="{$PHP_SELF}?m=gedcom_import&f={$gedcom.filename}">publish</a></td>
			<td class="list_item">&nbsp;</td>
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