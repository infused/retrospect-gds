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

	# create page title
	$g_title = sprintf(_("Family Page for %s"), $o->name);
	
	# create father link
	if ($o->father_indkey) { 
		$f = new person($o->father_indkey, 3); 
		$father_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$f->indkey)).'">'.$f->name.'</a>';	
		unset($f);
	}
	else { $father_link = '&nbsp;'; }
	
	# create mother link
	if ($o->mother_indkey) { 
		$m = new person($o->mother_indkey, 3); 
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
	echo '<p class="content-title">'.$o->name;
	if (isset($o->title) and $o->title != '') { $g_content .= ', '.$o->title; }
	echo '</p>';
	if ($print === false) {
		include(Theme::getPage($g_theme, 'nav'));
	}
  
	# vitals
	?>
	<p class="content-subtitle"><?php echo _("Family Page"); ?></p>
	<div class="tab-page">
	<?php
	if (!empty($o->aka)) { ?>
		<div class="col1"><?php echo _("Aka"); ?></div>
		<div class="col2-2"><?php echo $o->aka; ?></div>
	<?php } ?>
	<div class="col1"><?php echo _("Gender"); ?></div>
	<div class="col2"><?php echo _($o->gender); ?></div>
  <div class="col3">&nbsp;</div>
	<div class="col1"><?php echo _("Father"); ?>:</div>
	<div class="col2-2"><?php echo $father_link; unset($father_link); ?></div>
	<div class="col1"><?php echo _("Mother"); ?>:</div>
  <div class="col2-2"><?php echo $mother_link; unset($mother_link); ?></div>
  <div class="col1"><?php echo _("Birth"); ?>:</div>
	<div class="col2"><?php echo $o->birth->date; ?></div>
  <div class="col3"><?php echo $o->birth->place . disp_sources($o->birth->sources); ?></div>
	<div class="col1"><?php echo _("Death"); ?>:</div>
  <div class="col2"><?php echo $o->death->date; ?></div>
  <div class="col3"><?php echo $o->death->place . disp_sources($o->death->sources); ?></div>
	
	<?php
	# events
	foreach($o->events as $event) { ?>
		<div class="col1"><?php echo _($event->type); ?>:</div>
		<div class="col2"><?php echo $event->date; ?></div>
		<div class="col3"><?php echo $event->place . disp_sources($event->sources); ?></div>
	<?php } 
	
	# notes
	if ($o->notes) { ?>
		<div class="col1"><?php echo _("Notes"); ?>:</div>
  	<div class="col2-2"><?php echo $o->notes; ?></div>
  <?php }
  
	# marriages
  foreach ($o->marriages as $m) {
		$fam_count++;
		$s = (!empty($m->spouse)) ? new person($m->spouse, 3) : null;
		$spouse_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$s->indkey)).'">'.$s->name.'</a>';
		?>
		<br />
 	 	<p class="content-subtitle"><?php printf(_("Family %s"), $fam_count); ?></p>
		<div class="col1"><?php echo _("Spouse/Partner"); ?>:</div>
		<div class="col2-2">
		<?php 
			echo $spouse_link; 
			unset($spouse_link);
			if ($s->birth->date || $s->death->date) { echo '&nbsp;&nbsp;'; }
			if ($s->birth->date) { echo ' '._("b.").' '.$s->birth->date; }
			if ($s->death->date) { echo ' '._("d.").' '.$s->death->date; } 
			unset($s);
		?>
		</div>
		
		<?php
		if ($m->beginstatus) {
			echo '<div class="col1">'._($m->beginstatus).':</div>';
			echo '<div class="col2">'.$m->date.'</div>';
			echo '<div class="col3">'.$m->place . disp_sources($m->sources).'</div>';
		}

 		if ($m->endstatus) {
		  echo '<div class="col1">'._($m->endstatus).':</div>';
			echo '<div class="col2">'.$m->enddate.'</div>';
			echo '<div class="col3">'.$m->endplace . disp_sources($m->end_sources).'</div>';
		}
  	
		if ($m->notes) {
		  echo '<div class="col1">'._("Notes").'</div>';
			echo '<div class="col2-2">'.$m->notes.'</div>';
		}
		
		# children
		if ($m->child_count > 0) {
			echo '<br />';
			echo '<div class="col1">'._("Children").':</div>';
			$k = 0;
			foreach ($m->children as $child_indkey) {
				$c = new person($child_indkey, 3);
				$child_link = '<a href="'.Theme::GetArgs('family', array('indiv'=>$c->indkey)).'">'.$c->name.'</a>';
				if ($k != 0) {
					echo '<div class="col1"></div>';
				}
				echo '<div class="col2-2">';
				echo $child_link;
				unset($child_link);
				if ($c->birth->date || $c->death->date) { echo '&nbsp;&nbsp;'; }
				if ($c->birth->date) { echo _("b.").' '.$c->birth->date.'&nbsp;&nbsp;'; }
				if ($c->death->date) { echo _("d.").' '.$c->death->date; }
				echo '</div>';
				$k++;
				unset($c);
			}
		}
		unset($m);
	}

	if (count($sources) > 0) {
		echo '<br /><p class="content-subtitle">'._("Source Citations").'</p><ol>';
		$src_count = 0;
		foreach ($sources as $source) {
			$src_count++;
			echo '<li value="'.($src_count).'">'.$source.'<a name="s'.($src_count).'"></a></li>';
		}
		echo '</ol>';
		unset($sources);
		unset($src_count);
	}
	echo '</div>';
?>
