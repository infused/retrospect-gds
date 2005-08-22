<?php 
/**
 * Descendant Report
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
 * @cense http://opensource.org/censes/gpl-cense.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Pubc cense
 * as pubshed by the Free Software Foundation; either version 2
 * of the cense, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the imped warranty of
 * MERCHANTABITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Pubc cense contained in the file GNU.txt for
 * more details.
 *
 * $Id$
 *
 */
 
	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );	
	
	/**
	* Require Atree class
	*/
	require_once(CORE_PATH.'f_report.php');
	
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;
	$g_max_gens = isset($_GET['g']) ? $_GET['g'] : 250;
	
	# init other vars
	$g_descendants = array();
	$g_generation = 0;
	$g_count = 1;
	$individuals = array();

	# get first person information
	$o = new Person($g_indiv, 0, 1);
	array_push($g_descendants, array($o, 1));
	$smarty->assign_by_ref('indiv', $o);

	# assign other smarty variables
	$smarty->assign_by_ref('page_title', sprintf(gtc("Descendant Report for %s"), $o->name));
	$smarty->assign_by_ref('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign_by_ref('content_title', $content_title);
	
	# iterate through the descendants array
	while (count($g_descendants) > 0) {
		display_indiv(array_shift($g_descendants));
	}
	$smarty->assign('individuals', $individuals);
	
	function display_indiv($p_array) {
		global $g_content, $g_descendants, $g_generation, $g_max_gens, $g_count, $individuals;
		$string = '';
		$p_node = $p_array[0];
		$p_generation  = $p_array[1];
		
		$father = ($p_node->father_indkey) ? new Person($p_node->father_indkey, 3) : null;		
		$mother = ($p_node->mother_indkey) ? new Person($p_node->mother_indkey, 3) : null;
		
		if ($p_generation > $g_generation ) $g_generation = $p_generation;
			
		# children
		foreach ($p_node->marriages as $marriage) {
			$spouse = (!empty($marriage->spouse)) ? new Person($marriage->spouse, 3) : null;
			if ($marriage->child_count > 0) {
				$string .= '<br />'."\n";
				$string .= get_children_of_sentence($p_node, $spouse).':<br />';
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
					$child_nk = '<a class="secondary" href="'.$_SERVER['PHP_SELF'].'?m=family&amp;id='.$child->indkey.'">'.$child->name.'</a>';
					
					if ($child->ns_number) {	
						$string .= '<ol><li value="'.$child->ns_number.'">'.$child_nk;
						if (($child->birth && $child->birth->date) || ($child->death && $child->death->date)) { 
							$string .= '&nbsp;&nbsp;'; 
							if ($child->birth && $child->birth->date) $string .= gtc("b.").' '.$child->birth->date.' ';
							if ($child->death && $child->death->date) $string .= gtc("d.").' '.$child->death->date;
						}
						$string .= '</li></ol>';
					} else {
						$string .= '<ul><li class="nobullet">'.$child_nk.'</li></ul>';
					}
				}
			}
		}
		$string .= '</li></ol>';
		
		$individual['generation'] = $p_generation;
		$individual['generation_title'] = sprintf(gtc("Generation %s"), $g_generation);
		$individual['ns_number'] = $p_node->ns_number;
		$individual['name_link'] = '<a href="'.$_SERVER['PHP_SELF'].'?m=family&amp;id='.$p_node->indkey.'">'.$p_node->name.'</a>';
		$individual['parent_sentence'] = get_parents_sentence($p_node, $father, $mother);
		$individual['birth_sentence'] = get_birth_sentence($p_node);
		$individual['marriage_sentence'] = get_marriage_sentences($p_node);
		$individual['death_sentence'] = get_death_sentence($p_node);
		$individual['children_string'] = $string;
		$individuals[] = $individual;
	}
?>