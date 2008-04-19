<?php
/**
 * Authorization Class
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2006
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
 */
 
 /**
 * $Id$
 */  

	# Ensure this file is being included by a parent file
	defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );

class Auth {
	
	function Check() {
		if (isset($_GET['auth']) and $_GET['auth'] == 'logout') { 
			Auth::Logout(); 
			return false;
		} else { 
			return Auth::Login(); 
		}
	}
	
	function Login() {
		global $db;
		if (isset($_POST['uid'])) {
			$uid = substr($_POST['uid'], 0, 16);
		} elseif (isset($_SESSION['uid'])) {
			$uid = substr($_SESSION['uid'], 0, 16);
		} else {
			$uid = null;
		}
		if (isset($_POST['pwd'])) {
			$pwd = substr($_POST['pwd'], 0, 16);
		} elseif (isset($_SESSION['pwd'])) {
			$pwd = substr($_SESSION['pwd'], 0, 16);
		} else {
			$pwd = null;
		}
		
		$sql = 'SELECT * FROM '.TBL_USER.' WHERE uid='.$db->qstr($uid).' AND pwd='.$db->qstr(md5($pwd));
		$rs = $db->Execute($sql);
		if ($rs->RecordCount() == 0) {
			unset($_SESSION['uid']);
			unset($_SESSION['pwd']);
			return false;
		} else {
			$row = $rs->FetchRow();
			if ($row['enabled'] == '0') return false;
			$s_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
			$s_pwd = isset($_SESSION['pwd']) ? $_SESSION['pwd'] : null;
			if ($s_uid != $uid and $s_pwd != $pwd) {
				$_SESSION['uid'] = $uid;
				$_SESSION['pwd'] = $pwd;
				$sql = 'UPDATE '.TBL_USER.' SET last='.$db->DBTimestamp(time()).' WHERE uid='.$db->qstr($uid);
				$db->Execute($sql);
			}
			return true;
		}
	}
	
	function Logout() {
		$_SESSION = array();
		unset($_COOKIE[session_name()]);
		@session_destroy();
	}
	
	function AddUser($fields) {
		global $db;
		$fields['created'] = time();
		$sql = 'SELECT * FROM '.TBL_USER.' WHERE id='.$db->qstr('-1');
		$rs = $db->Execute($sql);
		$sql = $db->GetInsertSQL($rs, $fields);
		if ($db->Execute($sql) !== false) { return true; }
		else { return false; }
	}
	
	function UpdateUser($id, $fields) {
		global $db;
		$rs = $db->Execute('SELECT * FROM '.TBL_USER.' WHERE id='.$db->qstr($id));
		$sql = $db->GetUpdateSQL($rs, $fields);
		$db->Execute($sql);
	}
	
	function UserExists($uid) {
		global $db;
		$rs = $db->Execute('SELECT * FROM '.TBL_USER.' WHERE uid='.$db->qstr($uid));
		return ($rs->RecordCount() > 0) ? true : false;
	}
	
	function UserIdExists($id) {
		global $db;
		$sql = 'SELECT * FROM '.TBL_USER.' WHERE id='.$db->qstr($id);
		$rs = $db->Execute($sql);
		return ($rs->RecordCount() > 0) ? true : false;
	}
	
	function PasswordExpired($uid) {
		global $db;
		$sql = 'SELECT pwd_expired FROM '.TBL_USER.' WHERE uid='.$db->qstr($uid);
		$rs = $db->GetOne($sql);
		return ($db->GetOne($sql) == 1) ? true : false;
	}
	
	function ToggleEnabled($id) {
		global $db;
		$rs = $db->Execute('SELECT * FROM '.TBL_USER.' WHERE id='.$db->qstr($id));
		$fields['enabled'] = $rs->fields['enabled'] === '1' ? '0' : '1';
		$sql = $db->GetUpdateSQL($rs, $fields);
		return ($db->Execute($sql)) ? true : false;
	}
	
	function Enable($id) {
		global $db;
		$enabled = '1';
		$sql = 'UPDATE '.TBL_USER.' SET enabled='.$db->Qstr($enabled).' WHERE id='.$db->qstr($id);
		return ($db->Execute($sql)) ? true : false;
	}
	
	function Disable($id) {
		global $db;
		$enabled = '0';
		$sql = 'UPDATE '.TBL_USER.' SET enabled='.$db->Qstr($enabled).' WHERE id='.$db->qstr($id);
		return ($db->Execute($sql)) ? true : false;
	}

}
?>