<?php
/**
 * Language Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
	function lang_init() {
		global $db, $options, $smarty, $charset, $lang_strings;
		
		# determine current language
		if (isset($_POST['lang'])) $lang = $_POST['lang'];  
		else $lang = isset($_SESSION['language']) ? $_SESSION['language'] : $options->GetOption('default_lang'); 
		
		# store the current language in the session
		$_SESSION['language'] = $lang;  
		
		# grab the correct charset from the database
		$sql = "SELECT lang_charset FROM ".TBL_LANG." WHERE lang_code = '{$lang}'";
		$charset = $db->GetOne($sql);
		
		# we can't rely on the html meta tag to enforce the character set if 
		# the the server has a default character set specified
		header('Content-Type: text/html; charset='.$charset);
		require(ROOT_PATH.'/locale/'.$lang.'.php');
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
	* @param string $key
	* @return string
	*/
	function gtc($key) {
		global $lang_strings;
		if (array_key_exists($key, $lang_strings) AND !empty($lang_strings[$key])) return $lang_strings[$key];
		else return $key;
	}
	
	/**
	* Another gettext wrapper.  This one echo's the output rather than returning it as a string
	* @param string $key
	*/
	function t($key) {
	  echo gtc($key);
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

?>