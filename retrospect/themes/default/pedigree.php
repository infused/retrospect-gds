<?php
/**
 * Pedigree Report
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @version			1.0
 * @license http://opensource.org/licenses/gpl-license.php
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details.
 *
 */

	/**
	* @access public
	*/
	require_once('core/atree.class.php');
	
	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;

	# get first person information
	$o = new Person($g_indiv);

	# initialize other variables
	$sources = array();
	$g_node_indkey = array();
	$g_node_strings = array();
	$g_node_parents = array();
	$g_max_gens = 4;
	$g_content_height = 625;
	
	# title
	$g_title = sprintf(_("Pedigree for %s"), $o->name);

	# instantiate new tree
	$tree = new ATree($g_indiv);
	# fill tree with ancestors
	$tree->fill_tree(4);
	# get root node and traverse tree
	# each node of the tree is passed to the display_indiv function
	$root = $tree->get_node_at_index(0);
	$tree->level_order_traversal($root, 'process_indiv');
	
	function process_indiv($p_node) {
		global $g_node_strings, $g_node_parents, $g_node_indkey;
		$g_node_indkey[$p_node->ns_number] = $p_node->indkey;
		$birth = $p_node->birth->date;
		$death = $p_node->death->date;
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			$g_node_parents[$p_node->ns_number] = true;
		}
		else { $g_node_parents[$p_node->ns_number] = false; }
		
		$g_node_strings[$p_node->ns_number]  = '<table width="148" height="58" callpadding="0" cellspacing="0">';
		$g_node_strings[$p_node->ns_number] .= '<tr><td class="pedbox-text" align="left" valign="middle">';
		$g_node_strings[$p_node->ns_number] .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$p_node->indkey.'">'.$p_node->name.'</a><br />';
		$g_node_strings[$p_node->ns_number] .= _("b.").' '.$birth.'<br />';
		$g_node_strings[$p_node->ns_number] .= _("d.").' '.$death.'</td></tr></table>';
	}

	# name and menu
	$g_content = '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
	$g_content .= '</p>';
 	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
	unset($o);

  # pad content div so that footer is below chart
	$g_content .= '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
	$g_content .= '<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />';
	$g_content .= '<br /><br /><br /><br /><br /><br /><br /><br />';	
	
	# chart (individual boxes)
	if (! isset($g_node_strings[1])) { $g_node_strings[1] = ''; }
	$g_content .= '<div class="pedbox" id="Person1" style="position:absolute; width:150px; height:60px; z-index:3; left: 230px; top: 387px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[1].'</div>';
	if (! isset($g_node_strings[2])) { $g_node_strings[2] = ''; }
	$g_content .= '<div class="pedbox" id="Person2" style="position:absolute; width:150px; height:60px; z-index:4; left: 370px; top: 262px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[2].'</div>';
	if (! isset($g_node_strings[3])) { $g_node_strings[3] = ''; }
	$g_content .= '<div class="pedbox" id="Person3" style="position:absolute; width:150px; height:60px; z-index:5; left: 370px; top: 522px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[3].'</div>';
	if (! isset($g_node_strings[4])) { $g_node_strings[4] = ''; }
	$g_content .= '<div class="pedbox" id="Person4" style="position:absolute; width:150px; height:60px; z-index:6; left: 530px; top: 197px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[4].'</div>';
	if (! isset($g_node_strings[5])) { $g_node_strings[5] = ''; }
 	$g_content .= '<div class="pedbox" id="Person5" style="position:absolute; width:150px; height:60px; z-index:7; left: 530px; top: 327px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[5].'</div>';
	if (! isset($g_node_strings[6])) { $g_node_strings[6] = ''; }
	$g_content .= '<div class="pedbox" id="Person6" style="position:absolute; width:150px; height:60px; z-index:8; left: 530px; top: 457px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[6].'</div>';
 	if (! isset($g_node_strings[7])) { $g_node_strings[7] = ''; }
	$g_content .= '<div class="pedbox" id="Person7" style="position:absolute; width:150px; height:60px; z-index:9; left: 531px; top: 587px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[7].'</div>';
	if (! isset($g_node_strings[8])) { $g_node_strings[8] = ''; }
	$g_content .= '<div class="pedbox" id="Person8" style="position:absolute; width:150px; height:60px; z-index:10; left: 690px; top: 165px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[8].'</div>';
  if (! isset($g_node_strings[9])) { $g_node_strings[9] = ''; }
	$g_content .= '<div class="pedbox" id="Person9" style="position:absolute; width:150px; height:60px; z-index:11; left: 690px; top: 230px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[9].'</div>';
	if (! isset($g_node_strings[10])) { $g_node_strings[10] = ''; }
	$g_content .= '<div class="pedbox" id="Person10" style="position:absolute; width:150px; height:60px; z-index:12; left: 690px; top: 295px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[10].'</div>';
 	if (! isset($g_node_strings[11])) { $g_node_strings[11] = ''; }
	$g_content .= '<div class="pedbox" id="Person11" style="position:absolute; width:150px; height:60px; z-index:13; left: 690px; top: 360px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[11].'</div>';
	if (! isset($g_node_strings[12])) { $g_node_strings[12] = ''; }
	$g_content .= '<div class="pedbox" id="Person12" style="position:absolute; width:150px; height:60px; z-index:14; left: 690px; top: 425px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[12].'</div>';
	if (! isset($g_node_strings[13])) { $g_node_strings[13] = ''; }
	$g_content .= '<div class="pedbox" id="Person13" style="position:absolute; width:150px; height:60px; z-index:15; left: 690px; top: 490px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[13].'</div>';
  if (! isset($g_node_strings[14])) { $g_node_strings[14] = ''; }
	$g_content .= '<div class="pedbox" id="Person14" style="position:absolute; width:150px; height:60px; z-index:16; left: 690px; top: 555px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[14].'</div>';
  if (! isset($g_node_strings[15])) { $g_node_strings[15] = ''; }
	$g_content .= '<div class="pedbox" id="Person15" style="position:absolute; width:150px; height:60px; z-index:17; left: 690px; top: 620px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[15].'</div>';

	# chart (connecting lines)	
	$g_content .= '<div id="Lines1" style="position:absolute; width:200px; height:115px; z-index:1; left: 300px; top: 293px; border-top: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	$g_content .= '<div id="Lines2" style="position:absolute; width:200px; height:134px; z-index:1; left: 440px; top: 226px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	$g_content .= '<div id="Lines3" style="position:absolute; width:200px; height:115px; z-index:2; left: 300px; top: 440px; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  $g_content .= '<div id="Lines4" style="position:absolute; width:200px; height:134px; z-index:2; left: 440px; top: 487px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  $g_content .= '<div id="Lines5" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 187px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	$g_content .= '<div id="Lines6" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 317px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	$g_content .= '<div id="Lines7" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 447px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	$g_content .= '<div id="Lines8" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 577px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  $g_content .= '<div id="Parents8" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 165px;">';
		if (isset($g_node_parents[8]) and $g_node_parents[8] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[8].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents9" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 230px;">';
		if (isset($g_node_parents[9]) and $g_node_parents[9] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[9].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents10" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 295px;">';
		if (isset($g_node_parents[10]) and $g_node_parents[10] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[10].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents11" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 360px;">';
		if (isset($g_node_parents[11]) and $g_node_parents[11] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[11].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents12" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 425px;">';
		if (isset($g_node_parents[12]) and $g_node_parents[12] === true) {
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[12].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents13" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 490px;">';
		if (isset($g_node_parents[13]) and $g_node_parents[13] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[13].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents14" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 555px;">';
		if (isset($g_node_parents[14]) and $g_node_parents[14] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[14].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
	$g_content .= '<div id="Parents15" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 620px;">';
		if (isset($g_node_parents[15]) and $g_node_parents[15] === true) { 
			$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$g_node_indkey[15].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0"></a>';
		}
	$g_content .= '</div>';
?>