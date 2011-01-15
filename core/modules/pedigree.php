<?php
/**
 * Pedigree Report
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
 */
 
 /**
 * $Id$
 */

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	require_once(CORE_PATH . 'atree.class.php');
	
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;
	
	# populate keyword array
	keyword_push(gtc("Pedigree"));
	keyword_push(gtc("Ancestors"));

	# get first person information
	$o = new Person($g_indiv);
	$smarty->assign('indiv', $o);

	# initialize other variables
	$g_node_indkey = array();
	$g_node_strings = array();
	$g_node_parents = array();
	$g_max_gens = 4;
	
	# assign other smarty variables
	$smarty->assign('page_title', sprintf(gtc("Family Page for %s"), $o->full_name()));
	$smarty->assign('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->full_name();
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign('content_title', $content_title);

	# instantiate new tree
	$tree = new ATree($g_indiv);
	# fill tree with ancestors
	$tree->fill_tree(4);
	# get root node and traverse tree
	# each node of the tree is passed to the display_indiv function
	$root = $tree->get_node_at_index(0);
	$tree->level_order_traversal($root, 'process_indiv');
	
	function process_indiv($p_node) {
		global $g_node_strings, $g_node_parents, $g_node_indkey, $g_nodes;
		
		# populate keyword array
		keyword_push($p_node->full_name());
		
		$g_node_indkey[$p_node->ns_number] = $p_node->indkey;
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			$g_node_parents[$p_node->ns_number] = true;
		}
		else { $g_node_parents[$p_node->ns_number] = false; }

		$g_nodes[$p_node->ns_number] = $p_node;
	}
	$smarty->assign('individuals', $g_nodes);
	$smarty->assign('parents', $g_node_parents);
	
	# box and connector positions
  $smarty->assign('col1', 35);
  $smarty->assign('con1', 35 + 85);
  
  $smarty->assign('col2', 210);
  $smarty->assign('con2', 210 + 85);
  
  $smarty->assign('col3', 385);
  $smarty->assign('con3', 385 + 85);
  
  $smarty->assign('col4', 560);
  
  $smarty->assign('col5', 730);
?>