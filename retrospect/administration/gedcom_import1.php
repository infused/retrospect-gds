<?php
/**
 * Admin - Gedcom Import Module - Step 1
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		administration
 * @license 		http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details.
 *
 * $Id$
 *
 */  
?>
<link href="styles.css" rel="stylesheet" type="text/css">
<?php
	# Load the gedcom and date classes
	require_once(CORE_PATH.'gedcom.class.php');
	require_once(CORE_PATH.'date-parser.class.php');
	
	# Set some variables
	$gedcomdir = ROOT_PATH . '/../gedcom/';

	# Check if gedcom directory is writable
	if (!is_writable($gedcomdir)) { 
		notify('The gedcom directory is not writable. Check your server configuration.');
	}
	
	$gedcomfile = $gedcomdir.$_POST['selectedfile'];
	$gedcom = new GedcomParser();
	$gedcom->Open($gedcomfile);
	$gedcom->GetStatistics();
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="5"> 
  <tr>
    <td align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">Import Gedcom </td>
      </tr>
      <tr>
        <td class="section_body"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td valign="middle" class="content-label">Analyzing gedcom file...</td>
          </tr>
          <tr>
            <td valign="middle" class="text">File size: <?php echo filesize_format($gedcom->fsize); ?></td>
          </tr>
          <tr>
            <td valign="middle" class="text">Number of individuals: <?php echo number_format($gedcom->individual_count); ?></td>
          </tr>
          <tr>
            <td valign="middle" class="text">Number of families: <?php echo number_format($gedcom->family_count); ?></td>
          </tr>
          <tr>
            <td valign="middle" class="text">Number of sources: <?php echo number_format($gedcom->source_count); ?></td>
          </tr>
          <tr>
            <td valign="middle" class="text">Number of notes: <?php echo number_format($gedcom->note_count); ?></td>
          </tr>
          <tr>
            <td valign="middle" class="text">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr> 
    <td align="left" valign="top" class="notification"><p><strong>WARNING!</strong><br>
      If you continue, your current database will be overwritten with new data from this gedcom file. Please make sure that your current database has been backed up before you continue. </p>
    </td> 
  </tr>
  <tr>
    <td align="left" valign="top" class="notification">&nbsp;</td>
  </tr> 
	<tr>
	<td>
		<form action="<?php echo $_SERVER['PHP_SELF'].'?option=gedcom_import2'; ?>" method="post" enctype="multipart/form-data" name="gedcom_import_form1" id="gedcom_import_form1">
			<input name="selectedfile" type="hidden" value="<?php echo $_POST['selectedfile'] ?>">
			<input name="Continue" type="submit" class="text" id="Continue" value="Continue"> 
		</form>
	</td>
	</tr>
</table> 
