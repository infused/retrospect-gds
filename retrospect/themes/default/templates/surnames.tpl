<!--
/**
*	Surnames sub-template
* $Id$
*/
-->
<div class="content-title">{translate s="Surname List"}</div>
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		{foreach from=$tabs item=tab}
			<td class="{$tab.class}">{$tab.link}</td>
		{/foreach}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>
<div class="tab-page">
	<p class="text">{translate s="Number of surnames listed"}: {$surnames|@count}</p>
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