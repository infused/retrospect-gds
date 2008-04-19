{*
	/** 
	*	Commentadd sub-template
	* $Id$
	*
	*/
*}
{if $SAVED}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
<div align="right"><a href="{$PHP_SELF}?m=comments&amp;id={$indiv->indkey}">< {php}t("Return to comment list"){/php} ></a></div>
<p>
{php}t("The comment you submitted is show below."){/php}&nbsp;&nbsp; 
{php}t("Please note that it will not be visible in the comment list until it has been reviewed and approved by an administrator."){/php}
</p>
<div class="comment">
			{php}t("From"){/php}: {$smarty.post.email|escape:"htmlall"}<br />
			<br />
			{$smarty.post.comment|escape:"htmlall"|nl2br}
		</div>
</div>
{else}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	<div align="right"><a href="{$PHP_SELF}?m=comments&amp;id={$indiv->indkey}">< {php}t("Return to comment list"){/php} ></a></div>
	<form action="{$PHP_SELF}?m=commentadd&amp;id={$indiv->indkey}" method="post" name="commentform" id="commentform">
		<label for="from">{php}t("Your email address"){/php}:</label><br />
		<input class="textbox" name="email" type="text" size="40" value="{$smarty.post.email}">
		<div style="color: red; margin-top: 3px;">{$form_errors.email}</div>
		<br />
		<label for="text">{php}t("Your comments"){/php}:</label><br />
		<textarea name="comment" cols="80" rows="15" class="textbox">{$smarty.post.text}</textarea>
		<div style="color: red; margin-top: 3px;">{$form_errors.comment}</div>
		<br />
		<input class="text" type="submit" name="Submit" value="{php}t("Submit"){/php}">
	</form>
</div>
{/if}