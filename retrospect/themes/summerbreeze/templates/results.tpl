<!--
/**
*	Results sub-template
* $Id$
*/
-->
<h1>{$content_title}</h1>
<div id="tabs">
	<ul>
		<li><a href="{$php_self}?m=search{$search_params}">{php}t("Search"){/php}</a></li>
		<li id="selected"><a id="selected">{php}t("Results"){/php}</a></td>
	</ul>
</div>
<div class="tab-page">
	{if $individuals|@count > 0}
		<div class-"text">{php}t("Number of individuals listed"){/php}: {$individuals|@count}</div>
		<div class="text">&nbsp;</div>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td style="padding: 2px 4px"><b>{php}t("Name"){/php}</b></td>
				<td style="padding: 2px"><b>{php}t("Birth"){/php}</b></td>
				<td style="padding: 2px"><b>{php}t("Death"){/php}</b></td>
			</tr>
			{foreach from=$individuals item=indiv}
			<tr style="background: {cycle values="#ddd,#fff"}">
				<td style="padding: 2px 4px">
					<a href="{$php_self}?m=family&amp;id={$indiv->indkey}">{$counter}{$indiv->sname}, {$indiv->gname}</a>
					<img align="top" src="{$THEME_URL}/images/{$indiv->gender|lower}.gif" alt="{$indiv->gender}" />
				</td>
				<td style="padding: 2px">{$indiv->birth->date}</td>
				<td style="padding: 2px">{$indiv->death->date}</td>
			</tr>
			{/foreach}
		</table>
	{else}
		{php}t("No matching records were found."){/php}
	{/if}
	{include file="genderkey.tpl"}
</div>
