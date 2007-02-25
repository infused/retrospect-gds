<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	{if $other_indiv}
		{if $relationship}
			<p><a href="?m=family&id={$other_indiv->indkey}">{$other_indiv->full_name()}</a> is {$indiv->full_name()}'s {$relationship}.</p>
			<p>Common ancestors are:</p>
			<ul>
			{foreach from=$common_ancestors item=ancestor}
				<li><a href="?m=family&id={$ancestor->indkey}">{$ancestor->full_name()}</a></li>
			{/foreach}
			</ul>
		{else}
			{if $indiv->indkey == $other_indiv->indkey}
			They are the same person.<BR>
			{else}
				{$indiv->name}	and <a href="?m=family&id={$other_indiv->indkey}">{$other_indiv->name}</a> are not related.<BR>
			{/if}
		{/if}
	{/if}
	<br />
	<p>
  	<form action="?" method="get">
  		<input type="hidden" name="m" value="relcalc">
  		<input type="hidden" name="id" value="{$indiv->indkey}">
  		Individual Number: <input type="text" name="other_id" value="{$other_indiv->indkey}">
  		<input type="submit" value="Calculate">
  	</form>
  </p>
</div>