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
	} else {
		# process expected get/post variables
		$print = isset($_GET['print']) ? true : false;
		$g_indiv = isset($_GET['indiv']) ? $_GET['indiv'] : exit;
	
		# initialize other variables
		$sources = array();
		$o = new person($g_indiv);
	
		$g_title = sprintf(gtc("Reports for %s"), $o->name);
		
		# populate keyword array
		keyword_push(gtc("Reports"));
		keyword_push($o->name);

		# name and menu
		echo '<p class="content-title">';
		if (!empty($o->prefix)) echo $o->prefix.' ';
		echo $o->name;
		if (!empty($o->suffix)) echo ', '.$o->suffix; 
		echo '</p>';
		if ($print === false) {
			include(Theme::getPage($g_theme, 'nav'));
		}
		
		echo '<div class="tab-page">';
		
		# family reports
		echo '<p class="content-subtitle">'.gtc("Family Reports").'</p>';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?no_template=y&amp;option=family_pdf&amp;indiv='.$o->indkey.'">'.gtc("Family PDF").'</a>';
		# pedigree reports
		echo '<p class="content-subtitle">'.gtc("Pedigree Reports").'</p>';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?no_template=y&amp;option=pedigree_pdf&amp;indiv='.$o->indkey.'">'.gtc("Pedigree PDF").'</a>';
		# ancestor reports
		echo '<p class="content-subtitle">'.gtc("Ancestor Reports").'</p>';
		echo '<form name="form_change_report" method="get" action="">';
		echo '<table border="0" cellpadding="0" cellspacing="0"><tr>';
		echo '<td class="text">'.gtc("Report type").':&nbsp;</td>';
		echo '<td width="125"><select name="report_type" class="listbox"><option value="ahnentafel">'.gtc("Ahnentafel").'</option><option value="ahnentafel_pdf">'.gtc("Ahnentafel PDF").'</option></select></td>';
		echo '<td class="text">'.'&nbsp;'.gtc("Number of Generations").':&nbsp;</td>';
		echo '<td><input name="max_gens" type="text" class="textbox" value="250" size="3" />';
		echo '<input name="indiv" type="hidden" value="'.$_GET['indiv'].'" />';
		echo '<input name="option" type="hidden" value="'.$_GET['option'].'" />';
		echo '</td>';
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td><input name="" type="submit" class="text" value="'.gtc("Apply").'" /></td>';
		echo '</tr></table>';
		echo '</form>';
		# descendant reports
		echo '<p class="content-subtitle">'.gtc("Descendant Reports").'</p>';
		echo '<form name="form_change_report" method="get" action="">';
		echo '<table border="0" cellpadding="0" cellspacing="0"><tr>';
		echo '<td class="text">'.gtc("Report type").':&nbsp;</td>';
		echo '<td width="125"><select name="report_type" class="listbox"><option value="descendant">'.gtc("Descendant").'</option><option value="descendant_pdf">'.gtc("Descendant PDF").'</option></select></td>';
		echo '<td class="text">'.'&nbsp;'.gtc("Number of Generations").':&nbsp;</td>';
		echo '<td><input name="max_gens" type="text" class="textbox" value="250" size="3" />';
		echo '<input name="indiv" type="hidden" value="'.$_GET['indiv'].'" />';
		echo '<input name="option" type="hidden" value="'.$_GET['option'].'" />';
		echo '</td>';
		echo '<td>&nbsp;&nbsp;&nbsp;</td>';
		echo '<td><input name="" type="submit" class="text" value="'.gtc("Apply").'" /></td>';
		echo '</tr></table>';
		echo '</form>';
		
		echo '</div>';
	}
?>