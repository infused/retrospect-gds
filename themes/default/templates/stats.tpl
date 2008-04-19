<!--
/**
*	Stats sub-template
* $Id$
*/
-->
<div class="content-title">{$content_title}</div>

<div class="col1">{php}t("Surnames"){/php}:</div>
<div class="col2-2">{$cnt_surnames|number_format}</div>

<br />
<div class="col1">{php}t("Individuals"){/php}:</div>
<div class="col2-2">{$cnt_indiv|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Male"){/php}:</div>
<div class="col2-2">{$cnt_indiv_male|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Female"){/php}:</div>
<div class="col2-2">{$cnt_indiv_female|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Unknown"){/php}:</div>
<div class="col2-2">{$cnt_indiv_unknown|number_format}</div>

<br />
<div class="col1">{php}t("Families"){/php}:</div>
<div class="col2-2">{$cnt_families|number_format}</div>

<br />
<div class="col1">{php}t("Events"){/php}:</div>
<div class="col2-2">{$cnt_events|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Birth"){/php}:</div>
<div class="col2-2">{$cnt_events_birth|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Death"){/php}:</div>
<div class="col2-2">{$cnt_events_death|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Marriage"){/php}:</div>
<div class="col2-2">{$cnt_events_marriage|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Other"){/php}:</div>
<div class="col2-2">{$cnt_events_other|number_format}</div>

<br />
<div class="col1">{php}t("Notes"){/php}:</div>
<div class="col2-2">{$cnt_notes|number_format}</div>

<br />
<div class="col1">{php}t("Sources"){/php}:</div>
<div class="col2-2">{$cnt_sources|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{php}t("Citations"){/php}:</div>
<div class="col2-2">{$cnt_citations|number_format}</div>

<br />
<div class="col1">{php}t("Comments"){/php}</div>
<div class="col2-2">{$cnt_comments|number_format}</div>