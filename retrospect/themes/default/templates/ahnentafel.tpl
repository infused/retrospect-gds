{*
	/** 
	*	Ahnentafel sub-template
	* $Id$
	*
	*/
*}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	{foreach from=$individuals item=indivstrings}
		{$indivstrings}
	{/foreach}
</div>