<?php 
/**
 * Comment add
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
	
	# get first person information
	$o = new person($g_indiv);
	$smarty->assign('indiv', $o);
	
	# populate keyword array
	keyword_push(gtc("Comments"));
	keyword_push($o->name);
	
	# assign other smarty variables
	$smarty->assign('page_title', sprintf(gtc("Comments for %s"), $o->name));
	$smarty->assign('surname_title', sprintf(gtc("%s Surname"), $o->sname));
	$content_title = $o->prefix.' '.$o->name;
	if ($o->suffix) $content_title .= ', '.$o->suffix;
	$smarty->assign('content_title', $content_title);
	$smarty->assign('comment_count', count_comments($g_indiv));
	
	# If the form has been posted then let's validate the form variables
	if (!empty($_POST)) {
		if (empty($_POST['email'])) {
			$form_errors['email'] = 'YOU MUST ENTER AN EMAIL ADDRESS';
		} elseif (!is_email(trim($_POST['email']))) {
			$form_errors['email'] = 'THE EMAIL ADDRESS YOU ENTERED IS NOT VALID';
		}
		if (empty($_POST['comment'])) {
			$form_errors['comment'] = 'PLEASE ENTER SOME TEXT';
		}
		$smarty->assign('form_errors', $form_errors);
			
		# The form validated ok, so now save the data
		if (!$form_errors) {	
			insert_comment($g_indiv, $_POST['email'], $_POST['comment']);
			$smarty->assign('SAVED',1);
		}
	} 

?>