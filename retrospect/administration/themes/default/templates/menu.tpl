<script language="JavaScript" src="{$THEME_URL}js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript"><!--
var myMenu =
[
	[null, 'Home', '{$PHP_SELF}', null, 'Home'],
	_cmSplit,
	[null, 'Configuration', null, null, 'Configuration',
		['<img src="{$THEME_URL}js/ThemeOffice/help.png" />', 'Status', '{$PHP_SELF}', null, 'Status'],
		['<img src="{$THEME_URL}js/ThemeOffice/config.png" />', 'Global Configuration', '{$PHP_SELF}?m=config', null, 'Global Configuration'],
	],
	_cmSplit,
	[null, 'Users', null, null, 'Users',
		['<img src="{$THEME_URL}js/ThemeOffice/user.png" />', 'User Manager', '{$PHP_SELF}?m=usermgr', null, 'User Manager'],
		['<img src="{$THEME_URL}js/ThemeOffice/new_user.png" />', 'Add User', '{$PHP_SELF}?m=useradd', null, 'Add User'],
		['', 'Edit User', '{$PHP_SELF}?m=useredit', null, 'Edit User']
	],
	_cmSplit,
	[null, 'Trees', null, null, 'Trees',
		['<img src="{$THEME_URL}js/ThemeOffice/restore.png" />', 'Gedcom Manager', '{$PHP_SELF}?m=gedcom', null, 'Gedcom Manager'],
		['<img src="{$THEME_URL}js/ThemeOffice/contact.png" />', 'Review Comments', '{$PHP_SELF}?m=commentmgr', null, 'Review Comments'],
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