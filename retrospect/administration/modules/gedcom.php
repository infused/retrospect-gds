<?php
	/**
	* @copyright 	Keith Morrison, Infused Solutions	2001-2004
	* @author			Keith Morrison <keithm@infused-solutions.com>
	* @package 		Administration
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
	
	$smarty->assign('page_title', 'Retrospect-GDS Administration');
	
	# Process tasks
	if (isset($_POST['Submit'])) {
		$task = $_POST['task'];
		$selected = $_POST['selectitem'];
		if ($task == 'delete') {
			foreach ($selected as $filename) {
				@unlink(GEDCOM_DIR.$filename);
				$deleted[] = $filename;
			}
			$smarty->assign('DELETED', $deleted);
			$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=gedcom');
		}
	}
	
	# Get a list of gedcom files
	$gedcoms = array();
	$dir = dir(GEDCOM_DIR);
	while (($filename = $dir->read()) !== false) {
		$info = pathinfo($filename);
		$gedcomfile = GEDCOM_DIR.$filename;
		if (isset($info['extension']) AND strtolower($info['extension']) == 'ged') {
			$gedcom['filename'] = $filename;
			$gedcom['filepath'] = BASE_URL.'/../gedcom/'.$filename;
			$gedcom['timestamp'] = date('F d Y H:i:s', filemtime($gedcomfile));
			$gedcom['size'] = number_format(filesize($gedcomfile));
			$gedcoms[] = $gedcom;
		}
	}

	# Create task list
	$tasks = array('na'=>'With selected:','delete'=>'Delete');
	
	# Assign Smarty vars
	$smarty->assign('gedcoms', $gedcoms);
	$smarty->assign('tasks', $tasks);
?>