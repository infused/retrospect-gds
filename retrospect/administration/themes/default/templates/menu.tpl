<script language="JavaScript" src="{$THEME_URL}js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript"><!--
var myMenu =
[
	[null, 'Home', '{$PHP_SELF}', null, 'Home'],
	_cmSplit,
	[null, 'Site', null, null, 'Site',
		['<img src="{$THEME_URL}js/ThemeOffice/help.png" />', 'Status', '{$PHP_SELF}', null, 'Status'],
		['<img src="{$THEME_URL}js/ThemeOffice/config.png" />', 'Global Configuration', '{$PHP_SELF}?m=config', null, 'Global Configuration'],
		['<img src="{$THEME_URL}js/ThemeOffice/user.png" />', 'User Manager', '{$PHP_SELF}?m=usermgr', null, 'User Manager']
	],
	_cmSplit,
	[null, 'Database', null, null, 'Database',
		['<img src="{$THEME_URL}js/ThemeOffice/install.png" />', 'Import Gedcom', '{$PHP_SELF}?m=gedcom', null, 'Import Gedcom'],
		['<img src="{$THEME_URL}js/ThemeOffice/edit.png" />', 'Edit', null, null, 'Edit',
			['<img src="{$THEME_URL}js/ThemeOffice/new_user.png" />', 'Individual', 'url', null, 'Edit Individual']
		],
		['<img src="{$THEME_URL}js/ThemeOffice/db.png" />', 'Maintenance', null, null, 'Maintenance',
			['<img src="{$THEME_URL}js/ThemeOffice/sysinfo.png" />', 'Optimize Tables', 'url', null, 'Optimize Tables']
		]
	],
	_cmSplit,
	[null, 'Media', null, null, 'Media',   // a folder item
			['<img src="{$THEME_URL}js/ThemeOffice/content.png" />', 'Media Manager', 'url', null, 'Media Manager']
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