<?php
/**
 * Main index file
 *
 * @copyright         Keith Morrison, Infused Solutions        2001-2004
 * @author                        Keith Morrison <keithm@infused-solutions.com>
 * @package                 core
 * @license                 http://opensource.org/licenses/gpl-license.php
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

        # Start output buffering
        ob_start();

        /**
        * Root path
        * @global string
        */
        define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']));

        /**
        * Location of core files
        * @global string
        */
        define('CORE_PATH', ROOT_PATH.'/core/');

        /**
        * Location of library files
        * @global string
        */
        define('LIB_PATH', ROOT_PATH.'/libraries/');

        /** Location of gettext locale files
        * @global string
        */
        define('LOCALE_PATH', ROOT_PATH.'/locale/');

        /**
        * Current url w/query string
        * @global string
        */
        if (!empty($_SERVER['QUERY_STRING'])) {
                define('CURRENT_PAGE', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        }
        else {
                define('CURRENT_PAGE', $_SERVER['PHP_SELF']);
        }

        /**
        * Require core.php
        * @access public
        */
        require_once(CORE_PATH.'core.php');

        /**
        * Load the appropriate theme option page.
        * Uses output buffering to capture any output into $g_content
        * for display later in the theme template.
        * @access public
        */
				ob_flush();
        $g_option = isset($_GET['option']) ? $_GET['option'] : $options->GetOption('default_page');
        include(Theme::getPage($g_theme, $g_option));
        $g_content = ob_get_contents();
        ob_clean();

        /**
        * Load the appropriate theme menu page
        * @access public
        */
        include(Theme::getPage($g_theme, 'menu'));

        /**
        * Load the appropriate theme template page
        * @access public
        */
        isset($_GET['print']) ? include(Theme::getPage($g_theme, 'template_print')) : include(Theme::getPage($g_theme, 'template'));
?>