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
 
	echo '<table class="tab-row" cellpadding="0" cellspacing="0">';
	echo '<tr>';
	
	# surnames tab
	if ($g_option == 'surnames') {
		echo '<td class="tab-selected">'.sprintf(_("%s Surname"), $o->sname).'</td>';
	}
	else {	
		echo '<td class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=surnames&sn='.$o->sname.'">'.sprintf(_("%s Surname"), $o->sname).'</a></td>';
	}
	
	# family tab
	if ($g_option == 'family') {
		echo '<td class="tab-selected">'._("Family").'</td>';
	}
	else {
		echo '<td class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=family&indiv='.$o->indkey.'">'._("Family").'</a></td>';
	}
	
	# pedigree tab
	if ($g_option == 'pedigree') {
		echo '<td class="tab-selected">'._("Pedigree").'</td>';
	}
	else {
		echo '<td class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=pedigree&indiv='.$o->indkey.'">'._("Pedigree").'</a></td>';
	}
	
	# reports tab
	if ($g_option == 'reports') {
		echo '<td class="tab-selected"><a href="'.$_SERVER['PHP_SELF'].'?option=reports&indiv='.$o->indkey.'">'._("Reports").'</a></td>';
	}
	else {
		echo '<td class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=reports&indiv='.$o->indkey.'">'._("Reports").'</a></td>';
	}
	
	# multimedia tab
	if ($g_option == 'multimedia') {
		echo '<td class="tab-selected">'._("Multimedia").'</td>';
	}
	else {
		echo '<td class="tab"><a href="'.$_SERVER['PHP_SELF'].'?option=multimedia&indiv='.$o->indkey.'">'._("Multimedia").'</a></td>';
	}
	
	echo '<td class="tab-last">&nbsp;</td>';
	echo '</tr>';
	echo '</table>';
?>