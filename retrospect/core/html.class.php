<?php
/**
 * Language Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		core
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

	class HTML {
	
		/** 
		*	Listbox
		* This function creates a listbox and populates it with items
		* from the $options variable.  Name and Id are both set to the 
		* $name variable.  If $selected is provided, the option with a value
		* matching $selected will be selected by default.
		* @access public
		* @param string $name 
		* @param array $options (in the form 'option'=>'value')
		* @param string $class
		* @param mixed $selected
		* @return string
		*/
		function listbox($name, $options, $class = null, $selected = null) {
			$listbox = '<select name="'.$name.'" id="'.$name.'"';
			if (!is_null($class)) {
				$listbox .= ' class="'.$class.'"';
			}
			$listbox .= '>';
			foreach($options as $option => $value) {
				$listbox .= '<option value="'.$value.'"';
				if (!is_null($selected) AND $selected == $value) {
					$listbox .= ' selected';
				}
				$listbox .= '>'.$option.'</option>';
			}
			
			$listbox .= '</select>';
			return $listbox;
		}
	}

?>