<?php
/**
 * Language Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2005
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		language
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
 
 /*
 * $Id$
 */

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );
	
	/**
	* Initialize Gettext
	*/
	function lang_init_gettext() {
		global $db, $options, $smarty;
		
		# determine current language
		if (isset($_POST['lang'])) { 
			$lang = $_POST['lang']; 
			$_SESSION['language'] = $lang; 
		}
		elseif (isset($_SESSION['language'])) { 
			$lang = $_SESSION['language']; 
		}
		else { 
			$lang = $options->GetOption('default_lang'); 
			$_SESSION['language'] = $lang;
		}
		
		# grab the correct charset from the database
		$sql = "SELECT lang_charset FROM ".TBL_LANG." WHERE lang_code = '{$lang}'";
		$charset = $db->GetOne($sql);

		# use LC_ALL because some operating systems do not support 
		# the LC_MESSAGES domain
		setlocale(LC_ALL, $lang);
		bindtextdomain('messages', LOCALE_PATH); 
		textdomain('messages');	
		
		# do not try to set environment var if safe mode is on
		# (this will break gettext on some windows platforms)
		if (!ini_get('safe_mode')) {
			putenv('LC_ALL='.$lang);
			putenv('LANG='.$lang);
			putenv('LANGUAGE='.$lang);
		}
		
		header('Content-type: text/html; charset='.$charset);
	}
	
	/** 
	* Populated the globals $lang_names and $lang_codes
	* with the supported language descriptive names and locale codes
	*/
	function lang_init_arrays() {
		global $db, $lang_names, $lang_codes;
		$sql = 'SELECT lang_name, lang_code FROM '.TBL_LANG;
		$langs = $db->GetAll($sql);
		foreach ($langs as $lang) {
			$lang_names[] = gtc($lang['lang_name']);
			$lang_codes[] = $lang['lang_code'];
		}
	}
	
	/**
	* Gettext wrapper function
	*
	* We use this wrapper instead of the native gettext function call so that
	* we have better control over the process.
	* @param string $string
	* @return string
	*/
	function gtc($string) {
		return gettext($string);
	}
	
	/** 
	* Smarty gettext plugin function
	*/
	function lang_translate_smarty($params) {
		if ($params['s']) {
			$s = $params['s'];
			return gtc($s);
		} else return '';
	}
	
	function t($string) {
		echo htmlentities(gettext($string));
	}
?>