<?php 
/** 
	* Location of FPDF font definitions
	* @global string
	*/
	define('FPDF_FONTPATH', LIB_PATH.'fpdf/font/');
	
	/**
	* Location of media files
	* @global string
	*/
	define('_MEDIA_FILES','media/files/');
	
	/**
	* Location of media thumbnails
	* @global string
	*/
	define('_MEDIA_THUMBS','media/thumbs/');
	
	/** 
	* Retrospect Copyright
	*/
	define('RGDS_COPYRIGHT', '©2003-2004 Keith Morrison, Infused Solutions');
	
	# Initialize table vars
	
	/**
	* Individual table.
	* @global string $g_tbl_indiv
	*/
	$g_tbl_indiv  			= $g_db_prefix . 'indiv';
	
	/**
	* Fact table.
	* @global string $g_tbl_fact
	*/
	$g_tbl_fact   			= $g_db_prefix . 'fact';
	
	/**
	* Family table.
	* @global string $g_tbl_family
	*/
	$g_tbl_family 			= $g_db_prefix . 'family';
	
	/**
	*
	* Citation table.
	* @global string $g_tbl_citation
	*/
	$g_tbl_citation 		= $g_db_prefix . 'citation';
	
	/**
	* Source table.
	* @global string $g_tbl_source
	*/
	$g_tbl_source   		= $g_db_prefix . 'source';
	
	/**
	* Note table.
	* @global string $g_tbl_note
	*/
	$g_tbl_note					= $g_db_prefix . 'note';
	
	/**
	* Child table.
	* @global string $g_tbl_child
	*/
	$g_tbl_child				= $g_db_prefix . 'children';
	
	/**
	* User table.
	* @global string $g_tbl_user
	* */
	$g_tbl_user					= $g_db_prefix . 'user';
	
	/**
	* Language table.
	* @global string $g_tbl_lang
	*/
	$g_tbl_lang					= $g_db_prefix . 'language';
	
	/**
	* Options table.
	* @global string $g_tbl_option
	*/
	$g_tbl_option 			= $g_db_prefix . 'options';
	
	/**
	* Media table.
	* @global string $g_tbl_media
	*/
	$g_tbl_media				= $g_db_prefix  . 'media';
	
	/**
	* Comment table.
	* @global string $g_tbl_comment
	*/
	$g_tbl_comment			= $g_db_prefix . 'comment';

?>