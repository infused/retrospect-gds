<?php
/**
 * Nav Menu
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
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details.
 *
 * $Id$
 *
 */
 
	echo '<div class="tab-row">';
	
	# surnames tab
	if ($g_option == 'surnames') {
		echo '<div class="tab selected">'.sprintf(_("%s Surname"), $o->sname).'</div>';
	}
	else {	
		echo '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=surnames&sn='.$o->sname.'">'.sprintf(_("%s Surname"), $o->sname).'</a></div>';
	}
	
	# family tab
	if ($g_option == 'family') {
		echo '<div class="tab selected">'._("Family").'</div>';
	}
	else {
		echo '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'._("Family").'</a></div>';
	}
	
	# pedigree tab
	if ($g_option == 'pedigree') {
		echo '<div class="tab selected">'._("Pedigree").'</div>';
	}
	else {
		echo '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$o->indkey.'">'._("Pedigree").'</a></div>';
	}
	
	# reports tab
	if ($g_option == 'reports') {
		echo '<div class="tab selected"><a href="'.$_SERVER['PHP_SELF'].'?option=reports&indiv='.$o->indkey.'">'._("Reports").'</a></div>';
	}
	else {
		echo '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=reports&indiv='.$o->indkey.'">'._("Reports").'</a></div>';
	}
	
	# multimedia tab
	if ($g_option == 'multimedia') {
		echo '<div class="tab selected">'._("Multimedia").'</div>';
	}
	else {
		echo '<div class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=multimedia&indiv='.$o->indkey.'">'._("Multimedia").'</a></div>';
	}
	
	echo '</div>';
?>