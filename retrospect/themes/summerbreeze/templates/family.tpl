{*
	/** 
	*	Family sub-template
	* $Id$
	*
	*/
*}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	
	<table cellpadding="0" cellspacing="0" width="100%">
	  {if $indiv->aka}
  	  <tr>
  	  	<td class="label">{php}t("Aka"){/php}:</td>
  	  	<td colspan="2" class="fact2">{$indiv->aka}</td>
  	  </tr>
	  {/if}
	  <tr>
	    <td class="label">{php}t("Gender"){/php}:</td>
	    <td colspan="2" class="fact2">{translate s=$indiv->gender}</td>
	  </tr>
	  <tr>
	    <td class="label">{php}t("Father"){/php}:</td>
	    <td colspan="2" class="fact2">{$father_link|default:"&nbsp;"}</td>
	  </tr>
	  <tr>
	    <td class="label">{php}t("Mother"){/php}:</td>
	    <td class="fact2">{$mother_link|default:"&nbsp;"}</td>	    
	  </tr>
	{foreach from=$events item=event}
		<tr>
  		<td class="label">{translate s=$event->type}:</td>
  		<td class="fact1">{$event->date}</td>
  		<td class="fact2">
  			{if $event->comment}<i>{$event->comment}</i>{if $event->place}<br />{/if}{/if}
  			{$event->place}
  			{foreach from=$event->sources item=source}
  				{counter assign=source_count print=no}
  				<span class="citation"><a href="#s{$source_count}">{$source_count}</a></span>
  			{/foreach}
  		</td>
		</tr>
	{/foreach}
	{if $indiv->refn}
		<tr>
  		<td class="label">{php}t("Reference Number"){/php}:</td>
  		<td colspan="2" class="fact2">{$indiv->refn}</td>
  	</tr>
	{/if}
	{if $indiv->notes}
		<tr>
  		<td class="label">{php}t("Notes"){/php}:</td>
  		<td colspan="2" class="fact2">{$indiv->notes}</td>
		</tr>
	{/if}
	</table>

	{foreach from=$marriages item=marriage}
		<h2>{$marriage.family_number}</h2>
		
		<table cellpadding="0" cellspacing="0" width="100%">
		  <tr>
		    <td class="label">{php}t("Spouse/Partner"){/php}:</td>
		    <td class="fact1">{$marriage.spouse_link}</td>
		    <td class="fact2">
		    	{if $marriage.spouse->birth->date}
		    		{php}t("b."){/php} {$marriage.spouse->birth->date}
		    	{/if}
		    	{if $marriage.spouse->death->date}
		    		{php}t("d."){/php} {$marriage.spouse->death->date}
		    	{/if}
		    </td>
		  </tr>
		  {foreach from=$marriage.events item=event}
		  <tr>
		  	<td class="label">{translate s=$event->type}:</td>
		  	<td class="fact1">{$event->date}</td>
		  	<td class="fact2">
		  		{if $event->comment}{$event->comment}{if $event->place}<br />{/if}{/if}
		  		{$event->place}
		  		{foreach from=$event->sources item=source}
		  			{counter assign=source_count print=no}
		  			<span class="citation"><a href="#s{$source_count}">{$source_count}</a></span>
		  		{/foreach}
		  	</td>
		  </tr>
		  {/foreach}
		  {if $marriage.notes}
		  	<tr>
  		  	<td class="label">{php}t("Notes"){/php}:</td>
  		  	<td colspan="2" class="fact2">{$marriage->notes}</td>
		    </tr>
		  {/if}
		  {if $marriage.child_count > 0}
		  <tr>	
		  	<td colspan="3" class="label">{php}t("Children"){/php}:</td>
		  </tr>
		  	{foreach name=children from=$marriage.children item=child}
		  		<tr>
  		  		<td class="label">&nbsp;</td>
  		  		<td class="fact1">{$child.child_link} 
  		  		  <img align="top" src="{$THEME_URL}/images/{$child.child->gender|lower}.gif" alt="{$indiv->gender}" /></td>
  		  		<td class="fact2">
  		  			{if $child.child->birth->date}
  		  				{php}t("b."){/php} {$child.child->birth->date}
  		  			{/if}
  		  			{if $child.child->death->date}
  		  				{php}t("d."){/php} {$child.child->death->date}
  		  			{/if}
  		  		</td>
		  		</tr>
		  	{/foreach}
		  {/if}
		</table>
	{/foreach}
	
	{if $source_count > 0}
		<h2>{php}t("Source Citations"){/php}</h2>	
		<ol>
			{foreach name=sources from=$sources item=source}
				<li><a name="s{$smarty.foreach.sources.iteration}"></a>{$source}</li>
			{/foreach}
		</ol>
	{/if}
</div>