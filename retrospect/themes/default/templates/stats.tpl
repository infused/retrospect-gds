<!--
/**
*	Stats sub-template
* $Id$
*/
-->
<div class="content-title">{$content_title}</div>

<div class="col1">{translate s="Surnames"}:</div>
<div class="col2-2">{$cnt_surnames|number_format}</div>

<br />
<div class="col1">{translate s="Individuals"}:</div>
<div class="col2-2">{$cnt_indiv|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Male"}:</div>
<div class="col2-2">{$cnt_indiv_male|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Female"}:</div>
<div class="col2-2">{$cnt_indiv_female|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Unknown"}:</div>
<div class="col2-2">{$cnt_indiv_unknown|number_format}</div>

<br />
<div class="col1">{translate s="Families"}:</div>
<div class="col2-2">{$cnt_families|number_format}</div>

<br />
<div class="col1">{translate s="Events"}:</div>
<div class="col2-2">{$cnt_events|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Birth"}:</div>
<div class="col2-2">{$cnt_events_birth|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Death"}:</div>
<div class="col2-2">{$cnt_events_death|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Marriage"}:</div>
<div class="col2-2">{$cnt_events_marriage|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Other"}:</div>
<div class="col2-2">{$cnt_events_other|number_format}</div>

<br />
<div class="col1">{translate s="Notes"}:</div>
<div class="col2-2">{$cnt_notes|number_format}</div>

<br />
<div class="col1">{translate s="Sources"}:</div>
<div class="col2-2">{$cnt_sources|number_format}</div>

<div class="col1">&nbsp;&nbsp;&nbsp;{translate s="Citations"}:</div>
<div class="col2-2">{$cnt_citations|number_format}</div>