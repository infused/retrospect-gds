#
# Table structure for table `gms_children`
#

CREATE TABLE `gms2_children` (
  `famkey` varchar(20) NOT NULL default '',
  `indkey` varchar(20) NOT NULL default '',
  KEY `famkey` (`famkey`),
  KEY `indkey` (`indkey`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_citation`
#

CREATE TABLE `gms2_citation` (
  `factkey` varchar(20) NOT NULL default '0',
  `srckey` varchar(20) default NULL,
  `source` text,
  KEY `factkey` (`factkey`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_comment`
#

CREATE TABLE `gms2_comment` (
  `id` int(11) NOT NULL auto_increment,
  `indkey` varchar(20) NOT NULL default '',
  `from` tinytext NOT NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment` text NOT NULL,
  `reviewed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `indkey` (`indkey`)
) TYPE=MyISAM AUTO_INCREMENT=80 ;

# --------------------------------------------------------

#
# Table structure for table `gms_fact`
#

CREATE TABLE `gms2_fact` (
  `indfamkey` varchar(20) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `date` tinytext NOT NULL,
  `place` tinytext NOT NULL,
  `factkey` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`factkey`),
  KEY `indfamkey` (`indfamkey`),
  KEY `type` (`type`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_family`
#

CREATE TABLE `gms2_family` (
  `famkey` varchar(20) NOT NULL default '',
  `spouse1` varchar(20) NOT NULL default '',
  `spouse2` varchar(20) NOT NULL default '',
  `beginstatus` tinytext NOT NULL,
  `endstatus` tinytext NOT NULL,
  `notekey` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`famkey`),
  KEY `spouse1` (`spouse1`),
  KEY `spouse2` (`spouse2`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_indiv`
#

CREATE TABLE `gms2_indiv` (
  `indkey` varchar(20) NOT NULL default '',
  `title` tinytext NOT NULL,
  `surname` varchar(255) NOT NULL default '',
  `givenname` varchar(255) NOT NULL default '',
  `aka` tinytext NOT NULL,
  `sex` char(1) NOT NULL default '',
  `notekey` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`indkey`),
  KEY `surname` (`surname`),
  KEY `givenname` (`givenname`),
  KEY `sex` (`sex`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_language`
#

CREATE TABLE `gms2_language` (
  `lang_code` char(5) NOT NULL default '',
  `lang_name` char(20) NOT NULL default ''
) TYPE=MyISAM;

INSERT INTO `gms2_language` (`lang_code`, `lang_name`) VALUES ('en_US', 'English');
INSERT INTO `gms2_language` (`lang_code`, `lang_name`) VALUES ('es_ES', 'Spanish');

# --------------------------------------------------------

#
# Table structure for table `gms_note`
#

CREATE TABLE `gms2_note` (
  `notekey` varchar(20) NOT NULL default '',
  `text` text NOT NULL,
  PRIMARY KEY  (`notekey`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_options`
#

CREATE TABLE `gms2_options` (
  `opt_id` tinyint(3) NOT NULL default '0',
  `opt_key` varchar(20) NOT NULL default '',
  `opt_val` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`opt_id`),
  UNIQUE KEY `opt_key` (`opt_key`)
) TYPE=MyISAM;

INSERT INTO `gms2_options` (`opt_id`, `opt_key`, `opt_val`) VALUES (1, 'default_lang', 'en_US');
INSERT INTO `gms2_options` (`opt_id`, `opt_key`, `opt_val`) VALUES (2, 'allow_lang_change', '1');
INSERT INTO `gms2_options` (`opt_id`, `opt_key`, `opt_val`) VALUES (3, 'default_page', 'surnames');
INSERT INTO `gms2_options` (`opt_id`, `opt_key`, `opt_val`) VALUES (4, 'translate_dates', '1');


# --------------------------------------------------------

#
# Table structure for table `gms_relation`
#

CREATE TABLE `gms2_relation` (
  `indkey` varchar(20) NOT NULL default '',
  `famkey` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`indkey`),
  KEY `famkey` (`famkey`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_source`
#

CREATE TABLE `gms2_source` (
  `srckey` varchar(20) NOT NULL default '',
  `text` text NOT NULL,
  `notekey` varchar(20) default NULL,
  PRIMARY KEY  (`srckey`)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `gms_user`
#

CREATE TABLE `gms2_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` char(16) NOT NULL default '',
  `pwd` char(32) NOT NULL default '',
  `fullname` char(100) NOT NULL default '',
  `email` char(100) NOT NULL default '',
  `last` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=16 ;
    
