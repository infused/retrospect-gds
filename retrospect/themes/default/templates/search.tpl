<!--
/**
*	Search sub-template
* $Id$
*/
-->
<div class="content-title">{php}t("Search"){/php}</div>
<table class="tab-row" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="tab-selected">{php}t("Search"){/php}</td>
		<td class="tab">{php}t("Results"){/php}</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
<!-- Begin name search form -->
<form name="form_search_name" method="post" action="{$php_self}?option=results">
	<input name="search_type" type="hidden" value="name" />
	<table class="section" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td colspan="2" class="text"><b>{php}t("Name Search"){/php}</b></td>
					</tr>
					<tr>
						<td class="text">{php}t("Given Name"){/php}:</td>
						<td class="text">{php}t("Surname"){/php}:</td>
					</tr>
					<tr>
						<td><input name="gname" type="text" class="textbox" id="gname" value="{$form_gname}" /></td>
						<td><input name="sname" type="text" class="textbox" id="sname" value="{$form_sname}" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="text">
							<input name="soundex" type="checkbox" id="soundex" value="1" {if $form_soundex == 1}checked{/if} />
							Use Soundex?
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="Submit" type="submit" class="text" value="{php}t("Search"){/php}" />
							<input name="Reset" type="reset" class="text" value="{php}t("Reset"){/php}" />
							<input name="Clear" type="button" class="text" onMouseDown="MM_setTextOfTextfield('gname','','');MM_setTextOfTextfield('sname','','')" value="{php}t("Clear"){/php}" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<!-- End name search form -->
<!-- Begin location search form -->
<form name="form_search_location" method="post" action="{$php_self}?option=results">
	<input name="search_type" type="hidden" value="location" />
	<table class="section" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td colspan="2" class="text"><b>{php}t("Location Search"){/php}</b></td>
					</tr>
					<tr>
						<td colspan="2" class="text">{php}t("Keywords"){/php} ({php}t("separate with spaces"){/php}):</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="locat" size="40" type="text" class="textbox" id="locat" value="{$form_location}" />
						</td>
					</tr>
					<tr>
						<td class="text">{php}t("Match Keywords"){/php}:</td>
						<td>
							<select name="parts" class="listbox">
								<option value="all" {if $form_parts=="all"} selected{/if}>{php}t("All"){/php}</option>
								<option value="any" {if $form_parts=="any"} selected{/if}>{php}t("Any"){/php}</option>
								<option value="phrase" {if $form_parts=="phrase"} selected{/if}>{php}t("Phrase"){/php}</option>
								<option value="starts" {if $form_parts=="starts"} selected{/if}>{php}t("Starts with"){/php}</option>
								<option value="ends" {if $form_parts=="ends"} selected{/if}>{php}t("Ends with"){/php}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="Submit" type="submit" class="text" value="{php}t("Search"){/php}" />
							<input name="Reset" type="reset" class="text" value="{php}t("Reset"){/php}" />
							<input name="Clear" type="button" class="text" value="{php}t("Clear"){/php}" onmousedown="MM_setTextOfTextfield('locat','','')" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<!-- End location search form -->
<!-- Begin note search form -->
<form name="form_search_note" method="post" action="{$php_self}?option=results">

	<input name="search_type" type="hidden" value="note" />
	<table class="section" width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<table border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td colspan="2" class="text"><b>{php}t("Note Search"){/php}</b></td>
					</tr>
					<tr>
						<td colspan="2" class="text">{php}t("Keywords"){/php} ({php}t("separate with spaces"){/php}):</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="note" size="40" type="text" class="textbox" id="note" value="{$form_note}" />
						</td>
					</tr>
					<tr>
						<td class="text">{php}t("Match Keywords"){/php}:</td>
						<td>
							<select name="parts" class="listbox">
								<option value="all" {if $form_parts=="all"} selected{/if}>{php}t("All"){/php}</option>
								<option value="any" {if $form_parts=="any"} selected{/if}>{php}t("Any"){/php}</option>
								<option value="phrase" {if $form_parts=="phrase"} selected{/if}>{php}t("Phrase"){/php}</option>
								<option value="starts" {if $form_parts=="starts"} selected{/if}>{php}t("Starts with"){/php}</option>
								<option value="ends" {if $form_parts=="ends"} selected{/if}>{php}t("Ends with"){/php}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="Submit" type="submit" class="text" value="{php}t("Search"){/php}" />
							<input name="Reset" type="reset" class="text" value="{php}t("Reset"){/php}" />
							<input name="Clear" type="button" class="text" value="{php}t("Clear"){/php}" onmousedown="MM_setTextOfTextfield('note','','')" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
<!-- End note search form -->
</div>
