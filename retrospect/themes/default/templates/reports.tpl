{*
	/** 
	*	Reports sub-template
	* $Id$
	*
	*/
*}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	<!-- Begin family reports -->
	<p class="content-subtitle">{php}t("Family Reports"){/php}</p>
	<a href="{$php_self}?option=family_pdf&amp;id={$indiv->indkey}">{php}t("Family PDF"){/php}</a>
	<!-- End family reports -->
	
	<!-- Begin pedigree reports -->
	<p class="content-subtitle">{php}t("Pedigree Reports"){/php}</p>
	<a href="{$php_self}?option=pedigree_pdf&amp;id={$indiv->indkey}">{php}t("Pedigree PDF"){/php}</a>
	<!-- End pedigree reports -->
	
	<!-- Begin ancestor reports -->
	<p class="content-subtitle">{php}t("Ancestor Reports"){/php}</p>
	<form name="form_change_report" method="get" action="">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="125">
					<select name="option" class="listbox">
						<option value="ahnentafel">{php}t("Ahnentafel"){/php}</option>
						<option value="ahnentafel_pdf">{php}t("Ahnentafel PDF"){/php}</option>
					</select>
				</td>
				<td class="text">&nbsp;&nbsp;{php}t("Number of Generations"){/php}:&nbsp;</td>
				<td>
					<input name="id" type="hidden" value="{$indiv->indkey}" />
					<input name="g" type="text" class="textbox" value="250" size="3" />
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td><input name="a" type="submit" class="text" value="{php}t("Apply"){/php}" /></td>
			</tr>
		</table>
	</form>
	<!-- End ancestor reports -->
	
	<!-- Begin descendant reports-->
	<p class="content-subtitle">{php}t("Descendant Reports"){/php}</p>
	<form name="form_change_report" method="get" action="">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="125">
					<select name="option" class="listbox">
						<option value="descendant">{php}t("Descendant"){/php}</option>
						<option value="descendant_pdf">{php}t("Descendant PDF"){/php}</option>
					</select>
				</td>
				<td class="text">&nbsp;&nbsp;{php}t("Number of Generations"){/php}:&nbsp;</td>
				<td>
					<input name="id" type="hidden" value="{$indiv->indkey}" />
					<input name="g" type="text" class="textbox" value="250" size="3" />
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td><input name="a" type="submit" class="text" value="{php}t("Apply"){/php}" /></td>
			</tr>
		</table>
	</form>
	<!-- End descendant reports-->
</div>