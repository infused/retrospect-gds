{if $UPLOAD_SUCCESS}<br>
	<div class="content-title">Gedcom Manager</div>
	<p>The file was upload successfully.</p>
	<p>Click <a href="{$PHP_SELF}?m=gedcom">HERE</a> to return to the Gedcom Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main administration page.</p>
{else}
<form enctype="multipart/form-data" action="{$PHP_SELF}?m=gedcom_upload" method="post">
<div class="content-title">Gedcom Manager</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab"><a href="{$PHP_SELF}?m=gedcom">Gedcom List</a></td>
		<td class="tab-selected">Upload</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<p>Select a file to upload.</p>
	<p>You can upload a single gedcom file with an extension of .ged or a zip file containing
		one or more gedcom files.<br />
		The maximum file upload size allowed by the server is {$UPLOAD_MAX_FILESIZE}.
	</p>
	{if $UPLOAD_ERROR}
		<p style="color:#FF0000;">{$UPLOAD_ERROR}</p>
	{/if}
	<p><input name="file" type="file" class="textbox" size="40">
	</p>
	<p><input name="Upload" type="submit" class="text" value="Upload"></p>
</div>
</form>
{/if}