{*
	/** 
	*	Pedigree sub-template
	* $Id$
	*
	*/
*}
<div class="content-title">{$content_title}</div>
{include file="nav.tpl"}
<div class="tab-page">
	<!-- Begin pedigree boxes -->
	<div class="pedbox" style="z-index:3;  left: 240px; top: 387px;">{include file="pedigree.indiv.tpl" indiv="$individuals[1]"}</div>
	<div class="pedbox" style="z-index:4;  left: 370px; top: 262px;">{include file="pedigree.indiv.tpl" indiv="$individuals[2]"}</div>
	<div class="pedbox" style="z-index:5;  left: 370px; top: 522px;">{include file="pedigree.indiv.tpl" indiv="$individuals[3]"}</div>
	<div class="pedbox" style="z-index:6;  left: 530px; top: 197px;">{include file="pedigree.indiv.tpl" indiv="$individuals[4]"}</div>
	<div class="pedbox" style="z-index:7;  left: 530px; top: 327px;">{include file="pedigree.indiv.tpl" indiv="$individuals[5]"}</div>
	<div class="pedbox" style="z-index:8;  left: 530px; top: 457px;">{include file="pedigree.indiv.tpl" indiv="$individuals[6]"}</div>
	<div class="pedbox" style="z-index:9;  left: 531px; top: 587px;">{include file="pedigree.indiv.tpl" indiv="$individuals[7]"}</div>
	<div class="pedbox" style="z-index:10; left: 690px; top: 165px;">{include file="pedigree.indiv.tpl" indiv="$individuals[8]"}</div>
	<div class="pedbox" style="z-index:11; left: 690px; top: 230px;">{include file="pedigree.indiv.tpl" indiv="$individuals[9]"}</div>
	<div class="pedbox" style="z-index:12; left: 690px; top: 295px;">{include file="pedigree.indiv.tpl" indiv="$individuals[10]"}</div>
	<div class="pedbox" style="z-index:13; left: 690px; top: 360px;">{include file="pedigree.indiv.tpl" indiv="$individuals[11]"}</div>
	<div class="pedbox" style="z-index:14; left: 690px; top: 425px;">{include file="pedigree.indiv.tpl" indiv="$individuals[12]"}</div>
	<div class="pedbox" style="z-index:15; left: 690px; top: 490px;">{include file="pedigree.indiv.tpl" indiv="$individuals[13]"}</div>
	<div class="pedbox" style="z-index:16; left: 690px; top: 555px;">{include file="pedigree.indiv.tpl" indiv="$individuals[14]"}</div>
	<div class="pedbox" style="z-index:17; left: 690px; top: 620px;">{include file="pedigree.indiv.tpl" indiv="$individuals[15]"}</div>
	<!-- End pedigree boxes -->
	<!-- Begin connecting lines -->
	<div style="position:absolute; width:200px; height:115px; z-index:1; left: 310px; top: 293px; border-top: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<div style="position:absolute; width:200px; height:134px; z-index:1; left: 440px; top: 226px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<div style="position:absolute; width:200px; height:115px; z-index:2; left: 310px; top: 438px; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
  <div style="position:absolute; width:200px; height:134px; z-index:2; left: 440px; top: 487px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
  <div style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 187px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<div style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 317px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<div style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 447px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<div style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 577px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>
	<!-- End connecting lines -->
	<!-- Begin continuation links -->
	{if $parents[8]}
		<div class="ped-arrow" style="left: 840px; top: 165px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[8]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[9]}
		<div class="ped-arrow" style="left: 840px; top: 230px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[9]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[10]}
		<div class="ped-arrow" style="left: 840px; top: 295px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[10]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[11]}
		<div class="ped-arrow" style="left: 840px; top: 360px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[11]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[12]}
		<div class="ped-arrow" style="left: 840px; top: 425px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[12]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[13]}
		<div class="ped-arrow" style="left: 840px; top: 490px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[13]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[14]}
		<div class="ped-arrow" style="left: 840px; top: 555px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[14]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	{if $parents[15]}
		<div class="ped-arrow" style="left: 840px; top: 620px;">
			<a href="{$php_self}?m=pedigree&id={$individuals[15]->indkey}"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>
		</div>
	{/if}
	<!-- End continuation links -->
	<!-- Begin content padding -->
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br /><br /><br />
	<!-- End content padding -->
</div>