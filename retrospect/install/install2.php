<?php
/**
 * Installation 
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
 * @license http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="install.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<?php
	# Disable error reporting
	error_reporting(0);
	
	/**
	* Root path
	* @global string
	*/
	define('ROOT_PATH', dirname($_SERVER['PATH_TRANSLATED']));

	/**
	* Location of core files
	* @global string
	*/
	define('CORE_PATH', ROOT_PATH.'/../core/');	
	
	/** 
	* Location of library files
	* @global string
	*/
	define('LIB_PATH', ROOT_PATH.'/../libraries/');
	
	# Process post vars
	$db_type = isset( $_POST['frm_db_type'] ) ? $_POST['frm_db_type'] : '';
	$db_host = isset( $_POST['frm_db_host'] ) ? $_POST['frm_db_host'] : '';
	$db_port = isset( $_POST['frm_db_port'] ) ? $_POST['frm_db_port'] : '';
	$db_name = isset( $_POST['frm_db_name'] ) ? $_POST['frm_db_name'] : '';
	$db_user = isset( $_POST['frm_db_user'] ) ? $_POST['frm_db_user'] : '';
	$db_pass = isset( $_POST['frm_db_pass'] ) ? $_POST['frm_db_pass'] : '';
	$db_pref = isset( $_POST['frm_db_pref'] ) ? rtrim( $_POST['frm_db_pref'], '_' ) : '';
	$db_drop = isset( $_POST['frm_db_drop'] ) ? true : false;
	
	# Load adodb library w/xmlschema
	require_once(LIB_PATH . 'adodb/adodb.inc.php');
	require_once(LIB_PATH . 'adodb/adodb-xmlschema.inc.php');
	
	# Set failed var
	$failed = false;
	
	# Define config.php innards
	$cfg_innards  = "<?php\n";
	$cfg_innards .= "\$g_db_type = '{$db_type}';\n";
	$cfg_innards .= "\$g_db_host = '{$db_host}';\n";
	$cfg_innards .= "\$g_db_port = '{$db_port}';\n";
	$cfg_innards .= "\$g_db_name = '{$db_name}';\n";
	$cfg_innards .= "\$g_db_user = '{$db_user}';\n";
	$cfg_innards .= "\$g_db_pass = '{$db_pass}';\n";
	$cfg_innards .= "\$g_db_prefix = '{$db_pref}_';\n";
	$cfg_innards .= "\$g_theme = 'default';\n";
	$cfg_innards .= "?>";
	
	# is config.php writable
	$cfg_filename = CORE_PATH.'config.php';
	$cfg_writable = is_writable(CORE_PATH);
	
?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="title">Retrospect-GDS Installation </td>
  </tr>
</table>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Checking configuration... </td>
  </tr>
  <tr>
    <td class="section_body"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="400" class="section_item">&nbsp;</td>
        <td width="100" class="section_item">&nbsp;</td>
        <td class="section_item">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="section_item">Connecting to <i><?php echo $db_type; ?></i>  server...</td>
        <td align="left" valign="top" class="section_item">
					<?php 
						# Attempt server connection
						if ($db = &NewAdoCOnnection($db_type)) { 
							echo '<div class="yes">OK</div>';
						} else {
							echo '<div class="no">Failed</div>';
							$failed = true;
						}
					?>
					</td>
        <td align="left" valign="top" class="section_item">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="section_item">Logging in to <i><?php echo $db_name; ?></i> database...</td>
        <td align="left" valign="top" class="section_item">
					<?php 
						if ($failed == true) {
							echo '<div class="no">Skipping</div>';
						} else {
							# Attempt db connection
							if ($db_type == 'odbc_mssql') {
								# Microsoft SQL ODBC connection
								$dsn = 'Driver={SQL Server};Server='.$db_host.';Database='.$db_name.';';
								$db->Connect($dsn, $db_user, $db_pass);
							} else {
								# MySQL, PostrgreSQL, etc...
								$host = ($db_port != '') ? $db_host.':'.$db_port : $db_host;
								$db->Connect($host, $db_user, $db_pass, $db_name);
							}
							if ($db) {
								echo '<div class="yes">OK</div>';
							} else {
								echo '<div class="no">Failed</div>';
								$failed = true;
							} 
						}
					?>
				</td>
        <td align="left" valign="top" class="section_item">&nbsp;
				</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="section_item">Writing configuration to disc... </td>
        <td align="left" valign="top" class="section_item">
					<?php
						if ($failed == true) {
							echo '<div class="no">Skipping</div>';
						} else {
							if ($cfg_writable) {
								if ($fp = fopen($cfg_filename, 'w')) {
									fwrite($fp, $cfg_innards, strlen($cfg_innards));
									fclose($fp);
									echo '<div class="yes">OK</div>';
								} else {
									$failed = true;
									$cfg_writable = false;
								}
							} 
							if ($cfg_writable === false) {
								echo '<div class="no">Skipping... config.php not writable</div>';
							}
						}
					?>
				</td>
        <td align="left" valign="top" class="section_item">
					<?php
						echo ($cfg_writable) ? filesize($cfg_filename) . ' bytes written' : '';
					?>&nbsp;
				</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="section_item">Creating tables, indexes, and default settings...</td>
        <td align="left" valign="top" class="section_item">
					<?php
						if ($failed == true) {
							echo '<div class="no">Skipping</div>';
						} else {
							# drop existing tables
							if ($db_drop) {
								$schema = new adoSchema( $db );
								$schema->setPrefix( $db_pref );
								$sql = $schema->ParseSchema( 'drop.xml' );
								$result = $schema->ExecuteSchema( $sql );
								$schema->Destroy();
							}
							# create tables and indexes
							$schema = new adoSchema( $db );
							$schema->setPrefix( $db_pref );
							$sql = $schema->ParseSchema('create.xml');
							$result = $schema->ExecuteSchema( $sql );
							echo ($result) ? '<div class="yes">OK</div>' : '<div class="no">Failed</div>';
						}
					?>
			  </td>
        <td align="left" valign="top" class="section_item">
					<?php
						echo count($sql) . ' queries were executed ';
						echo ($result) ? 'successfully' : 'unsuccessfully';
						$schema->Destroy();
					?>
				</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="section_item">Verifying tables... </td>
        <td align="left" valign="top" class="section_item">
					<?php 
						$pref = (!empty($db_pref)) ? $db_pref . '_' : '';
						$check_arr = array( $pref . 'children',
																$pref . 'citation',
																$pref . 'comment',
																$pref . 'fact',
																$pref . 'family',
																$pref . 'indiv',
																$pref . 'language',
																$pref . 'media',
																$pref . 'note',
																$pref . 'options',
																$pref . 'source',
																$pref . 'user');
						$table_arr = $db->MetaTables('TABLES');
						foreach($check_arr as $table) {
							$table_chk = in_array($table, $table_arr);
							if ( $table_chk === false ) {
								$failed = true;
								break;
							}
						}
						echo ( $table_chk ) ? '<div class="yes">OK</div>' : '<div class="no">Failed</div>';
					?>				</td>
        <td align="left" valign="top" class="section_item">
				<?php
					echo ( $table_chk ) ? count( $check_arr ) . ' tables were verified' : 'The <i>'.$table.'</i> table is missing';
				?>
				</td>
      </tr>
    </table>
		<?php if ($failed != true) { ?>
		<p>Congratulations! The installation of Retrospect-GDS has completed successfully. </p>
		<p>You should now log into the <a href="../administration/index.php">administration</a> module to import your data. The default username is 'admin' and the password is 'welcome'.</p>
		<p class="style1">IMPORTANT! You should remove the entire /install directory from your web server now that the installation is complete. </p>
		<?php } ?>
		</td>
  </tr>
</table>
<?php if (!$cfg_writable) { ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="section">
  <tr>
    <td class="section_head">Configuration Information </td>
  </tr>
  <tr>
    <td class="section_body"><p>Your configuration file was not writable. Copy the contents of the text box below and paste them into  the core/config.php file (replacing the existing contents of the file).</p>
    <p><textarea name="textfield" cols="80" rows="20" class="textbox"><?php echo $cfg_innards; ?></textarea>
    </p>
		</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
