<?php
/**
 * Family Report
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

	# initialize other variables
	$sources = array();
	$fam_count = 0;
	
	# get first person information
	$o = new person($g_indiv);
	$smarty->assign('indiv', $o);
	
	# populate keywords array
	keyword_push($o->name);
	if (!empty($o->birth->place)) { keyword_push($o->birth->place); }
	if (!empty($o->death->place)) { keyword_push($o->death->place); }
	

	# create page title
	$smarty->assign('page_title', sprintf(gtc("Family Page for %s"), $o->name));
	
	# content title
	$content_title = '';
	if (!empty($o->prefix)) $content_title .= $o->prefix.' ';
	$content_title .= $o->name;
	if (!empty($o->suffix)) $content_title .= $o->suffix;
	$smarty->assign('content_title', $content_title);
	
	# create father link
	if ($o->father_indkey) { 
		$f = new person($o->father_indkey, 3); 
		$father_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$f->indkey)).'">'.$f->name.'</a>';	
		# populate keywords array
		keyword_push($f->name);
		unset($f);
	}
	else { $father_link = '&nbsp;'; }
	$smarty->assign('father_link', $father_link);
	unset($father_link);
	
	# create mother link
	if ($o->mother_indkey) { 
		$m = new person($o->mother_indkey, 3); 
		$mother_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$m->indkey)).'">'.$m->name.'</a>';	
		# populate keywords array
		keyword_push($m->name);
		unset($m);
	}
	else { $mother_link = '&nbsp;'; }
	$smarty->assign('mother_link', $mother_link);
	unset($mother_link);
	
?>
