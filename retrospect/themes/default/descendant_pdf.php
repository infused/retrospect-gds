<?php
/**
 * Descendant PDF Report
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

	require_once(LIB_PATH.'fpdf/fpdf.php');
	require_once(CORE_PATH.'f_report.php');

	$font = 'Helvetica';
	
	# die if not called properly
	if (!isset($_GET['indiv'])) { exit; }
	# else init script
	else {
		# extract _get vars
		$g_indiv = $_GET['indiv'];
		if (isset($_GET['max_gens'])) { $g_max_gens = $_GET['max_gens']; }
		else { $g_max_gens = 250; }
		# init other vars
		$g_descendants = array();
		$g_generation = 0;
		# get first person information
		$o = new Person($g_indiv, 0, 1);
		array_push($g_descendants, array($o, 1));
		
		
	}
	
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
			$this->Cell(0, 5, sprintf(_("Descendant Report for %s"), $o->name), 0, 0, 'C');
    	$this->Ln(15);
		}
		
		# Page footer
		function Footer() {
    	global $font;
			$this->SetY(-10);
    	$this->SetFont($font,'',8);
    	$this->Cell(0, 4, '©2002-2004 Keith Morrison, Infused Solutions - www.infused.org', 0, 1, 'C', 0, 'http://www.infused.org');
			$this->Cell(0, 4, sprintf(_("Send questions or comments to %s"), 'keithm@infused.org'), 0, 0, 'C', 0, 'mailto:keithm@infused.org');
		}
	}
	
	function display_indiv($p_array) {
		global $pdf, $g_descendants, $g_generation, $g_max_gens, $font;
		$gencol = 13;
		$factcol = 30;
		$childcol = 40;
		$birthcol = 100; 
		$deathcol = 150;
		$p_node = $p_array[0];
		$p_generation  = $p_array[1];
		if ($p_node->father_indkey) { $father = new Person($p_node->father_indkey, 3); }
		else { $father = null; }
		if ($p_node->mother_indkey) { $mother = new Person($p_node->mother_indkey, 3); }
		else { $mother = null; }
		
		if ($p_generation > $g_generation ) {
			$g_generation = $p_generation;
			# display generation if it changed	
			$pdf->SetLeftMargin(13);
			$pdf->SetX(0);
			$pdf->SetFont($font, 'BU', 10);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, sprintf(_("Generation %s"), $g_generation), 0, 2, 'C');
			//$pdf->Ln(5);
		}
		$pdf->LN(5);
		$pdf->SetX($gencol);
		$pdf->SetFont($font, '', 9);
		$pdf->Write(5, $p_node->ns_number.'.');
		$pdf->SetLeftMargin($factcol);
		$pdf->SetFont($font, 'B', 9);
		$pdf->Write(5, $p_node->name.' - ');
		$pdf->SetFont($font, '', 9);
		$pdf->Write(5, html_entity_decode(strip_tags(get_parents_sentence($p_node, $father, $mother))));
		$pdf->Write(5, html_entity_decode(strip_tags(get_birth_sentence($p_node))));
		$pdf->Write(5, html_entity_decode(strip_tags(get_marriage_sentences($p_node))));
		$pdf->Write(5, html_entity_decode(strip_tags(get_death_sentence($p_node))));
		$pdf->Ln(5);
		
		# children
		foreach ($p_node->marriages as $marriage) {
			$spouse = new Person($marriage->spouse);
			if ($marriage->child_count > 0) {
				$pdf->Ln(5);
				$pdf->Write(5, html_entity_decode(strip_tags(get_children_of_sentence($p_node, $spouse))).':');
				foreach ($marriage->children as $child_indkey) {
					$child = new Person($child_indkey);
					if ($child->marriage_count > 0) {
						foreach ($child->marriages as $cmarriage) {
							if ($cmarriage->child_count > 0) {
								$child->ns_number = count($g_descendants) + 1;
								$child_gen = $p_generation + 1;
								if ($child_gen > $g_max_gens) { break; }
								array_push($g_descendants, array($child, $child_gen));
								break;
							}
						}
					}
					if ($child->ns_number) {	
						$pdf->SetLeftMargin($factcol);
						$pdf->Ln(5);
						$pdf->Write(5, $child->ns_number);
						$pdf->SetX($childcol);
						$pdf->Write(5, $child->name);
						if ($child->birth->date || $child->death->date) { 
							if ($child->birth->date) {
								$pdf->SetX($birthcol);
								$pdf->Write(5, $child->birth->date);
							}
							if ($child->death->date) {
								$pdf->SetX($deathcol);
								$pdf->Write(5, $child->death->date);
							}
						}
					}
					else {
						$pdf->Ln(5);
						$pdf->SetX($childcol);
						$pdf->Write(5, $child->name);
						if ($child->birth->date || $child->death->date) { 
							if ($child->birth->date) {
								$pdf->SetX($birthcol);
								$pdf->Write(5, $child->birth->date);
							}
							if ($child->death->date) {
								$pdf->SetX($deathcol);
								$pdf->Write(5, $child->death->date);
							}
						}
					}
				}
			}
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
	$pdf->SetTitle(sprintf(_("Descendant Report for %s"), $o->name));
	$pdf->SetSubject(_("Genealogy"));
	
	for ($i = 0; $i < count($g_descendants); $i++) {
		display_indiv($g_descendants[$i]);
	}
	
	# End Main Program
	$pdf->Output();
	exit();	
?>