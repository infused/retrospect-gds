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
			<td class="cfg-lbl">oo</td>
			<td class="cfg-opt">oo</td>
			<td class="cfg-dsc">oo</td>
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
			<td class="cfg-lbl"><label for="db_port_new">Port:</label></td>
			<td class="cfg-opt">
				<input name="db_port_new" type="text" class="textbox" id="db_port_new" value="{$db_port}" readonly="true">
				<input name="db_port_old" type="hidden" id="db_port_old" value="{$db_port}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
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
			<td class="cfg-lbl"><label for="db_pass_new">Password:</label></td>
			<td class="cfg-opt">
				<input name="db_pass_new" type="password" class="textbox" id="db_pass_new" value="{$db_pass}" readonly="true">
				<input name="db_pass_old" type="hidden" id="db_pass_old" value="{$db_pass}">
			</td>
			<td class="cfg-dsc">&nbsp;</td>
		</tr>
		<tr>
			<td class="cfg-lbl"><label for="db_name_new">Database:</label></td>
			<td class="cfg=opt">
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
			<td class="cfg-lbl"><label for="allow_lang_change_new">Allow language changes?</label></td>
			<td class="cfg-opt">
				<select name="allow_lang_change_new" class="listbox" id="allow_lang_change_new">
					{html_options options=$yesno selected=$options.allow_lang_change}
				</select>
				<input name="allow_lang_change_old" type="hidden" id="allow_lang_change_old" value="{$options.allow_lang_change}">
			</td>
			<td class="cfg-dsc">Enables the language drop down menu on all pages.</td>
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
			<td class="cfg-lbl"><label for="sort_children_new">Date Format:</label></td>
			<td class="cfg-opt">
				<select name="sort_children_new" class="listbox" id="sort_children_new">
					{html_options options=$date_formats selected=$options.date_format}
				</select>
				<input type="hidden" name="sort_children_old" id="sort_children_old" value="{$options.sort_children}" />
			</td>
			<td class="cfg-dsc"></td>
		</tr>
	</table>
</div>
</form>