<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        validate_criteria.isFileSize.php
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
 * test if a value is a valid file size.
 *
 * @param string $value the value being tested
 * @param boolean $empty if field can be empty
 * @param array params validate parameter values
 * @param array formvars form var values
 */
function smarty_validate_criteria_isFileSize($value, $empty, &$params, &$formvars) {
    if(!isset($_FILES[$value]))
        // nothing in the form
        return false;
    
    if($_FILES[$value]['error'] == 4)
        // no file uploaded
        return $empty;

    if(!isset($params['max'])) {
        trigger_error("SmartyValidate: [isFileSize] 'max' attribute is missing.");        
        return false;           
    }
    
    $_max = trim($params['max']);
    
    if(!preg_match('!^(\d+)([bkmg](b)?)?$!i', $_max, $_match)) {
        trigger_error("SmartyValidate: [isFileSize] 'max' attribute is invalid.");        
        return false;   
    }
    $_size = $_match[1];
    $_type = strtolower($_match[2]);
    
    switch($_type) {
        case 'k':
            $_maxsize = $_size * 1024;            
            break;
        case 'm':
            $_maxsize = $_size * 1024 * 1024;            
            break;
        case 'g':
            $_maxsize = $_size * 1024 * 1024 * 1024;
            break;
        case 'b':
        default:
            $_maxsize = $_size;
            break;   
    }
    
    return $_FILES[$value]['size'] <= $_maxsize;
}

?>
