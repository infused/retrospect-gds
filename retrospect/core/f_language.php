<?php
/**
 * Language Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
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
		global $db, $options, $g_langs, $smarty;
		
		# determine current language
		if (isset($_POST['lang'])) { 
			$lang = $_POST['lang']; 
			$_SESSION['lang'] = $lang; 
		}
		elseif (isset($_SESSION['lang'])) { 
			$lang = $_SESSION['lang']; 
		}
		else { 
			$lang = $options->GetOption('default_lang'); 
			$_SESSION['lang'] = $lang;
		}
		
		# get charset
		$sql = "SELECT lang_charset FROM ".TBL_LANG." WHERE lang_code = '{$lang}'";
		$charset = $db->GetOne($sql);

		# use LC_ALL because some operating systems do not support 
		# the LC_MESSAGES domain
		setlocale(LC_ALL, $lang);
		bindtextdomain('messages', LOCALE_PATH); 
		textdomain('messages');	
		# do not try to set environment var if safe mode is on
		# (this may break gettext on some windows platforms)
		if (!ini_get('safe_mode')) {
			putenv('LC_ALL='.$lang);
			putenv('LANG='.$lang);
			putenv('LANGUAGE='.$lang);
		}
		# set correct charset in header
		header('Content-type: text/html; charset='.$charset);
	}
	
	/** 
	* Get list of supported languages
	* @return array 
	*/
	function lang_get_langs() {
		global $db;
		$sql = 'SELECT lang_name, lang_code FROM '.TBL_LANG;
		return $db->GetAll($sql);
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