CREATE TABLE rgds_children (
famkey           VARCHAR(20) NOT NULL,
indkey           VARCHAR(20) NOT NULL
);

CREATE TABLE rgds_citation (
factkey          VARCHAR(20) NOT NULL,
srckey           VARCHAR(20) NOT NULL,
source           LONGTEXT
);

CREATE TABLE rgds_comment (
id               INTEGER NOT NULL AUTO_INCREMENT,
indkey           VARCHAR(20) NOT NULL,
email            VARCHAR(128) NOT NULL,
received         DATETIME,
comment          LONGTEXT,
reviewed         TINYINT DEFAULT 0,
                 PRIMARY KEY (id)
);

CREATE TABLE rgds_fact (
indfamkey        VARCHAR(20) NOT NULL,
type             VARCHAR(128) NOT NULL,
date             VARCHAR(128) NOT NULL,
place            VARCHAR(250) NOT NULL,
comment          VARCHAR(250) NOT NULL,
factkey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (factkey)
);

CREATE TABLE rgds_family (
famkey           VARCHAR(20) NOT NULL,
spouse1          VARCHAR(20) NOT NULL,
spouse2          VARCHAR(20) NOT NULL,
beginstatus      VARCHAR(128) NOT NULL,
endstatus        VARCHAR(128) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (famkey)
);

CREATE TABLE rgds_indiv (
indkey           VARCHAR(20) NOT NULL,
title            VARCHAR(128) NOT NULL,
surname          VARCHAR(128) NOT NULL,
givenname        VARCHAR(128) NOT NULL,
aka              VARCHAR(128) NOT NULL,
prefix           VARCHAR(128) NOT NULL,
suffix           VARCHAR(128) NOT NULL,
sex              VARCHAR(1) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (indkey)
);

CREATE TABLE rgds_language (
lang_id          INTEGER NOT NULL AUTO_INCREMENT,
lang_code        VARCHAR(5) NOT NULL,
lang_charset     VARCHAR(20) NOT NULL,
lang_name        VARCHAR(20) NOT NULL,
                 PRIMARY KEY (lang_id)
);

CREATE TABLE rgds_media (
id               INTEGER NOT NULL AUTO_INCREMENT,
filename         VARCHAR(128) NOT NULL,
caption          VARCHAR(40) NOT NULL,
description      VARCHAR(250) NOT NULL,
                 PRIMARY KEY (id)
);

CREATE TABLE rgds_note (
notekey          VARCHAR(20) NOT NULL,
text             LONGTEXT,
                 PRIMARY KEY (notekey)
);

CREATE TABLE rgds_options (
opt_id           INTEGER NOT NULL,
opt_key          VARCHAR(20) NOT NULL,
opt_val          VARCHAR(250) NOT NULL,
                 PRIMARY KEY (opt_id)
);

CREATE TABLE rgds_source (
srckey           VARCHAR(20) NOT NULL,
text             LONGTEXT,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (srckey)
);

CREATE TABLE rgds_user (
id               INTEGER NOT NULL AUTO_INCREMENT,
uid              VARCHAR(16) NOT NULL,
pwd              VARCHAR(32) NOT NULL,
fullname         VARCHAR(100) NOT NULL,
email            VARCHAR(100) NOT NULL,
last             DATETIME,
pwd_expired      TINYINT NOT NULL,
                 PRIMARY KEY (id)
);

INSERT INTO  rgds_user VALUES  ('', 'Admin', '40be4e59b9a2a2b5dffb918c0e86b3d7', 'Administrator', 'root@someplace.com', null, '1');

INSERT INTO  rgds_options VALUES  (1, 'default_lang', 'en_US');

INSERT INTO  rgds_options VALUES  (2, 'allow_lang_change', '1');

INSERT INTO  rgds_options VALUES  (3, 'default_page', 'surnames');

INSERT INTO  rgds_options VALUES  (4, 'translate_dates', '1');

INSERT INTO  rgds_options VALUES  (4, 'profile_functions', '0');

INSERT INTO  rgds_language VALUES  (1, 'en_US', 'English');

INSERT INTO  rgds_language VALUES  (2, 'es_ES', 'Spanish');

INSERT INTO  rgds_language VALUES  (3, 'de_DE', 'German');
