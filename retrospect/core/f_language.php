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
 *
 * $Id$
 *
 */

	/**
	* Initialize Gettext
	* @access public
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
		header("Content-type: text/html; charset={$charset}");
		
		# assign all the possible labels
		$smarty->assign('label_aka', 		gtc("Aka"));
		$smarty->assign('label_gender', gtc("Gender"));
		$smarty->assign('label_father', gtc("Father"));
		$smarty->assign('label_mother', gtc("Mother"));
		$smarty->assign('label_birth', 	gtc("Birth"));
	}
	
	/** 
	* Get list of supported languages
	* @return array 
	*/
	function lang_get_langs() {
		global $db, $options;
		if ($options->GetOption('allow_lang_change') == 1) {
			$sql = "SELECT lang_name, lang_code FROM ".TBL_LANG;
			return $db->GetAll($sql);
		}
	}
	
	/**
	* Translate Date
	* 
	* Translates month names into the appropriate language
	* @param string $p_date english language date
	* @return string translated date string
	*/
	function lang_translate_date($date) {
		$orig_mon = array('/jan/i','/feb/i','/mar/i','/apr/i','/may/i',
			'/jun/i','/jul/i','/aug/i','/sep/i','/oct/i','/nov/i','/dec/i');
		$repl_mon = array(gtc("Jan"),gtc("Feb"),gtc("Mar"),gtc("Apr"),gtc("May"),
			gtc("Jun"),gtc("Jul"),gtc("Aug"),gtc("Sep"),gtc("Oct"),gtc("Nov"),gtc("Dec"));
		return preg_replace($orig_mon, $repl_mon, $date);
	}
	
	/**
	* Translate date modifier
	*
	* Translates date modifiers such as Abt, Bet, Aft
	* @param string $p_date english language modifier
	* @return string translated date modifier
	*/
	function lang_translate_mod($mod) {
		return gtc(strtolower($mod));
	}
	
	/**
	* Gettext wrapper function
	*
	* We use this wrapper instead of the native gettext function call so that
	* we have better control over the process.  This function returns strings that
	* have been passed through htmlentities.
	* @param string $string
	* @return string
	*/
	function gtc($string) {
		return htmlentities(gettext($string));
	}
	
	/** 
	* Smarty gettext plugin function
	*/
	function lang_translate_smarty($params) {
		if ($params['s']) {
			return gtc($params['s']);
		} else {
			return '';
		}
	}
?>