CREATE TABLE rgds__children (
famkey           VARCHAR(20) NOT NULL,
indkey           VARCHAR(20) NOT NULL
);

CREATE INDEX rgds__famkey ON rgds__children (famkey);

CREATE INDEX rgds__indkey ON rgds__children (indkey);

CREATE TABLE rgds__citation (
factkey          VARCHAR(20) NOT NULL,
srckey           VARCHAR(20) NOT NULL,
source           LONGTEXT
);

CREATE INDEX rgds__factkey ON rgds__citation (factkey);

CREATE TABLE rgds__comment (
id               INTEGER NOT NULL AUTO_INCREMENT,
indkey           VARCHAR(20) NOT NULL,
email            VARCHAR(128) NOT NULL,
received         DATETIME,
comment          LONGTEXT,
reviewed         TINYINT DEFAULT 0,
                 PRIMARY KEY (id)
);

CREATE INDEX rgds__indkey ON rgds__comment (indkey);

CREATE TABLE rgds__fact (
indfamkey        VARCHAR(20) NOT NULL,
type             VARCHAR(128) NOT NULL,
date             VARCHAR(128) NOT NULL,
place            VARCHAR(250) NOT NULL,
factkey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (factkey)
);

CREATE INDEX rgds__indfamkey ON rgds__fact (indfamkey);

CREATE INDEX rgds__type ON rgds__fact (type(10));

CREATE INDEX rgds__type ON rgds__fact (type);

CREATE TABLE rgds__family (
famkey           VARCHAR(20) NOT NULL,
spouse1          VARCHAR(20) NOT NULL,
spouse2          VARCHAR(20) NOT NULL,
beginstatus      VARCHAR(128) NOT NULL,
endstatus        VARCHAR(128) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (famkey)
);

CREATE INDEX rgds__spouse1 ON rgds__family (spouse1);

CREATE INDEX rgds__spouse2 ON rgds__family (spouse2);

CREATE TABLE rgds__indiv (
indkey           VARCHAR(20) NOT NULL,
title            VARCHAR(128) NOT NULL,
surname          VARCHAR(128) NOT NULL,
givenname        VARCHAR(128) NOT NULL,
aka              VARCHAR(128) NOT NULL,
sex              VARCHAR(1) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (indkey)
);

CREATE INDEX rgds__surname ON rgds__indiv (surname);

CREATE INDEX rgds__givenname ON rgds__indiv (givenname);

CREATE INDEX rgds__sex ON rgds__indiv (sex);

CREATE TABLE rgds__language (
lang_id          INTEGER NOT NULL AUTO_INCREMENT,
lang_code        VARCHAR(5) NOT NULL,
lang_name        VARCHAR(20) NOT NULL,
                 PRIMARY KEY (lang_id)
);

CREATE TABLE rgds__media (
id               INTEGER NOT NULL AUTO_INCREMENT,
filename         VARCHAR(128) NOT NULL,
caption          VARCHAR(40) NOT NULL,
description      VARCHAR(250) NOT NULL,
indfamkey        VARCHAR(20) NOT NULL,
                 PRIMARY KEY (id)
);

CREATE INDEX rgds__indfamkey ON rgds__media (indfamkey);

CREATE TABLE rgds__note (
notekey          VARCHAR(20) NOT NULL,
text             LONGTEXT,
                 PRIMARY KEY (notekey)
);

CREATE TABLE rgds__options (
opt_id           INTEGER NOT NULL,
opt_key          VARCHAR(20) NOT NULL,
opt_val          VARCHAR(250) NOT NULL,
                 PRIMARY KEY (opt_id)
);

CREATE UNIQUE INDEX rgds__opt_key ON rgds__options (opt_key);

CREATE INDEX rgds__famkey ON rgds__relation (famkey);

CREATE TABLE rgds__source (
srckey           VARCHAR(20) NOT NULL,
text             LONGTEXT,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (srckey)
);

CREATE TABLE rgds__user (
id               INTEGER NOT NULL AUTO_INCREMENT,
uid              VARCHAR(16) NOT NULL,
pwd              VARCHAR(32) NOT NULL,
fullname         VARCHAR(100) NOT NULL,
email            VARCHAR(100) NOT NULL,
last             DATETIME,
pwd_expired      TINYINT NOT NULL,
                 PRIMARY KEY (id)
);

CREATE UNIQUE INDEX rgds__uid ON rgds__user (uid);

CREATE INDEX rgds__pwd ON rgds__user (pwd);

INSERT INTO  rgds__user VALUES   ('', 'Admin', '40be4e59b9a2a2b5dffb918c0e86b3d7', 'Administrator', 'root@someplace.com', null, '1');

INSERT INTO  rgds__options VALUES   (1, 'default_lang', 'en_US');

INSERT INTO  rgds__options VALUES   (2, 'allow_lang_change', '1');

INSERT INTO  rgds__options VALUES   (3, 'default_page', 'surnames');

INSERT INTO  rgds__options VALUES   (4, 'translate_dates', '1');

INSERT INTO  rgds__language VALUES   (1, 'en_US', 'English');

INSERT INTO  rgds__language VALUES   (2, 'es_ES', 'Spanish');

INSERT INTO  rgds__language VALUES   (3, 'de_DE', 'German');

CREATE TABLE rgds__children (
famkey           VARCHAR(20) NOT NULL,
indkey           VARCHAR(20) NOT NULL
);

CREATE INDEX rgds__famkey ON rgds__children (famkey);

CREATE INDEX rgds__indkey ON rgds__children (indkey);

CREATE TABLE rgds__citation (
factkey          VARCHAR(20) NOT NULL,
srckey           VARCHAR(20) NOT NULL,
source           LONGTEXT
);

CREATE INDEX rgds__factkey ON rgds__citation (factkey);

CREATE TABLE rgds__comment (
id               INTEGER NOT NULL AUTO_INCREMENT,
indkey           VARCHAR(20) NOT NULL,
email            VARCHAR(128) NOT NULL,
received         DATETIME,
comment          LONGTEXT,
reviewed         TINYINT DEFAULT 0,
                 PRIMARY KEY (id)
);

CREATE INDEX rgds__indkey ON rgds__comment (indkey);

CREATE TABLE rgds__fact (
indfamkey        VARCHAR(20) NOT NULL,
type             VARCHAR(128) NOT NULL,
date             VARCHAR(128) NOT NULL,
place            VARCHAR(250) NOT NULL,
factkey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (factkey)
);

CREATE INDEX rgds__indfamkey ON rgds__fact (indfamkey);

CREATE INDEX rgds__type ON rgds__fact (type(10));

CREATE INDEX rgds__type ON rgds__fact (type);

CREATE TABLE rgds__family (
famkey           VARCHAR(20) NOT NULL,
spouse1          VARCHAR(20) NOT NULL,
spouse2          VARCHAR(20) NOT NULL,
beginstatus      VARCHAR(128) NOT NULL,
endstatus        VARCHAR(128) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (famkey)
);

CREATE INDEX rgds__spouse1 ON rgds__family (spouse1);

CREATE INDEX rgds__spouse2 ON rgds__family (spouse2);

CREATE TABLE rgds__indiv (
indkey           VARCHAR(20) NOT NULL,
title            VARCHAR(128) NOT NULL,
surname          VARCHAR(128) NOT NULL,
givenname        VARCHAR(128) NOT NULL,
aka              VARCHAR(128) NOT NULL,
sex              VARCHAR(1) NOT NULL,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (indkey)
);

CREATE INDEX rgds__surname ON rgds__indiv (surname);

CREATE INDEX rgds__givenname ON rgds__indiv (givenname);

CREATE INDEX rgds__sex ON rgds__indiv (sex);

CREATE TABLE rgds__language (
lang_id          INTEGER NOT NULL AUTO_INCREMENT,
lang_code        VARCHAR(5) NOT NULL,
lang_name        VARCHAR(20) NOT NULL,
                 PRIMARY KEY (lang_id)
);

CREATE TABLE rgds__media (
id               INTEGER NOT NULL AUTO_INCREMENT,
filename         VARCHAR(128) NOT NULL,
caption          VARCHAR(40) NOT NULL,
description      VARCHAR(250) NOT NULL,
indfamkey        VARCHAR(20) NOT NULL,
                 PRIMARY KEY (id)
);

CREATE INDEX rgds__indfamkey ON rgds__media (indfamkey);

CREATE TABLE rgds__note (
notekey          VARCHAR(20) NOT NULL,
text             LONGTEXT,
                 PRIMARY KEY (notekey)
);

CREATE TABLE rgds__options (
opt_id           INTEGER NOT NULL,
opt_key          VARCHAR(20) NOT NULL,
opt_val          VARCHAR(250) NOT NULL,
                 PRIMARY KEY (opt_id)
);

CREATE UNIQUE INDEX rgds__opt_key ON rgds__options (opt_key);

CREATE INDEX rgds__famkey ON rgds__relation (famkey);

CREATE TABLE rgds__source (
srckey           VARCHAR(20) NOT NULL,
text             LONGTEXT,
notekey          VARCHAR(20) NOT NULL,
                 PRIMARY KEY (srckey)
);

CREATE TABLE rgds__user (
id               INTEGER NOT NULL AUTO_INCREMENT,
uid              VARCHAR(16) NOT NULL,
pwd              VARCHAR(32) NOT NULL,
fullname         VARCHAR(100) NOT NULL,
email            VARCHAR(100) NOT NULL,
last             DATETIME,
pwd_expired      TINYINT NOT NULL,
                 PRIMARY KEY (id)
);

CREATE UNIQUE INDEX rgds__uid ON rgds__user (uid);

CREATE INDEX rgds__pwd ON rgds__user (pwd);

INSERT INTO  rgds__user VALUES   ('', 'Admin', '40be4e59b9a2a2b5dffb918c0e86b3d7', 'Administrator', 'root@someplace.com', null, '1');

INSERT INTO  rgds__options VALUES   (1, 'default_lang', 'en_US');

INSERT INTO  rgds__options VALUES   (2, 'allow_lang_change', '1');

INSERT INTO  rgds__options VALUES   (3, 'default_page', 'surnames');

INSERT INTO  rgds__options VALUES   (4, 'translate_dates', '1');

INSERT INTO  rgds__language VALUES   (1, 'en_US', 'English');

INSERT INTO  rgds__language VALUES   (2, 'es_ES', 'Spanish');

INSERT INTO  rgds__language VALUES   (3, 'de_DE', 'German');

