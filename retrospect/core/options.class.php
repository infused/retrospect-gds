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
		* Options class constructor
		* @access public
		*/
		function Options() {
			$this->Initialize();
		}
		
		
		/** 
		*	Initializes the class
		* Loads options from the database and stuffs them into
		* class variables.  For example if an option has a key name of 
		* myoption and a value of 'dosomething' then a class variable is
		* created with a name of $this->myoption = 'dosomething'
		* @access public
		*/
		function Initialize() {
			global $g_tbl_option, $db;
			$sql = "SELECT * FROM $g_tbl_option";
			$rs = $db->Execute($sql);
			while ($row = $rs->FetchRow()) {
				$optkey = $row['opt_key'];
				$this->{$optkey} = $row['opt_val'];
			}
		}
		
		/**
		* GetOption
		* Returns a single option value.
		* This function returns null if the option is not found.
		* @param string $optkey
		* @return mixed
		*/
		function GetOption($optkey) {
			if (isset($this->{$optkey})) { 
				return $this->{$optkey};
			} else {
				return null;
			}
		}
		
		/**
		* OptionUpdate
		* Updates the option parameters in the options table
		* @param string $opt_val
		* @param string $opt_key
		* @return boolean
		*/
		function OptionUpdate($opt_val, $opt_key) {
			global $db, $g_tbl_option;
			$sql = "UPDATE {$g_tbl_option} SET opt_val='{$opt_val}' WHERE opt_key='{$opt_key}'";
			if ($db->Execute($sql)) {
				return true;
			} else {
				return false;
			}
		}
	}
?>