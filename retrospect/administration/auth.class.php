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
		global $g_tbl_user;
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
		
		$query = "SELECT * FROM $g_tbl_user WHERE uid='$uid' AND pwd=MD5('$pwd')";
		$result = db_query_r($query);
		if (mysql_num_rows($result) == 0) {
			unset($_SESSION['uid']);
			unset($_SESSION['pwd']);
			return false;
		}
		else {
			$row = mysql_fetch_array($result);
			$s_uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : null;
			$s_pwd = isset($_SESSION['pwd']) ? $_SESSION['pwd'] : null;
			if ($s_uid != $uid and $s_pwd != $pwd) {
				$_SESSION['uid'] = $uid;
				$_SESSION['pwd'] = $pwd;
				$sql = "UPDATE $g_tbl_user SET last=NOW() WHERE uid='$uid'";
				db_query_N($sql);
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
		global $g_tbl_user;
		$c_uid = mysql_real_escape_string($p_uid);
		$c_fullname = mysql_real_escape_string($p_fullname);
		$c_email = mysql_real_escape_string($p_email);
		$c_pwd = mysql_real_escape_string($p_pwd);
		$sql = "INSERT INTO $g_tbl_user VALUES('', '$c_uid', MD5('$c_pwd'), '$c_fullname', '$c_email','')";
		if (db_query_a($sql) == 1) { return true; }
		else { return false; }
	}
	
	function UpdateUser($p_id, $p_uid, $p_fullname, $p_email, $p_pwd) {
		global $g_tbl_user;
		$c_id = (int) $p_id;
		$c_uid = mysql_real_escape_string($p_uid);
		$c_fullname = mysql_real_escape_string($p_fullname);
		$c_email = mysql_real_escape_string($p_email);
		$c_pwd = mysql_real_escape_string($p_pwd);
		if (!$p_pwd) { 
			$sql = "UPDATE $g_tbl_user SET uid='$c_uid', fullname='$c_fullname', email='$c_email' WHERE id='$c_id'";
		}
		else {
			$sql = "UPDATE $g_tbl_user SET uid='$c_uid', fullname='$c_fullname', email='$c_email', pwd=MD5('$c_pwd') WHERE id='$c_id'";
		}
		if (db_query_a($sql) == 1) { return true; }
		else { return false; }
	}
	
	function UserExists($p_uid) {
		global $g_tbl_user;
		$sql = "SELECT * FROM $g_tbl_user WHERE uid='$p_uid'";
		if (db_query_a($sql) > 0) { return true; }
		else { return false; }
	}
}
?>