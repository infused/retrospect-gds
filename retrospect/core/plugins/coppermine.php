<?php
 /* This is an experimental plugin for linking Coppermine photos to individuals.
	* See http://coppermine.sourceforge.net for information about Coppermine
	* @copyright 2005 Keith Morrison
	*/
	
	class GalleryPlugin {
		
		# Customize these variables...
		var $db_type = 'mysql';
		var $db_host = 'localhost';
		var $db_port = '';
		var $db_name = 'retrospect';
		var $db_user = 'root';
		var $db_pass = '';
		var $cpg_pictures_tbl = 'cpg132_pictures';
		var $cpg_search_url = 'http://retrospect/cpg/thumbnails.php';
		
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
			$sql .= ' WHERE keywords like "%'.$id.'%"';
			return $this->db->GetOne($sql);
		}
		
		function media_link($id) {
			return $this->cpg_search_url.'?album=search&type=full&search='.$id;
		}
		
	}
	
?>