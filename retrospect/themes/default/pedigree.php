<?php
/**
 * Pedigree Report
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @license http://opensource.org/licenses/gpl-license.php
 *
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
 * $Id$
 *
 */

	/**
	* @access public
	*/
	require_once('core/atree.class.php');
	
	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	
	# populate keyword array
	keyword_push(gtc("Pedigree"));
	keyword_push(gtc("Ancestors"));

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
	$g_title = sprintf(gtc("Pedigree for %s"), $o->name);

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
		
		# populate keyword array
		keyword_push($p_node->name);
		
		$g_node_indkey[$p_node->ns_number] = $p_node->indkey;
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			$g_node_parents[$p_node->ns_number] = true;
		}
		else { $g_node_parents[$p_node->ns_number] = false; }
		
		$g_node_strings[$p_node->ns_number]  = '<table width="148" cellpadding="2" cellspacing="0">';
		$g_node_strings[$p_node->ns_number] .= '<tr><td class="pedbox-text" align="left" valign="middle">';
		$g_node_strings[$p_node->ns_number] .= '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$p_node->indkey.'">'.$p_node->name.'</a><br />';
		$g_node_strings[$p_node->ns_number] .= gtc("b.").' '.$p_node->birth->date.'<br />';
		$g_node_strings[$p_node->ns_number] .= gtc("d.").' '.$p_node->death->date.'</td></tr></table>';
	}

  # name and menu
	echo '<p class="content-title">';
	if (!empty($o->prefix)) echo $o->prefix.' ';
	echo $o->name;
	if (!empty($o->suffix)) echo ', '.$o->suffix; 
	echo '</p>';
	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
	unset($o);
	echo '<div class="tab-page">';
	
	# chart (individual boxes)
	if (! isset($g_node_strings[1])) { $g_node_strings[1] = ''; }
	echo '<div class="pedbox" id="Person1" style="position:absolute; width:150px; height:60px; z-index:3; left: 240px; top: 387px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[1].'</div>';
	if (! isset($g_node_strings[2])) { $g_node_strings[2] = ''; }
	echo '<div class="pedbox" id="Person2" style="position:absolute; width:150px; height:60px; z-index:4; left: 370px; top: 262px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[2].'</div>';
	if (! isset($g_node_strings[3])) { $g_node_strings[3] = ''; }
	echo '<div class="pedbox" id="Person3" style="position:absolute; width:150px; height:60px; z-index:5; left: 370px; top: 522px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[3].'</div>';
	if (! isset($g_node_strings[4])) { $g_node_strings[4] = ''; }
	echo '<div class="pedbox" id="Person4" style="position:absolute; width:150px; height:60px; z-index:6; left: 530px; top: 197px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[4].'</div>';
	if (! isset($g_node_strings[5])) { $g_node_strings[5] = ''; }
 	echo '<div class="pedbox" id="Person5" style="position:absolute; width:150px; height:60px; z-index:7; left: 530px; top: 327px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[5].'</div>';
	if (! isset($g_node_strings[6])) { $g_node_strings[6] = ''; }
	echo '<div class="pedbox" id="Person6" style="position:absolute; width:150px; height:60px; z-index:8; left: 530px; top: 457px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[6].'</div>';
 	if (! isset($g_node_strings[7])) { $g_node_strings[7] = ''; }
	echo '<div class="pedbox" id="Person7" style="position:absolute; width:150px; height:60px; z-index:9; left: 531px; top: 587px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[7].'</div>';
	if (! isset($g_node_strings[8])) { $g_node_strings[8] = ''; }
	echo '<div class="pedbox" id="Person8" style="position:absolute; width:150px; height:60px; z-index:10; left: 690px; top: 165px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[8].'</div>';
  if (! isset($g_node_strings[9])) { $g_node_strings[9] = ''; }
	echo '<div class="pedbox" id="Person9" style="position:absolute; width:150px; height:60px; z-index:11; left: 690px; top: 230px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[9].'</div>';
	if (! isset($g_node_strings[10])) { $g_node_strings[10] = ''; }
	echo '<div class="pedbox" id="Person10" style="position:absolute; width:150px; height:60px; z-index:12; left: 690px; top: 295px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[10].'</div>';
 	if (! isset($g_node_strings[11])) { $g_node_strings[11] = ''; }
	echo '<div class="pedbox" id="Person11" style="position:absolute; width:150px; height:60px; z-index:13; left: 690px; top: 360px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[11].'</div>';
	if (! isset($g_node_strings[12])) { $g_node_strings[12] = ''; }
	echo '<div class="pedbox" id="Person12" style="position:absolute; width:150px; height:60px; z-index:14; left: 690px; top: 425px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[12].'</div>';
	if (! isset($g_node_strings[13])) { $g_node_strings[13] = ''; }
	echo '<div class="pedbox" id="Person13" style="position:absolute; width:150px; height:60px; z-index:15; left: 690px; top: 490px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[13].'</div>';
  if (! isset($g_node_strings[14])) { $g_node_strings[14] = ''; }
	echo '<div class="pedbox" id="Person14" style="position:absolute; width:150px; height:60px; z-index:16; left: 690px; top: 555px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[14].'</div>';
  if (! isset($g_node_strings[15])) { $g_node_strings[15] = ''; }
	echo '<div class="pedbox" id="Person15" style="position:absolute; width:150px; height:60px; z-index:17; left: 690px; top: 620px; background-color: #CCCCCC; padding: 0px 2px 0px 2px; overflow: hidden;">'.$g_node_strings[15].'</div>';

	# chart (connecting lines)	
	echo '<div id="Lines1" style="position:absolute; width:200px; height:115px; z-index:1; left: 310px; top: 293px; border-top: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	echo '<div id="Lines2" style="position:absolute; width:200px; height:134px; z-index:1; left: 440px; top: 226px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	echo '<div id="Lines3" style="position:absolute; width:200px; height:115px; z-index:2; left: 310px; top: 440px; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  echo '<div id="Lines4" style="position:absolute; width:200px; height:134px; z-index:2; left: 440px; top: 487px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  echo '<div id="Lines5" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 187px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	echo '<div id="Lines6" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 317px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	echo '<div id="Lines7" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 447px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
	echo '<div id="Lines8" style="position:absolute; width:200px; height:80px; z-index:3; left: 603px; top: 577px; border-top: 2px solid #CCCCCC; border-bottom: 2px solid #CCCCCC; border-left: 2px solid #CCCCCC;"></div>';
  echo '<div id="Parents8" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 165px;">';
		if (isset($g_node_parents[8]) and $g_node_parents[8] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[8].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents9" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 230px;">';
		if (isset($g_node_parents[9]) and $g_node_parents[9] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[9].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents10" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 295px;">';
		if (isset($g_node_parents[10]) and $g_node_parents[10] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[10].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents11" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 360px;">';
		if (isset($g_node_parents[11]) and $g_node_parents[11] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[11].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents12" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 425px;">';
		if (isset($g_node_parents[12]) and $g_node_parents[12] === true) {
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[12].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents13" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 490px;">';
		if (isset($g_node_parents[13]) and $g_node_parents[13] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[13].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents14" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 555px;">';
		if (isset($g_node_parents[14]) and $g_node_parents[14] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[14].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '<div id="Parents15" style="position:absolute; width:20px; height:60px; z-index:1; left: 840px; top: 620px;">';
		if (isset($g_node_parents[15]) and $g_node_parents[15] === true) { 
			echo '<a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&amp;indiv='.$g_node_indkey[15].'"><img src="themes/default/images/r_arrow.gif" width="20" height="60" border="0" alt="" /></a>';
		}
	echo '</div>';
	echo '</div>';
?>