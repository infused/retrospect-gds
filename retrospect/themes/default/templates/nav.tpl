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
				<a href="{$PHP_SELF}?m=surnames&amp;sn={$indiv->sname}">{$surname_title}</a>
			</td>
		{/if}
		{if $option=="family"}
			<td class="tab-selected">{php}t("Family"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=family&amp;id={$indiv->indkey}">{php}t("Family"){/php}</a>
			</td>
		{/if}
		{if $option=="pedigree"}
			<td class="tab-selected">{php}t("Pedigree"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=pedigree&amp;id={$indiv->indkey}">{php}t("Pedigree"){/php}</a>
			</td>
		{/if}
		{if $option=="reports"}
			<td class="tab-selected">{php}t("Reports"){/php}</td>
		{elseif $option=="ahnentafel" or $option=="descendant"}
			<td class="tab-selected">
				<a href="{$PHP_SELF}?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{/if}
		{if $option=="multimedia"}
			<td class="tab-selected">{php}t("Multimedia"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=multimedia&amp;id={$indiv->indkey}">{php}t("Multimedia"){/php}</a>
			</td>
		{/if}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>