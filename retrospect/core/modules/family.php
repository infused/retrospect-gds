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
 */
 
 /**
 * $Id$
 */

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );	
	
	# process expected get/post variables
	$g_indiv = isset($_GET['id']) ? $_GET['id'] : exit;

	# initialize other variables
	$sources = array();
	
	# get first person information
	$o = new person($g_indiv);
	$smarty->assign('indiv', $o);
	
	# populate keywords array
	keyword_push($o->name);
	if (!empty($o->birth->place)) { keyword_push($o->birth->place); }
	if (!empty($o->death->place)) { keyword_push($o->death->place); }
	
	# assign other smarty variables
	$smarty->assign_by_ref('page_title', sprintf(gtc("Family Page for %s"), $o->name));
	$smarty->assign_by_ref('surname_title', sprintf(gtc("%s Surname"), htmlentities($o->sname)));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign_by_ref('content_title', $content_title);
	
	# create father link
	if ($o->father_indkey) { 
		$f = new person($o->father_indkey, 3); 
		$params = array('m'=>'family','id'=>$f->indkey);
		$smarty->assign_by_ref('father_link', Theme::BuildLink($params, htmlentities($f->name)));
		keyword_push($f->name);
		unset($f, $params);
	}
	
	# create mother link
	if ($o->mother_indkey) { 
		$m = new person($o->mother_indkey, 3); 
		$params = array('m'=>'family','id'=>$m->indkey);
		$smarty->assign('mother_link', Theme::BuildLink($params, htmlentities($m->name)));
		keyword_push($m->name);
		unset($m, $params);
	}
	
	# assign events to the events array
	$vitals = array();
	if ($o->birth) $vitals[] = $o->birth;
	if ($o->death AND $o->death->comment != 'Y') $vitals[] = $o->death;
	$events = array_merge($vitals, $o->events);	
	foreach ($events as $event) {
		foreach ($event->sources as $source) {
			$sources[] = nl2br($source);
		}
	}
	$smarty->assign('events', $events);
	unset($events, $vitals);
	
	# marriages
	$marriages = array();
	for ($i = 0; $i < count($o->marriages); $i++) {
		$m = $o->marriages[$i];
		$s = (!empty($m->spouse)) ? new person($m->spouse, 3) : null;
		if ($s->name) { keyword_push($s->name); }
		$marriages[$i]['family_number'] = sprintf(gtc("Family %s"), $i + 1);
		$marriages[$i]['notes'] = $m->notes;
		$events = array();
		if ($m->begin_event) $events[] = $m->begin_event;
		if ($m->end_event) $events[] = $m->end_event;
		$marriages[$i]['events'] = array_merge($events, $m->events);
		foreach ($marriages[$i]['events'] as $event) {
			foreach ($event->sources as $source) {
				$sources[] = nl2br($source);
			}
		}
		# spouse
		$params = array('m'=>'family','id'=>$s->indkey); 
		$marriages[$i]['spouse'] = $s;
		$marriages[$i]['spouse_link'] = Theme::BuildLink($params, $s->name);
		$marriages[$i]['spouse_birth'] = $s->birth->date;
		$marriages[$i]['spouse_death'] = $s->death->date;
		# children
		$marriages[$i]['child_count'] = $m->child_count;
		if ($m->child_count > 0) {
			$children = array();
			foreach ($m->children as $child_indkey) {
				$c = new person($child_indkey, 3);
				keyword_push($c->name);
				$params = array('m'=>'family','id'=>$c->indkey);
				$children[] = array('child_link'=>Theme::BuildLink($params, $c->name), 'child'=>$c);
			}
			$marriages[$i]['children'] = $children;
		}
		
	}
	$smarty->assign_by_ref('marriages', $marriages);
	$smarty->assign_by_ref('sources', $sources);
	$smarty->assign_by_ref('marriage_count', count($marriages));
	$smarty->assign_by_ref('source_count', count($sources));
	unset($s, $m, $c, $params, $spouse_link, $marriages, $events, $children, $child_link);
	
?>
