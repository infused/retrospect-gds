<!-- 
/**
*	Nav sub-template
* $Id$
*/
-->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		{if $option=="surnames"}
			<td class="tab-selected">{$surname_title}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=surnames&amp;sn={$indiv->sname}">{$surname_title}</a>
			</td>
		{/if}
		{if $option=="family"}
			<td class="tab-selected">{php}t("Family"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=family&amp;indiv={$indiv->indkey}">{php}t("Family"){/php}</a>
			</td>
		{/if}
		{if $option=="pedigree"}
			<td class="tab-selected">{php}t("Pedigree"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=pedigree&amp;indiv={$indiv->indkey}">{php}t("Pedigree"){/php}</a>
			</td>
		{/if}
		{if $option=="reports"}
			<td class="tab-selected">{php}t("Reports"){/php}</td>
		{elseif $option=="ahnentafel" or $option=="descendant"}
			<td class="tab-selected">
				<a href="{$php_self}?option=reports&amp;indiv={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=reports&amp;indiv={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{/if}
		{if $option=="multimedia"}
			<td class="tab-selected">{php}t("Multimedia"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=multimedia&amp;indiv={$indiv->indkey}">{php}t("Multimedia"){/php}</a>
			</td>
		{/if}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>