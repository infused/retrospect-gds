<?php
/**
 * Admin - Gedcom Import Module - Upload and Select
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
	# Set some variables
	$gedcomdir = ROOT_PATH . '/gedcom/';
	
	# Check if gedcom directory is writable
	if (!is_writable($gedcomdir)) { 
		notify('The gedcom directory is not writable. Check your server configuration.');
	}
	
	# Handle file uploads
	if (isset($_POST['Upload'])) {
		switch ($_FILES['file']['error']) {
			case 4:
				notify('No file was selected for upload.');
				break;
			case 3:
				notify('The file upload did not complete.  Try again.');
				break;
			case 2:
				notify('The file is too large to upload.');
				break;
			case 1:
				notify('The file is too large to upload.');
				break;
			case 0:
				$uploadfile = $gedcomdir.$_FILES['file']['name'];
				# Check for valid file extension (no mime)
				$valid_extensions = array('ged','zip');
				$pathinfo = pathinfo($uploadfile);
				$extension = strtolower($pathinfo['extension']);
				if (!in_array($extension, $valid_extensions)) {
					notify('Only .ged or .zip files are allowed.');
					break;
				}
				# Check if gedcom directory is writable
				if (!is_writable($gedcomdir)) { 
					notify('The gedcom directory is not writable. Check your server configuration.');
					break;
				}
				# Check if file already exists
				if (file_exists($uploadfile)) {
					notify('A file with the same name already exists.');
					break;
				}
				# Move the file
				if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
					notify('Error moving file to the gedcom directory.  Check your server configuration.');
					break;
				}
				# Extract gedcoms from zip files and cleanup
				if (strtolower($extension) == 'zip') {
					# load the pclzip library
					require_once(LIB_PATH.'pcl/pclzip.lib.php');
					$zip = new pclzip($uploadfile);
					# extract only .ged files (case insensitive)
					$zip->extract(PCLZIP_OPT_PATH, $gedcomdir, PCLZIP_OPT_BY_PREG, '/ged$/i');
					# remove the zip file
					unlink($uploadfile);
				} 
				break; 
		}
	}
	# Handle file deletes
	if (isset($_GET['delete']) AND $_GET['delete'] == '1') {
		if (isset($_GET['fn'])) {
			$gedcomfile = $gedcomdir.$_GET['fn'];
				if (@unlink($gedcomfile) == false) {
					notify('Unable to delete the selected file.');
				}
		} else {
			notify('No file was selected for deletion.');
		}
	}
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td align="left" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
      <tr>
        <td class="section_head">Upload Gedcom </td>
      </tr>
      <tr>
        <td class="section_body">
				<form action="" method="post" enctype="multipart/form-data" name="gedcom_upload_form" id="gedcom_upload_form">
				<table width="100%"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td colspan="3" valign="middle" class="text"><?php echo sprintf('Your server is configured for a maximum file upload size of %s. If you wish to upload a gedcom file that is larger than %s either change the upload_max_filesize directive in php.ini or manually upload the file to the gedcom directory.', ini_get('upload_max_filesize'), ini_get('upload_max_filesize')); ?></td>
          </tr>
          <tr>
            <td colspan="3" valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td width="125" valign="middle" class="content-label">Gedcom File:</td>
            <td valign="middle"><input name="file" type="file" class="text"></td>
            <td align="left" valign="top"><p>You can upload a single gedcom file with an extension of .ged or a zip file containing one or more gedcom files. </p></td>
          </tr>
          <tr>
            <td valign="middle" class="content-label">&nbsp;</td>
            <td valign="middle"><input name="Upload" type="submit" class="text" id="Upload" value="Upload"></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
				</form>
				</td>
      </tr>
    </table>
      <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
        <tr>
          <td class="section_head">Import Gedcom </td>
        </tr>
        <tr>
          <td class="section_body"><form action="<?php echo $_SERVER['PHP_SELF'].'?option=gedcom_import1'; ?>" method="post" enctype="multipart/form-data" name="gedcom_import_form1" id="gedcom_import_form1">
            <table width="100%"  border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td colspan="5">Select a gedcom file to begin the import process...</td>
              </tr>
              <tr>
                <td colspan="5"><table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" nowrap>&nbsp;</td>
                      <td nowrap><em>Filename</em></td>
                      <td width="20" nowrap>&nbsp;</td>
                      <td nowrap><em>Last Modified </em></td>
                      <td width="20" nowrap>&nbsp;</td>
                      <td nowrap><em>Size</em></td>
                      <td width="20" nowrap>&nbsp;</td>
                      <td nowrap>&nbsp;</td>
                      <td width="20" nowrap>&nbsp;</td>
                      <td nowrap>&nbsp;</td>
                    </tr>
                    <?php
								$dir = dir($gedcomdir);
								while (($filename = $dir->read()) !== false) {
									$pathinfo = pathinfo($filename);
									$gedcomfile = $gedcomdir.$filename;
									if (isset($pathinfo['extension']) AND strtolower($pathinfo['extension']) == 'ged') { ?>
                    <tr>
                      <td width="50" align="center" nowrap><input name="selectedfile" type="radio" value="<?php echo $filename; ?>">
                      </td>
                      <td nowrap><strong><?php echo $filename; ?></strong></td>
                      <td nowrap>&nbsp;</td>
                      <td nowrap><?php echo date('F d Y H:i:s', filemtime($gedcomfile)); ?></td>
                      <td nowrap>&nbsp;</td>
                      <td nowrap><?php echo sprintf('%s bytes', number_format(filesize($gedcomfile))); ?></td>
                      <td nowrap>&nbsp;</td>
                      <td nowrap><a class="text" href="<?php echo $gedcomfile; ?>">view</a></td>
                      <td nowrap>&nbsp;</td>
                      <td nowrap><a class="text" href="<?php echo $_SERVER['PHP_SELF'].'?option=gedcom_import&delete=1&fn='.$filename; ?>">delete</a></td>
                    </tr>
                    <?php 
									}
								}
								$dir->close();
							?>
                </table></td>
              </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5"><input name="Import" type="submit" class="text" id="Import" value="Begin Import...">
                </td>
              </tr>
            </table>
          </form></td>
        </tr>
      </table></td>
  </tr>
</table>
