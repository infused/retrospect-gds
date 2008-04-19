<div id="quickstats">
	<div class="header">Database Stats</div>
	<br />
	<div class="label">Individuals:</div><div class="value">{$DB_COUNT_INDIV|number_format}</div>
	<div class="label">Families:</div><div class="value">{$DB_COUNT_FAMILY|number_format}</div>
	<div class="label">Events:</div><div class="value">{$DB_COUNT_FACT|number_format}</div>
	<div class="label">Notes:</div><div class="value">{$DB_COUNT_NOTE|number_format}</div>
	<div class="label">Sources:</div><div class="value">{$DB_COUNT_SOURCE|number_format}</div>
	<div class="label">Citations:</div><div class="value">{$DB_COUNT_CITATION|number_format}</div>
	<br />
	<div class="label">Comments:</div><div class="value">{$DB_COUNT_COMMENT|number_format}</div>

</div>
<div id="notifications">Notifications:
	<ol>{foreach from=$notify item="message"}<li>{$message}</li>{/foreach}</ol>
</div>