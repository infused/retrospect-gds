<script language="JavaScript" src="js/JSCookMenu.js" type="text/javascript"></script>
<script language="JavaScript"><!--
var myMenu =
[
	[null, '<?php echo _("Configuration"); ?>', null, null, '<?php echo _("Configuration"); ?>',
		['<img src="js/ThemeOffice/config.png" />', '<?php echo _("System"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=sys_config', null, '<?php echo _("System"); ?>'],
		['<img src="js/ThemeOffice/user.png" />', '<?php echo _("User Admin"); ?>', null, null, '<?php echo _("User Admin"); ?>',
			['<img src="js/ThemeOffice/edit.png" />', '<?php echo _("User List"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=user_list', null, '<?php echo _("Edit Users"); ?>'],
			['<img src="js/ThemeOffice/new_user.png" />', '<?php echo _("Add User"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=user_add', null, '<?php echo _("Add User"); ?>']
			
		]
	],
    _cmSplit,
		[null, '<?php echo _("Database"); ?>', null, null, '<?php echo _("Database"); ?>',
			['<img src="js/ThemeOffice/edit.png" />', '<?php echo _("Edit"); ?>', null, null, '<?php echo _("Edit"); ?>',
				['<img src="js/ThemeOffice/new_user.png" />', '<?php echo _("Individual"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=db_edit_indiv', null, '<?php echo _("Edit Individual"); ?>']
			],
			['<img src="js/ThemeOffice/db.png" />', '<?php echo _("Maintenance"); ?>', null, null, '<?php echo _("Maintenance"); ?>',
				['<img src="js/ThemeOffice/sysinfo.png" />', '<?php echo _("Optimize Tables"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=db_optimize', null, '<?php echo _("Optimize Tables"); ?>']
			]
		],
    _cmSplit,
    [null, 'Media', null, null, '<?php echo _("Media"); ?>',   // a folder item
        ['<img src="js/ThemeOffice/content.png" />', '<?php echo _("Media List"); ?>', '<?php echo $_SERVER['PHP_SELF']; ?>?option=media_list', null, '<?php echo _("Media List"); ?>']
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