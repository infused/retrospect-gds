<?php
  # Disable error reporting
  error_reporting(E_ALL);

  # Define all application paths
  define('ROOT_PATH', dirname(__FILE__));
  define('CORE_PATH', ROOT_PATH.'/../core/');	
  define('LIB_PATH', ROOT_PATH.'/../libraries/');
  
  # Load the user configuration
  require_once(CORE_PATH.'config.php');
  
  # Load adodb library w/xmlschema
  require_once(LIB_PATH . 'adodb/adodb.inc.php');
  require_once(LIB_PATH . 'adodb/adodb-xmlschema.inc.php');
  
  # Establish the database connection
  # Connections to MSSQL via ODBC require a special connection string!
  # Always return recordsets as associative arrays
  $db =& AdoNewConnection($g_db_type);
  if ($g_db_type == 'odbc_mssql') {
  	$dsn = 'Driver={SQL Server};Server='.$g_db_host.';Database='.$g_db_name.';';
  	$db->Connect($dsn, $g_db_user, $g_db_pass);
  } else {
  	$host = ($g_db_port) ? $g_db_host : $g_db_host.':'.$g_db_port;
  	$db->Connect($host, $g_db_user, $g_db_pass, $g_db_name);
  }
  $db->SetFetchMode(ADODB_FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Retrospect-GDS - Installation</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="install.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <h1>Retrospect-GDS Installer</h1>
  <h2>Step 2 - Creating tables</h2>
  <?php 
    # Do we have a good database connection?
    if ($db != true)
      die('A database connection could not be established.  Check your configuration settings in core/config.php and try again.');

    # Drop existing Retrospect-GDS tables
    $schema = new adoSchema( $db );
		$schema->setPrefix( $g_db_prefix );
		$sql = $schema->ParseSchema( 'drop.xml' );
		$result = $schema->ExecuteSchema( $sql );
		$schema->Destroy();
		if ($result != true)
		  die('The existing tables could not be dropped.  Please remove all Retrospect-GDS tables and try again.');
		  
		# create new tables and indexes
		$schema = new adoSchema( $db );
		$schema->setPrefix( $g_db_prefix );
		$sql = $schema->ParseSchema('create.xml');
		$result = $schema->ExecuteSchema( $sql );
		$error = $db->ErrorMsg(); 
    if ($result != true) 
      die('There were error was encountered while creating the database tables: '.$error);
  ?>
  No errors were encountered.
  
  <h2>Step 3 - Verifying data</h2>
  
  <?php
    # Verifying tables
    $tables_in_db = $db->MetaTables('TABLES');
    $tables = array('children' => 0 ,
                    'citation' => 0,
                    'comment' => 0,
                    'fact' => 0,
                    'family' => 0,
                    'indiv' => 0,
                    'language' => 8,
                    'note' => 0,
                    'options' => 13,
                    'source' => 0,
                    'user' => 1);
    foreach ($tables as $table => $records) {
      $sql = 'SELECT COUNT(*) FROM '.$g_db_prefix.$table;
      $count = $db->GetOne($sql);
      if ($count != $records) 
        die('The '.$g_db_prefix.$table.' table does not contain the correct number of records. Found '.$count.', but there should be '.$records.'.');
    }
  ?>
  No errors were encountered.
  
  <h2>Installation Complete!</h2>
  <p>The installation of Retrospect-GDS has completed successfully. 
  You should now login to the <a href="../administration/">administration</a> 
  area using the following username and password:</p>
  <p>Username: admin<br />
  Password: welcome</p>
  
  </p>
  <p></p>
</body>
</html>