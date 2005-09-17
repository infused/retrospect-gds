{*
	/** 
	*	Comments sub-template
	* $Id$
	*
	*/
*}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	
	<div align="right">
	  <a href="?m=commentadd&amp;id={$indiv->indkey}">< {php}t("Submit a comment"){/php} ></a>
	</div>
	
	{foreach from=$COMMENTS item="comment"}
		  <h2>{php}t("Posted by"){/php} {$comment.email|escape:"htmlall"}
		  {php}t("on"){/php} {$comment.received|date_format:"%B %d, %Y"}:</h2>
			{$comment.comment|nl2br}
	{/foreach}	
	
</div>