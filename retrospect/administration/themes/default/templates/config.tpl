{if $SAVED}
	<div class="content-title">System Configuration</div>
	<p>The system configuration has been changed.</p>
	<p>Click <a href="{$PHP_SELF}">HERE</a> to return to the main administration page.</p>
{else}
<form action="{$PHP_SELF}?m=config" method="post">
<div class="content-title">System Configuration</div>
<!-- SITE OPTIONS -->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">Site Options</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="default_page">Default Module:</label></td>
			<td class="cfg-opt"><input name="default_page" type="text" class="textbox" id="default_page" value="{$options.default_page}" /></td>
			<td class="cfg-dsc">This is the default page that is displayed when opening the site. It is only used if no other module is selected. It must be a module that does not require any other parameters.</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="sort_children">Sort Children?</label></td>
			<td class="cfg-opt2">
				<select name="sort_children" class="listbox" id="sort_children">
					{html_options options=$yesno selected=$options.sort_children}
				</select>
			</td>
			<td class="cfg-dsc2">
				If set to Yes, children will be listed in chronological order by birth date. Children with no birth date will be listed first.<br />
			  If set to No, children will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="sort_marriages">Sort Marriages?</label></td>
			<td class="cfg-opt">
				<select name="sort_marriages" class="listbox" id="sort_marriages">
					{html_options options=$yesno selected=$options.sort_marriages}
				</select>
			</td>
			<td class="cfg-dsc">
				If set to Yes, marriages will be listed in chronological order by marriage date. Marriages with no date will be listed first.<br />
			  If set to No, marriages will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="sort_events">Sort Events?</label></td>
			<td class="cfg-opt2">
				<select name="sort_events" class="listbox" id="sort_events">
					{html_options options=$yesno selected=$options.sort_events}
				</select>
			</td>
			<td class="cfg-dsc2">
				If set to Yes, events will be listed in chronological order by the event's date. Events with no date will be listed first.<br />
				If set to No, events will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="comments_allow">Allow Comments:</label></td>
			<td class="cfg-opt">
				<select name="allow_comments" class="listbox" id="allow_comments">
					{html_options options=$yesno selected=$options.allow_comments}
				</select>
			</td>
			<td class="cfg-dsc">Allow the public to submit comments on individuals?</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="meta_copyright">Copyright Notice:</label></td>
			<td class="cfg-opt2">
				<textarea name="meta_copyright" cols="30" rows="2" class="textbox" id="meta_copyright">{$options.meta_copyright}</textarea>
			</td>
			<td class="cfg-dsc2">This populates the $SITE_COPYRIGHT variable used in the template system.</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="meta_keywords">Default Keywords:</label></td>
			<td class="cfg-opt">
				<textarea name="meta_keywords" cols="30" rows="2" class="textbox" id="meta_keywords">{$options.meta_keywords}</textarea>
			</td>
			<td class="cfg-dsc">These keywords will be added to the keywords meta tag on every page.</td>
		</tr>
	</table>
</div>
<br />
<!-- DATABASE OPTIONS -->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">Database Options</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
      <td colspan="3">The database settings are shown for reference only and can not be changed from this screen. You must edit core/config.php to change these settings.</td>
    </tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_host">Hostname:</label></td>
			<td class="cfg-opt"><input name="db_host" type="text" class="textbox" value="{$db_host}" readonly="true"></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="db_port">Port:</label></td>
			<td class="cfg-opt2"><input name="db_port" type="text" class="textbox" value="{$db_port}" readonly="true"></td>
			<td class="cfg-dsc2">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_user">User:</label></td>
			<td class="cfg-opt"><input name="db_user" type="text" class="textbox" value="{$db_user}" readonly="true"></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="db_pass">Password:</label></td>
			<td class="cfg-opt2"><input name="db_pass" type="password" class="textbox" value="{$db_pass}" readonly="true"></td>
			<td class="cfg-dsc2">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_name">Database:</label></td>
			<td class="cfg-opt"><input name="db" type="text" class="textbox" value="{$db_name}" readonly="true"></td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
	</table>
</div>
<br />
<!-- LANGUAGE OPTIONS -->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">Language Options</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="default_lang">Default Language:</label></td>
			<td class="cfg-opt">
				<select name="default_lang" class="listbox" id="default_lang">
					{html_options output=$lang_names values=$lang_codes selected=$lang}
				</select>
			</td>
			<td class="cfg-dsc">If you change the default language you may need to restart your browser to see the change.</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="allow_lang_change">Allow language changes?</label></td>
			<td class="cfg-opt2">
				<select name="allow_lang_change" class="listbox" id="allow_lang_change">
					{html_options options=$yesno selected=$options.allow_lang_change}
				</select>
			</td>
			<td class="cfg-dsc2">Enables the language drop down menu on all pages.</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="translate_dates">Translate Dates?</label></td>
			<td class="cfg-opt">
				<select name="translate_dates" class="listbox" id="translate_dates">
					{html_options options=$yesno selected=$options.translate_dates}
				</select>
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="date_format">Date Format:</label></td>
			<td class="cfg-opt2">
				<select name="date_format" class="listbox" id="date_format">
					{html_options options=$date_formats selected=$options.date_format}
				</select>
			</td>
			<td class="cfg-dsc2"></td>
		</tr>
	</table>
</div>
<br />
<!-- DEBUG OPTIONS -->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tab-selected">Debug Options</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<table cellpadding="0" cellspacing="0">
		<tr>
			<td class="cfg-lbl"><label for="debug">Debugging Console?</label></td>
			<td class="cfg-opt">
				<select name="debug" class="listbox" id="debug">
					{html_options options=$yesno selected=$options.debug}
				</select>
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
	</table>
</div>
<br />	
	<input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Reset" type="reset" class="text" id="Reset" value="Reset">
</form>
{/if}