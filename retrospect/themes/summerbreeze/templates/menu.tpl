<!-- 
/**
*	Menu sub-template
* $Id$
*/
-->
<a href="index.php">Home</a>
<a href="{$php_self}?m=search">{php}t("Search"){/php}</a>
<a href="{$php_self}?m=surnames">{php}t("Surname List"){/php}</a>
<a href="{$php_self}?m=stats">{php}t("Statistics"){/php}</a>

{if $allow_lang_change == "1"}
<form name="form_change_lang" method="post" action="{$CURRENT_PAGE|escape}">
	<select name="lang" size="1" id="lang" onchange="document.forms.form_change_lang.submit();">
	{html_options output=$lang_names values=$lang_codes selected=$lang}
	</select>
</form>
{/if}