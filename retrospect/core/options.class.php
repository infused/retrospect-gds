<?php 
/**
 * Option classes
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		options
 * @license http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
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
	* Options class
	* 
	* When instantiated, this class loads configuration options from the db.
	* @package options
	*/
	class Options {
		
		/**
		* Default Language
		* @access public
		* @var string
		*/
		var $default_lang;
		
		/**
		* Allow Language Changes
		* @access public
		* @var boolean
		*/
		var $allow_lang_change;
		
		/** 
		* Default Page
		* 
		* This page is loaded if no options are specified as _GET variables
		* @access public
		* @var string
		*/
		var $default_page;
		
		/**
		* Translate Dates
		*
		* Boolean flag specifying whether dates should be translated or not
		* @access public
		* @var boolean
		*/
		var $translate_dates;
		
		/**
		* Options Class Constructor
		* @access public
		*/
		function Options() {
			$this->GetAll();
		}
		
		function GetAll() {
			global $g_tbl_option, $db;
			$sql = "SELECT * FROM $g_tbl_option";
			$rs = $db->Execute($sql);
			while ($row = $rs->FetchRow()) {
				$optkey = $row['opt_key'];
				$this->{$optkey} = $row['opt_val'];
			}
			
			# declare some defaults just in case
			if (!isset($this->default_page)) {
				$this->default_page = 'surnames';
			}
			if (!isset($this->default_lang)) {
				$this->default_lang = 'en_US';
			}
			if (!isset($this->allow_lang_change)) {
				$this->allow_lang_change = true;
			}
		}
		
		function OptionUpdate($opt_val_new, $opt_val_old, $opt_key) {
			global $db, $g_tbl_option;
			$sql = "UPDATE {$g_tbl_option} SET opt_val='{$opt_val_new}' WHERE opt_key='{$opt_key}'";
			if ($db->Execute($sql)) {
				return true;
			}
			else {
				return false;
			}
		}
	}
?>