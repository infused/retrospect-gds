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
<div class="log">
<?php
	# helper functions
	function outputnow($s, $nl=true) {
		echo $s;
		if ($nl == true) echo '<br />';
		ob_flush();
		flush();
	}
	
	function cleantable($tbl) {
		global $db;
		$sql = 'DELETE FROM '.$tbl;
		$db->Execute($sql);
		$sql = 'SELECT * FROM '.$tbl;
		$rs = $db->Execute($sql);
		outputnow( 'Cleaning '.$tbl.' table...', false);
		outputnow( $rs->RecordCount > 0 ? 'Failed' : 'OK');
	}
	
	$filename = $_GET['f'];
	$filepath = GEDCOM_DIR.$filename;
	//$maxtime = ini_get('max_execution_time') - 5;
	$maxtime = 30;
	$stime = time();
	
	# initialize gedcom parser
	outputnow( 'Initializing gedcom parser...');
	require_once(CORE_PATH.'gedcom.class.php');
	$gedcom = new GedcomParser();
	$gedcom->Open($filepath);
	
	# Set the file offset and set the factkey if needed
	if (isset($_GET['offset']) AND $_GET['offset'] > 0) {
		
		$offset = $_GET['offset'];
		
		# we need to set the factkey to the highest already in the database
		# in case we are not starting from the beginning of the file
		$sql = 'SELECT factkey FROM '.TBL_FACT;
		$rs = $db->Execute($sql);
		$factkey = 0;
		while ($row = $rs->FetchRow()) {
			if ($row['factkey'] > $factkey) $factkey = $row['factkey'];
		}
		$gedcom->factkey = $factkey;
	}
	else {
		$offset = 0;
	}
	
	# Empty tables if starting import from beginning
	if ($offset == 0) { 
	 	# Clean tables
		cleantable(TBL_INDIV);
		cleantable(TBL_FAMILY);
		cleantable(TBL_CHILD);
		cleantable(TBL_FACT);
		cleantable(TBL_NOTE);
		cleantable(TBL_CITATION);
		cleantable(TBL_SOURCE);
	}
	
	# Begin processing
	# We need to limit processing time to 25 seconds because the default php.ini setting is 30
	# Maybe we can add this as a configuration option in the future
	outputnow( 'Processing '.$filename.' starting at line '.$offset );
	while ($offset !== true) {
		$offset = $gedcom->ParseGedcom($offset,5);
		$complete = ($offset !== true) ? number_format($offset / $gedcom->file_end_offset * 100, 1) : 100;
		if ($complete != 100) {
			outputnow( 'Processing is '.$complete.'% complete...' );
			$etime = time();
			if ($etime - $stime > $maxtime - 5) {
				$yes = '<a href="'.$_SERVER['PHP_SELF'].'?m=gedcom_process&f='.$filename.'&offset='.$offset.'">Continue</a>';
				$no = '<a href="'.BASE_SCRIPT.'?m=gedcom" target="_parent">Abort</a>';
				outputnow( '' );
				outputnow( 'Would you like to continue processing this gedcom file?' );
				outputnow( $yes );
				outputnow( $no );
				exit;
			}
		} else {
			$return = '<a href="'.BASE_SCRIPT.'" target="_parent">here</a>';
			outputnow( 'Processing is '.$complete.'% complete...' );
			outputnow('');
			outputnow( 'The import process is complete.');
			outputnow( 'Click '.$return.' to return to the main menu.' );
		}
	}
	

?>
</div>