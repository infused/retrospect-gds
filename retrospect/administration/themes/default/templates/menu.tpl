<script language="JavaScript" src="{$THEME_URL}js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript"><!--
var myMenu =
[
	[null, 'Home', '{$PHP_SELF}', null, 'Home'],
	_cmSplit,
	[null, 'Site', null, null, 'Site',
		['<img src="js/ThemeOffice/help.png" />', 'Status', '{$PHP_SELF}', null, 'Status'],
		['<img src="js/ThemeOffice/config.png" />', 'Global Configuration', '{$PHP_SELF}?m=config', null, 'Global Configuration'],
		['<img src="js/ThemeOffice/user.png" />', 'User Manager', null, null, 'User Manager',
			['<img src="js/ThemeOffice/edit.png" />', 'User List', 'url', null, 'Edit Users'],
			['<img src="js/ThemeOffice/new_user.png" />', 'Add User', 'url', null, 'Add User']
		]
	],
	_cmSplit,
	[null, 'Database', null, null, 'Database',
		['<img src="js/ThemeOffice/install.png" />', 'Import Gedcom', 'url', null, 'Import Gedcom'],
		['<img src="js/ThemeOffice/edit.png" />', 'Edit', null, null, 'Edit',
			['<img src="js/ThemeOffice/new_user.png" />', 'Individual', 'url', null, 'Edit Individual']
		],
		['<img src="js/ThemeOffice/db.png" />', 'Maintenance', null, null, 'Maintenance',
			['<img src="js/ThemeOffice/sysinfo.png" />', 'Optimize Tables', 'url', null, 'Optimize Tables']
		]
	],
	_cmSplit,
	[null, 'Media', null, null, 'Media',   // a folder item
			['<img src="js/ThemeOffice/content.png" />', 'Media Manager', 'url', null, 'Media Manager']
	]
];
--></script>
<link rel="stylesheet" href="{$THEME_URL}js/ThemeOffice/theme.css" type="text/css" />
<script language="JavaScript" src="{$THEME_URL}js/ThemeOffice/theme.js" type="text/javascript"></script>
<script language="JavaScript">
<!--
	cmDraw ('adminmenu', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
-->
</script>