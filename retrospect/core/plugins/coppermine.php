<?php
 /* This is an experimental plugin for linking photos to individuals using 
	* a Coppermine photo gallery.  This plugin has been tested to work with
	* Coppermine 1.3.2.  
	* See http://coppermine.sourceforge.net for information about Coppermine
	* 
	* @copyright 2005 Keith Morrison
	* 
	* INSTALLATION
	* ------------
	* 
	* First, your server needs to have access to the MySQL database where your 
	* Coppermine gallery is hosted. Modify the connection variables below and 
	* then turn on the Coppermine gallery plugin from the Retrospect-GDS 
	* Global Configuration page.
	* 
	* Next, for each photo you want to associate with an individual, you need to
	* add the individuals id number to the photo's keyword field.  You can associate
	* a photo with more than one individual by adding multiple id's to the keyword field
	* separated by spaces.
	*/
	
	class GalleryPlugin {
		
		# Customize these variables...
		var $db_type = 'mysql';                                       # database type
		var $db_host = 'localhost';                                   # database host - usually localhost
		var $db_port = '';                                            # database port - you should leave this blank
		var $db_name = 'retrospect';                                  # database name
		var $db_user = 'root';                                        # database user
		var $db_pass = '';                                            # database password
		var $cpg_pictures_tbl = 'cpg132_pictures';                    # name of the coppermine pictures table
		var $cpg_search_url = 'http://retrospect/cpg/thumbnails.php'; # url of the coppermine thumbnails.php
		
		# Don't touch these...
		var $name = 'Coppermine Plugin';
		var $db;
		
		function GalleryPlugin() {
			$this->db =& AdoNewConnection($this->db_type);
			$host = ($this->db_port != '') ? $this->db_host.':'.$this->db_port : $this->db_host;
			$this->db->Connect($host, $this->db_user, $this->db_pass, $this->db_name);
		}
		
		function media_count($id) {
			$sql = 'SELECT COUNT(*) FROM '.$this->cpg_pictures_tbl;
			$sql .= ' WHERE keywords regexp "(^|[:blank:])'.$id.'($|[:blank:])"';
			return $this->db->GetOne($sql);
		}
		
		function media_link($id) {
			return $this->cpg_search_url.'?album=search&type=full&search='.$id;
		}
		
	}
	
?>