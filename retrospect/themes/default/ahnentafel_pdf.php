<?php 
/**
 * Ahnentafel PDF Report
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
	
	require_once(LIB_PATH.'fpdf/fpdf.php'); 
	require_once(CORE_PATH.'atree.class.php');
	require_once(CORE_PATH.'f_report.php');
	
	$font = 'Helvetica';
	
	# process expected get/post variables
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	$g_max_gens = isset($_GET['max_gens']) ? $_GET['max_gens'] : 250;

	# init other vars
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
	
	/**
	* Extend FPDF class to add header and footer
	* @package theme_default
	* @access public
	*/
	class PDF extends FPDF {
		/**
		* Page header
		* @access public
		*/
		function Header() {
    	global $o, $font;
    	$this->SetFont($font,'BU',12);
			$this->Cell(0, 5, sprintf(_("Ahnentafel Report for %s"), $o->name), 0, 0, 'C');
    	$this->Ln(15);
		}
		
		/**
		* Page footer
		* @access public
		*/
		function Footer() {
    	global $font;
			$this->SetY(-10);
    	$this->SetFont($font,'',8);
    	$this->Cell(0, 4, '©2002-2003 Keith Morrison, Infused Solutions - www.infused.org', 0, 1, 'C', 0, 'http://www.infused.org');
			$this->Cell(0, 4, sprintf(_("Send questions or comments to %s"), 'keithm@infused.org'), 0, 0, 'C', 0, 'mailto:keithm@infused.org');
		}
	}
	
	# Begin PDF Output
	$pdf = new PDF('P', 'mm', 'Letter');
	$pdf->Open();
	$pdf->SetTopMargin(13);
	$pdf->SetLeftMargin(13);
	$pdf->SetRightMargin(10);
	$pdf->SetAutoPageBreak(True, 13);
	$pdf->AddPage();
	$pdf->SetCreator($_SERVER['PHP_SELF']);
	$pdf->SetAuthor('Keith Morrison, keithm@infused.org');
	$pdf->SetTitle(sprintf(_("Ahnentafel Report for %s"), $o->name));
	$pdf->SetSubject(_("Genealogy"));
	
	$tree->level_order_traversal($root, 'display_indiv');

	function display_indiv($p_node, $p_generation) {
		global $pdf, $g_generation, $font;
		$gencol = 13;
		$factcol = 30;
		$father = null;
		$mother = null;
		if ($p_node->father_indkey) { $father = new Person($p_node->father_indkey, 1); }
		if ($p_node->mother_indkey) { $mother = new Person($p_node->mother_indkey, 1); }	
		if ($p_generation > $g_generation ) {
			$g_generation = $p_generation;
			# display generation if it changed	
			$pdf->SetLeftMargin(13);
			$pdf->SetX(0);
			$pdf->SetFont($font, 'BU', 10);
			$pdf->Ln(5);
			$pdf->Cell(0, 5, sprintf(_("Generation %s"), $g_generation), 0, 2, 'C');
			$pdf->Ln(5);
		 }
		$pdf->SetX($gencol);
		$pdf->SetFont($font, '', 9);
		$pdf->Write(5, $p_node->ns_number.'.');
		$pdf->SetLeftMargin($factcol);
		$pdf->SetFont($font, 'B', 9);
		$pdf->Write(5, $p_node->name);
		$pdf->SetFont($font, '', 9);
		$pdf->Write(5, html_entity_decode(strip_tags(get_parents_sentence($p_node, $father, $mother))));
		$pdf->Ln(5);
		$pdf->Write(5, html_entity_decode(strip_tags(get_birth_sentence($p_node))));
		$pdf->Write(5, html_entity_decode(strip_tags(get_marriage_sentences($p_node))));
		$pdf->Write(5, html_entity_decode(strip_tags(get_death_sentence($p_node))));
		$pdf->Ln(10);
		
	}
	
	# End Main Program
	$pdf->Output();
	exit();
?>