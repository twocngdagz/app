<?php 
require_once("../includes/config/dbconfig.php");
require_once("../includes/connection.php");
class Logs{ 
	function InsertLog($activity="",$userid="",$rsakey="",$status=1){
		$Settings	= New Settings();
		$dbsuffix 	= $Settings->dbsuffix;
		$db = new MySQL(); 
		$values["description"] = MySQL::SQLValue($activity);
		if(strpos($activity,"Logged in")  !== FALSE)
	    	$values["userid"] = MySQL::SQLValue($userid, MySQL::SQLVALUE_NUMBER);
		else
			$values["userid"]= MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]), MySQL::SQLVALUE_NUMBER);
			
		$values["userip"]=	MySQL::SQLValue($this->get_client_ip());
		if(!$db->Query(MySQL::BuildSQLInsert($dbsuffix."_loginsessions", $values)))
			return false;
		$expire=time()+60*60*60;
		setcookie("__amstoken", $db->GetLastInsertID(),$expire,"/");
		if(strpos($activity,"Logged in")  !== FALSE)
		{
			date_default_timezone_set('UTC');
		$users['rsakey']= MySQL::SQLValue($rsakey);
		$users['last_known_ip']= MySQL::SQLValue($this->get_client_ip());
		$users['last_login'] = MySQL::SQLValue(date('Y-m-d h:i:s'));
		$filter['userid']= MySQL::SQLValue($userid, MySQL::SQLVALUE_NUMBER);
		if(!$db->Query(MySQL::BuildSQLUpdate($dbsuffix."_users",$users,$filter)))
			return false;
		} else {
			$users['status'] = MySQL::SQLValue(9);
			$users['statusupdate'] = MySQL::SQLValue(date('Y-m-d h:i:s'));
			$filter['userid']= MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]), MySQL::SQLVALUE_NUMBER);
			if(!$db->Query(MySQL::BuildSQLUpdate($dbsuffix."_users",$users,$filter)))
			return false;
		}
		
	}
	function get_client_ip() {
		
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
}
?>
