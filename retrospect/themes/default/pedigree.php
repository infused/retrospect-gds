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
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	
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
	$smarty->assign('page_title', sprintf(gtc("Family Page for %s"), $o->name));
	$smarty->assign('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
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
		keyword_push($p_node->name);
		
		$g_node_indkey[$p_node->ns_number] = $p_node->indkey;
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			$g_node_parents[$p_node->ns_number] = true;
		}
		else { $g_node_parents[$p_node->ns_number] = false; }

		$g_nodes[$p_node->ns_number] = $p_node;
	}
	$smarty->assign('individuals', $g_nodes);
	$smarty->assign('parents', $g_node_parents);

?>