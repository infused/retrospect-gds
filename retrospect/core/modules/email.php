<?php
/**
 * Email-this
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
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
	
	# Define some regular expressions
	define('REG_EMAIL', '/[_a-zA-Z\d\-\.]+@([_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+)/');
	
	$subject = 'Test';
	
	$errors = array();
	$smarty->assign('page_title', gtc("Email to a friend"));
	$smarty->assign('content_title', gtc("Email to a friend"));
	
	$decoded = ($_GET['ln']) ? base64_decode(urldecode($_GET['ln'])) : $_POST['ln'];
	$smarty->assign('TRACKBACK_URL', $decoded);

	# Verify and send email
	if (isset($_POST['send'])) {
		$to = $_POST['to'];
		$from = $_POST['from'];
		$name = $_POST['name'];
		$message = $_POST['message']; 
		
		# Check that email addresses are formatted correctly
		if ($to == '') { 
			$errors[] = "Friend's email is blank"; 
		} else {
			if (!preg_match(REG_EMAIL, $to)) {
				$errors[] = "Friend's email is invalid"; 
			}
		}
		if ($from == '') { 
			$errors[] = "Your email is blank"; 
		} else {
			if (!preg_match(REG_EMAIL, $from)) {
				$errors[] = "Your email is invalid"; 
			}
		}
		if ($name == '') {
			$errors[] = "Full name is blank";
		}
		
		$smarty->assign('errors', $errors);
		$smarty->assign('to', $to);
		$smarty->assign('from', $from);
		$smarty->assign('name', $name);
		$smarty->assign('message', $message);
		
		# Send the email
		if (count($errors) <= 0) {
			$smarty->assign('sending', true);
			$headers = 'From: '.$from."\r\n";
			mail($to, $subject, $message, $headers);
		}
	}

?>
