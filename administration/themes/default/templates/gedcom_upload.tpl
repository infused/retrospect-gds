<h1>Gedcom Manager</h1>
{if $UPLOAD_SUCCESS}
	<p>The file was upload successfully.</p>
	<p>Click <a href="{$PHP_SELF}?m=gedcom">HERE</a> to return to the Gedcom Manager.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main administration page.</p>
{else}

<div id="tabs">
  <ul>
    <li><a href="{$PHP_SELF}?m=gedcom">Gedcom List</a></li>
    <li id="selected"><a>Upload</a></li>
  </ul>
</div>
<div class="tab-page">
  <form enctype="multipart/form-data" action="{$PHP_SELF}?m=gedcom_upload" method="post">
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
  </form>
</div>
<h3>A note about character encodings</h3>
<p>
If your gedcom file contains any accented characters, they <u>may not display properly</u> if the gedcom file is not
encoded using the UTF-8 character set.  For best results always export your gedcom file using the UTF-8 character set
if your genealogy software supports it.
</p>
{/if}