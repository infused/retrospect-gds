{*
	/** 
	*	Pedigree sub-template
	* $Id$
	*
	*/
*}
<h1>{$content_title}</h1>
{include file="nav.tpl"}
<div class="tab-page">
	
	<!-- Begin pedigree boxes -->
	<div class="pedbox" style="z-index:3; left:{$col1}px; top:417px;">{include file="pedigree.indiv.tpl" indiv="$individuals[1]"}</div>
	<div class="pedbox" style="z-index:4; left:{$col2}px; top:292px;">{include file="pedigree.indiv.tpl" indiv="$individuals[2]"}</div>
	<div class="pedbox" style="z-index:5; left:{$col2}px; top:552px;">{include file="pedigree.indiv.tpl" indiv="$individuals[3]"}</div>
	<div class="pedbox" style="z-index:6; left:{$col3}px; top:227px;">{include file="pedigree.indiv.tpl" indiv="$individuals[4]"}</div>
	<div class="pedbox" style="z-index:7; left:{$col3}px; top:357px;">{include file="pedigree.indiv.tpl" indiv="$individuals[5]"}</div>
	<div class="pedbox" style="z-index:8; left:{$col3}px; top:487px;">{include file="pedigree.indiv.tpl" indiv="$individuals[6]"}</div>
	<div class="pedbox" style="z-index:9; left:{$col3}px; top:617px;">{include file="pedigree.indiv.tpl" indiv="$individuals[7]"}</div>
	<div class="pedbox" style="z-index:10; left:{$col4}px; top:195px;">{include file="pedigree.indiv.tpl" indiv="$individuals[8]"}</div>
	<div class="pedbox" style="z-index:11; left:{$col4}px; top:260px;">{include file="pedigree.indiv.tpl" indiv="$individuals[9]"}</div>
	<div class="pedbox" style="z-index:12; left:{$col4}px; top:325px;">{include file="pedigree.indiv.tpl" indiv="$individuals[10]"}</div>
	<div class="pedbox" style="z-index:13; left:{$col4}px; top:390px;">{include file="pedigree.indiv.tpl" indiv="$individuals[11]"}</div>
	<div class="pedbox" style="z-index:14; left:{$col4}px; top:455px;">{include file="pedigree.indiv.tpl" indiv="$individuals[12]"}</div>
	<div class="pedbox" style="z-index:15; left:{$col4}px; top:520px;">{include file="pedigree.indiv.tpl" indiv="$individuals[13]"}</div>
	<div class="pedbox" style="z-index:16; left:{$col4}px; top:585px;">{include file="pedigree.indiv.tpl" indiv="$individuals[14]"}</div>
	<div class="pedbox" style="z-index:17; left:{$col4}px; top:650px;">{include file="pedigree.indiv.tpl" indiv="$individuals[15]"}</div>
	<!-- End pedigree boxes -->
	
	<!-- Begin connecting lines -->
	<!-- 1 to 2 and 3-->
	<div class="pedconnect_top" style="height:115px; left:{$con1}px; top:323px;"></div>
	<div class="pedconnect_bot" style="height:115px; left:{$con1}px; top:468px;"></div>
  
  <!-- 2 -> 4 and 5 -->
	<div class="pedconnect_top" style="height:50px; left:{$con2}px; top:256px;"></div>
	<div class="pedconnect_bot" style="height:50px; left:{$con2}px; top:338px;"></div>
  
  <!-- 3 to 6 and 7 -->
  <div class="pedconnect_top" style="height:50px; left:{$con2}px; top:517px;"></div>
  <div class="pedconnect_bot" style="height:50px; left:{$con2}px; top:599px;"></div>
  
  <!-- 4 to 8 and 9 -->
  <div class="pedconnect_top" style="height:50px; left:{$con3}px; top:215px;"></div>
  <div class="pedconnect_bot" style="height:50px; left:{$con3}px; top:250px;"></div>
  
  <!-- 5 to 10 and 11 -->
  <div class="pedconnect_top" style="height:50px; left:{$con3}px; top: 345px;"></div>
  <div class="pedconnect_bot" style="height:50px; left:{$con3}px; top: 380px;"></div>
  
  <!-- 6 to 12 and 13 -->
  <div class="pedconnect_top" style="height:50px; left:{$con3}px; top: 475px;"></div>
  <div class="pedconnect_bot" style="height:50px; left:{$con3}px; top: 510px;"></div>
  
  <!-- 7 to 14 and 15 -->
  <div class="pedconnect_top" style="height:50px; left:{$con3}px; top: 605px;"></div>
  <div class="pedconnect_bot" style="height:50px; left:{$con3}px; top: 640px;"></div>
	<!-- End connecting lines -->
	
	<!-- Begin continuation links -->
	{if $parents[8]}
		<a class="pedtab" style="left:{$col5}px; top:205px;" href="?m=pedigree&id={$individuals[8]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[9]}
		<a class="pedtab" style="left:{$col5}px; top:270px;" href="?m=pedigree&id={$individuals[9]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[10]}
    <a class="pedtab" style="left:{$col5}px; top:335px;" href="?m=pedigree&id={$individuals[10]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[11]}
    <a class="pedtab" style="left:{$col5}px; top:400px;" href="?m=pedigree&id={$individuals[11]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[12]}
    <a class="pedtab" style="left:{$col5}px; top:465px;" href="?m=pedigree&id={$individuals[12]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[13]}
    <a class="pedtab" style="left:{$col5}px; top:530px;" href="?m=pedigree&id={$individuals[13]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[14]}
    <a class="pedtab" style="left:{$col5}px; top:595px;" href="?m=pedigree&id={$individuals[14]->indkey}">&nbsp;</a>
	{/if}
	{if $parents[15]}
    <a class="pedtab" style="left:{$col5}px; top:660px;" href="?m=pedigree&id={$individuals[15]->indkey}">&nbsp;</a>
	{/if}
  <!-- End continuation links -->
	<!-- Begin content padding -->
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br />
	<!-- End content padding -->
</div>