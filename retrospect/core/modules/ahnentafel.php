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
 *
 * $Id$
 *
 */

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
	
	# instantiate new tree
	$tree = new ATree($g_indiv);
	
	# fill tree with ancestors
	$tree->fill_tree($g_max_gens);
	
	# get root node and traverse tree
	# each node of the tree is passed to the display_indiv function
	$root = $tree->get_node_at_index(0);

	# assign other smarty variables
	$smarty->assign('page_title', sprintf(gtc("Ahnentafel Report for %s"), $o->name));
	$smarty->assign('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign('content_title', $content_title);

	$tree->level_order_traversal($root, 'display_indiv');
	$smarty->assign('individuals', $individuals);
	unset($root, $tree, $o);
	
	/**
	* Display individual
	* @access public
	* @param string $p_node
	* @param integer $p_generation
	*/
	function display_indiv($p_node, $p_generation) { 
		global $g_generation, $individuals;
		$string = '';
		if ($p_node->father_indkey) { 
			$father = new Person($p_node->father_indkey, 3); 
		} 
		else {
			$father = null;
		}
		if ($p_node->mother_indkey) { 
			$mother = new Person($p_node->mother_indkey, 3); 
		} 
		else {
			$mother = null;
		}
		if ($p_generation > $g_generation ) {
			$g_generation = $p_generation;
			# display generation if it changed	
			$string .= '<h3>'.sprintf(gtc("Generation %s"), $g_generation).'</h3>';
		}
		$string .= '<ol><li value="'.$p_node->ns_number.'">';
		# display ahnentafel number and name
		$string .= '<a href="'.$_SERVER['PHP_SELF'].'?option=family&amp;id='.$p_node->indkey.'">'.$p_node->name.'</a>'; 
		# display parents
		$string .= get_parents_sentence($p_node, $father, $mother).'<br />';
		# display birth sentence
		$string .= get_birth_sentence($p_node);
		# display marriage sentence(s)
		$string .= get_marriage_sentences($p_node);
		# display death sentence
		$string .= get_death_sentence($p_node);
		$string .= '</li></ol>';
		$individuals[] = $string;
	}
?>