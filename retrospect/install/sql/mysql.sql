CREATE TABLE rgds_children (
famkey                   VARCHAR(20) NOT NULL,
indkey                   VARCHAR(20) NOT NULL
);

ALTER TABLE rgds_children ADD  INDEX rgds_famkey  (famkey);

ALTER TABLE rgds_children ADD  INDEX rgds_indkey  (indkey);

CREATE TABLE rgds_citation (
factkey                  VARCHAR(20) NOT NULL,
srckey                   VARCHAR(20) NOT NULL,
source                   LONGTEXT,
citekey                  INTEGER NOT NULL AUTO_INCREMENT,
                 PRIMARY KEY (citekey)
);

ALTER TABLE rgds_citation ADD  INDEX rgds_factkey  (factkey);

CREATE TABLE rgds_comment (
id                       INTEGER NOT NULL AUTO_INCREMENT,
indkey                   VARCHAR(20) NOT NULL,
email                    VARCHAR(128) NOT NULL,
received                 DATETIME,
comment                  LONGTEXT,
reviewed                 TINYINT DEFAULT 0,
                 PRIMARY KEY (id)
);

ALTER TABLE rgds_comment ADD  INDEX rgds_indkey  (indkey);

CREATE TABLE rgds_fact (
indfamkey                VARCHAR(20) NOT NULL,
type                     VARCHAR(128) NOT NULL,
date_mod                 VARCHAR(2) NOT NULL,
date1                    VARCHAR(8) NOT NULL,
date2                    VARCHAR(8) NOT NULL,
date_str                 VARCHAR(128) NOT NULL,
place                    VARCHAR(250) NOT NULL,
comment                  VARCHAR(250) NOT NULL,
factkey                  INTEGER NOT NULL,
                 PRIMARY KEY (factkey)
);

ALTER TABLE rgds_fact ADD  INDEX rgds_indfamkey  (indfamkey);

ALTER TABLE rgds_fact ADD  INDEX rgds_type  (type);

CREATE TABLE rgds_family (
famkey                   VARCHAR(20) NOT NULL,
spouse1                  VARCHAR(20) NOT NULL,
spouse2                  VARCHAR(20) NOT NULL,
beginstatus              VARCHAR(128) NOT NULL,
endstatus                VARCHAR(128) NOT NULL,
notekey                  VARCHAR(20) NOT NULL,
                 PRIMARY KEY (famkey)
);

ALTER TABLE rgds_family ADD  INDEX rgds_spouse1  (spouse1);

ALTER TABLE rgds_family ADD  INDEX rgds_spouse2  (spouse2);

CREATE TABLE rgds_indiv (
indkey                   VARCHAR(20) NOT NULL,
surname                  VARCHAR(128) NOT NULL,
givenname                VARCHAR(128) NOT NULL,
aka                      VARCHAR(128) NOT NULL,
prefix                   VARCHAR(128) NOT NULL,
suffix                   VARCHAR(128) NOT NULL,
sex                      VARCHAR(1) NOT NULL,
refn                     VARCHAR(128) NOT NULL,
notekey                  VARCHAR(20) NOT NULL,
                 PRIMARY KEY (indkey)
);

ALTER TABLE rgds_indiv ADD  INDEX rgds_surname  (surname);

ALTER TABLE rgds_indiv ADD  INDEX rgds_givenname  (givenname);

ALTER TABLE rgds_indiv ADD  INDEX rgds_sex  (sex);

CREATE TABLE rgds_language (
lang_id                  INTEGER NOT NULL AUTO_INCREMENT,
lang_code                VARCHAR(5) NOT NULL,
lang_charset             VARCHAR(20) NOT NULL,
lang_name                VARCHAR(20) NOT NULL,
                 PRIMARY KEY (lang_id)
);

ALTER TABLE rgds_language ADD  INDEX rgds_lang_code  (lang_code);

CREATE TABLE rgds_media (
id                       INTEGER NOT NULL AUTO_INCREMENT,
filename                 VARCHAR(128) NOT NULL,
caption                  VARCHAR(40) NOT NULL,
description              VARCHAR(250) NOT NULL,
                 PRIMARY KEY (id)
);

CREATE TABLE rgds_note (
notekey                  VARCHAR(20) NOT NULL,
text                     LONGTEXT,
                 PRIMARY KEY (notekey)
);

CREATE TABLE rgds_options (
opt_id                   INTEGER NOT NULL,
opt_key                  VARCHAR(20) NOT NULL,
opt_val                  VARCHAR(250) NOT NULL,
                 PRIMARY KEY (opt_id)
);

ALTER TABLE rgds_options ADD  UNIQUE INDEX rgds_opt_key  (opt_key);

CREATE TABLE rgds_source (
srckey                   VARCHAR(20) NOT NULL,
text                     LONGTEXT,
notekey                  VARCHAR(20) NOT NULL,
                 PRIMARY KEY (srckey)
);

CREATE TABLE rgds_user (
id                       INTEGER NOT NULL AUTO_INCREMENT,
uid                      VARCHAR(16) NOT NULL,
pwd                      VARCHAR(32) NOT NULL,
fullname                 VARCHAR(100) NOT NULL,
email                    VARCHAR(100) NOT NULL,
grp                      INTEGER NOT NULL,
created                  DATETIME,
last                     DATETIME,
pwd_expired              TINYINT NOT NULL,
enabled                  TINYINT NOT NULL,
                 PRIMARY KEY (id)
);

ALTER TABLE rgds_user ADD  UNIQUE INDEX rgds_uid  (uid);

ALTER TABLE rgds_user ADD  INDEX rgds_pwd  (pwd);

INSERT INTO  rgds_user VALUES  ('1', 'admin', '40be4e59b9a2a2b5dffb918c0e86b3d7', 'Administrator', 'root@oo.com', 1, null, null, 1, 1);

INSERT INTO  rgds_options VALUES  ('1', 'default_lang', 'en_US');

INSERT INTO  rgds_options VALUES  ('2', 'allow_lang_change', '1');

INSERT INTO  rgds_options VALUES  ('3', 'default_page', 'surnames');

INSERT INTO  rgds_options VALUES  ('4', 'translate_dates', '1');

INSERT INTO  rgds_options VALUES  ('5', 'debug', '0');

INSERT INTO  rgds_options VALUES  ('6', 'meta_copyright', '');

INSERT INTO  rgds_options VALUES  ('7', 'meta_keywords', 'Genealogy,Family History');

INSERT INTO  rgds_options VALUES  ('8', 'date_format', '1');

INSERT INTO  rgds_options VALUES  ('9', 'sort_children', '0');

INSERT INTO  rgds_options VALUES  ('10', 'sort_marriages', '0');

INSERT INTO  rgds_options VALUES  ('11', 'sort_events', '0');

INSERT INTO  rgds_language VALUES  ('1', 'en_US', 'iso-8859-1', 'English');

INSERT INTO  rgds_language VALUES  ('2', 'es_ES', 'iso-8859-1', 'Spanish');

INSERT INTO  rgds_language VALUES  ('3', 'de_DE', 'iso-8859-1', 'German');

INSERT INTO  rgds_language VALUES  ('4', 'nl_NL', 'iso-8859-1', 'Dutch');

INSERT INTO  rgds_language VALUES  ('5', 'fr_FR', 'iso-8859-1', 'French');

