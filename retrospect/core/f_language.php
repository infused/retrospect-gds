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
		global $db, $options, $g_langs, $g_tbl_lang;
		
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
		$sql = "SELECT lang_charset FROM {$g_tbl_lang} WHERE lang_code = '{$lang}'";
		$charset = $db->GetOne($sql);

		# if gettext is available initialize with the default language
		# use LC_ALL because some operating systems do not support 
		# the LC_MESSAGES domain
		if (extension_loaded('gettext')) {
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
		}
		# if gettext is not available redefine some simple gettext functions
		else {
			function gettext($p_string) {
				return $p_string;
			}
			function _($p_string) {
				return $p_string;
			}
		}
		# get list of supported languages 
		if ($options->GetOption('allow_lang_change') == 1) {
			$sql = "SELECT lang_name, lang_code FROM {$g_tbl_lang}";
			$g_langs = $db->GetAll($sql);
		}
	}
	
	/**
	* Translate Date
	* 
	* Translates month names into the appropriate language
	* @access public
	* @param string $p_date english language date
	* @return string translated date string
	*/
	function lang_translate_date($p_date) {
		global $options;
		if ($_SESSION['lang'] != 'en_US' and $options->GetOption('translate_dates') == 1) {
			# replace month names
			$p_date = str_replace(array('jan', 'Jan', 'JAN'), _("Jan"), $p_date);
			$p_date = str_replace(array('feb', 'Feb', 'FEB'), _("Feb"), $p_date);
			$p_date = str_replace(array('mar', 'Mar', 'MAR'), _("Mar"), $p_date);
			$p_date = str_replace(array('apr', 'Apr', 'APR'), _("Apr"), $p_date);
			$p_date = str_replace(array('may', 'May', 'MAY'), _("May"), $p_date);
			$p_date = str_replace(array('jun', 'Jun', 'JUN'), _("Jun"), $p_date);
			$p_date = str_replace(array('jul', 'Jul', 'JUL'), _("Jul"), $p_date);
			$p_date = str_replace(array('aug', 'Aug', 'AUG'), _("Aug"), $p_date);
			$p_date = str_replace(array('sep', 'Sep', 'SEP'), _("Sep"), $p_date);
			$p_date = str_replace(array('oct', 'Oct', 'OCT'), _("Oct"), $p_date);
			$p_date = str_replace(array('nov', 'Nov', 'NOV'), _("Nov"), $p_date);
			$p_date = str_replace(array('dec', 'Dec', 'DEC'), _("Dec"), $p_date);
		
			# replace date qualifiers
			$p_date = str_replace(array('abt', 'Abt', 'ABT', 'about', 'About', 'ABOUT'), _("abt"), $p_date);
			$p_date = str_replace(array('cir', 'Cir', 'CIR', 'circa', 'Circa', 'CIRCA'), _("cir"), $p_date);
			$p_date = str_replace(array('aft', 'Aft', 'AFT', 'after', 'After', 'AFTER'), _("aft"), $p_date);
			$p_date = str_replace(array('bef', 'Bef', 'BEF', 'before', 'Before', 'BEFORE'), _("bef"), $p_date);
			$p_date = str_replace(array('bet', 'Bet', 'BET', 'between', 'Between', 'BETWEEN'), _("bet"), $p_date);
			$p_date = str_replace(array('cal', 'Cal', 'CAL', 'calculated', 'Calculated', 'CALCULATED'), _("cal"), $p_date);		
		}
		return $p_date;
	}
?>