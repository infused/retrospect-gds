{*
	/** 
	*	Comments sub-template
	* $Id$
	*
	*/
*}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	<div align="right"><a href="{$PHP_SELF}?m=commentadd&amp;id={$indiv->indkey}">< {php}t("Submit a comment"){/php} ></a></div>
	{foreach from=$COMMENTS item="comment"}
		<div class="comment">
			{php}t("From"){/php}: {$comment.email|escape:"htmlall"}<br />
			{php}t("Posted"){/php}: {$comment.received|escape:"htmlall"}<br />
			<br />
			{$comment.comment|escape:"htmlall"|nl2br}
		</div>
	{/foreach}	
</div>