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
		outputnow( 'Cleaning '.$tbl.'...', false);
		outputnow( $rs->RecordCount > 0 ? 'Failed' : 'OK');
	}
	
	$filename = $_GET['f'];
	$filepath = GEDCOM_DIR.$filename;
	
	# initialize gedcom parser
	outputnow( 'Initializing gedcom parser...');
	require_once(CORE_PATH.'gedcom.class.php');
	$gedcom = new GedcomParser();
	$gedcom->Open($filepath);
	
	# Set the file offset and set the factkey if needed
	if (isset($_POST['offset']) AND $_POST['offset'] > 0) {
		$offset = $_POST['offset'];
		
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
		
		# Begin processing
		outputnow( 'Processing '.$filename.'...' );
		$offset = $gedcom->ParseGedcom($offset);
		$complete = ($offset) ? number_format($offset / $gedcom->file_end_offset * 100, 1) : '';
		outputnow( 'Processing is '.$complete.'% complete.' );

	}
	else {
		# Continue processing
	}

	

?>
</span>