<?php
/**
 * Ahnentafel Report
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
 */
 
 /**
 * $Id$
 */

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	/**
	* Require Atree class
	*/
	require_once(CORE_PATH.'atree.class.php');
	
	/**
	* Require report functions
	*/	
	require_once(CORE_PATH.'f_report.php');
	
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;
	$g_max_gens = isset($_GET['g']) ? $_GET['g'] : 250;
	
	# populate keyword array
	keyword_push(gtc("Ahnentafel"));
	keyword_push(gtc("Ancestors"));
	
	# initialize other variables
	$g_generation = 0;	# current generation
	$individuals = array();
	
	# get first person information
	$o = new Person($g_indiv);
	$smarty->assign('indiv', $o);
	
	# instantiate new tree and populate with ancestors
	$tree = new ATree($g_indiv);
	$tree->fill_tree($g_max_gens);

	# assign other smarty variables
	$smarty->assign_by_ref('page_title', sprintf(gtc("Ahnentafel Report for %s"), $o->name));
	$smarty->assign_by_ref('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign_by_ref('content_title', $content_title);
	
	# get root node and traverse tree
	# each node of the tree is passed to the process_indiv function
	$root = $tree->get_node_at_index(0);
	$tree->level_order_traversal($root, 'process_indiv');
	$smarty->assign_by_ref('individuals', $individuals);
	unset($root, $tree, $o);
	
	/**
	* @access public
	* @param string $p_node
	* @param integer $p_generation
	*/
	function process_indiv($p_node, $p_generation) { 
		global $g_generation, $individuals;
		$father = ($p_node->father_indkey) ? new Person($p_node->father_indkey, 3) : null;  
		$mother = ($p_node->mother_indkey) ? new Person($p_node->mother_indkey, 3) : null;  
		
		# increment $g_generation if generation has changed
		if ($p_generation > $g_generation ) $g_generation = $p_generation;
		
		$individual['generation'] = $g_generation;
		$individual['generation_title'] = sprintf(gtc("Generation %s"), $g_generation);
		$individual['ns_number'] = $p_node->ns_number;
		$individual['name_link'] = '<a href="'.$_SERVER['PHP_SELF'].'?m=family&amp;id='.$p_node->indkey.'">'.$p_node->name.'</a>';
		$individual['parent_sentence'] = get_parents_sentence($p_node, $father, $mother);
		$individual['birth_sentence'] = get_birth_sentence($p_node);
		$individual['marriage_sentence'] = get_marriage_sentences($p_node);
		$individual['death_sentence'] = get_death_sentence($p_node);
		$individuals[] = $individual;
	}
?>