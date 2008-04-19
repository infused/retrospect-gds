<style type="text/css">
<!--
a {
	color: #0066CC;
	text-decoration: none;
}
a:hover {
	color: #FF9900;
}
.log {
	font: 14px Georgia, "Times New Roman", Times, serif;
}
-->
</style>
<span class="log">
<?php
	# helper function
	function outputnow($s) {
		echo $s.'<br />';
		ob_flush();
		flush();
	}
	
	$filename = $_GET['f'];
	$filepath = GEDCOM_DIR.$filename;
	
	# initialize gedcom parser
	outputnow( 'Initializing gedcom parser...');
	require_once(CORE_PATH.'gedcom.class.php');
	$gedcom = new GedcomParser();
	
	# analyze gedcom
	outputnow( 'Analyzing '.$filename.'...' );
	$gedcom->Open($filepath);
	$gedcom->GetStatistics();
	
	#display results of analysis
	outputnow( '' );
	outputnow( 'Size: '.filesize_format($gedcom->fsize) );
	outputnow( 'Lines: '.number_format($gedcom->lines) );
	outputnow( 'Individuals: '.number_format($gedcom->individual_count) );
	outputnow( 'Families: '.number_format($gedcom->family_count) );
	outputnow( 'Sources: '.number_format($gedcom->source_count) );
	outputnow( 'Notes: '.number_format($gedcom->note_count) );
	
	outputnow( '' );
	
	$yes = '<a href="'.$_SERVER['PHP_SELF'].'?m=gedcom_process&f='.$filename.'">Yes</a>';
	$no = '<a href="'.BASE_SCRIPT.'?m=gedcom" target="_parent">No</a>';
	outputnow( 'Are you sure you want to import this file?' );
	outputnow( $yes );
	outputnow( $no );
?>
</span>