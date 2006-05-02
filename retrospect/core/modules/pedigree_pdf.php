<?php
/**
 * Pedigree PDF Report
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
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
	
	require_once(CORE_PATH.'core.php');
	require_once(CORE_PATH.'atree.class.php');
	require_once(LIB_PATH.'fpdf/fpdf.php'); 
	
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;

	# get first person information
	$o = new Person($g_indiv);

	# initialize other variables
	$sources = array();
	$font = 'helvetica';
	$g_node_indkey = array();
	$g_node_strings = array();
	$g_node_parents = array();
	$g_content_height = 625;

	# instantiate new tree
	$tree = new ATree($g_indiv);
	# fill tree with ancestors
	$tree->fill_tree(4);
	# get root node and traverse tree
	# each node of the tree is passed to the display_indiv function
	$root = $tree->get_node_at_index(0);
	$tree->level_order_traversal($root, 'process_indiv');
	
	/**
	* Extend FPDF class to add header and footer
	* @package theme_default
	* @access public
	*/
	class PDF extends FPDF {
		# Page header
		function Header() {
    	global $o, $font;
    	$this->SetFont($font,'BU',12);
			$this->Cell(0, 5, sprintf(gtc("Pedigree for %s"), $o->full_name()), 0, 0, 'C');
    	$this->Ln(15);
		}
		
		# Page footer
		function Footer() {
    	global $font;
			$this->SetY(-10);
    	$this->SetFont($font,'',8);
    	$this->Cell(0, 4, '©2002-2003 Keith Morrison, Infused Solutions - www.infused.org', 0, 1, 'C', 0, 'http://www.infused.org');
			$this->Cell(0, 4, sprintf(gtc("Send questions or comments to %s"), 'keithm@infused.org'), 0, 0, 'C', 0, 'mailto:keithm@infused.org');
		}
	}
	
	function process_indiv($p_node) {
		global $g_node_strings, $g_node_parents, $g_node_indkey;
		$g_node_indkey[$p_node->ns_number] = $p_node->indkey;
		$birth = $p_node->birth->date;
		$death = $p_node->death->date;
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			$g_node_parents[$p_node->ns_number] = true;
		}
		else { 
			$g_node_parents[$p_node->ns_number] = false;
		}
		
		$g_node_strings[$p_node->ns_number][0] = $p_node->full_name();
		$g_node_strings[$p_node->ns_number][1] = gtc("Birth").': '.$p_node->birth->date;
		$g_node_strings[$p_node->ns_number][2] = gtc("Death").': '.$p_node->death->date;
	}
	
	# Begin PDF Output
	$w = 63;
	$top = 28;
	$c1x = 13;
	$c2x = $c1x + $w;
	$c3x = $c2x + $w;
	$c4x = $c3x + $w;
	$c1h = 170;
	$c2h = $c1h / 2;
	$c3h = $c2h / 2;
	$c4h = $c3h / 2;
	$bottom = $top + $c1h;
	
	$pdf = new PDF('L', 'mm', 'Letter');
	$pdf->Open();
	$pdf->SetTopMargin(13);
	$pdf->SetLeftMargin(13);
	$pdf->SetRightMargin(10);
	$pdf->SetAutoPageBreak(True, 13);
	$pdf->AddPage();
	$pdf->SetCreator($_SERVER["PHP_SELF"]);
	$pdf->SetAuthor("Keith Morrison, keithm@infused.org");
	$pdf->SetTitle(sprintf(gtc("Pedigree for %s"), $o->full_name()));
	$pdf->SetSubject(gtc("Genealogy"));
	
	# Person 1
	$pdf->SetY($top);
	$pdf->SetX($c1x);
	$pdf->Cell($w, $c1h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c1h / 2 ) - 6);
	$pdf->SetX($c1x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[1][0]) ? $g_node_strings[1][0] : '', 0, 'L');
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[1][1]) ? $g_node_strings[1][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[1][2]) ? $g_node_strings[1][2] : '', 0, 0, 'L');
	# Person 2
	$pdf->SetY($top);
	$pdf->SetX($c2x);
	$pdf->Cell($w, $c2h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c2h / 2) - 6);
	$pdf->SetX($c2x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[2][0]) ? $g_node_strings[2][0] : '', 0, 'L');
	$pdf->SetX($c2x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[2][1]) ? $g_node_strings[2][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[2][2]) ? $g_node_strings[2][2] : '', 0, 0, 'L');
	# Person 3
	$pdf->SetY($top + $c2h);
	$pdf->SetX($c2x);
	$pdf->Cell($w, $c2h, '', 1, 0, 'L');
	$pdf->SetY($top + $c2h + ($c2h / 2) - 6);
	$pdf->SetX($c2x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[3][0]) ? $g_node_strings[3][0] : '', 0, 'L');
	$pdf->SetX($c2x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[3][1]) ? $g_node_strings[3][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[3][2]) ? $g_node_strings[3][2] : '', 0, 0, 'L');
	# Person 4
	$pdf->SetY($top);
	$pdf->SetX($c3x);
	$pdf->Cell($w, $c3h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c3h / 2) - 6 );
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[4][0]) ? $g_node_strings[4][0] : '', 0, 'L');
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[4][1]) ? $g_node_strings[4][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[4][2]) ? $g_node_strings[4][2] : '', 0, 0, 'L');	
	# Person 5
	$pdf->SetY($top + $c3h);
	$pdf->SetX($c3x);
	$pdf->Cell($w, $c3h, '', 1, 0, 'L');
	$pdf->SetY($top + $c3h + ($c3h / 2) - 6);
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[5][0]) ? $g_node_strings[5][0] : '', 0, 'L');
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[5][1]) ? $g_node_strings[5][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[5][2]) ? $g_node_strings[5][2] : '', 0, 0, 'L');
	# Person 6
	$pdf->SetY($top + ($c3h * 2));
	$pdf->SetX($c3x);
	$pdf->Cell($w, $c3h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c3h * 2) + ($c3h / 2) - 6);
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[6][0]) ? $g_node_strings[6][0] : '', 0, 'L');
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[6][1]) ? $g_node_strings[6][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[6][2]) ? $g_node_strings[6][2] : '', 0, 0, 'L');
	# Person 7
	$pdf->SetY($top + ($c3h * 3));
	$pdf->SetX($c3x);
	$pdf->Cell($w, $c3h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c3h * 3) + ($c3h / 2) - 6);
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[7][0]) ? $g_node_strings[7][0] : '', 0, 'L');
	$pdf->SetX($c3x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[7][1]) ? $g_node_strings[7][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[7][2]) ? $g_node_strings[7][2] : '', 0, 0, 'L');
	# Person 8
	$pdf->SetY($top);
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[8][0]) ? $g_node_strings[8][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[8][1]) ? $g_node_strings[8][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[8][2]) ? $g_node_strings[8][2] : '', 0, 0, 'L');
	# Person 9
	$pdf->SetY($top + $c4h);
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + $c4h + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[9][0]) ? $g_node_strings[9][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[9][1]) ? $g_node_strings[9][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[9][2]) ? $g_node_strings[9][2] : '', 0, 0, 'L');
	# Person 10
	$pdf->SetY($top + ($c4h * 2));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 2) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[10][0]) ? $g_node_strings[10][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[10][1]) ? $g_node_strings[10][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[10][2]) ? $g_node_strings[10][2] : '', 0, 0, 'L');
	# Person 11
	$pdf->SetY($top + ($c4h * 3));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 3) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[11][0]) ? $g_node_strings[11][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[11][1]) ? $g_node_strings[11][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[11][2]) ? $g_node_strings[11][2] : '', 0, 0, 'L');
	# Person 12
	$pdf->SetY($top + ($c4h * 4));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 4) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[12][0]) ? $g_node_strings[12][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[12][1]) ? $g_node_strings[12][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[12][2]) ? $g_node_strings[12][2] : '', 0, 0, 'L');		
	# Person 13
	$pdf->SetY($top + ($c4h * 5));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 5) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[13][0]) ? $g_node_strings[13][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[13][1]) ? $g_node_strings[13][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[13][2]) ? $g_node_strings[13][2] : '', 0, 0, 'L');
	# Person 14
	$pdf->SetY($top + ($c4h * 6));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 6) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[14][0]) ? $g_node_strings[14][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[14][1]) ? $g_node_strings[14][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[14][2]) ? $g_node_strings[14][2] : '', 0, 0, 'L');
	// Person 15
	$pdf->SetY($top + ($c4h * 7));
	$pdf->SetX($c4x);
	$pdf->Cell($w, $c4h, '', 1, 0, 'L');
	$pdf->SetY($top + ($c4h * 7) + ($c4h / 2) - 6);
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'B',10);
	$pdf->MultiCell($w, 4, isset($g_node_strings[15][0]) ? $g_node_strings[15][0] : '', 0, 'L');
	$pdf->SetX($c4x);
	$pdf->SetFont($font,'',10);
	$pdf->Cell($w, 4, isset($g_node_strings[15][1]) ? $g_node_strings[15][1] : '', 0, 2, 'L');
	$pdf->Cell($w, 4, isset($g_node_strings[15][2]) ? $g_node_strings[15][2] : '', 0, 0, 'L');			
	
	$pdf->Output();
	// End Main Program
	exit();

?>