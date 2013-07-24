<?PHP 
require_once("../includes/config/dbconfig.php");
require_once("../includes/connection.php");

		$Settings	= New Settings();
		$dbsuffix 	= $Settings->dbsuffix;
		$db = new MySQL();
		$users = '';
		$email = $_POST['u'];
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) { 
			if($db->HasRecords("SELECT username,".$dbsuffix."_users.personid,userid,firstname,lastname,1 as email FROM (".$dbsuffix."_emailaccounts INNER JOIN ".$dbsuffix."_persons on ".$dbsuffix."_emailaccounts.personid=".$dbsuffix."_persons.personid) INNER JOIN ".$dbsuffix."_users on ".$dbsuffix."_emailaccounts.personid=".$dbsuffix."_users.personid WHERE emailadd='".$_POST['u']."' and userid is not null")){
				$users=$db->Row();
				define('INSTALL_PATH',"../mail/");
				require_once '../mail/program/include/iniset.php';
				$RCMAIL = rcmail::get_instance();
				$username =  $_POST['u'];
				$password = $_POST['p'];
				$domain = 	"www.".get_domain($username);
				if(!$RCMAIL->login($username, $password, $domain, true)) die (0);
				echo $db->GetJSON();
			} else {
				die(0);
					
			}
		} 
		else { 
			if($db->HasRecords("SELECT username,".$dbsuffix."_users.personid,userid,firstname,lastname, 0 as email FROM ".$dbsuffix."_users INNER JOIN ".$dbsuffix."_persons on ".$dbsuffix."_users.personid=".$dbsuffix."_persons.personid WHERE username='".$_POST['u']."' and password='".md5($_POST['p'])."'")){
				$users=$db->Row();
				echo $db->GetJSON();
			} else {
				die(0);
			}
		}

		InsertLog("Logged in AMS",$users->userid);
		function get_domain($email)
		{
			$domain = implode('.',
				array_slice( preg_split("/(\.|@)/", $email), -2)
			);
			return strtolower($domain);
		}
		
		function InsertLog($activity="",$userid=""){
				$Settings	= New Settings();
				$dbsuffix 	= $Settings->dbsuffix;
				$db = new MySQL(); 
				$values["description"] = MySQL::SQLValue($activity);
				$values["userid"] = MySQL::SQLValue($userid, MySQL::SQLVALUE_NUMBER);
				$values["userip"]=	MySQL::SQLValue(get_client_ip());
				if(!$db->Query(MySQL::BuildSQLInsert($dbsuffix."_loginsessions", $values)))
					return false;
				if(strpos($activity,"Logged in")  !== FALSE)
				{
					date_default_timezone_set('UTC');
					$users['last_known_ip']= MySQL::SQLValue(get_client_ip());
					$users['last_login'] = MySQL::SQLValue(date('Y-m-d h:i:s'));
					$filter['userid']= MySQL::SQLValue($userid, MySQL::SQLVALUE_NUMBER);
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
	
?>