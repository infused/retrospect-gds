<?php 
/**
 * Multimedia Report
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

	# process expected get/post variables
	$print = isset($_GET['print']) ? true : false;
	$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	
	# get first person information
	$o = new person($g_indiv);
	
	# title
	$g_title = sprintf(_("Multimedia for %s"), $o->name);
	
	# name and menu
	$g_content = '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
	$g_content .= '</p>';
	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
	$g_content .= '<p><b>'._("This feature has not been implemented yet.").'</b></p>';
?>