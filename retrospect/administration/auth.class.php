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
		global $db, $g_tbl_user;
		if (isset($_POST['uid'])) {
			$uid = substr($_POST['uid'], 0, 16);
		}
		elseif (isset($_SESSION['uid'])) {
			$uid = substr($_SESSION['uid'], 0, 16);
		}
		else {
			$uid = null;
		}
		if (isset($_POST['pwd'])) {
			$pwd = substr($_POST['pwd'], 0, 16);
		}
		elseif (isset($_SESSION['pwd'])) {
			$pwd = substr($_SESSION['pwd'], 0, 16);
		}
		else {
			$pwd = null;
		}
		
		$md5pwd = md5($pwd);
		$sql = "SELECT * FROM {$g_tbl_user} WHERE uid='{$uid}' AND pwd='{$md5pwd}'";
		$rs = $db->Execute($sql);
		if ($rs->RecordCount() == 0) {
			unset($_SESSION['uid']);
			unset($_SESSION['pwd']);
			return false;
		}
		else {
			$row = $rs->FetchRow();
			$s_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
			$s_pwd = isset($_SESSION['pwd']) ? $_SESSION['pwd'] : null;
			if ($s_uid != $uid and $s_pwd != $pwd) {
				$_SESSION['uid'] = $uid;
				$_SESSION['pwd'] = $pwd;
				$sql = "UPDATE {$g_tbl_user} SET last=".$db->DBTimestamp(time())." WHERE uid='{$uid}'";
				$db->Execute($sql);
			}
			return true;
		}
	}
	
	function Logout() {
		unset($_SESSION['uid']);
		unset($_SESSION['pwd']);
		return session_destroy();
	}
	
	function AddUser($p_uid, $p_fullname, $p_email, $p_pwd) {
		global $db, $g_tbl_user;
		$c_uid = $db->Qstr($p_uid);
		$c_fullname = $db->Qstr($p_fullname);
		$c_email = $db->Qstr($p_email);
		$c_pwd = $db->Qstr(md5($p_pwd));
		$sql = "INSERT INTO {$g_tbl_user} VALUES('', {$c_uid}, {$c_pwd}, {$c_fullname}, {$c_email},'')";
		if ($db->Execute($sql) !== false) { return true; }
		else { return false; }
	}
	
	function UpdateUser($p_id, $p_uid, $p_fullname, $p_email, $p_pwd) {
		global $db, $g_tbl_user;
		$c_id = (int) $p_id;
		$c_uid = $db->Qstr($p_uid);
		$c_fullname = $db->Qstr($p_fullname);
		$c_email = $db->Qstr($p_email);
		$c_pwd = $db->Qstr(md5($p_pwd));
		if (!$p_pwd) { 
			$sql = "UPDATE {$g_tbl_user} SET uid={$c_uid}, fullname={$c_fullname}, email={$c_email} WHERE id='{$c_id}'";
		}
		else {
			$sql = "UPDATE {$g_tbl_user} SET uid={$c_uid}, fullname={$c_fullname}, email={$c_email}, pwd={$c_pwd} WHERE id='{$c_id}'";
		}
		if ($db->Execute($sql) !== false) { return true; }
		else { return false; }
	}
	
	function UserExists($p_uid) {
		global $db, $g_tbl_user;
		$sql = "SELECT * FROM {$g_tbl_user} WHERE uid='{$p_uid}'";
		$rs = $db->Execute($sql);
		if ($rs->RecordCount() > 0) { return true; }
		else { return false; }
	}
}
?>