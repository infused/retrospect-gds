<?php
/**
 * Nav Menu
 *
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		theme_default
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
 
	$g_content .= '<div class="tab-row">';
	
	# surnames tab
	if ($g_option == 'surnames') {
		$g_content .= '<div class="tab selected">'.sprintf(_("%s Surname"), $o->sname).'</div>';
	}
	else {	
		$g_content .= '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=surnames&sn='.$o->sname.'">'.sprintf(_("%s Surname"), $o->sname).'</a></div>';
	}
	
	# family tab
	if ($g_option == 'family') {
		$g_content .= '<div class="tab selected">'._("Family").'</div>';
	}
	else {
		$g_content .= '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'._("Family").'</a></div>';
	}
	
	# pedigree tab
	if ($g_option == 'pedigree') {
		$g_content .= '<div class="tab selected">'._("Pedigree").'</div>';
	}
	else {
		$g_content .= '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$o->indkey.'">'._("Pedigree").'</a></div>';
	}
	
	# reports tab
	if ($g_option == 'reports') {
		$g_content .= '<div class="tab selected">'._("Reports").'</div>';
	}
	else {
		$g_content .= '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=reports&indiv='.$o->indkey.'">'._("Reports").'</a></div>';
	}
	
	# multimedia tab
	if ($g_option == 'multimedia') {
		$g_content .= '<div class="tab selected">'._("Multimedia").'</div>';
	}
	else {
		$g_content .= '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=multimedia&indiv='.$o->indkey.'">'._("Multimedia").'</a></div>';
	}
	
	$g_content .= '</div>';
?>