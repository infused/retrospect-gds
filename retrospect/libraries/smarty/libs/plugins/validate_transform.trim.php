<?php

/**
 * Project:     SmartyValidate: Form Validator for the Smarty Template Engine
 * File:        validate_transform.trim.php
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
 * transform fuction, trim a value
 *
 * @param string $value the value being trimmed
 * @param array  $params the parameters passed to the transform function
 * @param array  $formvars the form variables
 */

function smarty_validate_transform_trim($value, $params, &$formvars) {
    return trim($value);
}

?>
