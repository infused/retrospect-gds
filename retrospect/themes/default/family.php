<?php
/**
 * Family Report
 *
 * @copyright 	Infused Solutions	2001-2003
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

	# create page title
	$g_title = sprintf(_("Family Page for %s"), $o->name);
	
	# create father link
	if ($o->father_indkey) { 
		$f = new person($o->father_indkey, 1); 
		$father_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$f->indkey)).'">'.$f->name.'</a>';	
		unset($f);
	}
	else { $father_link = '&nbsp;'; }
	
	# create mother link
	if ($o->mother_indkey) { 
		$m = new person($o->mother_indkey, 1); 
		$mother_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$m->indkey)).'">'.$m->name.'</a>';	
		unset($m);
	}
	else { $mother_link = '&nbsp;'; }

	/**
	* Display sources
	* @access public
	* @param array $p_sources
	*/
	function disp_sources($p_sources) {
		global $sources;
		$links = null;
		if ($p_sources) {
			foreach($p_sources as $source) {
				array_push($sources, $source);
				$count = count($sources);
				$links .= ' <a href="#s'.$count.'">'.$count.'</a>';
			}
		}
		return $links;
	}

  # name and menu
	$g_content = '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
	$g_content .= '</p>';
	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
  
	# vitals
	$g_content .= '<p class="content-subtitle">'._("Family Page").'</p>';
	$g_content .= '<div class="tab-page">';
	$g_content .= '<div class="col1">'._("Gender").':</div>';
  $g_content .= '<div class="col2">'._($o->gender).'</div>';
  $g_content .= '<div class="col3"></div>';
	$g_content .= '<div class="col1">'._("Father").':</div>';
	$g_content .= '<div class="col2-2">'.$father_link.'</div>';
	unset($father_link);
	$g_content .= '<div class="col1">'._("Mother").':</div>';
  $g_content .= '<div class="col2-2">'.$mother_link.'</div>';
	unset($mother_link);
  $g_content .= '<div class="col1">'._("Birth").':</div>';
	$g_content .= '<div class="col2">'.$o->birth->date.'</div>';
  $g_content .= '<div class="col3">'.$o->birth->place . disp_sources($o->birth->sources).'</div>';
	$g_content .= '<div class="col1">'._("Death").':</div>';
  $g_content .= '<div class="col2">'.$o->death->date.'</div>';
  $g_content .= '<div class="col3">'.$o->death->place . disp_sources($o->death->sources).'</div>';
	
	# events
	foreach($o->events as $event) {
		$g_content .= '<div class="col1">'._($event->type).':</div>';
		$g_content .= '<div class="col2">'.$event->date.'</div>';
		$g_content .= '<div class="col3">'.$event->place . disp_sources($event->sources).'</div>';
	}
	
	# notes
	if ($o->notes) {
		$g_content .= '<div class="col1">'._("Notes").':</div>';
  	$g_content .= '<div class="col2-2">'.$o->notes.'</div>';
  }
  
	# marriages
  foreach ($o->marriages as $m) {
		$fam_count++;
		$s = new person($m->spouse);
		$spouse_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$s->indkey)).'">'.$s->name.'</a>';
		
		$g_content .= '<br />';
 	 	$g_content .= '<p class="content-subtitle">'.sprintf(_("Family %s"), $fam_count).'</p>';
		$g_content .= '<div class="col1">'._("Spouse/Partner").':</div>';
		$g_content .= '<div class="col2-2">';
		$g_content .= $spouse_link;
		unset($spouse_link);
		if ($s->birth->date || $s->death->date) { $g_content .= '&nbsp;&nbsp;'; }
		if ($s->birth->date) { $g_content .= ' '._("b.").' '.$s->birth->date; }
		if ($s->death->date) { $g_content .= ' '._("d.").' '.$s->death->date; } 
		$g_content .= '</div>';
		unset($s);

		if ($m->beginstatus) {
			$g_content .= '<div class="col1">'._($m->beginstatus).':</div>';
			$g_content .= '<div class="col2">'.$m->date.'</div>';
			$g_content .= '<div class="col3">'.$m->place . disp_sources($m->sources).'</div>';
		}

 		if ($m->endstatus) {
		  $g_content .= '<div class="col1">'._($m->endstatus).':</div>';
			$g_content .= '<div class="col2">'.$m->enddate.'</div>';
			$g_content .= '<div class="col3">'.$m->endplace . disp_sources($m->end_sources).'</div>';
		}
  	
		if ($m->notes) {
		  $g_content .= '<div class="col1">'._("Notes").'</div>';
			$g_content .= '<div class="col2-2">'.$m->notes.'</div>';
		}
		
		# children
		if ($m->child_count > 0) {
			$g_content .= '<br />';
			$g_content .= '<div class="col1">'._("Children").':</div>';
			$k = 0;
			foreach ($m->children as $child_indkey) {
				$c = new person($child_indkey, 1);
				$child_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$c->indkey)).'">'.$c->name.'</a>';
				if ($k != 0) {
					$g_content .= '<div class="col1"></div>';
				}
				$g_content .= '<div class="col2-2">';
				$g_content .= $child_link;
				unset($child_link);
				if ($c->birth->date || $c->death->date) { $g_content .= '&nbsp;&nbsp;'; }
				if ($c->birth->date) { $g_content .= _("b.").' '.$c->birth->date.'&nbsp;&nbsp;'; }
				if ($c->death->date) { $g_content .= _("d.").' '.$c->death->date; }
				$g_content .= '</div>';
				$k++;
				unset($c);
			}
		}
		unset($m);
	}

	if (count($sources) > 0) {
		$g_content .= '<br /><p class="content-subtitle">'._("Source Citations").'</p><ol>';
		$src_count = 0;
		foreach ($sources as $source) {
			$src_count++;
			$g_content .= '<li value="'.($src_count).'">'.$source.'<a name="s'.($src_count).'"></a></li>';
		}
		$g_content .= '</ol>';
		unset($sources);
		unset($src_count);
	}
	$g_content .= '</div>';
?>
