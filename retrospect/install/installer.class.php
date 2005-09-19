<?php

class Installer {

	var $inivars;
	var $extensions;
	var $phpversion;

	function Installer() {
		$this->inivars = ini_get_all();
		$this->extensions = get_loaded_extensions();
		$this->phpversion = phpversion();
	}
	
	function PHPVersion() {
		return $this->phpversion;
	}
	
	function ini_SafeMode() {
		return $this->inivars['safe_mode']['local_value'];
	}

	function ini_RegisterGlobals() {
		return $this->inivars['register_globals']['local_value'];
	}

	function ini_FileUploads() {
		return $this->inivars['file_uploads']['local_value'];
	}

	function ini_MagicQuotes() {	
		return $this->inivars['magic_quotes']['local_value'];
	}
	
	function ext_Gettext() {
		return in_array('gettext', $this->extensions);
	}
	
	function make_writable($filespec) {
		if (is_writable($filespec)) return true;
		else return @chmod($filespec, 0644);
	}
	
}
?>