<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        function.validate.php
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

function smarty_function_validate($params, &$smarty) {

    $_init_params = $smarty->get_template_vars('validate_init');

    if(isset($_init_params)) {
        $params = array_merge($_init_params, $params);
    }
    
    static $_halt = array();

    $_form = isset($params['form']) ? $params['form'] : 'default';
    
    if(!SmartyValidate::is_registered_form($_form)) {
        trigger_error("SmartyValidate: [validate plugin] form '$_form' is not registered.");
        return false;
    }    
    
    if(isset($_halt[$_form]) && $_halt[$_form])
        return;    
    
    if (!class_exists('SmartyValidate')) {
        $smarty->trigger_error("validate: missing SmartyValidate class");
        return;
    }
    if (!isset($_SESSION['SmartyValidate'])) {
        $smarty->trigger_error("validate: SmartyValidate is not initialized, use connect() first");
        return;        
    }
    if (strlen($params['field']) == 0) {
        $smarty->trigger_error("validate: missing 'field' parameter");
        return;
    }
    if (strlen($params['criteria']) == 0) {
        $smarty->trigger_error("validate: missing 'criteria' parameter");
        return;
    }
    if(isset($params['trim'])) {
        $params['trim'] = SmartyValidate::_booleanize($params['trim']);   
    } else {
        $params['trim'] = false;   
    }
    if(isset($params['empty'])) {
        $params['empty'] = SmartyValidate::_booleanize($params['empty']);
    } else {
        $params['empty'] = false;   
    }
    if(isset($params['halt'])) {
        $params['halt'] = SmartyValidate::_booleanize($params['halt']);
    } else {
        $params['halt'] = false;
    }

    if(strlen($params['criteria']) == 0) {        
            $smarty->trigger_error("validate: parameter 'criteria' missing.");
            return;                
    }
      
    $_sess =& $_SESSION['SmartyValidate'][$_form];
    
    $_found = false;
    if(isset($_sess['validators']) && is_array($_sess['validators'])) {
        foreach($_sess['validators'] as $_key => $_field) {
            if($_field['field'] == $params['field']
                && $_field['criteria'] == $params['criteria']) { 
                // field exists
                $_found = true;
                if(isset($_sess['validators'][$_key]['valid'])
                        && !$_sess['validators'][$_key]['valid']) {
                    // not valid, show error and reset
                    $_halt[$_form] = $params['halt'];
                    $_echo = true;
                    if(!isset($params['assign'])
                        && !isset($params['append'])) {
                        // no assign or append, so echo message
                        echo $_sess['validators'][$_key]['message'];
                    }
                    $_sess['validators'][$_key]['valid'] = null;
                    break;
                }
            }
        }
    }
    if(!$_found) {
        // initialize validator
        $_sess['validators'][] = $params;
        $_sess['is_init'] = true;
    }
}

?>
