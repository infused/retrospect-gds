<?php
/**
 * Navigation Menu
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

	# main links
  $g_menu = '<div class="menu-title">'._("Database").'</div>';
	$g_menu .= '<a href="'.Theme::GetArgs('search').'" title="'._("Search the Database").'" class="menu-item">'._("Search").'</a><br />';
	$g_menu .= '<a href="'.Theme::GetArgs('surnames').'" title="'._("Surname List").'" class="menu-item">'._("Surname List").'</a><br />';
  $g_menu .= '<a href="'.Theme::GetArgs('stats').'" title="'._("Database Statistics").'" class="menu-item">'._("Statistics").'</a><br />';
  $g_menu .= '<br />';
	
	# language selection
	if ($g_opts->allow_lang_change) {
		$g_menu .= '<div class="menu-title">'._("Language").'</div>';
		$g_menu .= '<form name="form_change_lang" method="post" action="'._CURRENT_PAGE.'">';
		$g_menu .= '<select name="lang" size="1" class="listbox" id="lang" onChange="document.forms.form_change_lang.submit();">';
		$g_menu .= '<option value="en_US"';
			if ($_SESSION['lang'] == 'en_US') { 
				$g_menu .= ' SELECTED'; 
			} 
		$g_menu .= '>'.gettext("English").'</option>';
		$g_menu .= '<option value="es_ES"';
			if ($_SESSION['lang'] == 'es_ES') { 
		 		$g_menu .= ' SELECTED';
			}
		$g_menu .= '>'.gettext("Spanish").'</option>';
		$g_menu .= '</select>';
		$g_menu .= '</form>';
	} 
?>