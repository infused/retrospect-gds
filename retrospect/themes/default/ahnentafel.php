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
	* @access public
	*/
	require_once('core/atree.class.php');
	
	/**
	* Require report functions
	* @access public
	*/	
	require_once('core/f_report.php');
	
	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	$g_max_gens = isset($_GET['max_gens']) ? $_GET['max_gens'] : 250;
	
	# initialize other variables
	$g_generation = 0;	# current generation
	# get first person information
	$o = new Person($g_indiv);
	# instantiate new tree
	$tree = new ATree($g_indiv);
	# fill tree with ancestors
	$tree->fill_tree($g_max_gens);
	# get root node and traverse tree
	# each node of the tree is passed to the display_indiv function
	$root = $tree->get_node_at_index(0);

	# title
	$g_title = sprintf(_("Ahnentafel Report for %s"), $o->name);

	# name and menu
	echo '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { echo ', '.$o->title; }
	echo '</p>';
	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
	echo '<p class="content-subtitle">'._("Ahnentafel Report").'</p>';
	
	$tree->level_order_traversal($root, 'display_indiv');
	unset($root);
	unset($tree);
	unset($o);

	/**
	* Display individual
	* @access public
	* @param string $p_node
	* @param integer $p_generation
	*/
	function display_indiv($p_node, $p_generation) { 
		global $g_generation, $g_content;
		$father = null;
		$mother = null;
		if ($p_node->father_indkey) { $father = new Person($p_node->father_indkey, 3); }
		if ($p_node->mother_indkey) { $mother = new Person($p_node->mother_indkey, 3); }
		if ($p_generation > $g_generation ) {
			$g_generation = $p_generation;
			# display generation if it changed	
			echo '<h3>'.sprintf(_("Generation %s"), $g_generation).'</h3>';
		}
		echo '<ol><li value='.$p_node->ns_number.'">';
		# display ahnentafel number and name
		echo '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$p_node->indkey.'">'.$p_node->name.'</a>'; 
		# display parents
		echo get_parents_sentence($p_node, $father, $mother).'<br />';
		# display birth sentence
		echo get_birth_sentence($p_node);
		# display marriage sentence(s)
		echo get_marriage_sentences($p_node);
		# display death sentence
		echo get_death_sentence($p_node);
		echo '</li></ol>';
	}
?>