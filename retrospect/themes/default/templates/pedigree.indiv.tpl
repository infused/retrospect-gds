{*
	/** 
	*	Pedigree.Indiv sub-template
	* $Id$
	*
	*/
*}
{if $indiv}
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td class="pedbox-text">
			<a href="{$php_self}?option=pedigree&amp;indiv={$indiv->indkey}">{$indiv->name}</a>
		</td>
	</tr>
	<tr>
		<td class="pedbox-text">{php}t("b."){/php} {$indiv->birth->date}</td>
	</tr>
	<tr>
		<td class="pedbox-text">{php}t("d."){/php} {$indiv->death->date}</td>
	</tr>
</table>
{/if}