<!-- 
/**
*	Menu sub-template
* $Id$
*/
-->
<div class="menu-item"><a href="index.php">Home</a></div>
<br />
<div class="menu-title">{php}t("Database"){/php}</div>
<div class="menu-item">
	<a href="{$php_self}?m=search">{php}t("Search"){/php}</a>
</div>
<div class="menu-item">
	<a href="{$php_self}?m=surnames">{php}t("Surname List"){/php}</a>
</div>
<div class="menu-item">
	<a href="{$php_self}?m=stats">{php}t("Statistics"){/php}</a>
</div>
<br />
<div class="menu-title">{php}t("Language"){/php}</div>
<form name="form_change_lang" method="post" action="{$CURRENT_PAGE}">
	<select name="lang" size="1" class="listbox" id="lang" onchange="document.forms.form_change_lang.submit();">
	{html_options output=$lang_names values=$lang_codes selected=$lang}
	</select>
</form>