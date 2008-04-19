{*
/**
*	Results sub-template
* $Id$
*/
*}
<div class="content-title">{$content_title}</div>
<table class="tab-row" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td class="tab">
			<a href="{$php_self}?option=search{$search_params}">{php}t("Search"){/php}</a>
		</td>
		<td class="tab-selected">{php}t("Results"){/php}</td>
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	{if !$form_gname and !$form_sname and !$form_location and !$form_note}
		{php}t("No search parameters were specified."){/php}
		{php}t("Please go back to the search page and enter some search criteria."){/php}
	{elseif $individuals|@count > 0}
		<div class-"text">{php}t("Number of individuals listed"){/php}: {$individuals|@count}</div>
		<div class="text">&nbsp;</div>
		<table border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td class="surname_col1"><b>{php}t("Name"){/php}</b></td>
				<td class="surname_col2"><b>{php}t("Birth"){/php}</b></td>
				<td class="surname_col2"><b>{php}t("Death"){/php}</b></td>
			</tr>
			{foreach from=$individuals item=indiv}
			<tr>
				<td class="surname_col1">
					<a href="{$php_self}?m=family&amp;id={$indiv->indkey}">{$indiv->sname}, {$indiv->gname}</a>
				</td>
				<td class="surname_col2">{$indiv->birth->date}</td>
				<td class="surname_col2">{$indiv->death->date}</td>
			</tr>
			{/foreach}
		</table>
	{else}
		{php}t("No matching records were found."){/php}
	{/if}
</div>
