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
	
	# get first person information
	$o = new person($g_indiv);
	$smarty->assign('indiv', $o);
	
	# populate keywords array
	keyword_push($o->name);
	if (!empty($o->birth->place)) { keyword_push($o->birth->place); }
	if (!empty($o->death->place)) { keyword_push($o->death->place); }
	
	# assign other smarty variables
	$smarty->assign('page_title', sprintf(gtc("Family Page for %s"), $o->name));
	$smarty->assign('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	
	# content title
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign('content_title', $content_title);
	
	# create father link
	if ($o->father_indkey) { 
		$f = new person($o->father_indkey, 3); 
		$args = Theme::GetArgs('family', array('indiv'=>$f->indkey));
		$smarty->assign('father_link', '<a href="'.$args.'">'.$f->name.'</a>');
		keyword_push($f->name);
		unset($f, $args);
	}
	
	# create mother link
	if ($o->mother_indkey) { 
		$m = new person($o->mother_indkey, 3); 
		$args = Theme::GetArgs('family', array('indiv'=>$m->indkey));
		$smarty->assign('mother_link', '<a href="'.$args.'">'.$m->name.'</a>');
		keyword_push($m->name);
		unset($m, $args);
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
		$args = Theme::GetArgs('family', array('indiv'=>$s->indkey)); 
		$spouse_link = '<a href="'.$args.'">'.$s->name.'</a>';
		$marriages[$i]['spouse'] = $s;
		$marriages[$i]['spouse_link'] = $spouse_link;
		$marriages[$i]['spouse_birth'] = $s->birth->date;
		$marriages[$i]['spouse_death'] = $s->death->date;
		# children
		$marriages[$i]['child_count'] = $m->child_count;
		if ($m->child_count > 0) {
			$children = array();
			foreach ($m->children as $child_indkey) {
				$c = new person($child_indkey, 3);
				keyword_push($c->name);
				$args = Theme::GetArgs('family', array('indiv'=>$c->indkey));
				$child_link = '<a href="'.$args.'">'.$c->name.'</a>';
				$children[] = array('child_link'=>$child_link, 'child'=>$c);
			}
			$marriages[$i]['children'] = $children;
		}
		
	}
	$smarty->assign('marriages', $marriages);
	$smarty->assign('sources', $sources);
	$smarty->assign('marriage_count', count($marriages));
	$smarty->assign('source_count', count($sources));
	unset($s, $m, $c, $args, $spouse_link, $marriages, $events, $children, $child_link);
	
?>
