<p class="content-title">{$content_title}</p>
<div class="tab-page">
	{if $indiv->aka}
	<div class="col1">{$label_aka}</div>
	<div class="col2-2">{$indiv->aka}</div>
	{/if}
	<div class="col1">{$label_gender}</div>
	<div class="col2">{$indiv->gender}</div>
</div>