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
		<div class="col1">{translate s="Aka"}:</div>
		<div class="col2-2">{$indiv->aka}</div>
	{/if}
	<div class="col1">{translate s="Gender"}:</div>
	<div class="col2">{$indiv->gender}</div>
	<div class="col3">&nbsp;</div>
	<div class="col1">{translate s="Father"}:</div>
	<div class="col2-2">{$father_link}</div>
	<div class="col1">{translate s="Mother"}:</div>
  <div class="col2-2">{$mother_link}</div>
	{foreach from=$events item=event}
		<div class="col1">{translate s=$event->type}:</div>
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
	{if $indiv->notes}
		<div class="col1">{translate s="Notes"}:</div>
		<div class="col2-2">{$indiv->notes}</div>
	{/if}
	{foreach from=$marriages item=marriage}
		<br />
		<p class="content-subtitle">{$marriage.family_number}</p>
		<div class="col1">{translate s="Spouse/Partner"}:</div>
		<div class="col2">{$marriage.spouse_link}</div>
		<div class="col3">
			{if $marriage.spouse->birth->date}
				{translate s=b.} {$marriage.spouse->birth->date}
			{/if}
			{if $marriage.spouse->death->date}
				{translate s=d.} {$marriage.spouse->death->date}
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
			<div class="col1">{translate s="Notes"}:</div>
			<div class="col2-2">{$marriage.notes}</div>
		{/if}
		{if $marriage.child_count > 0}
			<br />
			<div class="col1">{translate s="Children"}:</div>
			{foreach name=children from=$marriage.children item=child}
				{if $smarty.foreach.children.iteration != 1}
					<div class="col1">&nbsp;</div>
				{/if}
				<div class="col2">
					{$child.child_link}
				</div>
				<div class="col3">
					{if $child.child->birth->date}
						{translate s=b.} {$child.child->birth->date}
					{/if}
					{if $child.child->death->date}
						{translate s=d.} {$child.child->death->date}
					{/if}
				</div>
			{/foreach}
		{/if}
	{/foreach}
	{if $source_count > 0}
		<br />
		<p class="content-subtitle">{translate s="Source Citations"}</p>	
		<ol>
			{foreach name=sources from=$sources item=source}
				<li><a name="s{$smarty.foreach.sources.iteration}"></a>{$source}</li>
			{/foreach}
		</ol>
	{/if}
</div>