<!-- 
/**
*	Nav sub-template
* $Id$
*/
-->
<table class="tab-row" cellpadding="0" cellspacing="0">
	<tr>
		{if $module=="surnames"}
			<td class="tab-selected">{$surname_title}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=surnames&amp;sn={$indiv->sname}">{$surname_title}</a>
			</td>
		{/if}
		{if $module=="family"}
			<td class="tab-selected">{php}t("Family"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=family&amp;id={$indiv->indkey}">{php}t("Family"){/php}</a>
			</td>
		{/if}
		{if $module=="pedigree"}
			<td class="tab-selected">{php}t("Pedigree"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=pedigree&amp;id={$indiv->indkey}">{php}t("Pedigree"){/php}</a>
			</td>
		{/if}
		{if $module=="reports"}
			<td class="tab-selected">{php}t("Reports"){/php}</td>
		{elseif $module=="ahnentafel" or $module=="descendant"}
			<td class="tab-selected">
				<a href="{$PHP_SELF}?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a>
			</td>
		{/if}
		{if $module=="multimedia"}
			<td class="tab-selected">{php}t("Multimedia"){/php}</td>
		{else}
			<td class="tab">
				<a href="{$PHP_SELF}?m=multimedia&amp;id={$indiv->indkey}">{php}t("Multimedia"){/php}</a>
			</td>
		{/if}
		{if $allow_comments}
			{if $module=="comments" or $module=="commentadd"}
				<td class="tab-selected">{php}t("Comments"){/php} ({$comment_count})</td>
			{else}
				<td class="tab">
					<a href="{$PHP_SELF}?m=comments&amp;id={$indiv->indkey}">{php}t("Comments"){/php} ({$comment_count})</a>
				</td>
			{/if}
		{/if}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>