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
	<!-- Begin ancestor reports -->
	<h2>{php}t("Ancestor Reports"){/php}</h2>
	<form name="form_change_report" method="get" action="">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="125">
					<select name="m" class="listbox">
						<option value="ahnentafel">{php}t("Ahnentafel"){/php}</option>
						<!-- <option value="ahnentafel_pdf">{php}t("Ahnentafel PDF"){/php}</option> -->
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
						<!-- <option value="descendant_pdf">{php}t("Descendant PDF"){/php}</option> -->
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
	
	<!-- Other -->
	<h2>{php}t("Other"){/php}</h2>
	<ul>
	 <li><a href="{$php_self}?m=relcalc&amp;id={$indiv->indkey}">Relationship Calculator</a></li>
	</ul>
	
</div>