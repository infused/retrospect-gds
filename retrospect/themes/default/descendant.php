<?php 
/**
 * Descendant Report
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
	require_once('core/f_report.php');
	
	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	$g_max_gens = isset($_GET['max_gens']) ? $_GET['max_gens'] : 250;
	
	# init other vars
	$g_descendants = array();
	$g_generation = 0;
	$g_count = 1;
	
	# get first person information
	$o = new Person($g_indiv, 0, 1);
	array_push($g_descendants, array($o, 1));
	
	function display_indiv($p_array) {
		global $g_content, $g_descendants, $g_generation, $g_max_gens, $g_count;
		$p_node = $p_array[0];
		$p_generation  = $p_array[1];
		if ($p_node->father_indkey) { $father = new Person($p_node->father_indkey, 1); }
		if ($p_node->mother_indkey) { $mother = new Person($p_node->mother_indkey, 1); }
		
		if ($p_generation > $g_generation ) {
			$g_generation = $p_generation;
			$g_content .= '<h3>'.sprintf(_("Generation %s"), $g_generation).'</h3>';
		}
		
		$g_content .= '<ol><li value="'.$p_node->ns_number.'">';
		$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$p_node->indkey.'">'.$p_node->name.'</a>';
		# display parents
		$g_content .= get_parents_sentence($p_node, $father, $mother);
		$g_content .= '<br />';
		# display birth sentence
		$g_content .= get_birth_sentence($p_node);
		# display marriage sentence(s)
		$g_content .= get_marriage_sentences($p_node);
		# display death sentence
		$g_content .= get_death_sentence($p_node);
		$g_content .= '<br />';
		# children
		foreach ($p_node->marriages as $marriage) {
			$spouse = new Person($marriage->spouse, 1);
			if ($marriage->child_count > 0) {
				$g_content .= '<br />';
				$g_content .= get_children_of_sentence($p_node, $spouse).':<br />';
				foreach ($marriage->children as $child_indkey) {
					$child = new Person($child_indkey);
					if ($child->marriage_count > 0) {
						foreach ($child->marriages as $cmarriage) {
							if ($cmarriage->child_count > 0) {
								$child->ns_number = $g_count + 1;
								$child_gen = $p_generation + 1;
								if ($child_gen > $g_max_gens) { break; }
								array_push($g_descendants, array($child, $child_gen));
								$g_count++;
								break;
							}
						}
					}
					$child_link = '<a class="secondary" href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$child->indkey.'">'.$child->name.'</a>';
					$g_content .= '<ol>';
					if ($child->ns_number) {	
						$g_content .= '<li value="'.$child->ns_number.'">';
						$g_content .= $child_link;
						if ($child->birth->date || $child->death->date) { 
							$g_content .= '&nbsp;&nbsp;'; 
							if ($child->birth->date) {
								$g_content .= _("b.").' '.$child->birth->date.' ';
							}
							if ($child->death->date) {
								$g_content .= _("d.").' '.$child->death->date;
							}
						}
						$g_content .= '</li>';
					}
					else {
						$g_content .= $child_link;
					}
					$g_content .= '</ol>';
				}
			}
		}

		$g_content .= '</li></ol>';
	}

	# title
	$g_title = sprintf(_("Descendant Report for %s"), $o->name);
	
	# name and menu
	$g_content = '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
	$g_content .= '</p>';
 	if ($print === false) {	
		include(Theme::getPage($g_theme, 'nav'));
	}
	$g_content .= '<p class="content-subtitle">'._("Descendant Report").'</p>';
	
	while (count($g_descendants) > 0) {
		display_indiv(array_shift($g_descendants));
	}

?>