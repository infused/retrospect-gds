<?php
/**
 * Admin - Gedcom Import Module - Step 2
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
	require_once(CORE_PATH.'date.class.php');
	
	# Set some variables
	$gedcomdir = ROOT_PATH . '/../gedcom/';

	# Check if gedcom directory is writable
	if (!is_writable($gedcomdir)) { 
		notify('The gedcom directory is not writable. Check your server configuration.');
	}
	
	$gedcomfile = $gedcomdir.$_POST['selectedfile'];
	$gedcom = new GedcomParser();
	$gedcom->Open($gedcomfile);
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
            <td valign="middle" class="content-label">Emptying tables... </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Individual table...
                <?php
							$sql = 'delete from '.TBL_INDIV;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Family table...
                <?php
							$sql = 'delete from '.TBL_FAMILY;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Child table...
                <?php 
							$sql = 'delete from '.TBL_CHILD;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Fact table...
                <?php 
							$sql = 'delete from '.TBL_FACT;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Note table...
                <?php 
							$sql = 'delete from '.TBL_NOTE;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Source table...
                <?php 
							$sql = 'delete from '.TBL_CITATION;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Citation table...
                <?php 
							$sql = 'delete from '.TBL_SOURCE;
							echo ($db->Execute($sql)) ? 'OK' : 'Failed';
						?>
            </td>
          </tr>
          <tr>
            <td valign="middle" class="text">&nbsp;</td>
          </tr>
          <tr>
            <td valign="middle" class="content-label">Processing gedcom...</td>
          </tr>
          <tr>
            <td valign="middle" class="text"><?php
							$gedcom->ParseGedcom();
						?>
&nbsp; </td>
          </tr>
          <tr>
            <td valign="middle" class="text">Processing complete. </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr> 
	<tr>
	<td>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input name="Continue" type="submit" class="text" id="Continue" value="Continue"> 
		</form>
	</td>
	</tr>
</table> 
