<?php
  define('_RGDS_VALID', 1 );
  define('ROOT_PATH', dirname('../../index.php'));
  require_once('./config.php');
  require_once('../../libraries/adodb.493a/adodb.inc.php');
  require_once('../../libraries/phpunit/phpunit.php');
  require_once('../../core/options.class.php');
  require_once('../../core/f_misc.php');
  require_once('../../core/f_language.php');
	
	# Define all database table names
	define('TBL_INDIV', 'rgds_indiv');
	define('TBL_FACT', 'rgds_fact');
	define('TBL_FAMILY', 'rgds_family');
	define('TBL_CITATION', 'rgds_citation');
	define('TBL_SOURCE', 'rgds_source');
	define('TBL_NOTE', 'rgds_note');
	define('TBL_CHILD', 'rgds_children');
	define('TBL_USER', 'rgds_user');
	define('TBL_USERTYPE', 'rgds_usertype');
	define('TBL_LANG', 'rgds_language');
	define('TBL_OPTION', 'rgds_options');
	define('TBL_MEDIA', 'rgds_media');
	define('TBL_COMMENT', 'rgds_comment');
	
  $db =& AdoNewConnection('mysql');
	$db->Connect('localhost', 'root', '', 'retrospect');
	$db->SetFetchMode(ADODB_FETCH_ASSOC);
	
	$options = new Options();
	
	lang_init();
	lang_init_arrays();
?>