<?php
/**
 * Family PDF Report
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
 
 /*
 * $Id$
 */
 
	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );	
	
	require(LIB_PATH.'fpdf/fpdf.php'); 

	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;
		
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
			$this->Cell(0, 5, sprintf(gtc("Family Group Sheet for %s"), $o->full_name()), 0, 0, 'C');
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
	$pdf->SetTitle(sprintf(gtc("Family Group Sheet for %s"), $o->full_name()));
	$pdf->SetSubject(gtc("Genealogy"));
	
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
		if ($p_node->father_indkey) { $f = new Person($p_node->father_indkey, 3); }
		if ($p_node->mother_indkey) { $m = new Person($p_node->mother_indkey, 3); }
		$pdf->SetFont($font, 'B', 11);
		$namestr = '';
		if ($p_node->prefix) $namestr .= $p_node->prefix;
		$namestr .= $p_node->full_name();
		if ($p_node->suffix) $namestr .= ', '.$p_node->suffix;
		$pdf->Cell(0, 5, $namestr);
		
		# print aka string
		if (!empty($p_node->aka)) {
			$pdf->Ln($linespace);
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, gtc("Aka").':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			$pdf->Cell(0, 5, $p_node->aka);
		}
		
		# print gender string
		$pdf->Ln($linespace);
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, gtc("Gender").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, gtc($p_node->gender));
		
		# print birth record
		$pdf->Ln($linespace);
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, gtc("Birth").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, $p_node->birth->date);
		$pdf->SetX($placecol);
		$birthplace = $p_node->birth->place;
		if ($p_node->birth->sources) { 
			$birthplace .= ' ('.gtc("Sources").':';
			foreach($p_node->birth->sources as $birthsource) {
				array_push($sources, $birthsource);
				$birthplace .= ' '.count($sources);
			}
			$birthplace = $birthplace.")";
		}
		$pdf->MultiCell(0,5, $birthplace, 0, 'L');
		
		# print death record
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, gtc("Death").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, $p_node->death->date);
		$pdf->SetX($placecol);
		$deathplace = $p_node->death->place;
		if ($p_node->death->sources) { 
			$deathplace .= ' ('.gtc("Sources").':';
			foreach($p_node->death->sources as $deathsource) {
				array_push($sources, $deathsource);
				$deathplace .= ' '.count($sources);
			}
			$deathplace = $deathplace.')';
		}
		$pdf->MultiCell(0,5, $deathplace, 0, 'L');
		
		# print father
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, gtc("Father").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->MultiCell(0, 5, isset($f->full_name()) ? $f->full_name() : '', 0, 'L');
		# print mother
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0,5, gtc("Mother").':');
		$pdf->SetX($factcol);
		$pdf->SetFont($font, '', 10);
		$pdf->MultiCell(0, 5, isset($m->full_name()) ? $m->full_name() : '', 0, 'L');			
		# print misc events
		foreach ($p_node->events as $event) {
			$eventplace = '';
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, gtc($event->type).':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			$pdf->Cell(0, 5, $event->date);
			$pdf->SetX($placecol);
			if (!empty($event->place) AND !empty($event->comment)) {
				$eventstring = $event->comment.' / '.$event->place;
			}
			elseif (!empty($event->comment)) {
				$eventstring = $event->comment;
			}
			elseif (!empty($event->place)) {
				$eventstring = $event->place;
			}
			else {
				$eventstring = '';
			}
			if ($event->sources) {
				$eventplace .= ' ('.gtc("Sources").': '; 
				foreach ($event->sources as $source)  {
					array_push($sources, $source);
					$eventplace .= ' '.count($sources);
				}
				$eventplace .= ')';
			}
			$pdf->MultiCell(0, 5, $eventstring, 0, 'L');
		}
		# print notes
		if ($p_node->notes) {
			$noteparagraphs = explode('<br>', $p_node->notes);
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, gtc("Notes").':');
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
		$spouse = (!empty($p_marriage->spouse)) ? new Person($p_marriage->spouse, 3) : null;
		$pdf->Ln(5);		
		$pdf->SetFont($font, 'I', 10);
		$pdf->Cell(0, 5, sprintf(gtc("Family %s"), $p_mnum).' :', 0, 1);
		$pdf->Cell(0, 0, ' ', 'B', 1);
		$pdf->Ln(5);
		$pdf->SetFont($font, '', 10);
		$pdf->Cell(0, 5, gtc("Spouse/Partner").':');
		$pdf->SetX($factcol);
		$spousestr = $spouse->full_name();
		if ($spouse->birth) { $spousestr .= '   '.gtc("b.").' '.$spouse->birth->date; }
		if ($spouse->death) { $spousestr .= '   '.gtc("d.").' '.$spouse->death->date; }
		
		$pdf->Cell(0, 5, $spousestr, 0, 1);
		$pdf->Cell(0, 5, gtc($p_marriage->beginstatus).':');
		$pdf->SetX($factcol);
		$pdf->Cell(0, 5, $p_marriage->date);
		$pdf->SetX($placecol);
		$marriageplace = $p_marriage->place;
		if ($p_marriage->sources) {
			$marriageplace .= ' ('.gtc("Sources").': '; 
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
			$pdf->Cell(0, 5, gtc($p_marriage->endstatus).':');
			$pdf->SetX($factcol);
			$pdf->Cell(0, 5, $p_marriage->enddate);
			$pdf->SetX($placecol);
			$endplace = $p_marriage->endplace;
			if ($p_marriage->end_sources) {
				$endplace .= ' ('.gtc("Sources").': '; 
				foreach ($p_marriage->end_sources as $source)  {
					array_push($sources, $source);
					$endplace .= ' '.count($sources);
				}
				$endplace .= ')';
			}
			$pdf->MultiCell(0, 5, $endplace, 0, 'L');
		}
			# print misc events
		foreach ($p_marriage->events as $event) {
			$eventplace = '';
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, gtc($event->type).':');
			$pdf->SetX($factcol);
			$pdf->SetFont($font, '', 10);
			$pdf->Cell(0, 5, $event->date);
			$pdf->SetX($placecol);
			if (!empty($event->place) AND !empty($event->comment)) {
				$eventstring = $event->comment.' / '.$event->place;
			}
			elseif (!empty($event->comment)) {
				$eventstring = $event->comment;
			}
			elseif (!empty($event->place)) {
				$eventstring = $event->place;
			}
			else {
				$eventstring = '';
			}
			if ($event->sources) {
				$eventplace .= ' ('.gtc("Sources").': '; 
				foreach ($event->sources as $source)  {
					array_push($sources, $source);
					$eventplace .= ' '.count($sources);
				}
				$eventplace .= ')';
			}
			$pdf->MultiCell(0, 5, $eventstring, 0, 'L');
		}

		# print marriage notes
		if ($p_marriage->notes) {
			$noteparagraphs = explode('<br>', $mnotes);
			$pdf->SetFont($font, 'I', 10);
			$pdf->Cell(0, 5, gtc("Notes").':');
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
			$pdf->Cell(0, 5, gtc("Children").':', 0, 1);
			$cnum = 0;
			foreach ($p_marriage->children as $child) {
				$cnum++;
				$c = new Person($child, 3);
				$pdf->Cell(0, 5, $cnum.'.');
				$pdf->SetX($namecol);
				$pdf->Cell(0, 5, $c->full_name());
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
		$pdf->Cell(0, 5, gtc("Sources").':', 0, 1);
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
