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
			<td class="tab-selected">{translate s="Family"}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=family&amp;indiv={$indiv->indkey}">{translate s="Family"}</a>
			</td>
		{/if}
		{if $option=="pedigree"}
			<td class="tab-selected">{translate s="Pedigree"}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=pedigree&amp;indiv={$indiv->indkey}">{translate s="Pedigree"}</a>
			</td>
		{/if}
		{if $option=="reports"}
			<td class="tab-selected">{translate s="Reports"}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=reports&amp;indiv={$indiv->indkey}">{translate s="Reports"}</a>
			</td>
		{/if}
		{if $option=="multimedia"}
			<td class="tab-selected">{translate s="Multimedia"}</td>
		{else}
			<td class="tab">
				<a href="{$php_self}?option=multimedia&amp;indiv={$indiv->indkey}">{translate s="Multimedia"}</a>
			</td>
		{/if}
		<td class="tab-last">&nbsp;</td>
	</tr>
</table>