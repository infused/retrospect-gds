<form>
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
			<td class="cfg-lbl"><label for="default_page_new">Default Module:</label></td>
			<td class="cfg-opt">
				<input name="default_page_new" type="text" class="textbox" id="default_page_new" value="{$options.default_page}" />
				<input name="default_page_old" type="hidden" id="default_page_old" value="{$options.default_page}" />
			</td>
			<td class="cfg-dsc">This is the default page that is displayed when opening the site. It is only used if no other module is selected. It must be a module that does not require any other parameters.</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="sort_children_new">Sort Children?</label></td>
			<td class="cfg-opt2">
				<select name="sort_children_new" class="listbox" id="sort_children_new">
					{html_options options=$yesno selected=$options.sort_children}
				</select>
				<input type="hidden" name="sort_children_old" id="sort_children_old" value="{$options.sort_children}" />
			</td>
			<td class="cfg-dsc2">
				If set to Yes, children will be listed in chronological order by birth date. Children with no birth date will be listed first.<br />
			  If set to No, children will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="sort_marriages_new">Sort Marriages?</label></td>
			<td class="cfg-opt">
				<select name="sort_marriages_new" class="listbox" id="sort_marriages_new">
					{html_options options=$yesno selected=$options.sort_marriages}
				</select>
				<input type="hidden" name="sort_marriages_old" id="sort_marriages_old" value="{$options.sort_marriages}" />
			</td>
			<td class="cfg-dsc">
				If set to Yes, marriages will be listed in chronological order by marriage date. Marriages with no date will be listed first.<br />
			  If set to No, marriages will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="sort_events_new">Sort Events?</label></td>
			<td class="cfg-opt2">
				<select name="sort_events_new" class="listbox" id="sort_events_new">
					{html_options options=$yesno selected=$options.sort_events}
				</select>
				<input type="hidden" name="sort_events_old" id="sort_events_old" value="{$options.sort_events}" />
			</td>
			<td class="cfg-dsc2">
				If set to Yes, events will be listed in chronological order by the event's date. Events with no date will be listed first.<br />
				If set to No, events will be listed in the order they were found in the original gedcom file.
			</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="meta_copyright_new">Copyright Notice:</label></td>
			<td class="cfg-opt">
				<textarea name="meta_copyright_new" cols="30" rows="2" class="textbox" id="meta_copyright_new">{$options.meta_copyright}</textarea>
        <input name="meta_copyright_old" type="hidden" id="meta_copyright_old" value="{$options.meta_copyright}">
			</td>
			<td class="cfg-dsc">This populates the $SITE_COPYRIGHT variable used in the template system.</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="meta_keywords_new">Default Keywords:</label></td>
			<td class="cfg-opt2">
				<textarea name="meta_keywords_new" cols="30" rows="2" class="textbox" id="meta_keywords_new">{$options.meta_keywords}</textarea>
        <input name="meta_keywords_old" type="hidden" id="meta_keywords_old" value="{$options.meta_keywords}">
			</td>
			<td class="cfg-dsc2">These keywords will be added to the keywords meta tag on every page.</td>
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
			<td class="cfg-lbl"><label for="db_host_new">Hostname:</label></td>
			<td class="cfg-opt">
				<input name="db_host_new" type="text" class="textbox" id="db_host_new" value="{$db_host}" readonly="true">
				<input name="db_host_old" type="hidden" id="db_host_old" value="{$db_host}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="db_port_new">Port:</label></td>
			<td class="cfg-opt2">
				<input name="db_port_new" type="text" class="textbox" id="db_port_new" value="{$db_port}" readonly="true">
				<input name="db_port_old" type="hidden" id="db_port_old" value="{$db_port}">
			</td>
			<td class="cfg-dsc2">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_user_new">User:</label></td>
			<td class="cfg-opt">
				<input name="db_user_new" type="text" class="textbox" id="db_user_new" value="{$db_user}" readonly="true">
				<input name="db_user_old" type="hidden" id="db_user_old" value="{$db_user}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="db_pass_new">Password:</label></td>
			<td class="cfg-opt2">
				<input name="db_pass_new" type="password" class="textbox" id="db_pass_new" value="{$db_pass}" readonly="true">
				<input name="db_pass_old" type="hidden" id="db_pass_old" value="{$db_pass}">
			</td>
			<td class="cfg-dsc2">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_name_new">Database:</label></td>
			<td class="cfg-opt">
				<input name="db_new" type="text" class="textbox" id="db_new" value="{$db_name}" readonly="true">
				<input name="db_old" type="hidden" id="db_old" value="{$db_name}">
			</td>
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
			<td class="cfg-lbl"><label for="default_lang_new">Default Language:</label></td>
			<td class="cfg-opt">
				<select name="default_lang_new" class="listbox" id="default_lang_new">
					{html_options output=$lang_names values=$lang_codes selected=$lang}
				</select>
				<input name="default_lang_old" type="hidden" id="default_lang_old" value="{$options.default_lang}">
			</td>
			<td class="cfg-dsc">If you change the default language you may need to restart your browser to see the change.</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="allow_lang_change_new">Allow language changes?</label></td>
			<td class="cfg-opt2">
				<select name="allow_lang_change_new" class="listbox" id="allow_lang_change_new">
					{html_options options=$yesno selected=$options.allow_lang_change}
				</select>
				<input name="allow_lang_change_old" type="hidden" id="allow_lang_change_old" value="{$options.allow_lang_change}">
			</td>
			<td class="cfg-dsc2">Enables the language drop down menu on all pages.</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="translate_dates_new">Translate Dates?</label></td>
			<td class="cfg-opt">
				<select name="translate_dates_new" class="listbox" id="translate_dates_new">
					{html_options options=$yesno selected=$options.translate_dates}
				</select>
				<input name="translate_dates_old" type="hidden" id="translate_dates_old" value="{$options.translate_dates}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl2"><label for="date_format_new">Date Format:</label></td>
			<td class="cfg-opt2">
				<select name="date_format_new" class="listbox" id="date_format_new">
					{html_options options=$date_formats selected=$options.date_format}
				</select>
				<input type="hidden" name="date_format_old" id="date_format_old" value="{$options.date_format}" />
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
			<td class="cfg-lbl"><label for="debug_new">Debugging Console?</label></td>
			<td class="cfg-opt">
				<select name="debug_new" class="listbox" id="debug_new">
					{html_options options=$yesno selected=$options.debug}
				</select>
				<input type="hidden" name="debug_old" id="debug_old" value="{$options.debug}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
	</table>
</div>
<br />	
	<input name="Save" type="submit" class="text" id="Save" value="Save"> 
	<input name="Reset" type="reset" class="text" id="Reset" value="Reset">
</form>