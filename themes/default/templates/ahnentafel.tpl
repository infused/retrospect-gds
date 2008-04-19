{*
	/** 
	*	Ahnentafel sub-template
	* $Id$
	*
	*/
*}
{assign var="generation" value="0"}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	{foreach from=$individuals item=individual}
		{if $individual.generation > $generation}
			{assign var="generation" value=$individual.generation}
			<h3>{$individual.generation_title}</h3>
		{/if}
		<ol>
			<li value="{$individual.ns_number}">
				{$individual.name_link}{$individual.parent_sentence}<br />
				{$individual.birth_sentence}
				{$individual.marriage_sentence}
				{$individual.death_sentence}
			</li>
		</ol>
	{/foreach}
</div>