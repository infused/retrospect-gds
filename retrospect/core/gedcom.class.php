<?php
/**
 * Gedcom classes
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		gedcom
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
 	* GedcomParser class
 	* @package public
 	* @access public
 	*/
	class GedcomParser {
	
		var $filename; 
		var $fhandle;
		var $fsize;
		
		
		/**
		* GedcomParser class constructor
		* @access public
		*/
		function GedcomParser() {
			# initialize 
		}
		
		/** 
		* OpenFile 
		* 
		* Opens the gedcom file in readonly mode and sets fhandle var.
		* @access public
		* @param $filename
		* @return boolean
		*/
		function OpenReadOnly($filename) {
			$handle = @fopen($filename, 'rb');
			if ($handle == false) {
				return false;
			} else {
				$this->fhandle = $handle;
				$this->fsize = sprintf("%u", filesize($filename));
				return true;
			}
		}
		
		/**
		* Open
		* 
		* Alias for OpenReadOnly
		* @access public
		* @param $filename
		* @return boolean
		*/
		function Open($filename) {
			$tmp = $this->OpenReadOnly($filename);
			return $tmp;
		}
		
		
 	}
 
?>