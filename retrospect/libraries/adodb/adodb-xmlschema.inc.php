<?PHP
// Copyright (c) 2003 ars Cognita Inc., all rights reserved
/* ******************************************************************************
    Released under both BSD license and Lesser GPL library license. 
 	Whenever there is any discrepancy between the two licenses, 
 	the BSD license will take precedence. 
*******************************************************************************/
/**
 * xmlschema is a class that allows the user to quickly and easily
 * build a database on any ADOdb-supported platform using a simple
 * XML schema.
 *
 * @author Richard Tango-Lowy
 * @version $Revision$
 */
 
/**
* Debug on or off
*/
 define( 'XMLS_DEBUG', FALSE );
 
 /**
* Default prefix key
*/
 define( 'XMLS_PREFIX', '%%P' );
 
/**
* Maximum length allowed for object prefix
*/
define( 'XMLS_PREFIX_MAXLEN', 10 );
 
/**
* Include the main ADODB library
*/
if (!defined( '_ADODB_LAYER' ) ) {
	require( 'adodb.inc.php' );
}

/**
* Abstract DB Object. This class provides basic methods for database objects, such
* as tables and indexes.
*
* @access private
*/
class dbObject {
	
	/**
	* var string $prefix Object prefix
	*/
	var $prefix;
	
	/**
	* Creates and returns the object set
	*
	* @return array Database object
	*/
	function create() {
		return $this->querySet;
	}
	
	/**
	* Sets object name, adding prefix and anything else necessary.
	*
	* @param string $baseName Object name to process
	* @return string Process name, ready for use
	*/	
	function setName( $baseName, $prefix = NULL ) {
	
		// Test prefix
		if( !isset( $prefix ) or $prefix == '' ) {
			// No prefix set. Use name provided.
			$endName = $baseName;
			
		} elseif( preg_match( '/^[A-Za-z]+[A-Za-z0-9]+/', $prefix ) ) {
			// Prepend the object prefix to the table name
			$endName = $prefix . '_' . $baseName;
			
		} else {
			// Bad prefix. Fail out.
			die( "Bad object prefix '$prefix'. Prefix must begin with a letter and contain only alphanumeric characters." );
		}
		
	return $endName;
	}
	
	/**
	* Destroys the object
	*/
	function destroy() {
		unset( $this );
	}
}

/**
 * Creates a table object in ADOdb's datadict format
 *
 * This class stores information about a database table. As charactaristics
 * of the table are loaded from the external source, methods and properties
 * of this class are used to build up the table description in ADOdb's
*  datadict format.
 *
 * @access private
 */
class dbTable extends dbObject {
	
	/**
	* @var string	Table name
	*/
	var $tableName;
	
	/**
	* @var array	Field specifier: Meta-information about each field
	*/
	var $fieldSpec;
	
	/**
	* @var array	Table options: Table-level options
	*/
	var $tableOpts;
	
	/**
	* @var string	Field index: Keeps track of which field is currently being processed
	*/
	var $currentField;
	
	/**
	* @var string If set (to 'ALTER' or 'REPLACE'), upgrade an existing database
	* @access private
	*/
	var $upgrade;
	
	/**
	* @var array Array of legacy metadata. Used for REPLACE upgrades.
	* @access private
	*/
	var $legacyFieldMetadata;
	
	/**
	* @var boolean Mark table for destruction
	* @access private
	*/
	var $dropTable;
	
	/**
	* @var boolean Mark field for destruction (not yet implemented)
	* @access private
	*/
	var $dropField;
	
	/**
	* Constructor. Iniitializes a new table object.
	*
	* If the table already exists, there are two methods available to upgrade it.
	* To upgrade an existing table the new schema by ALTERing the table, set the upgradeTable
	* argument to "ALTER."  To force the new table to replace the current table, set the upgradeTable
	* argument to "REPLACE."
	*
	* @param string	$name		Table name
	* @param string	$upgradeTable		Upgrade method (NULL, ALTER, or REPLACE)
	* @param string 	$prefix		DB Object prefix
	*/
	function dbTable( $name, $upgrade = NULL, $prefix = NULL ) {
		
		$dbconn = $GLOBALS['AXMLS_DBCONN'];
		$dbdict = $GLOBALS['AXMLS_DBDICT'];
		
		// Preprend the object prefix to the table name
		$name = $this->setName( $name, $prefix );	
			
		$this->tableName = $name;

		// If upgrading, set and handle the upgrade method
		if( isset( $upgrade ) ) {
			$upgrade = strtoupper( $upgrade );
			
			switch( $upgrade ) {
				
				case "ALTER":
					$this->upgrade = strtoupper( $upgrade );
					logMsg( "Upgrading table '$name' using {$this->upgrade}" );
					break;
					
				case "REPLACE":
					$this->upgrade = strtoupper( $upgrade );
					logMsg( "Upgrading table '$name' using {$this->upgrade}" );
					
					// Need to fetch column names, run them through the case handler (for MySQL),
					// create the new column, migrate the data, then drop the old column.
					$this->legacyFieldMetadata = $dbconn->MetaColumns( $name );
					logMsg( $this->legacyFieldMetadata, "Legacy Metadata" );
					break;
					
				default:
					unset( $this->upgrade );
					break;
			}
			
		} else {
			logMsg( "Creating table '$name'" );
		}
	}
	
	/**
	* Adds a field to a table object
	*
	* $name is the name of the table to which the field should be added. 
	* $type is an ADODB datadict field type. The following field types
	* are supported as of ADODB 3.40:
	* 	- C:  varchar
	*	- X:  CLOB (character large object) or largest varchar size
	*	   if CLOB is not supported
	*	- C2: Multibyte varchar
	*	- X2: Multibyte CLOB
	*	- B:  BLOB (binary large object)
	*	- D:  Date (some databases do not support this, and we return a datetime type)
	*	- T:  Datetime or Timestamp
	*	- L:  Integer field suitable for storing booleans (0 or 1)
	*	- I:  Integer (mapped to I4)
	*	- I1: 1-byte integer
	*	- I2: 2-byte integer
	*	- I4: 4-byte integer
	*	- I8: 8-byte integer
	*	- F:  Floating point number
	*	- N:  Numeric or decimal number
	*
	* @param string $name	Name of the table to which the field will be added.
	* @param string $type		ADODB datadict field type.
	* @param string $size		Field size
	* @param array $opts		Field options array
	* @return array	Field specifier array
	*/
	function addField( $name, $type, $size = NULL, $opts = NULL ) {

		// Set the field index so we know where we are
		$this->currentField = $name;
		
		// Set the field type (required)
		$this->fieldSpec[$name]['TYPE'] = $type;
		
		// Set the field size (optional)
		if( isset( $size ) ) {
			$this->fieldSpec[$name]['SIZE'] = $size;
		}
		
		// Set the field options
		if( isset( $opts ) ) $this->fieldSpec[$name]['OPTS'] = $opts;
		
		// Return array containing field specifier
		return $this->fieldSpec;
	}
	
	/**
	* Adds a field option to the current field specifier
	*
	* This method adds a field option allowed by the ADOdb datadict 
	* and appends it to the given field.
	*
	* @param string $field		Field name
	* @param string $opt		ADOdb field option
	* @param mixed $value	Field option value
	* @return array	Field specifier array
	*/
	function addFieldOpt( $field, $opt, $value = NULL ) {
		
		// Add the option to the field specifier
		if(  $value === NULL ) { // No value, so add only the option
			$this->fieldSpec[$field]['OPTS'][] = $opt;
		} else { // Add the option and value
			$this->fieldSpec[$field]['OPTS'][] = array( "$opt" => "$value" );
		}
	
		// Return array containing field specifier
		return $this->fieldSpec;
	}
	
	/**
	* BROKEN: Adds an option to the table
	*
	*This method takes a comma-separated list of table-level options
	* and appends them to the table object.
	*
	* @param string $opt		Table option
	* @return string	Option list
	*/
	function addTableOpt( $opt ) {
		
		$optlist = &$this->tableOpts;
		$optlist ? ( $optlist .= ", $opt" ) : ($optlist = $opt );
		
		print "<H1>Optlist</H1>";
		print_r( $optlist );
		print "<BR>";
		return $optlist;
	}
	
	/**
	* Generates the SQL that will create the table in the database
	*
	* Returns SQL that will create the table represented by the object.
	*
	* @param object $dict		ADOdb data dictionary
	* @return array	Array containing table creation SQL
	*/
	function create( $dict ) {
	
		// Drop the table
		if( $this->dropTable ) {
			$sqlArray[] = "DROP TABLE {$this->tableName}";
			return $sqlArray;
		}
		
		// Loop through the field specifier array, building the associative array for the field options
		$fldarray = array();
		$i = 0;
		
		foreach( $this->fieldSpec as $field => $finfo ) {
			$i++;
			
			// Set an empty size if it isn't supplied
			if( !isset( $finfo['SIZE'] ) ) $finfo['SIZE'] = '';
			
			// Initialize the field array with the type and size
			$fldarray[$i] = array( $field, $finfo['TYPE'], $finfo['SIZE'] );
			
			// Loop through the options array and add the field options. 
			if( isset( $finfo['OPTS'] ) ) {
				foreach( $finfo['OPTS'] as $opt ) {
					
					if( is_array( $opt ) ) { // Option has an argument.
						$key = key( $opt );
						$value = $opt[key( $opt ) ];
						$fldarray[$i][$key] = $value;
						
					} else { // Option doesn't have arguments
						array_push( $fldarray[$i], $opt );
					}
				}
			}
		}
		
		// Check for existing table
		$legacyTables = $dict->MetaTables();
		if( is_array( $legacyTables ) and count( $legacyTables > 0 ) ) {
			foreach( $dict->MetaTables() as $table ) {
				$this->legacyTables[ strtoupper( $table ) ] = $table;
			}
			if( isset( $this->legacyTables ) and is_array( $this->legacyTables ) and count( $this->legacyTables > 0 ) ) {
				if( array_key_exists( strtoupper( $this->tableName ), $this->legacyTables ) ) {
					$existingTableName = $this->legacyTables[strtoupper( $this->tableName )];
					//logMsg( "Upgrading $existingTableName using '{$this->upgrade}'" );
				}
			}
		} 	
		
		// Build table array
		if( !isset( $this->upgrade ) or !isset( $existingTableName ) ) {
			
			// Create the new table
			$sqlArray = $dict->CreateTableSQL( $this->tableName, $fldarray, $this->tableOpts );
			logMsg( $sqlArray, "Generated CreateTableSQL" );
			
		} else {
			
			// Upgrade an existing table
			switch( $this->upgrade ) {
				
				case 'ALTER':
					// Use ChangeTableSQL
					$sqlArray = $dict->ChangeTableSQL( $this->tableName, $fldarray, $this->tableOpts );
					logMsg( $sqlArray, "Generated ChangeTableSQL (ALTERing table)" );
					break;
					
				case 'REPLACE':
					logMsg( "Doing upgrade REPLACE (testing)" );
					$sqlArray = $dict->ChangeTableSQL( $this->tableName, $fldarray, $this->tableOpts );
					$this->replace( $dict );
					break;
					
				default:
			}
		}
		
		// Return the array containing the SQL to create the table
		return $sqlArray;
	}
	
	/**
	* Generates the SQL that will drop the table or field from the database
	*
	* @param object $dict		ADOdb data dictionary
	* @return array	Array containing table creation SQL
	*/
	function drop( $dict ) {
		$sqlArray = array();
		if( isset( $this->currentField ) ) {
			// Drop the current field
			logMsg( "Dropping field '{$this->currentField}' from table '{$this->tableName}'" );
			$this->dropField = TRUE;
			$sqlArray = $dict->DropColumnSQL( $this->tableName, $this->currentField );
		} else {
			// Drop the current table
			logMsg( "Dropping table '{$this->tableName}'" );
			$this->dropTable = TRUE;
		}
		return $sqlArray; 
	}
	
	/**
	* NOT IMPLEMENTED: Generates the SQL that will replace an existing table in the database
	*
	* Returns SQL that will replace the table represented by the object.
	*
	* @return array	Array containing table replacement SQL
	*/
	function replace( $dict ) {
		
		// Identify new columns
	}
}

/**
* Creates an index object in ADOdb's datadict format
*
* This class stores information about a database index. As charactaristics
* of the index are loaded from the external source, methods and properties
* of this class are used to build up the index description in ADOdb's
* datadict format.
*
* @access private
*/
class dbIndex extends dbObject {
	
	/**
	* @var string	Index name
	*/
	var $indexName;
	
	/**
	* @var array	Index options: Index-level options
	*/
	var $indexOpts;

	/**
	* @var string	Name of the table this index is attached to
	*/
	var $tableName;
	
	/**
	* @var array	Indexed fields: Table columns included in this index
	*/
	var $fields;
	
	/**
	* @var string If set (to 'ALTER' or 'REPLACE'), upgrade an existing database
	* @access private
	*/
	var $upgrade;
	
	/**
	* @var boolean Mark index for destruction
	* @access private
	*/
	var $dropIndex;
	
	/**
	* Constructor. Initialize the index and table names.
	*
	* If the upgrade argument is set to ALTER or REPLACE, axmls will attempt to drop the index
	* before and replace it with the new one.
	*
	* @param string $name	Index name
	* @param string $table		Name of indexed table
	* @param string	$upgrade		Upgrade method (NULL, ALTER, or REPLACE)
	* @param string $prefix	DB object prefix
	*/
	function dbIndex( $name, $table, $upgrade = NULL, $dict = NULL, $prefix = NULL ) {

		
		// Preprend the object prefix to the index and table names
		$name = $this->setName( $name, $prefix );
		$table = $this->setName( $table, $prefix );

		$this->indexName = $name;
		$this->tableName = $table;
		$this->dropIndex = FALSE;
		$this->dict = $dict;
		
		// If upgrading, set the upgrade method
		if( isset( $upgrade ) ) {
			$upgrade = strtoupper( $upgrade );
			if( $upgrade == 'ALTER' or $upgrade == 'REPLACE' ) {
				$this->upgrade = strtoupper( $upgrade );
				// Drop the old index
				logMsg( "Dropping old index '$name' using {$this->upgrade}" );
			} else {
				unset( $this->upgrade );
			}	
		}
	}
	
	/**
	* Adds a field to the index
	* 
	* This method adds the specified column to an index.
	*
	* @param string $name		Field name
	* @return string	Field list
	*/
	function addField( $name ) {
		
		$fieldlist = &$this->fields;
		$fieldlist ? ( $fieldlist .=" , $name" ) : ( $fieldlist = $name );
		
		// Return the field list
		return $fieldlist;
	}
	
	/**
	* Adds an option to the index
	*
	*This method takes a comma-separated list of index-level options
	* and appends them to the index object.
	*
	* @param string $opt		Index option
	* @return string	Option list
	*/
	function addIndexOpt( $opt ) {
		
		$optlist = &$this->indexOpts;
		$optlist ? ( $optlist .= ", $opt" ) : ( $optlist = $opt );

		// Return the options list
		return $optlist;
	}

	/**
	* Generates the SQL that will create the index in the database
	*
	* Returns SQL that will create the index represented by the object.
	*
	* @param object $dict	ADOdb data dictionary object
	* @return array	Array containing index creation SQL
	*/
	function create( $dict ) {
		
		// Drop the index
		if( $this->dropIndex == TRUE ) {
		    //$sqlArray = array( "DROP INDEX {$this->indexName}" );
			$sqlArray = $this->dict->_IndexSQL($this->indexName,'', null,array('REPLACE'=>true));
			return $sqlArray; 
		}
		
		if (isset($this->indexOpts) ) {
			// CreateIndexSQL requires an array of options.
			$indexOpts_arr = explode(",",$this->indexOpts);
		} else {
			$indexOpts_arr = NULL;
		}
	 
		if( isset( $this->upgrade ) ) {
		  $indexOpts_arr['REPLACE'] = true;
		}
	 
		// Build index SQL array
		$sqlArray = $dict->CreateIndexSQL( $this->indexName, $this->tableName, $this->fields, $indexOpts_arr );
	 	
		// Return the array containing the SQL to create the table
		return $sqlArray;
	}
	
	/**
	* Marks an index for destruction
	*/
	function drop() {
		$this->dropIndex = TRUE;
	}
	
	/**
	* Destructor
	*/
	function destroy() {
		unset( $this );
	}
}

/**
* Creates the SQL to execute a list of provided SQL queries
*
* This class compiles a list of SQL queries specified in the external file.
*
* @access private
*/
class dbQuerySet extends dbObject {
	
	/**
	* @var array	List of SQL queries
	*/
	var $querySet;
	
	/**
	* @var string	String used to build of a query line by line
	*/
	var $query;
	
	/**
	* @var string	Query prefix key
	*/
	var $prefixKey;
	
	/**
	* @var boolean	Auto prefix enable (TRUE)
	*/
	var $prefixMethod;
	
	/**
	* Constructor. Initializes the queries array
	*
	* @param string $prefix Object prefix string
	* @param string $prefixKey Object prefix key. Used to override default replacement key
	* @param string $prefixMethod Automatic prefix generation enabled
	*/
	function dbQuerySet( $prefix = NULL, $prefixKey = NULL, $prefixMethod = 'AUTO' ) {
		
		// Initialize properties
		$this->querySet = array();
		$this->query = '';
		
		// Sets the object prefix string
		if( isset( $prefix ) ) $this->prefix = $prefix;
		
		// Overrides the manual prefix key
		if( isset( $prefixKey ) ) $this->prefixKey = $prefixKey;
		
		// Enables or disables automatic prefix prepending
		switch( strtoupper( trim( $prefixMethod ) ) ) {
			case 'AUTO':
				$this->prefixMethod = 'AUTO';
				break;
			case 'MANUAL' :
				$this->prefixMethod = 'MANUAL';
				break;
			case 'NONE':
				$this->prefixMethod = 'NONE';
				break;
			default:
				$this->prefixMethod = 'AUTO';
				break;
		}
	}
	
	/** 
	* Appends a line to a query that is being built line by line
	*
	* $param string $data	Line of SQL data or NULL to initialize a new query
	*/
	function buildQuery( $data = NULL ) {;
		
		isset( $data ) ? ( $this->query .= " " . trim( $data ) ) : ( $this->query = '' );
	}
	
	/**
	* Adds a completed query to the query list
	*
	* @return string	SQL of added query
	*/
	function addQuery() {
		
		if( !function_exists( 'prefixQuery' ) ) {
			// Rebuild the query with the prefix attached to any objects
			function prefixQuery( $regex, $query, $prefix = NULL ) {
				
				if( !isset( $prefix ) ) return $query;
				
				if( preg_match( $regex, $query, $match ) ) {
				
					$preamble = $match[1];
					$postamble = $match[5];
					$objectList = explode( ',', $match[3] );
					$prefix = $prefix . '_';
					
					$prefixedList = '';
					foreach( $objectList as $object ) {
						if( $prefixedList === '' ) {
							$prefixedList .= $prefix . trim( $object );
						}else {
							$prefixedList .= ', ' . $prefix . trim( $object );
						}
					}
					$query = "$preamble $prefixedList  $postamble";
				}
				
				return $query;
			}
		}
		
		$query = $this->query;
		
		switch( $this->prefixMethod ) {
				
			case "AUTO":
				// Enable auto prefix replacement
				
				// Process object prefix.		
				// Evaluate SQL statements to prepend prefix to objects
				$query = prefixQuery( '/^\s*((?is)INSERT\s+(INTO\s+)?)((\w+\s*,?\s*)+)(\s.*$)/', $query, $this->prefix );
				$query = prefixQuery( '/^\s*((?is)UPDATE\s+(FROM\s+)?)((\w+\s*,?\s*)+)(\s.*$)/', $query, $this->prefix );
				$query = prefixQuery( '/^\s*((?is)DELETE\s+(FROM\s+)?)((\w+\s*,?\s*)+)(\s.*$)/', $query, $this->prefix );
				
				// SELECT statements aren't working yet
				#$data = preg_replace( '/(?ias)(^\s*SELECT\s+.*\s+FROM)\s+(\W\s*,?\s*)+((?i)\s+WHERE.*$)/', "\1 $prefix\2 \3", $data );
				
			case "MANUAL":
				
				// If prefixKey is set and has a value then we use it to override the default constant XMLS_PREFIX.
				// If prefixKey is not set, we use the default constant XMLS_PREFIX
				if( isset( $this->prefixKey ) and !($this->prefixKey === '' ) ) {
					// Enable prefix override
					$query = str_replace( $this->prefixKey, $this->prefix . '_', $query );
				} else {
					// Use default replacement
					$query = str_replace( XMLS_PREFIX , $this->prefix . "_", $query );
				}
				break;
		}

		$this->query = trim( $query );
		
		// Push the query onto the query set array
		array_push( $this->querySet, $this->query );
		
		// Return the query set array
		return $this->query;
	}
	
	/**
	* Creates and returns the current query set
	*
	* @return array Query set
	*/
	function create() {
		return $this->querySet;
	}
}


/**
* Loads and parses an XML file, creating an array of "ready-to-run" SQL statements
* 
* This class is used to load and parse the XML file, to create an array of SQL statements
* that can be used to build a database, and to build the database using the SQL array.
*
* @author Richard Tango-Lowy
* @version $Revision$
* @copyright (c) 2003 ars Cognita, Inc., all rights reserved
*/
class adoSchema {
	
	/**
	* @var array	Array containing SQL queries to generate all objects
	*/
	var $sqlArray;
	
	/**
	* @var object	XML Parser object
	* @access private
	*/
	var $xmlParser;
	
	/**
	* @var object	ADOdb connection object
	* @access private
	*/
	var $dbconn;
	
	/**
	* @var string	Database type (platform)
	* @access private
	*/
	var $dbType;
	
	/**
	* @var object	ADOdb Data Dictionary
	* @access private
	*/
	var $dict;
	
	/**
	* @var object	Temporary dbTable object
	* @access private
	*/
	var $table;
	
	/**
	* @var object	Temporary dbIndex object
	* @access private
	*/
	var $index;
	
	/**
	* @var object	Temporary dbQuerySet object
	* @access private
	*/
	var $querySet;
	
	/**
	* @var string Current XML element
	* @access private
	*/
	var $currentElement;
	
	/**
	* @var string If set (to 'ALTER' or 'REPLACE'), upgrade an existing database
	* @access private
	*/
	var $upgradeMethod;
	
	/**
	* @var mixed Existing tables before upgrade
	* @access private
	*/
	var $legacyTables;
	
	/**
	* @var string Optional object prefix
	* @access private
	*/
	var $objectPrefix;
	
	/**
	* @var long	Original Magic Quotes Runtime value
	* @access private
	*/
	var $mgq;
	
	/**
	* @var long	System debug
	* @access private
	*/
	var $debug;
	
	/**
	* Constructor. Initializes the xmlschema object.
	*
	* adoSchema provides methods to parse and process the XML schema file. The dbconn argument 
	* is a database connection object created by ADONewConnection. To upgrade an existing database to
	* the provided schema, set the upgradeSchema flag to TRUE. By default, adoSchema will attempt to
	* upgrade tables by ALTERing them on the fly. (NOT YET IMPLEMENTED->If your RDBMS doesn't support direct alteration
	* (e.g., PostgreSQL), setting the forceReplace flag to TRUE will replace existing tables rather than
	* altering them, copying data from each column in the old table to the like-named column in the
	* new table.)
	*
	* @param object $dbconn		ADOdb connection object
	* @param boolean $upgradeSchema	Upgrade the database (deprecated)
	* @param boolean $forceReplace	If upgrading, REPLACE tables (deprecated)
	*/
	function adoSchema( $dbconn, $upgradeSchema = FALSE, $forceReplace = FALSE ) {
		
		// Initialize the environment
		$this->mgq = get_magic_quotes_runtime();
		set_magic_quotes_runtime(0);	
		
		$this->dbconn	=  &$dbconn;
		$this->dbType = $dbconn->databaseType;
		$this->sqlArray = array();
		$this->debug = $this->dbconn->debug;
		$this->objectPrefix = '';
		
		// Create an ADOdb dictionary object
		$this->dict = NewDataDictionary( $dbconn );
	
		$GLOBALS['AXMLS_DBCONN'] = $this->dbconn;
		$GLOBALS['AXMLS_DBDICT'] = $this->dict;
		
		// If upgradeSchema is set, we will be upgrading an existing database to match
		// the provided schema. If forceReplace is set, objects are marked for replacement
		// rather than alteration. Both these options are deprecated in favor of the 
		// upgradeSchema method.
		if( $upgradeSchema == TRUE ) {
			
			if( $forceReplace == TRUE ) {
				logMsg( "upgradeSchema option deprecated. Use adoSchema->upgradeSchema('REPLACE') method instead" );
				$method = 'REPLACE';
			} else {
				logMsg( "upgradeSchema option deprecated. Use adoSchema->upgradeSchema() method instead" );
				$method = 'BEST';
			}
			$method = $this->upgradeSchema( $method );
			logMsg( "Upgrading database using '$method'" );
			
		} else {
			logMsg( "Creating new database schema" );
			unset( $this->upgradeMethod );
		}
	}
	
	/**
	* Upgrades an existing schema rather than creating a new one
	*
	* Upgrades an exsiting database to match the provided schema. The method
	* option can be set to ALTER, REPLACE, BEST, or NONE. ALTER attempts to
	* alter each database object directly, REPLACE attempts to rebuild each object
	* from scratch, BEST attempts to determine the best upgrade method for each
	* object, and NONE disables upgrading.
	*
	* @param string $method Upgrade method (ALTER|REPLACE|BEST|NONE)
	* @returns string Upgrade method used
	*/
	function upgradeSchema( $method = 'BEST' ) {
		
		// Get the metadata from existing tables, then map the names back to case-insensitive
		// names (for RDBMS' like MySQL,. that are case specific.)
		$legacyTables = $this->dict->MetaTables();

		if( is_array( $legacyTables ) and count( $legacyTables > 0 ) ) {
			foreach( $this->dict->MetaTables() as $table ) {
				$this->legacyTables[ strtoupper( $table ) ] = $table;
			}
			if(isset($this->legacyTables)) logMsg( $this->legacyTables, "Legacy Tables Map" );
		} 
		
		// Handle the upgrade methods
		switch( strtoupper( $method ) ) {
			
			case 'ALTER':
				$this->upgradeMethod = 'ALTER';
				break;
				
			case 'REPLACE':
				$this->upgradeMethod = 'REPLACE';
				break;
				
			case 'BEST':
				$this->upgradeMethod = 'ALTER';
				break;
				
			case 'NONE':
				$this->upgradeMethod = '';
				break;
				
			default:
				// Fail out if no legitimate method is passed.
				return FALSE;
		}
		return $method;
	}
		
	/**
	* Loads a schema and converts it to SQL.
	*
	* Loads the specified schema (see the DTD for the proper format) and generates
	* the SQL necessary to create the database described by the schema. The SQL may
	* be accessed directly by examining the adoSchema::sqlArray property.
	*
	* @param string $file		XML file
	* @return array	Array of SQL queries, ready to execute
	*/
	function ParseSchema( $file ) {
		
		// Create the parser
		$this->xmlParser = &$xmlParser;
		$xmlParser = xml_parser_create();
		xml_set_object( $xmlParser, $this );
		
		// Initialize the XML callback functions
		xml_set_element_handler( $xmlParser, "_xmlcb_startElement", "_xmlcb_endElement" );
		xml_set_character_data_handler( $xmlParser, "_xmlcb_cData" );
		
		// Open the file
		if( !( $fp = fopen( $file, "r" ) ) ) {
			die( "Unable to open file" );
		}
		
		// Process the file
		while( $data = fread( $fp, 4096 ) ) {
			if( !xml_parse( $xmlParser, $data, feof( $fp ) ) ) {
				die( sprintf( "XML error: %s at line %d",
					xml_error_string( xml_get_error_code( $xmlParser ) ),
					xml_get_current_line_number( $xmlParser ) ) );
			}
		}
		
		return $this->sqlArray;
	}
	
	/**
	* Applies the current schema to a database.
	*
	* Applies the current schema (generally created by calling adoSchema::ParseSchema)
	* to a database, creating the tables, indexes, and executing other SQL specified in the
	* schema.
	*
	* @param array $sqlArray	Array of SQL statements that will be applied rather than
	*		the current schema.
	* @param boolean $continueOnErr	Continue to apply the schema even if an error occurs.
	* @returns integer	0 if failure, 1 if errors, 2 if successful.
	*/
	function ExecuteSchema( $sqlArray = NULL, $continueOnErr =  TRUE ) {
		
		if( !isset( $sqlArray ) ) {
			$sqlArray = $this->sqlArray;
		}
		if( !isset( $sqlArray ) ) {
			return 0;
		}
		
		$err = $this->dict->ExecuteSQLArray( $sqlArray, $continueOnErr );
		
		return $err;
	}
	
	/**
	* Prints the schema SQL array
	*
	* Returns and/or displays the SQL array contained in the adoSchema::sqlArray property.
	*
	* @param array $sqlArray	Array of SQL statements that will be applied rather than
	*		the current schema.
	* @param boolean $format	Format: HTML, TEXT, or NONE
	* @return array Array of SQL statements or FALSE if an error occurs
	*/
	function PrintSchema( $sqlArray = NULL, $format = 'TEXT' ) {
		
		if( !isset( $sqlArray ) ) {
			$sqlArray = $this->sqlArray;
		}
		if( !isset( $sqlArray ) ) {
			return FALSE;
		}
		
		// Print the SQL array
		switch( strtoupper( $format ) ) {
			
			case "HTML":
			
				print "<PRE>";
				print_r( $sqlArray );
				print "</PRE>";
				
				break;
			
			case "TEXT":
			
				foreach( $sqlArray as $query ) {
					print "$query\n";
				}
				
				break;
			
			default:
				
				break;
		}
		
		return $sqlArray;
	}
	
	/**
	* Saves the schema SQL array
	*
	* Saves the SQL array to the local filesystem as a list of SQL queries.
	*
	* @param string $filename  Path and name where the file should be saved.
	* @param array $sqlArray	Array of SQL statements that will be applied rather than
	*		the current schema.
	* @return boolean TRUE is save is successful, else FALSE. 
	*/
	function SaveSchema( $filename = './mindmeld.sql', $sqlArray = NULL ) {
		
		if( !isset( $sqlArray ) ) {
			$sqlArray = $this->sqlArray;
		}
		if( !isset( $sqlArray ) ) {
			return FALSE;
		}
		
		$header = "# Mindmeld schema\n\n";
		$footer = "# --------------------------------------------------------\n\n";
		$close = "# End of Mindmeld schema\n\n";
		
		$fp = fopen( $filename, "w" );
		
		fwrite( $fp, $header );
		foreach( $sqlArray as $key => $query ) {
			fwrite( $fp, $query . ";\n" );
			fwrite( $fp, $footer );
		}
		fwrite( $fp, $close );
		fclose( $fp );
	}
	
	/**
	* XML Callback to process start elements
	*
	* Processes XML opening tags. 
	* Elements currently processed are: TABLE, INDEX, SQL. 
	* For tables: FIELD. KEY, NOTNULL, AUTOINCREMENT, DEFAULT, OPT. 
	* For indexes: CLUSTERED, BITMAP, UNIQUE, FULLTEXT, HASH. 
	* For SQL querysets: QUERY. 
	*
	* @access private
	*/
	function _xmlcb_startElement( $parser, $name, $attrs ) {
		
		isset( $this->upgradeMethod ) ? ( $upgradeMethod = $this->upgradeMethod ) : ( $upgradeMethod = '' );
		
		// Initialize some local variables from the object properties.
		$dbType = $this->dbType;
		if( isset( $this->table ) ) $table = &$this->table;
		if( isset( $this->index ) ) $index = &$this->index;
		if( isset( $this->querySet ) ) $querySet = &$this->querySet;
		
		// Set the name of the current open tag.
		$this->currentElement = $name;
		
		// Process the new open tag
		switch( $name ) {
			
			
			case "CLUSTERED":
			
				// Add index Option to open index object
				if( isset( $this->index ) ) $this->index->addIndexOpt( $name );
				
				break;
				
			case "BITMAP":
			
				// Add index Option to open index object
				if( isset( $this->index ) ) $this->index->addIndexOpt( $name );
				
				break;
				
			case "UNIQUE":
			
				// Add index Option to open index object
				if( isset( $this->index ) ) $this->index->addIndexOpt( $name );
				
				break;
				
			case "FULLTEXT":
			
				// Add index Option to open index object
				if( isset( $this->index ) ) $this->index->addIndexOpt( $name );
				
				break;
				
			case "HASH":
			
				// Add index Option to open index object
				if( isset( $this->index ) ) $this->index->addIndexOpt( $name );
				
				break;

			case "TABLE":
			
				if( !isset( $attrs['PLATFORM'] ) or $this->supportedPlatform( $attrs['PLATFORM'] ) ) {
					
					// Create a new table object
					$this->table = new dbTable( $attrs['NAME'], $upgradeMethod, $this->objectPrefix );
					
				} else {
					unset( $this->table );
				}
				
				break;
				
			case "FIELD":	

				if( isset( $this->table ) ) {
					
					// Add a field to an existing table object
					$fieldName = $attrs['NAME'];
					$fieldType = $attrs['TYPE'];
					isset( $attrs['SIZE'] ) ? ( $fieldSize = $attrs['SIZE'] ) : ( $fieldSize = NULL );
					isset( $attrs['OPTS'] ) ? ( $fieldOpts = $attrs['OPTS'] ) : ( $fieldOpts = NULL );
					
					$this->table->addField( $fieldName, $fieldType, $fieldSize, $fieldOpts );
				}
				
				break;
				
			case "KEY":	

				// Add a field option to the table object
				if( isset( $this->table ) ) {
					$this->table->addFieldOpt( $this->table->currentField, 'KEY' );
				}
				
				break;
				
			case "NOTNULL":
			
				// Add a field option to the table object
				if( isset( $this->table ) ) {
					$this->table->addFieldOpt( $this->table->currentField, 'NOTNULL' );
				}
				
				break;
				
			case "AUTOINCREMENT":
			
				// Add a field option to the table object
				if( isset( $this->table ) ) {
					$this->table->addFieldOpt( $this->table->currentField, 'AUTOINCREMENT' );
				}
				
				break;
				
			case "DEFAULT":

				// Add a field option to the table object
				if( isset( $this->table ) ) {
					
					// Work around ADOdb datadict issue that misinterprets empty strings.
					if( $attrs['VALUE'] == '' ) $attrs['VALUE'] = " '' ";
					
					$this->table->addFieldOpt( $this->table->currentField, 'DEFAULT', $attrs['VALUE'] );
				}
				
				break;
				
			case "INDEX":
			
				// Create a new index object
				if( !isset( $attrs['PLATFORM'] ) or $this->supportedPlatform( $attrs['PLATFORM'] ) ) {
					$this->index = new dbIndex( $attrs['NAME'], $attrs['TABLE'], $upgradeMethod, $this->dict, $this->objectPrefix );
				} else {
					if( isset( $this->index ) ) unset( $this->index );
				}
				break;
				
			case "SQL":	

				// Create a new freeform SQL query set
				if( !isset( $attrs['PLATFORM'] ) or $this->supportedPlatform( $attrs['PLATFORM'] ) ) {
					
					isset( $attrs['KEY'] ) ? ( $key = $attrs['KEY'] ) : ( $key = NULL );
					isset( $attrs['PREFIXMETHOD'] ) ? ( $pmeth = $attrs['PREFIXMETHOD'] ) : ( $pmeth = NULL );
					$this->querySet = new dbQuerySet( $this->objectPrefix, $key, $pmeth );
					
				} else {
					if( isset( $this->querySet ) ) unset( $this->querySet );
				}
				
				break;
				
			case "QUERY":	

				// Create a new query in a SQL queryset.
				if( isset( $this->querySet ) ) {
					
					// Ignore this query set if a platform is specified and it's different than the 
					// current connection platform.
					if( !isset( $attrs['PLATFORM'] ) or $this->supportedPlatform( $attrs['PLATFORM'] ) ) {
						
						$this->querySet->buildQuery();
						
					} else {
						if( isset( $this->querySet->query ) ) unset( $this->querySet->query );
					}
				}
				
				break;
		}	
	}

	/**
	* XML Callback to process cDATA elements
	*
	* Processes XML cdata.
	* Elements currently processed are:
	* For tables: CONSTRAINT, OPT. 
	* For indexes: COL. 
	* For SQL querysets: QUERY. 
	*
	* @access private
	*/
	function _xmlcb_cData( $parser, $data ) {
		
		$element = &$this->currentElement;
		
		if( trim( $data ) == "" ) return;
		
		// Process the data depending on the element
		switch( $element ) {
		
			case "COL":	
			
				// Index field name
				if( isset( $this->index ) ) $this->index->addField( $data );
				
				break;
			
			case "QUERY":	
			
				// Line of queryset SQL data
				if( isset( $this->querySet ) and isset( $this->querySet->query ) ) $this->querySet->buildQuery( $data );
				
				break;
			
			case "CONSTRAINT":
			
				// Table constraint
				if( isset( $this->table ) ) $this->table->addTableOpt( $data );
				
				break;
				
			case "OPT":
			
				// Table option
				if( isset( $this->table ) ) $this->table->addTableOpt( $data );
				
				break;
		}
	}

	/**
	* XML Callback to process end elements
	*
	* Processes XML closing tags.
	* Elements currently processed are: TABLE, INDEX, SQL. 
	* For tables: DROP. 
	* For indexes: DROP 
	* For SQL querysets: QUERY.
	*
	* @access private
	*/
	function _xmlcb_endElement( $parser, $name ) {
		
		// Process the XML tag.
		switch( trim( $name ) ) {
			
			case "TABLE":
			
				// Finish the creation process. 
				if( isset( $this->table ) ) {
					// Generate the table SQL from the table object.
					$tableSQL = $this->table->create( $this->dict );
					
					// Handle case changes in MySQL
					// Get the metadata from the database, convert old and new table names to the
					// same case and compare. If they're the same, pop a RENAME onto the query stack.
 					$tableName = $this->table->tableName;
					if( $this->dict->upperName == 'MYSQL' 
						and is_array( $this->legacyTables )
						and array_key_exists( strtoupper( $tableName ), $this->legacyTables )
						and $oldTableName = $this->legacyTables[ strtoupper( $tableName ) ] ) {
						if( $oldTableName != $tableName ) {
    						logMsg( "RENAMING table $oldTableName to $tableName" );
    						array_push( $this->sqlArray, "RENAME TABLE $oldTableName TO $tableName" );
						}
					}
					
					// Add completed table SQL to the SQL array.
					foreach( $tableSQL as $query ) {
						array_push( $this->sqlArray, $query );
					}
					
					// Destroy the current table object now that we're finished with it.
					$this->table->destroy();
				}
				
				break;
				
			case "DROP":	
				
				// Drop the current open object (table/field or index)

				if( isset( $this->table ) ) {
					// Drop a table or field
					$dropSQL = $this->table->drop( $this->dict );					
				} 
				if( isset( $this->index ) ) {
					// Drop an index
					$dropSQL = $this->index->drop();
				}
				
				break;
				
			case "INDEX":	

				// Finish the index creation process
				if( isset( $this->index ) ) {
					// Create the index SQL from the index object
					$indexSQL = $this->index->create( $this->dict );
					
					// Add the index SQL to the SQL array
					foreach( $indexSQL as $query ) {
						array_push( $this->sqlArray, $query );
					}
					
					// Destroy the current index object now that we're finished with it.
					$this->index->destroy();
				}
				
				break;
			
			case "QUERY":	

				// Add the finished query to the open query set.
				if( isset( $this->querySet ) and isset( $this->querySet->query ) ) {
					 $this->querySet->addQuery();
				}
				
				break;
			
			case "SQL":	
		
				// Finish the query set creation process
				if( isset( $this->querySet ) ) {
					// Create the query set from the querySet object
					$querySQL = $this->querySet->create();
					
					// Add the query set to the SQL array
					$this->sqlArray = array_merge( $this->sqlArray, $querySQL );
					
					// Destroy the current query set object now that we're finished with it.
					$this->querySet->destroy();
				}
				
				break;
		}
	}
	
	/**
    * Sets table and index prefix
    *
    * Sets a standard prefix that will be prepended to all database tables when the schema
	* is parsed. Note that a single underscore will be automatically appended to the prefix. 
	* Example: setting the prefix to "mm" will result in all tables and indexes being prepended
	* with "mm_". Calling setPrefix with no arguments clears the prefix.
    *
    * @param string $prefix Prefix
    * @return boolean       TRUE if successful, else FALSE
    */
    function setPrefix( $prefix = '' ) {

            if( !preg_match( '/[^\w]/', $prefix ) and strlen( $prefix < XMLS_PREFIX_MAXLEN ) ) {
                $this->objectPrefix = $prefix;
                logMsg( "Prepended prefix: $prefix" );
                return TRUE;
            } else {
            	logMsg( "No prefix" );
                return FALSE;
            }
    }
	
	
	/**
	* Checks if element references a specific platform
	*
	* Returns TRUE is no platform is specified or if we are currently
	* using the specified platform.
	*
	* @param string	$platform	Requested platform
	* @returns boolean	TRUE if platform check succeeds
	*
	* @access private
	*/
	function supportedPlatform( $platform = NULL ) {
		
		$dbType = $this->dbType;
		$regex = "/^(\w*\|)*" . $dbType . "(\|\w*)*$/";
		
		if( !isset( $platform ) or preg_match( $regex, $platform ) ) {
			logMsg( "Platform $platform is supported" );
			return TRUE;
		} else {
			logMsg( "Platform $platform is NOT supported" );
			return FALSE;
		}
	}
	
	/**
	* Destructor: Destroys an adoSchema object. 
	*
	* You should call this to clean up when you're finished with adoSchema.
	*/
	function Destroy() {
		xml_parser_free( $this->xmlParser );
		set_magic_quotes_runtime( $this->mgq );
		unset( $this );
	}
}

/**
* Message loggging function
*/
function logMsg( $msg, $title = NULL ) {
	if( XMLS_DEBUG ) {
		print "<PRE>";
		if( isset( $title ) ) {
			print "<H3>$title</H3>";
		}
		if( isset( $this ) ) {
			print "[" . get_class( $this ) . "] ";
		}
		if( is_array( $msg ) or is_object( $msg ) ) {
			print_r( $msg );
			print "<BR/>";
		} else {
			print "$msg<BR/>";
		}
		print "</PRE>";
	}
}
?>