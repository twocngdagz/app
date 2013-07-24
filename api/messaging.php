<?PHP 
	ob_start("ob_gzhandler");
require_once("../includes/config/dbconfig.php");
require_once("../includes/connection.php");
error_reporting(0);
$Settings	= New Settings();
$dbsuffix 	= $Settings->dbsuffix;
$db = new MySQL();
		
if(isset($_GET["cmd"]))
	$command = $_GET["cmd"];
else
	die("");


switch ($command)
{
	case "0":
		$counter = 0;
		while($counter<25 && !$db->HasRecords("SELECT imguploaded as img,statusmessage,userid,firstname,lastname,status,DATE_FORMAT(statusupdate,'%Y-%m-%dT%TZ') as SU FROM ".$dbsuffix."_users INNER JOIN ".$dbsuffix."_persons on ".$dbsuffix."_users.personid=".$dbsuffix."_persons.personid WHERE (".((isset($_GET["time"]))?"statusupdate>'".$_GET["time"]."' AND":"")." verificationcode='y' and userid<>".$db->translate($_COOKIE['__amsuid']).") order BY status desc")){
				sleep(1);
				$counter = $counter + 1;
		}
		$db->Query("SELECT imguploaded as img,statusmessage,userid,firstname,lastname,status,statusupdate FROM ".$dbsuffix."_users INNER JOIN ".$dbsuffix."_persons on ".$dbsuffix."_users.personid=".$dbsuffix."_persons.personid WHERE (verificationcode='y' and userid<>".$db->translate($_COOKIE['__amsuid']).") order BY status desc");
		echo $db->GetJSON();
		
		break;
	case "1":
		$values["status"]=MySQL::SQLValue($_GET["status"],MySQL::SQLVALUE_NUMBER);
		$values["statusupdate"]=MySQL::SQLValue(date("m/d/Y H:i:s"),MYSQL::SQLVALUE_DATETIME);
		$filter["userid"]=$db->translate($_COOKIE["__amsuid"]);
		$db->Query(MySQL::BuildSQLUpdate($dbsuffix."_users",$values,$filter));
		echo $db->Error();
		break;
	case "2":
		$counter = 0;
		while($counter<25 && !$db->HasRecords('SELECT * FROM '.$dbsuffix."_messages WHERE ((1=".$_GET['status']." AND status=0 AND `from`<>".$db->translate($_COOKIE["__amsuid"]).") OR datesent>'".$_GET["time"]."') AND ((`to`=".$_GET["id"]." and `from`=".$db->translate($_COOKIE["__amsuid"]).") or  (`to`=".$db->translate($_COOKIE["__amsuid"])." and `from`=".$_GET["id"].")) Order by status, datesent desc limit 0,20"))
		{
				sleep(1);
				$counter = $counter + 1;
		}
	
		echo $db->GetJSON();
	
		break;
	case "3":
		$values["from"]=MySQL::SQLValue($db->translate($_COOKIE['__amsuid']),MySQL::SQLVALUE_NUMBER);
		$values["to"] = MySQL::SQLValue($_GET["to"],MySQL::SQLVALUE_NUMBER);
		$values["status"] =	MySQL::SQLValue($_GET["status"],MySQL::SQLVALUE_NUMBER);
		switch($_GET["status"])
		{
			case 2:
				$values["datesent"] =	MySQL::SQLValue(date("m/d/Y H:i:s"),MYSQL::SQLVALUE_DATETIME);
				$values["message"]  =	MySQL::SQLValue($_GET["message"]);
				$filter["message"]  =  	MySQL::SQLValue($db->translate($_COOKIE['__amsuid']).$_GET["token"]);
				
				$db->Query(MySQL::BuildSQLUpdate($dbsuffix."_messages",$values,$filter));
				$delete["status"] =	MySQL::SQLValue(0,MySQL::SQLVALUE_NUMBER);
				$delete["from"]   =  MySQL::SQLValue($db->translate($_COOKIE['__amsuid']),MySQL::SQLVALUE_NUMBER);
				$db->Query(MySQL::BuildSQLDelete($dbsuffix."_messages",$delete));
				break;
			case 1:
				$filter["message"]  =  	MySQL::SQLValue($db->translate($_COOKIE['__amsuid']).$_GET["token"]);
				$db->Query(MySQL::BuildSQLDelete($dbsuffix."_messages",$filter));
				break;
			case 0:
				$values["message"]  =	MySQL::SQLValue($db->translate($_COOKIE['__amsuid']).$_GET["token"]);
				if(!$db->HasRecords(MySQL::BuildSQLSelect($dbsuffix."_messages",$values)))
					$db->Query(MySQL::BuildSQLInsert($dbsuffix."_messages",$values));
				break;
			case 4:
				$delete["status"] =	MySQL::SQLValue(0,MySQL::SQLVALUE_NUMBER);
				$delete["from"]   =  MySQL::SQLValue($db->translate($_COOKIE['__amsuid']),MySQL::SQLVALUE_NUMBER);
				$db->Query(MySQL::BuildSQLDelete($dbsuffix."_messages",$delete));
		}
	case "4":
		$datetime = new DateTime('2010-12-30 23:21:46');
		echo $datetime->format(DateTime::ISO8601);
		break;
		
}