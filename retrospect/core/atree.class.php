<?php 
/**
 * Ancestor Tree classes
 *
 * This file contains two classes: ATreeNode and ATree
 *
 * These classes are used to build ancestor trees for pedigree and
 * ancestor type reports.
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		genealogy
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
* ATreeNode classs
*
* Represents an ancestor tree node. 
* This class is used by the ATree class.
* @package genealogy
*/
class ATreeNode {
	
	/**
	* The index of this node
	* @var integer
	*/
	var $node_index;

	/**
	* The index of child node
	* @var integer
	*/
	var $child_index;		# index of child node
	
	/**
	* The index of the father's node
	* @var integer
	*/
	var $father_index;

	/**
	* The index of the mother's node
	* @var integer
	*/
	var $mother_index;	

	/**
	* Hold any extra data, typically an object
	* @var mixed
	*/
	var $data;

	/** 
	* Ahnentafel number
	*
	* This is calculated based on the place of the node within the tree.
	* @var integer
	*/
	var $ahnentafel;
	
	/**
	* Generation number
	*
	* This is calculated based on the place of the node within the tree.
	* @var integer
	*/
	var $generation;
	
	/**
	* ATreeNode constructor
	* @param mixed $p_data
	* @param integer $p_child_index Index of the child node to which this node is being attached
	* @param integer $p_node_index This nodes index
	* @param integer $p_generation Generation number of this node
	* @param integer $p_ahnentafel Ahnentafel number of this node
	*/
	function ATreeNode($p_data, $p_child_index, $p_node_index, $p_generation, $p_ahnentafel = null) {
		$this->data = $p_data;
		$this->generation = $p_generation;
		$this->ahnentafel = $p_ahnentafel;
		$this->node_index = $p_node_index;
		$this->child_index = $p_child_index;
		$this->father_index = null;
		$this->father_index = null;
	}
}

/**
* Atree Class
* 
* Represents an ancestor tree.
* To instantiate this class call it with a valid individual's ID number.
*
* Example: 
* <code>
* $tree = new ATree('I100');
* </code>
* @package genealogy
*/
class ATree {
	/**
	* Array of {@link ATreeNode}
	* @var array
	*/
	var $nodes;
	
	/**
	* Index of root node
	*
	* This is always equal to 0
	* @var integer
	*/
	var $root_index;
	
	/**
	* Index of current node
	* @var integer
	*/
	var $current_index;
	
	/**
	* ATree Constructor
	*
	* Initializes the ATree
	*	@param mixed $p_data
	*/
	function ATree($p_data) {
		# point root_node to the first node
		$this->root_index = 0;
		# create the first node, set ahnentafel number to 1
		$t_node = new ATreeNode($p_data, null, $this->root_index, 1, 1);
		$this->nodes[0] = $t_node;
		# point current_node to the first node
		$this->current_index = $this->root_index;
	}
	
	/**
	* Insert Node
	*
	* Inserts a node into the tree and creates links between individuals.
	* @param mixed $p_data
	* @param ATreeNode $p_child_node 
	* @param string $p_parant_type valid values are 'f' or 'm'
	*/
	function insert_node($p_data, $p_child_node, $p_parent_type) {
		$child_index = $p_child_node->node_index;
		$child_generation = $p_child_node->generation;
		$child_ahnentafel = $p_child_node->ahnentafel;
		
		# set current_index to the new node index
		$this->current_index = count($this->nodes);
		
		# create new node and insert into array
		$ahnentafel = ($p_parent_type == 'f') ? ($child_ahnentafel * 2) : (($child_ahnentafel * 2) + 1);
		$generation = $child_generation + 1;
		$this->nodes[] = new ATreeNode($p_data, $child_index, $this->current_index, $generation, $ahnentafel);
		
		# set childs parent property
		if ($p_parent_type == 'f') {
			$this->nodes[$child_index]->father_index = $this->current_index;
		}
		elseif ($p_parent_type == 'm') {
			$this->nodes[$child_index]->mother_index = $this->current_index;
		}
	}

	/**
	* Get Node At Index
	* 
	* Returns the node at a given index.
	* @param integer $p_index Index of node to get
	* @return ATreeNode
	*/
	function get_node_at_index($p_index) {
		return $this->nodes[$p_index];
	}
	
	/**
	* Get Root Node
	*
	* Returns the root node of the tree
	* @return ATreeNode
	*/
	function get_root_node() {
		return $this->nodes[0];

	}
	
	/**
	* Get Current Node
	* 
	* Returns the currently selected node in the tree
	*	@return ATreeNode
	*/
	function get_current_node() {
		return $this->nodes[$this->current_index];
	}
	
	/**
	* Level-Order Traversal
	*
	* This function tranverses through the tree starting at the root node 
	* and continuing through the tree by level rather than down each branch.
	* At each node, the node is passed out to the callback function.
	*
	* Example:
	* <code>
	* function print_name($name, $generation) {
	*   print $generation.'. '.$name.'<br>';
	* }
	* 
	* level_order_traversal($root_node, 'print_name');
	* </code>
	* @param ATreeNode $p_start_node
	* @param string $p_callback_func String containing the callback function name
	*/
	function level_order_traversal($p_start_node, $p_callback_func) {
		$nodes = array();
		array_push($nodes, $p_start_node);
		
		while (count($nodes) > 0 ) {
			$node = array_shift($nodes);

			# do something with the node here
			$person = new Person($node->data, 1, $node->ahnentafel);
			$p_callback_func($person, $node->generation);
			
			if ($node->father_index != null) {
				$father = $this->get_node_at_index($node->father_index);
				array_push($nodes, $father);
			}			
			
			if ($node->mother_index != null) { 
				$mother = $this->get_node_at_index($node->mother_index);
				array_push($nodes, $mother);
			}
		}
	}
	
	/**
	* Fill Tree
	* 
	* Fills the tree with the ancestors of the root node
	* @param integer $p_max_depth Maximum number of generations with which to fill the tree
	*/
	function fill_tree($p_max_depth = 250) {
		$nodes = array();
		# get root node
		$node = $this->nodes[0];
		array_push($nodes, $node);
		
		for ($i = 0; $i <  count($nodes); $i++) {
			$node = $nodes[$i];
			# process each person
			$person = new Person($node->data, 1, $node->ahnentafel);
		
			# stop after max_depth reached
			if ($node->generation == $p_max_depth) { break; }

			if ($person->father_indkey != null) { $this->insert_node($person->father_indkey, $node, 'f'); }
			if ($person->mother_indkey != null) { $this->insert_node($person->mother_indkey, $node, 'm'); }
			
			$node = $this->get_node_at_index($node->node_index);

			if ($node->father_index !== null) {
				$father_node = $this->get_node_at_index($node->father_index);
				array_push($nodes, $father_node);
			}
			if ($node->mother_index !== null) { 
				$mother_node = $this->get_node_at_index($node->mother_index);
				array_push($nodes, $mother_node);
			} 
		}
	}
}	

?>