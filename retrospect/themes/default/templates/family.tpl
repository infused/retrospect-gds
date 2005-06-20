{*
	/** 
	*	Family sub-template
	* $Id$
	*
	*/
*}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	{if $indiv->aka}
		<div class="col1">{php}t("Aka"){/php}:</div>
		<div class="col2-2">{$indiv->aka}</div>
	{/if}
	<div class="col1">{php}t("Gender"){/php}:</div>
	<div class="col2">{translate s=$indiv->gender}</div>
	<div class="col3">&nbsp;</div>
	<div class="col1">{php}t("Father"){/php}:</div>
	<div class="col2-2">{$father_link|default:"&nbsp;"}</div>
	<div class="col1">{php}t("Mother"){/php}:</div>
  <div class="col2-2">{$mother_link|default:"&nbsp;"}</div>
	{foreach from=$events item=event}
		<div class="col1">{translate s=$event->type}:</div>
		<div class="col2">{$event->date}</div>
		<div class="col3">
			{if $event->comment}<i>{$event->comment}</i>{if $event->place} / {/if}{/if}
			{$event->place}
			{foreach from=$event->sources item=source}
				{counter assign=source_count print=no}
				<sup><a href="#s{$source_count}">{$source_count}</a></sup> 
			{/foreach}
		</div>
	{/foreach}
	{if $indiv->refn}
		<div class="col1">{php}t("Reference Number"){/php}:</div>
		<div class="col2-2">{$indiv->refn}</div>
	{/if}
	{if $indiv->notes}
		<div class="col1">{php}t("Notes"){/php}:</div>
		<div class="col2-2">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>{$indiv->notes}</td>
				</tr>
			</table>
		</div>
	{/if}
	{foreach from=$marriages item=marriage}
		<br />
		<p class="content-subtitle">{$marriage.family_number}</p>
		<div class="col1">{php}t("Spouse/Partner"){/php}:</div>
		<div class="col2">{$marriage.spouse_link}</div>
		<div class="col3">
			{if $marriage.spouse->birth->date}
				{php}t("b."){/php} {$marriage.spouse->birth->date}
			{/if}
			{if $marriage.spouse->death->date}
				{php}t("d."){/php} {$marriage.spouse->death->date}
			{/if}
		</div>
		{foreach from=$marriage.events item=event}
			<div class="col1">{$event->type}:</div>
			<div class="col2">{$event->date}</div>
			<div class="col3">
				{if $event->comment}{$event->comment}{if $event->place} / {/if}{/if}
				{$event->place}
				{foreach from=$event->sources item=source}
					{counter assign=source_count print=no}
					<sup><a href="#s{$source_count}">{$source_count}</a></sup> 
				{/foreach}
			</div>
		{/foreach}
		{if $marriage.notes}
			<div class="col1">{php}t("Notes"){/php}:</div>
			<div class="col2-2">
			<div class="col2-2">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td>{$marriage->notes}</td>
					</tr>
				</table>
		</div>
		{/if}
		{if $marriage.child_count > 0}
			<br />
			<div class="col1">{php}t("Children"){/php}:</div>
			{foreach name=children from=$marriage.children item=child}
				{if $smarty.foreach.children.iteration != 1}
					<div class="col1">&nbsp;</div>
				{/if}
				<div class="col2">
					{$child.child_link}
				</div>
				<div class="col3">
					{if $child.child->birth->date}
						{php}t("b."){/php} {$child.child->birth->date}
					{/if}
					{if $child.child->death->date}
						{php}t("d."){/php} {$child.child->death->date}
					{/if}
				</div>
			{/foreach}
		{/if}
	{/foreach}
	{if $source_count > 0}
		<br />
		<p class="content-subtitle">{php}t("Source Citations"){/php}</p>	
		<ol>
			{foreach name=sources from=$sources item=source}
				<li><a name="s{$smarty.foreach.sources.iteration}"></a>{$source}</li>
			{/foreach}
		</ol>
	{/if}
</div>