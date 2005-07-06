{*
	/** 
	*	Pedigree.Indiv sub-template
	* $Id$
	*
	*/
*}
{if $indiv}
	<table cellpadding="0" cellspacing="0" width="100%">
	  <tr>
	    <td height="60" valign="middle">
  	    <div class="pedbox-text">
  	      <div><a href="{$php_self}?m=pedigree&amp;id={$indiv->indkey}">{$indiv->name}</a></div>
      		<div style="height: 1.3em; overflow: hidden;">{php}t("b."){/php} {$indiv->birth->date}</div>
      		<div style="height: 1.3em; overflow: hidden;">{php}t("d."){/php} {$indiv->death->date}</div>
      	</div>
      </td>
    </tr>
  </table>
{/if}