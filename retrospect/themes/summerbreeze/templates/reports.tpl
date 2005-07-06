{*
	/** 
	*	Reports sub-template
	* $Id$
	*
	*/
*}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	<!-- Begin family reports -->
	<h2>{php}t("Family Reports"){/php}</h2>
	<a target="_blank" href="{$php_self}?m=family_pdf&amp;id={$indiv->indkey}">{php}t("Family PDF"){/php}</a>
	<!-- End family reports -->
	
	<!-- Begin pedigree reports -->
	<h2>{php}t("Pedigree Reports"){/php}</h2>
	<a target="_blank" href="{$php_self}?m=pedigree_pdf&amp;id={$indiv->indkey}">{php}t("Pedigree PDF"){/php}</a>
	<!-- End pedigree reports -->
	
	<!-- Begin ancestor reports -->
	<h2>{php}t("Ancestor Reports"){/php}</h2>
	<form name="form_change_report" method="get" action="">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="125">
					<select name="m" class="listbox">
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
	<h2>{php}t("Descendant Reports"){/php}</h2>
	<form name="form_change_report" method="get" action="">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="125">
					<select name="m" class="listbox">
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