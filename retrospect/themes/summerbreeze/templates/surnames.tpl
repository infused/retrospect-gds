<!--
	/**
	*	Surnames sub-template
	* $Id$
	*/
-->
<h1>{$content_title}</h1>
<div id="tabs">
	<ul>
		{foreach from=$tabs item=tab}
			<li id="{$tab.class}">{$tab.link}</li>
		{/foreach}
	</ul>
</div>
<div class="tab-page">
{if $sn}
	<div class="text">{php}t("Number of individuals listed"){/php}: {$individuals|@count}</div>
	<div class="text">&nbsp;</div>
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td style="padding: 2px 4px"><b>{php}t("Name"){/php}</b></td>
			<td style="padding: 2px"><b>{php}t("Birth"){/php}</b></td>
			<td style="padding: 2px"><b>{php}t("Death"){/php}</b></td>
		</tr>
		{foreach from=$individuals item=indiv}
		<tr style="background: {cycle values="#ddd,#fff"}">
			<td style="padding: 2px 4px">
				<a href="{$PHP_SELF}?m=family&amp;id={$indiv->indkey}">{$indiv->sname}, {$indiv->gname}</a>
				<img align="top" src="{$THEME_URL}/images/{$indiv->gender|lower}.gif" alt="{$indiv->gender}" />
			</td>
			<td style="padding: 2px">{$indiv->birth->date}</td>
			<td style="padding: 2px">{$indiv->death->date}</td>
		</tr>
		{/foreach}
	</table>
{else}
	<div class="text">{php}t("Number of surnames listed"){/php}: {$surnames|@count}</div>
	<div class="text">&nbsp;</div>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text" width="200" valign="top">
				{assign var="count" value="1"}
				{section name=i loop=$surnames}
					{if $count % $max_rows == 0}
						<a href="?m=surnames&sn={$surnames[i].surname}">{$surnames[i].surname}</a>
						&nbsp;({$surnames[i].count})
						</td><td class="text" width="200" valign="top">
						{assign var="count" value="`$count+1`"}
					{else}
						<a href="?m=surnames&sn={$surnames[i].surname}">{$surnames[i].surname}</a>
						&nbsp;({$surnames[i].count})
						<br />
						{assign var="count" value="`$count+1`"}
					{/if}
				{/section}
			</td>
		</tr>
	</table>
{/if}
{include file="genderkey.tpl"}
</div>