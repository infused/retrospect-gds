<!--
/**
*	Surnames sub-template
* $Id$
*/
-->
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
	<div class="text">{translate s="Number of individuals listed"}: {$individuals|@count}</div>
	<div class="text">&nbsp;</div>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="surname_col1"><b>{translate s="Name"}</b></td>
			<td class="surname_col2"><b>{translate s="Birth"}</b></td>
			<td class="surname_col2"><b>{translate s="Death"}</b></td>
		</tr>
		{foreach from=$individuals item=indiv}
		<tr>
			<td class="surname_col1">
				<a href="{$php_self}?option=family&amp;indiv={$indiv->indkey}">{$indiv->sname}, {$indiv->gname}</a>
			</td>
			<td class="surname_col2">{$indiv->birth->date}</td>
			<td class="surname_col2">{$indiv->death->date}</td>
		</tr>
		{/foreach}
	</table>
</div>
{else}
<div class="tab-page">
	<div class="text">{translate s="Number of surnames listed"}: {$surnames|@count}</div>
	<div class="text">&nbsp;</div>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="text" width="200" valign="top">
				{assign var="count" value="1"}
				{section name=i loop=$surnames}
					{if $count % $max_rows == 0}
						<a href="{$php_self}?option=surnames&sn={$surnames[i].surname}">{$surnames[i].surname}</a>&nbsp;({$surnames[i].count})
						</td><td class="text" width="200" valign="top">
						{assign var="count" value="`$count+1`"}
					{else}
						<a href="{$php_self}?option=surnames&sn={$surnames[i].surname}">{$surnames[i].surname}</a>&nbsp;({$surnames[i].count})
						<br />
						{assign var="count" value="`$count+1`"}
					{/if}
				{/section}
			</td>
		</tr>
	</table>
</div>
{/if}