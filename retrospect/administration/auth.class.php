<?php
/**
 * Authorization Class
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
<?php

class Auth {
	
	function Check() {
		global $_GET;
		if (isset($_GET['auth']) and $_GET['auth'] == 'logout') { 
			Auth::Logout(); 
			return false;
		}
		else { 
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
		
		$md5pwd = md5($pwd);
		$sql = "SELECT * FROM ".TBL_USER." WHERE uid='{$uid}' AND pwd='{$md5pwd}'";
		$rs = $db->Execute($sql);
		if ($rs->RecordCount() == 0) {
			unset($_SESSION['uid']);
			unset($_SESSION['pwd']);
			return false;
		} else {
			$row = $rs->FetchRow();
			$s_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
			$s_pwd = isset($_SESSION['pwd']) ? $_SESSION['pwd'] : null;
			if ($s_uid != $uid and $s_pwd != $pwd) {
				$_SESSION['uid'] = $uid;
				$_SESSION['pwd'] = $pwd;
				$sql = "UPDATE ".TBL_USER." SET last=".$db->DBTimestamp(time())." WHERE uid='{$uid}'";
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
	
	function AddUser($p_uid, $p_fullname, $p_email, $p_pwd, $enabled) {
		global $db;
		$c_uid = $db->Qstr($p_uid);
		$c_fullname = $db->Qstr($p_fullname);
		$c_email = $db->Qstr($p_email);
		$c_pwd = $db->Qstr(md5($p_pwd));
		$c_enabled = $db->Qstr($enabled);
		$time = $db->DBTimestamp(time());
		$sql = "INSERT INTO ".TBL_USER." VALUES('',{$c_uid},{$c_pwd},{$c_fullname},{$c_email},{$time},NULL,'0',{$c_enabled})";
		if ($db->Execute($sql) !== false) { return true; }
		else { return false; }
	}
	
	function UpdateUser($p_id, $p_uid, $p_fullname, $p_email, $p_pwd, $enabled) {
		global $db, $smarty;
		$c_id = $p_id;
		$c_uid = $db->Qstr($p_uid);
		$c_fullname = $db->Qstr($p_fullname);
		$c_email = $db->Qstr($p_email);
		$c_enabled = $db->Qstr($enabled);
		if (!$p_pwd) { 
			$sql = "UPDATE ".TBL_USER." SET uid={$c_uid}, fullname={$c_fullname}, email={$c_email}, enabled={$c_enabled} WHERE id='{$c_id}'";
		} else {
			$c_pwd = $db->Qstr(md5($p_pwd));
			$sql = "UPDATE ".TBL_USER." SET uid={$c_uid}, fullname={$c_fullname}, email={$c_email}, pwd={$c_pwd}, pwd_expired='0', enabled={$c_enabled} WHERE id='{$c_id}'";
		}
		return ($db->Execute($sql) !== false) ? true : false;
	}
	
	function UserExists($p_uid) {
		$sql = "SELECT * FROM ".TBL_USER." WHERE uid='{$p_uid}'";
		$rs = $GLOBALS['db']->Execute($sql);
		return ($rs->RecordCount() > 0) ? true : false;
	}
	
	function UserIdExists($p_id) {
		$sql = "SELECT * FROM ".TBL_USER." WHERE id='{$p_id}'";
		$rs = $GLOBALS['db']->Execute($sql);
		return ($rs->RecordCount() > 0) ? true : false;
	}
	
	function PasswordExpired($p_uid) {
		$sql = "SELECT * FROM ".TBL_USER." WHERE uid='{$p_uid}'";
		$rs = $GLOBALS['db']->Execute($sql);
		if ($row = $rs->FetchRow()) {
			if ($row['pwd_expired'] == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function ToggleEnabled($p_id) {
		global $db, $smarty;
		$sql = "SELECT * FROM ".TBL_USER." WHERE id='{$p_id}'";
		$row = $db->GetRow($sql);
		$enabled = $row['enabled'] === '1' ? '0' : '1';
		$sql = "UPDATE ".TBL_USER." SET enabled='{$enabled}' WHERE id='{$p_id}'";
		$smarty->assign('enabled', $enabled);
		if ($db->Execute($sql)) return true;
		else return false;
	}
}
?>