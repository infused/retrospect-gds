{*
	/** 
	*	Commentadd sub-template
	* $Id$
	*
	*/
*}
{if $SAVED}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
<div align="right"><a href="{$PHP_SELF}?m=comments&amp;id={$indiv->indkey}">< {php}t("Return to comment list"){/php} ></a></div>
<p>
{php}t("The comment you submitted is shown below."){/php}&nbsp;&nbsp; 
{php}t("Please note that it will not be visible in the comment list until it has been reviewed and approved by an administrator."){/php}
</p>
<div class="comment">
			{php}t("From"){/php}: {$smarty.post.email|escape:"htmlall"}<br />
			<br />
			{$comment_preview|nl2br}
		</div>
</div>
{else}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	<div align="right"><a href="{$PHP_SELF}?m=comments&amp;id={$indiv->indkey}">&lt; {php}t("Return to comment list"){/php} &gt;</a></div>
	<form action="{$PHP_SELF}?m=commentadd&amp;id={$indiv->indkey}" method="post" name="commentform" id="commentform">
		<label for="email"><b>{php}t("Your email address"){/php}:</b></label><br />
		<input class="textbox" id="email" name="email" type="text" size="40" value="{$smarty.post.email}" />
		<div style="color: red; margin-top: 3px;">{$form_errors.email}</div>
		<br />
		<label for="comment"><b>{php}t("Your comments"){/php}:</b></label><br />
		<textarea id="comment" name="comment" cols="80" rows="15" class="textbox">{$smarty.post.text}</textarea>
		<p>{php}t("You can add links to your comment by enclosing them within square brackets. Examples:"){/php}<br />
		&emsp;[http://www.google.com] = <a href="http://www.google.com">www.google.com</a><br />
		&emsp;[http://www.google.com|Google] = <a href="http://www.google.com">Google</a></p>
		<div style="color: red; margin-top: 3px;">{$form_errors.comment}</div>
		<br />
		<input class="text" type="submit" name="Submit" value="{php}t("Submit"){/php}" />
	</form>
</div>
{/if}