<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        validate_criteria.isFileType.php
 * Author:      Monte Ohrt <monte@ispi.net>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://www.phpinsider.com/php/code/SmartyValidate/
 * @copyright 2001-2004 ispi of Lincoln, Inc.
 * @author Monte Ohrt <monte@ispi.net>
 * @package SmartyValidate
 * @version 2.3-dev
 */

/**
 * test if a value is a valid file type. This only checks the
 * file extention, it does not test the actual file type.
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isFileType($value, $empty, &$params, &$formvars) {
    if(!isset($_FILES[$value]))
        // nothing in the form
        return false;
    
    if($_FILES[$value]['error'] == 4)
        // no file uploaded
        return $empty;

    if(!preg_match('!\.(\w+)$!i', $_FILES[$value]['name'], $_match))
        // not valid filename
        return false;
    
    $_file_ext = $_match[1];            
    $_types = preg_split('![\s,]+!', $params['type'], -1, PREG_SPLIT_NO_EMPTY);
    foreach($_types as $_key => $_val) {
        $_types[$_key] = strtolower($_types[$_key]);   
    }
        
    if(!in_array(strtolower($_file_ext),$_types))
        // not valid file extention
        return false;
        
    return true;
}

?>
