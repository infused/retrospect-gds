<?php
/**
 * Admin - Menu Bar Definitions
 * 
 * Defines the java menu structure used by the jscookmenu module
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		administration
 * @license 		http://opensource.org/licenses/gpl-license.php
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
?>
<script language="JavaScript" src="js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript"><!--
var myMenu =
[
	[null, 'System', null, null, 'System',
		['<img src="js/ThemeOffice/help.png" />', 'Status', '<?php echo $_SERVER['PHP_SELF']; ?>?option=status', null, 'Status'],
		['<img src="js/ThemeOffice/config.png" />', 'Configuration', '<?php echo $_SERVER['PHP_SELF']; ?>?option=sys_config', null, 'Configuration'],
		['<img src="js/ThemeOffice/user.png" />', 'User Admin', null, null, 'User Admin',
			['<img src="js/ThemeOffice/edit.png" />', 'User List', '<?php echo $_SERVER['PHP_SELF']; ?>?option=user_list', null, 'Edit Users'],
			['<img src="js/ThemeOffice/new_user.png" />', 'Add User', '<?php echo $_SERVER['PHP_SELF']; ?>?option=user_add', null, 'Add User']
			
		]
	],
    _cmSplit,
		[null, 'Database', null, null, 'Database',
			['<img src="js/ThemeOffice/install.png" />', 'Import Gedcom', '<?php echo $_SERVER['PHP_SELF']; ?>?option=gedcom_import', null, 'Import Gedcom'],
			['<img src="js/ThemeOffice/edit.png" />', 'Edit', null, null, 'Edit',
				['<img src="js/ThemeOffice/new_user.png" />', 'Individual', '<?php echo $_SERVER['PHP_SELF']; ?>?option=db_edit_indiv', null, 'Edit Individual']
			],
			['<img src="js/ThemeOffice/db.png" />', 'Maintenance', null, null, 'Maintenance',
				['<img src="js/ThemeOffice/sysinfo.png" />', 'Optimize Tables', '<?php echo $_SERVER['PHP_SELF']; ?>?option=db_optimize', null, 'Optimize Tables']
			]
		],
    _cmSplit,
    [null, 'Media', null, null, 'Media',   // a folder item
        ['<img src="js/ThemeOffice/content.png" />', 'Media Manager', '<?php echo $_SERVER['PHP_SELF']; ?>?option=media_list', null, 'Media Manager']
    ]
];
--></script>
<link rel="stylesheet" href="js/ThemeOffice/theme.css" type="text/css" />
<script language="JavaScript" src="js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
	cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
-->
</script>