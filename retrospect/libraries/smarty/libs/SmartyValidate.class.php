<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        SmartyValidate.class.php
 * Author:      Monte Ohrt <monte at newdigitalgroup dot com>
 * Website:     http://www.phpinsider.com/php/code/SmartyValidate/
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
 * @copyright 2001-2005 New Digital Group, Inc.
 * @author Monte Ohrt <monte at newdigitalgroup dot com>
 * @package SmartyValidate
 * @version 2.4-dev
 */


class SmartyValidate {

    /**
     * Class Constructor
     */
    function SmartyValidate() { }

    
    /**
     * initialize the validator
     *
     * @param obj    $smarty the smarty object
     * @param string $reset reset the default form?
     */
    function connect(&$smarty, $reset = false) {
        if(is_object($smarty) && (strtolower(get_class($smarty)) == 'smarty' || is_subclass_of($smarty, 'smarty'))) {
            SmartyValidate::_object_instance('Smarty', $smarty);
            SmartyValidate::register_form('default', $reset);
        } else {
            trigger_error("SmartyValidate: [connect] I need a valid Smarty object.");
            return false;
        }
    }   

    /**
     * clear the entire SmartyValidate session
     *
     */
    function disconnect() {
        unset($_SESSION['SmartyValidate']);
        SmartyValidate::_object_instance('-', $_dummy);
    }    
            
    /**
     * initialize the session data
     *
     * @param string $form the name of the form being validated
     * @param string $reset reset an already registered form?
     */
    function register_form($form, $reset = false) {
        if(SmartyValidate::is_registered_form($form) && !$reset) {
            return false;
        } else {
            $_SESSION['SmartyValidate'][$form] = array();
            $_SESSION['SmartyValidate'][$form]['registered_funcs']['criteria'] = array();
            $_SESSION['SmartyValidate'][$form]['registered_funcs']['transform'] = array();
            $_SESSION['SmartyValidate'][$form]['validators'] = array();
            $_SESSION['SmartyValidate'][$form]['is_error'] = false;
            $_SESSION['SmartyValidate'][$form]['is_init'] = false;
            SmartyValidate::_smarty_assign();
            return true;
        }
    }
    
    /**
     * unregister a form from the session
     *
     * @param string $form the name of the form being validated
     */
    function unregister_form($form) {
        unset($_SESSION['SmartyValidate'][$form]);
    }    
    
    /**
     * test if the session data is initialized
     *
     * @param string $form the name of the form being validated
     */
    function is_registered_form($form = 'default') {    
        return isset($_SESSION['SmartyValidate'][$form]);
    }    
            
    /**
     * validate the form
     *
     * @param string $formvars the array of submitted for variables
     * @param string $form the name of the form being validated
     */
    function is_valid(&$formvars, $form = 'default') {
        
        if(!SmartyValidate::is_registered_form($form)) {
            trigger_error("SmartyValidate: [is_valid] form '$form' is not registered.");
            return false;
        } elseif (!$_SESSION['SmartyValidate'][$form]['is_init']) {
            // session expired or lost or not yet initialized, fail validation
            return false;            
        }
        
        // keep track of failed fields for current pass
        static $_failed_fields = array();
        
        $_ret = true;
        $_sess =& $_SESSION['SmartyValidate'][$form]['validators'];
        $_smarty_assign_fields = array();
        foreach($_sess as $_key => $_val) {
            $_field = $_sess[$_key]['field'];
            $_empty = $_sess[$_key]['empty'];
            $_assign = isset($_sess[$_key]['assign']) ? $_sess[$_key]['assign'] : null;
            $_append = isset($_sess[$_key]['append']) ? $_sess[$_key]['append'] : null;
            $_message = isset($_sess[$_key]['message']) ? $_sess[$_key]['message'] : null;
            
            if(in_array($_field, $_failed_fields)) {
                // already failed, skip this test
                continue;   
            }
            
            if(isset($_sess[$_key]['transform'])) {
                $_trans_names = preg_split('![\s,]+!', $_sess[$_key]['transform'], -1, PREG_SPLIT_NO_EMPTY);
                if($_sess[$_key]['trim']) {
                    // put trim on front of transform array
                    array_unshift($_trans_names, 'trim');
                }
                foreach($_trans_names as $_trans_name) {
                    if(substr($_trans_name,0,1) == '@') {
                        // transformation will apply to entire array
                        $_trans_on_array = true;   
                        $_trans_name = substr($_trans_name,1);   
                    } else {
                        // transformation will apply to each array element
                        $_trans_on_array = false;
                    }
                    if(is_array($formvars[$_field]) && !$_trans_on_array) {
                        for($_x = 0, $_y = count($formvars[$_field]); $_x < $_y; $_x++) {
                            if(($_new_val = SmartyValidate::_execute_transform($_trans_name, $formvars[$_field][$_x], $_sess[$_key], $formvars, $form)) !== false)
                                $formvars[$_field][$_x] = $_new_val;
                        }
                    } else {
                         if(($_new_val = SmartyValidate::_execute_transform($_trans_name, $formvars[$_field], $_sess[$_key], $formvars, $form)) !== false)
                             $formvars[$_field] = $_new_val;
                    }
                }
            }

            if(strpos($_field,':') !== false) {
                // validator is acting on uploaded file, set field name
                $formvars[$_field] = substr($_field,5);
            }
            
            if(!isset($formvars[$_field])
                || (strlen($formvars[$_field]) == 0 && $_empty)) {
                // field must exist, or else fails automatically
                $_sess[$_key]['valid'] = $_empty;
                $_ret = !$_ret ? false : $_empty;
            } else {
                if(substr($_val['criteria'],0,1) == '@') {
                    // criteria will apply to entire array
                    $_criteria_on_array = true;   
                    $_val['criteria'] = substr($_val['criteria'],1);
                } else {
                    // criteria will apply to each array element
                    $_criteria_on_array = false;
                }
                if(is_array($formvars[$_field]) && !$_criteria_on_array) {
                    for($_x = 0, $_y = count($formvars[$_field]); $_x < $_y; $_x++) {
                        if(! $_sess[$_key]['valid'] = SmartyValidate::_is_valid_criteria($_val['criteria'], $formvars[$_field][$_x], $_empty, $_sess[$_key], $formvars, $form)) {
                            // found invalid array element, exit for loop
                            break;
                        }   
                    }
                } else {
                    $_sess[$_key]['valid'] = SmartyValidate::_is_valid_criteria($_val['criteria'], $formvars[$_field], $_empty, $_sess[$_key], $formvars, $form);
                }
            }
            if(!$_sess[$_key]['valid']) {
                $_failed_fields[] = $_field;
                if(isset($_append))
                    $_smarty_assign_fields[$_append][$_field] = $_message;
                if(isset($_assign))
                    $_smarty_assign_fields[$_assign] = $_message;
                $_ret = false;
                if($_sess[$_key]['halt'])
                    break;
            }
        }        
        // set validation state of form
        $_SESSION['SmartyValidate'][$form]['is_error'] = !$_ret;
        SmartyValidate::_smarty_assign($_smarty_assign_fields);
        return $_ret;
    }
    
    /**
     * register a callable function for form verification
     *
     * @param string $func_name the function being registered
     */
    function register_object($object_name, &$object) {
        if(!is_object($object)) {
            trigger_error("SmartyValidate: [register_object] not a valid object.");
            return false;
        }
        SmartyValidate::_object_instance($object_name, $object);
    }    
    
    /**
     * register a callable function for form verification
     *
     * @param string $func_name the function being registered
     */
    function is_registered_object($object_name) {
        $_object =& SmartyValidate::_object_instance($object_name, $_dummy);
        return is_object($_object);
    }    

    /**
     * register a callable function for form verification
     *
     * @param string $func_name the function being registered
     */
    function register_criteria($name, $func_name, $form = 'default') {
        return SmartyValidate::_register_function('criteria', $name, $func_name, $form);
    }    
            
    /**
     * register a callable function for form verification
     *
     * @param string $func_name the function being registered
     */
    function register_transform($name, $func_name, $form = 'default') {
        return SmartyValidate::_register_function('transform', $name, $func_name, $form);
    }    
        
    /**
     * test if a criteria function is registered
     *
     * @param string $var the value being booleanized
     */
    function is_registered_criteria($name, $form = 'default') {  
        if(!SmartyValidate::is_registered_form($form)) {
            trigger_error("SmartyValidate: [is_registered_criteria] form '$form' is not registered.");
            return false;
        }
        return isset($_SESSION['SmartyValidate'][$form]['registered_funcs']['criteria'][$name]);
    }

    /**
     * test if a tranform function is registered
     *
     * @param string $var the value being booleanized
     */
    function is_registered_transform($name, $form = 'default') {
        if(!SmartyValidate::is_registered_form($form)) {
            trigger_error("SmartyValidate: [is_registered_transform] form '$form' is not registered.");
            return false;
        }
        return isset($_SESSION['SmartyValidate'][$form]['registered_funcs']['transform'][$name]);
    }    

    /**
     * return actual function name of registered func
     *
     * @param string $type the type of func
     * @param string $name the registered name
     * @param string $form the form name
     */
    function _execute_transform($name, $value, $params, &$formvars, $form) {
        if(SmartyValidate::is_registered_transform($name, $form)) {
            $_func_name = SmartyValidate::_get_registered_func_name('transform', $name, $form);
        } else {
            $_func_name = 'smarty_validate_transform_' . $name;
            if(!function_exists($_func_name)) {            
                $_smarty_obj =& SmartyValidate::_object_instance('Smarty', $_dummy);
                if($_plugin_file = $_smarty_obj->_get_plugin_filepath('validate_transform', $name)) {
                    include_once($_plugin_file);
                } else {
                    trigger_error("SmartyValidate: [is_valid] transform function '$name' was not found.");
                    return false;                    
                }
            }
        }
        if(strpos($_func_name,'->') !== false) {
            // object method
            preg_match('!(\w+)->(\w+)!', $_func_name, $_match);
            $_object_name = $_match[1];
            $_method_name = $_match[2];
            $_object =& SmartyValidate::_object_instance($_object_name, $_dummy);
            if(!method_exists($_object, $_method_name)) {
                trigger_error("SmartyValidate: [is_valid] method '$_method_name' is not valid for object '$_object_name'.");
                return false;                
            }
            return $_object->$_method_name($value, $params, $formvars);
        } else {
            return $_func_name($value, $params, $formvars);   
        }        
    }    
    
    /**
     * register a callable function for form verification
     *
     * @param string $func_name the function being registered
     */
    function _register_function($type, $name, $func_name, $form = 'default') {
        if(!SmartyValidate::is_registered_form($form)) {
            trigger_error("SmartyValidate: [register_$type] form '$form' is not registered.");
            return false;
        }
        if(strpos($func_name,'->') !== false) {
            // object method
            preg_match('!(\w+)->(\w+)!', $func_name, $_match);
            $_object_name = $_match[1];
            $_method_name = $_match[2];
            $_object =& SmartyValidate::_object_instance($_object_name, $_dummy);
            if(!method_exists($_object, $_method_name)) {
                trigger_error("SmartyValidate: [register_$type] method '$_method_name' is not valid for object '$_object_name'.");
                return false;                
            }
        } elseif (strpos($func_name,'::') !== false) {
            // static method
            preg_match('!(\w+)::(\w+)!', $func_name, $_match);
            if(!is_callable(array($_match[1], $_match[2]))) {
                trigger_error("SmartyValidate: [register_$type] static method '$func_name' does not exist.");
                return false;                
            }            
        } elseif(!function_exists($func_name)) {
            trigger_error("SmartyValidate: [register_$type] function '$func_name' does not exist.");
            return false;
        }
        $_SESSION['SmartyValidate'][$form]['registered_funcs'][$type][$name] = $func_name;
        return true;
    }    

    /**
     * return actual function name of registered func
     *
     * @param string $type the type of func
     * @param string $name the registered name
     * @param string $form the form name
     */
    function _get_registered_func_name($type,$name,$form) {
        return isset($_SESSION['SmartyValidate'][$form]['registered_funcs'][$type][$name])
           ? $_SESSION['SmartyValidate'][$form]['registered_funcs'][$type][$name]
           : false;
    }
    
            
    /**
     * booleanize a value
     *
     * @param string $var the value being booleanized
     */
    function _booleanize($var) {
        if(in_array(strtolower($var), array(true, 1, 'true','on','yes','y'),true)) {
            return true;
        }
        return false;
    }
    
    /**
     * validate criteria for given value
     *
     * @param string $criteria the criteria to test against
     * @param string $value the value being tested
     * @param string $empty skip empty values or not
     */
    function _is_valid_criteria($criteria, $value, $empty, &$params, &$formvars, $form) {
        if(SmartyValidate::is_registered_criteria($criteria,$form)) {
            $_func_name = SmartyValidate::_get_registered_func_name('criteria',$criteria, $form);
        } else {
            $_func_name = 'smarty_validate_criteria_' . $criteria;
            if(!function_exists($_func_name)) {            
                $_smarty_obj =& SmartyValidate::_object_instance('Smarty', $_dummy);
                if($_plugin_file = $_smarty_obj->_get_plugin_filepath('validate_criteria', $criteria)) {
                    include_once($_plugin_file);
                } else {
                    trigger_error("SmartyValidate: [is_valid] criteria function '$criteria' was not found.");
                    return false;                    
                }
            }
        }
        if(strpos($_func_name,'->') !== false) {
            // object method
            preg_match('!(\w+)->(\w+)!', $_func_name, $_match);
            $_object_name = $_match[1];
            $_method_name = $_match[2];
            $_object =& SmartyValidate::_object_instance($_object_name, $_dummy);
            if(!method_exists($_object, $_method_name)) {
                trigger_error("SmartyValidate: [is_valid] method '$_method_name' is not valid for object '$_object_name'.");
                return false;                
            }
            return $_object->$_method_name($value, $empty, $params, $formvars);
        } else {
            return $_func_name($value, $empty, $params, $formvars);   
        }
    }
    
    /**
     * get or set an object instance
     *
     * @param string $name the object name
     * @param object $object the object being set
     */
    function &_object_instance($name, &$object) {
        $return = false;
        static $_objects = array();
        if ($name=='-') {
            unset ($_objects);
            static $_objects = array();
        }
        if(!is_object($object)) {
            if (isset($_objects[$name]))
                return $_objects[$name];
            else
                return $return;
        } else {
            $_objects[$name] =& $object;
        }
    }    
    
    /**
     * get or set the smarty object instance
     *
     * @param string $value the value being tested
     */
    function _smarty_assign($vars = array()) {
        
        $_smarty_obj =& SmartyValidate::_object_instance('Smarty', $_dummy);
                        
        if(!empty($vars)) {
            $_smarty_obj->assign($vars);
        }
        foreach($_SESSION['SmartyValidate'] as $_key => $_val) {
            $_info[$_key]['is_error'] = $_SESSION['SmartyValidate'][$_key]['is_error'];        
        }
        $_smarty_obj->assign('validate', $_info);
        
    }    
        
}

?>
