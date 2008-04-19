<?php
	/**
	* @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
	
	# Assign Smarty vars
	$smarty->assign('UPLOAD_MAX_FILESIZE', ini_get('upload_max_filesize'));
	
	# Handle file uploads
	if (isset($_POST['Upload'])) {	
		switch ($_FILES['file']['error']) {
			case 4:
				$smarty->assign('UPLOAD_ERROR', 'No file was selected for upload.');
				break;
			case 3:
				$smarty->assign('UPLOAD_ERROR', 'The file upload did not complete.  Please try again.');
				break;
			case 2:
			case 1:
				$smarty->assign('UPLOAD_ERROR', 'The file is too large to upload.');
				break;
			case 0:
				$uploadfile = GEDCOM_DIR.$_FILES['file']['name'];
				# Check for valid file extension (no mime)
				$valid_extensions = array('ged','zip');
				$pathinfo = pathinfo($uploadfile);
				$extension = strtolower($pathinfo['extension']);
				if (!in_array($extension, $valid_extensions)) {
					$smarty->assign('UPLOAD_ERROR', 'Only .ged or .zip files are allowed.');
					break;
				}
				# Check if gedcom directory is writable
				if (!is_writable(GEDCOM_DIR)) { 
					$smarty->assign('UPLOAD_ERROR', 'The gedcom directory is not writable. Check your server configuration.');
					break;
				}
				# Check if file already exists
				if (file_exists($uploadfile)) {
					$smarty->assign('UPLOAD_ERROR', 'A file with the same name already exists.');
					break;
				}
				# Move the file
				if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
					$smarty->assign('UPLOAD_ERROR', 'Error moving file to the gedcom directory.  Check your server configuration.');
					break;
				}
				# Extract gedcoms from zip files and cleanup
				if (strtolower($extension) == 'zip') {
					# load the pclzip library
					require_once(LIB_PATH.'pcl/pclzip.lib.php');
					$zip = new pclzip($uploadfile);
					# extract only .ged files (case insensitive)
					$zip->extract(PCLZIP_OPT_PATH, GEDCOM_DIR, PCLZIP_OPT_BY_PREG, '/ged$/i');
					# remove the zip file
					unlink($uploadfile);
				} 
				# Success
				$smarty->assign('UPLOAD_SUCCESS' , '1');
				$smarty->assign('REDIRECT', $_SERVER['PHP_SELF'].'?m=gedcom');
				break; 
		}
	}
?>