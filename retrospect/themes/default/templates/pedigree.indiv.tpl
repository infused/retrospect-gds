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
			<a href="{$php_self}?m=pedigree&amp;id={$indiv->indkey}">{$indiv->full_name()}</a>
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