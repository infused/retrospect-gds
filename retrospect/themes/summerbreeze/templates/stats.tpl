<!--
/**
*	Stats sub-template
* $Id$
*/
-->
<h1>{$content_title}</h1>

<table cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="label">{php}t("Surnames"){/php}:</td>
    <td class="fact2">{$cnt_surnames|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Individuals"){/php}:</td>
    <td class="fact2">{$cnt_intd|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Male"){/php}:</td>
    <td class="fact2">{$cnt_intd_male|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Female"){/php}:</td>
    <td class="fact2">{$cnt_intd_female|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Unknown"){/php}:</td>
    <td class="fact2">{$cnt_intd_unknown|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Families"){/php}:</td>
    <td class="fact2">{$cnt_families|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Events"){/php}:</td>
    <td class="fact2">{$cnt_events|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Birth"){/php}:</td>
    <td class="fact2">{$cnt_events_birth|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Death"){/php}:</td>
    <td class="fact2">{$cnt_events_death|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Marriage"){/php}:</td>
    <td class="fact2">{$cnt_events_marriage|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Other"){/php}:</td>
    <td class="fact2">{$cnt_events_other|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Notes"){/php}:</td>
    <td class="fact2">{$cnt_notes|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Sources"){/php}:</td>
    <td class="fact2">{$cnt_sources|number_format}</td>
  </tr>
  <tr>
    <td class="label">&nbsp;&nbsp;&nbsp;{php}t("Citations"){/php}:</td>
    <td class="fact2">{$cnt_citations|number_format}</td>
  </tr>
  <tr>
    <td class="label">{php}t("Comments"){/php}</td>
    <td class="fact2">{$cnt_comments|number_format}</td>
  </tr>
</table>