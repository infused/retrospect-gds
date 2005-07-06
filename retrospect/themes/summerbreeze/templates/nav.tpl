{*
  /**
  *	Nav sub-template
  * $Id$
  *
  */
*}
<div id="tabs">
  <ul>
  	{if $module=="surnames"}
  		<li id="selected"><a>{$surname_title}</a></li>
  	{else}
  		<li><a href="?m=surnames&amp;sn={$indiv->sname}">{$surname_title}</a></li>
  	{/if}
  	{if $module=="family"}
  		<li id="selected"><a>{php}t("Family"){/php}</a></li>
  	{else}
  		<li><a href="?m=family&amp;id={$indiv->indkey}">{php}t("Family"){/php}</a></li>
  	{/if}

  	{if $module=="pedigree"}
  		<li id="selected"><a>{php}t("Pedigree"){/php}</a></li>
  	{else}
  		<li><a href="?m=pedigree&amp;id={$indiv->indkey}">{php}t("Pedigree"){/php}</a></li>
  	{/if}
  	

  	{if $module=="reports"}
  		<li id="selected"><a>{php}t("Reports"){/php}</a></td>
  	{elseif $module=="ahnentafel" or $module=="descendant"}
  		<li id="selected"><a href="?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a></li>
  	{else}
  	  <li><a href="?m=reports&amp;id={$indiv->indkey}">{php}t("Reports"){/php}</a></li>
  	{/if}

  	{if $gallery_plugin}
  		{if $module=="multimedia"}
  			<li id="selected"><a>{php}t("Multimedia"){/php}</a></td>
  		{else}
  			<li><a href="{$media_link}">{php}t("Multimedia"){/php} ({$media_count})</a></li>
  		{/if}
  	{/if}
  	
  	{if $allow_comments}
  		{if $module=="comments" or $module=="commentadd"}
  			<li id="selected"><a>{php}t("Comments"){/php} ({$comment_count})</a></li>
  		{else}
  			<li>
  				{if $comment_count < 1 }
  				  <a href="?m=commentadd&amp;id={$indiv->indkey}">
  				{else}
  				  <a href="?m=comments&amp;id={$indiv->indkey}">
  				{/if}
  			  {php}t("Comments"){/php} ({$comment_count})</a>
  			</li>
  		{/if}
  	{/if}

  </ul>
</div>