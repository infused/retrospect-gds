<?php
/**
 * Reports
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

	if (isset($_GET['report_type'])) {
		/**
		* Load the appropriate theme option page
		* @access public
		*/
		include(Theme::getPage($g_theme, strtolower($_GET['report_type'])));
	}
	else {
		# process expected get/post variables
		$print = isset($_GET['print']) ? true : false;
		$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	
		# initialize other variables
		$sources = array();
		$o = new person($g_indiv);
	
		$g_title = sprintf(_("Reports for %s"), $o->name);

		# name and menu
		$g_content = '<p class="content-title">'.$o->name;
		if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
		$g_content .= '</p>';
		if ($print === false) {
			include(Theme::getPage($g_theme, 'nav'));
		}
		$g_content .= '<p class="content-subtitle">'._("Ahnentafel Report").'</p>';
		
		# family reports
		$g_content .= '<p class="content-subtitle">'._("Family Reports").'</p>';
		$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?no_template=y&option=family_pdf&indiv='.$o->indkey.'">'._("Family PDF").'</a>';
		# pedigree reports
		$g_content .= '<p class="content-subtitle">'._("Pedigree Reports").'</p>';
		$g_content .= '<a href="'.$_SERVER['PHP_SELF'].'?no_template=y&option=pedigree_pdf&indiv='.$o->indkey.'">'._("Pedigree PDF").'</a>';
		# ancestor reports
		$g_content .= '<p class="content-subtitle">'._("Ancestor Reports").'</p>';
		$g_content .= '<form name="form_change_report" method="get" action="">';
		$g_content .= '<table border="0" cellpadding="0" cellspacing="0"><tr>';
		$g_content .= '<td class="text">'._("Report type").':&nbsp;</td>';
		$g_content .= '<td width="125"><select name="report_type" class="listbox" id="report_type"><option value="ahnentafel">'._("Ahnentafel").'</option><option value="ahnentafel_pdf">'._("Ahnentafel PDF").'</option></select></td>';
		$g_content .= '<td class="text">'.'&nbsp;'._("Number of Generations").':&nbsp;</td>';
		$g_content .= '<td><input name="max_gens" type="textfield" class="textbox" id="max_gens" value="250" size="3" /></td>';
		$g_content .= '<input name="indiv" type="hidden" id="indiv" value="'.$_GET['indiv'].'" />';
		$g_content .= '<input name="option" type="hidden" value="'.$_GET['option'].'" />';
		$g_content .= '<td>&nbsp;&nbsp;&nbsp;</td>';
		$g_content .= '<td><input name="" type="submit" class="text" value="'._("Apply").'" /></td>';
		$g_content .= '</tr></table>';
		$g_content .= '</form>';
		# descendant reports
		$g_content .= '<p class="content-subtitle">'._("Descendant Reports").'</p>';
		$g_content .= '<form name="form_change_report" method="get" action="">';
		$g_content .= '<table border="0" cellpadding="0" cellspacing="0"><tr>';
		$g_content .= '<td class="text">'._("Report type").':&nbsp;</td>';
		$g_content .= '<td width="125"><select name="report_type" class="listbox" id="report_type"><option value="descendant">'._("Descendant").'</option><option value="descendant_pdf">'._("Descendant PDF").'</option></select></td>';
		$g_content .= '<td class="text">'.'&nbsp;'._("Number of Generations").':&nbsp;</td>';
		$g_content .= '<td><input name="max_gens" type="textfield" class="textbox" id="max_gens" value="250" size="3" /></td>';
		$g_content .= '<input name="indiv" type="hidden" id="indiv" value="'.$_GET['indiv'].'" />';
		$g_content .= '<input name="option" type="hidden" value="'.$_GET['option'].'" />';
		$g_content .= '<td>&nbsp;&nbsp;&nbsp;</td>';
		$g_content .= '<td><input name="" type="submit" class="text" value="'._("Apply").'" /></td>';
		$g_content .= '</tr></table>';
		$g_content .= '</form>';
	}
?>