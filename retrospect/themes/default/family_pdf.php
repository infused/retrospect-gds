<?php
/**
 * Family PDF Report
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
 
	require('fpdf/fpdf.php'); 

	# process expected get/post variables
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
		
	# get basic data about the individual
	$o = new Person($g_indiv);
	
	# initialize other variables
	$sources 		= array();
	$mnum = 0;
	$linespace 	= 5;
	$factcol 		= 50;
	$placecol 	= 86;
	$namecol 		= 23;
	$birthcol 	= 86;
	$deathcol 	= 136;
	$font 			= 'Helvetica';

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
			$this->Cell(0, 5, sprintf(_("Family Group Sheet for %s"), $o->name), 0, 0, 'C');
    	$this->Ln(15);
		}
		
		# Page footer
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
	$pdf->SetTitle(sprintf(_("Family Group Sheet for %s"), $o->name));
	$pdf->SetSubject(_("Genealogy"));
	
	# Display main individual
	display_indiv($o);
	
	foreach ($o->marriages as $marriage) {
  	$mnum++;
		display_marriage($marriage, $mnum);
	}
	
	if ($sources) { display_sources(); }
		
	# End Main Program
	$pdf->Output();
	exit();
	
	/**
	* Display Individual Function
	* @access public
	* @param string $p_node
	*/
	function display_indiv($p_node) {
		global $pdf, $font, $factcol, $placecol, $shownotes, $sources, $linespace;
		if ($p_node->father_indkey) { $f = new Person($p_node->father_indkey, 1); }
		if ($p_node->mother_indkey) { $m = new Person($p_node->mother_indkey, 1); }
		$pdf->SetFont($font, 'B', 11);
		if ($p_node->title != '') { 
			$namestr = $p_node->name.', '.$p_node->title;
		}
		else {
			$namestr = $p_node->name;
		}
		$pdf->Cell(0, 5, $namestr);
		
		# print gender string
		$pdf->Ln($linespace);
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, _("Gender").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, $p_node->gender);
		
		# print birth record
		$pdf->Ln($linespace);
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, _("Birth").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, $p_node->birth->date);
		$pdf->SetX($placecol);
		$birthplace = $p_node->birth->place;
		if ($p_node->birth->sources) { 
			$birthplace .= ' ('._("Sources").':';
			foreach($p_node->birth->sources as $birthsource) {
				array_push($sources, $birthsource);
				$birthplace .= ' '.count($sources);
			}
			$birthplace = $birthplace.")";
		}
		$pdf->MultiCell(0,5, $birthplace, 0, 'L');
		
		# print death record
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, _("Death").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, $p_node->death->date);
		$pdf->SetX($placecol);
		$deathplace = $p_node->death->place;
		if ($p_node->death->sources) { 
			$deathplace .= ' ('._("Sources").':';
			foreach($p_node->death->sources as $deathsource) {
				array_push($sources, $deathsource);
				$deathplace .= ' '.count($sources);
			}
			$deathplace = $deathplace.')';
		}
		$pdf->MultiCell(0,5, $deathplace, 0, 'L');
		
		# print father
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, _("Father").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->MultiCell(0, 5, $f->name, 0, 'L');
		# print mother
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0,5, _("Mother").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->MultiCell(0, 5, $m->name, 0, 'L');			
		# print misc events
		foreach ($p_node->events as $event) {
			$eventplace = '';
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, _($event->type).':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			$pdf->Cell(0, 5, $event->date);
			$pdf->SetX($placecol);
			$eventplace = $event->place;
			if ($event->sources) {
				$eventplace .= ' ('._("Sources").': '; 
				foreach ($event->sources as $source)  {
					array_push($sources, $source);
					$eventplace .= ' '.count($sources);
				}
				$eventplace .= ')';
			}
			$pdf->MultiCell(0, 5, $eventplace, 0, 'L');
		}
		# print notes
		if ($p_node->notes) {
			$noteparagraphs = explode('<br>', $p_node->notes);
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, _("Notes").':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			foreach($noteparagraphs as $noteparagraph) {
				$pdf->SetX($factcol);
				$pdf->MultiCell(0, 5, $noteparagraph, 0, 'L');
			}
		}					
	}
	
	/**
	* Display marriage function
	* @access public
	* @param string $p_marriage
	* @param integer $p_mnum
	*/
	function display_marriage($p_marriage, $p_mnum) {
		global $pdf, $font, $factcol, $placecol, $namecol, $birthcol, $deathcol, $sources;
		$spouse = new Person($p_marriage->spouse, 1);
		$pdf->Ln(5);		
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, sprintf(_("Family %s"), $p_mnum).' :', 0, 1);
		$pdf->Cell(0, 0, ' ', 'B', 1);
		$pdf->Ln(5);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, _("Spouse/Partner").':');
		$pdf->SetX($factcol);
		$spousestr = $spouse->name;
		if ($spouse->birth) { $spousestr .= '   '._("b.").' '.$spouse->birth->date; }
		if ($spouse->death) { $spousestr .= '   '._("d.").' '.$spouse->death->date; }
		
		$pdf->Cell(0, 5, $spousestr, 0, 1);
		$pdf->Cell(0, 5, _($p_marriage->beginstatus).':');
		$pdf->SetX($factcol);
		$pdf->Cell(0, 5, $p_marriage->date);
		$pdf->SetX($placecol);
		$marriageplace = $p_marriage->place;
		if ($p_marriage->sources) {
			$marriageplace .= ' ('._("Sources").': '; 
			foreach ($p_marriage->sources as $source)  {
				array_push($sources, $source);
				$marriageplace .= ' '.count($sources);
			}
			$marriageplace .= ')';
		}
		$pdf->MultiCell(0, 5, $marriageplace, 0, 'L');
		# print marriage end status
		if ($p_marriage->endstatus) {
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, _($p_marriage->endstatus).':');
			$pdf->SetX($factcol);
			$pdf->Cell(0, 5, $p_marriage->enddate);
			$pdf->SetX($placecol);
			$endplace = $p_marriage->endplace;
			if ($p_marriage->end_sources) {
				$endplace .= ' ('._("Sources").': '; 
				foreach ($p_marriage->end_sources as $source)  {
					array_push($sources, $source);
					$endplace .= ' '.count($sources);
				}
				$endplace .= ')';
			}
			$pdf->MultiCell(0, 5, $endplace, 0, 'L');
		}
		# print marriage notes
		if ($p_marriage->notes) {
			$noteparagraphs = explode('<br>', $mnotes);
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, _("Notes").':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			foreach ($noteparagraphs as $noteparagraph) {
				$pdf->SetX($factcol);
				$pdf->MultiCell(0, 5, $noteparagraph, 0, 'L');
			}
		}
		$pdf->Ln(5);
		# print children
		if ($p_marriage->child_count > 0) {
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, _("Children").':', 0, 1);
			$cnum = 0;
			foreach ($p_marriage->children as $child) {
				$cnum++;
				$c = new Person($child, 1);
				$pdf->Cell(0, 5, $cnum.'.');
				$pdf->SetX($namecol);
				$pdf->Cell(0, 5, $c->name);
				$pdf->SetX($birthcol);
				$pdf->Cell(0, 5, $c->birth->date);
				$pdf->SetX($deathcol);
				$pdf->Cell(0, 5, $c->death->date);
				$pdf->Ln(5);
			}
		}
	} 
	
	/**
	* Display sources function
	* @access public
	*/
	function display_sources() {
		global $pdf, $font, $factcol, $placecol, $lmargin, $sources;
		$sourcecol = 23;
		$pdf->Ln(5);
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, _("Sources").':', 0, 1);
		$pdf->Cell(0, 0, " ", "B", 1);
		$pdf->Ln(5);
		$pdf->SetFont($font, '', 10);
		$num = 0;
		foreach ($sources as $source) {
			$num ++;
			$source = str_replace('<br>', "\n", $source);
			$pdf->Cell(0, 5, $num);
			$pdf->SetX($sourcecol);
			$pdf->MultiCell(0, 5, $source);
			$pdf->Ln(5);
		}
	}
?>
