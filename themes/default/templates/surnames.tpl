{*
	/**
	*	Surnames sub-template
	* $Id$
	*/
*}
<div class="content-title">{$content_title}</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		{foreach from=$tabs item=tab}
			<td class="{$tab.class}">{$tab.link}</td>
		{/foreach}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
{if $sn}
<div class="tab-page">
	<div class="text">{php}t("Number of individuals listed"){/php}: {$individuals|@count}</div>
	<div class="text">&nbsp;</div>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="surname_col1"><b>{php}t("Name"){/php}</b></td>
			<td class="surname_col2"><b>{php}t("Birth"){/php}</b></td>
			<td class="surname_col2"><b>{php}t("Death"){/php}</b></td>
		</tr>
		{foreach from=$individuals item=indiv}
		<tr>
			<td class="surname_col1">
				<a href="{$PHP_SELF}?m=family&amp;id={$indiv->indkey}">{$indiv->sname}, {$indiv->gname}</a>
			</td>
			<td class="surname_col2">{$indiv->birth->date}</td>
			<td class="surname_col2">{$indiv->death->date}</td>
		</tr>
		{/foreach}
	</table>
</div>
{else}
<div class="tab-page">
	<div class="text">{php}t("Number of surnames listed"){/php}: {$surnames|@count}</div>
	<div class="text">&nbsp;</div>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text" width="200" valign="top">
				{assign var="count" value="1"}
				{section name=i loop=$surnames}
					{if $count % $max_rows == 0}
						<a href="{$PHP_SELF}?m=surnames&amp;sn={$surnames[i].surname}">{$surnames[i].surname}</a>&nbsp;({$surnames[i].count})
						</td><td class="text" width="200" valign="top">
						{assign var="count" value="`$count+1`"}
					{else}
						<a href="{$PHP_SELF}?m=surnames&amp;sn={$surnames[i].surname}">{$surnames[i].surname}</a>&nbsp;({$surnames[i].count})
						<br />
						{assign var="count" value="`$count+1`"}
					{/if}
				{/section}
			</td>
		</tr>
	</table>
</div>
{/if}