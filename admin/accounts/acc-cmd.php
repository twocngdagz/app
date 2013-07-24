<?PHP 
require_once("../../includes/config/dbconfig.php");
require_once("../../includes/config/company_config.php");
require_once("../../includes/class.phpmailer.php");
require_once("../../includes/connection.php");
$fileName = "../../includes/config/company_config.php";
$Settings	= New Settings();
$dbsuffix 	= $Settings->dbsuffix;

if (isset($_POST['save'])){
	if($_POST['save']==-1) createAdmin($dbsuffix);	
	if($_POST['save']==0) createPerson($dbsuffix);
	if($_POST['save']==1) updatePerson($dbsuffix);
	if($_POST['save']==2) rewriteSettings($fileName);
	if($_POST['save']==3) verifyAccount($dbsuffix,$_POST['code'],$_POST['uname'],$_POST['pass']);
	if($_POST['save']==4) retrieveValues($dbsuffix);
	if($_POST['save']==5) newUser($dbsuffix);
	if($_POST['save']==6) sendVerificationCode($dbsuffix,$_POST['id']);
};
if (isset($_POST['delcmd'])){
	Delete($dbsuffix,$_POST['delcmd']);
};
	function retrieveValues($dbsuffix){
		$db = new MySQL();
		if(!$db->Open())
        	{
            	echo "Database login failed!";
            	return false;
        	}
		
		$db->Query("SELECT ".$dbsuffix."_persons.*, groupids, DATE_FORMAT(dateofbirth,'%m/%d/%Y') as dateofbirth FROM (".$dbsuffix."_persons LEFT JOIN (SELECT personid,GROUP_CONCAT(DISTINCT groupid) as groupids FROM ".$dbsuffix."_roles GROUP BY personid) as roles on roles.personid=".$dbsuffix."_persons.PersonID)  WHERE ".$dbsuffix."_persons.PersonID=".$_POST['useridedit']);
		header("Content-type: application/json");
	
        echo $db->GetJSON();
		return true;	
	}
	function createPerson($dbsuffix){
		$db = new MySQL();
		$values["firstname"] = MySQL::SQLValue($_POST["firstname"]);
		$values["lastname"] = MySQL::SQLValue($_POST["lastname"]);
		$values["contactnumber"] = MySQL::SQLValue($_POST["contactnumber"]);
		if($_POST["dateofbirth"]) $values["dateofbirth"] = MySQL::SQLValue($_POST["dateofbirth"],MYSQL::SQLVALUE_DATETIME);
		if($db->Query(MySQL::BuildSQLInsert($dbsuffix."_persons", $values))){
			echo "Account sucessfully created.";
				} else {
			echo "Failed to create new account";
		}
	}
	function updatePerson($dbsuffix){
		$db = new MySQL();
		$filter["PersonID"]=MySQL::SQLValue($_POST["PersonID"]);
		$values["firstname"] = MySQL::SQLValue($_POST["firstname"]);
		$values["lastname"] = MySQL::SQLValue($_POST["lastname"]);
		if(isset($_POST["contactnumber"]))$values["contactnumber"] = MySQL::SQLValue($_POST["contactnumber"]);
		if(isset($_POST["nationalitycountry"]))$values["nationalitycountry"]= MySQL::SQLValue($_POST["nationalitycountry"],MYSQL::SQLVALUE_NUMBER);
		if(isset($_POST["gender"]))$values["gender"]= MySQL::SQLValue($_POST["gender"],MYSQL::SQLVALUE_NUMBER);
		if(isset($_POST["address"]))$values["address"] = MySQL::SQLValue($_POST["address"]);
		if(isset($_POST["language"]))$values["language"] = MySQL::SQLValue($_POST["language"]);
		if(isset($_POST["city"]))$values["city"] = MySQL::SQLValue($_POST["city"]);
		if($_POST["dateofbirth"]) $values["dateofbirth"] = MySQL::SQLValue($_POST["dateofbirth"],MYSQL::SQLVALUE_DATETIME);
		if($db->Query(MySQL::BuildSQLUpdate($dbsuffix."_persons", $values,$filter))){
			
				if(isset($_POST["groupids"])){
					
					$values = explode(",",$_POST["groupids"][0]);
					$filter["personid"]= MySQL::SQLValue($_POST["PersonID"]);
					$db->Query(MySQL::BuildSQLDelete($db->getPrefix()."_roles",$filter));
					foreach($values as $value)
					{
						$val["personid"]= MySQL::SQLValue($_POST["PersonID"],MYSQL::SQLVALUE_NUMBER);
						$val["groupid"] = MySQL::SQLValue($value,MYSQL::SQLVALUE_NUMBER);
						$db->Query(MySQL::BuildSQLInsert($db->getPrefix()."_roles",$val));
					}
				}
			
			echo "Account sucessfully updated.";
				} else {
			echo "Failed to update account";
		}
	}
	
	function newUser($dbsuffix){
		$db = new MySQL();
		$email["emailadd"]=MySQL::SQLValue($_POST["emailadd"]);
		if($db->HasRecords(MySQL::BuildSQLSelect($dbsuffix."_emailaccounts", $email))){
					die ("Email is already used by other user.");
		}
		$email["personid"] =  MySQL::SQLValue($_POST["PersonID"]);
		$email['defaultemail'] = MySQL::SQLValue(1);
		if(!$db->Query(MySQL::BuildSQLInsert($dbsuffix."_emailaccounts", $email)))
			echo "Failed to insert email.";
		$user["personid"] =  MySQL::SQLValue($_POST["PersonID"]);
		//Create hash of email 
		$confirmcode =makeConfirmationMd5($_POST['emailadd']);
		$user["verificationcode"] =  MySQL::SQLValue($confirmcode);
	
		//Create new user account
		if($db->Query(MySQL::BuildSQLInsert($dbsuffix."_users",$user))){
			echo "User sucessfully created."	;	
		} else
			echo "Failed to create new account";
	}
	
	function sendVerificationCode($dbsuffix,$userid){
		
			$db = new MySQL();
			$users['userid']=MySQL::SQLValue($userid);
			$users['verificationcode']=MySQL::SQLValue('y');
			if($db->HasRecords(MySQL::BuildSQLSelect($dbsuffix."_emailaccounts", $users))){
					die ("User already verified his account.");
			}
			
			
			$user = $db->QuerySingleRowArray("SELECT * FROM ".$dbsuffix."_users WHERE userid='".$userid."'");
			$formvar = $db->QuerySingleRowArray("SELECT * FROM ".$dbsuffix."_persons WHERE personid='".$user['personid']."'");
			
			$email = $db->QuerySingleValue("SELECT emailadd FROM ".$dbsuffix."_emailaccounts WHERE (defaultemail<> 0 ) and personid=".$formvar["PersonID"]);

			$mailer = new PHPMailer();
			
			$compSettings	= New CompSettings();
			$mailer = new PHPMailer();
			$mailer->CharSet = 'utf-8';
			$mailer->AddAddress($email,$formvar["firstname"]." ".$formvar["lastname"]);
			$mailer->Subject = "Welcome to ".$compSettings->CompanyName."!";
			$mailer->From = $compSettings->Admin;
			$mailer->FromName = $compSettings->CompanyName;                   

		
			$confirm_url = GetAbsoluteURLFolder().'/users/?code='.$user['verificationcode'];
		
			$mailer->Body ="Hello ".$formvar["firstname"]." ".$formvar["lastname"].",<p/>".
			"The administrator sent you an access to ".$compSettings->WebsiteName.".<br/>".
			"Please click the link below to confirm your registration.\r\n".
			"$confirm_url<p/>".
			"\r\n".
			"Regards,<br/>".
			"DSS Team<br/>".
			$compSettings->CompanyName;
			
			if(!$mailer->Send())
			{
					echo "Failed sending registration confirmation email.";
					return false;
			}		
	}
	function createAdmin($dbsuffix){
		$db = new MySQL();
		$email["emailadd"]=MySQL::SQLValue($_POST["emailadd"]);
		$values["firstname"] = MySQL::SQLValue($_POST["fname"]);
		$values["lastname"] = MySQL::SQLValue($_POST["lname"]);
		//Create new account record
		if($db->Query(MySQL::BuildSQLInsert($dbsuffix."_persons", $values))){
			//Get last insert id {userid}
			$email['personid'] = MySQL::SQLValue($db->GetLastInsertID());
			$email['defaultemail'] = MySQL::SQLValue(1);
			if(!$db->Query(MySQL::BuildSQLInsert($dbsuffix."_emailaccounts", $email)))
				echo "Failed to insert email.";
			$user["personid"] = $email['personid'];
			//Create hash of email 
			$confirmcode =makeConfirmationMd5($_POST['emailadd']);
			$user["verificationcode"] =  MySQL::SQLValue($confirmcode);
			//Create new user account
			if($db->Query(MySQL::BuildSQLInsert($dbsuffix."_users",$user))){
					sendVerificationCode($dbsuffix,$db->GetLastInsertID());	
			} else
				echo "Failed to create new account";
		} else {
			echo "Failed to create new account";
		}
		
	}
	
	function rewriteSettings($fileName)
	{
		$handle = fopen($fileName, "w");
		$string = "<?php \n".
		  "$"."CompSettings = new CompSettings();\n".
		  "class CompSettings{ \n".
		  "var $"."CompanyName  = '".$_POST['cname']."';\n".
		  "var $"."WebsiteName  = '".$_POST['wname']."';\n".
	 	  "var $"."TechnicalSupport  = '".$_POST['tsupport']."';\n".
		  "var $"."ClientSupport = '".$_POST['csupport']."';\n".
	 	  "var $"."Accounting = '".$_POST['accounting']."';\n".
 		  "var $"."HumanResource = '".$_POST['hresource']."';\n".
 		  "var $"."Admin = '".$_POST['admin']."';\n".
	 	  "var $"."Random = '".$_POST['random']."';} ?>\n";
		fwrite($handle, $string);
   	};
	
	function verifyAccount ($dbsuffix,$code,$uname,$pass){
			$db = new MySQL();
			if($code=="y") die("Invalid verification code.");
        	$codes['verificationcode'] =MySQL::SQLValue($code);
			$formvars['username'] = MySQL::SQLValue($uname);
			
			if($db->HasRecords(MySQL::BuildSQLSelect($dbsuffix."_users",$formvars))){
					die ("Username already exists.");
			}
			
        	$formvars['password'] = MySQL::SQLValue(md5($pass));

			if(!$db->HasRecords(MySQL::BuildSQLSelect($dbsuffix."_users", $codes))){
					die ("Invalid verification code.");
			}
			$userid = $db->QuerySingleValue("SELECT personid FROM ".$dbsuffix."_users WHERE verificationcode='".$code."'");
			$user["personid"]= MySQL::SQLValue($userid );
			$formvars["verificationcode"]=MySQL::SQLValue("y");
			
			if($db->Query(MySQL::BuildSQLUpdate($dbsuffix."_users", $formvars,$user))){
				echo "1";
			} else {
				echo "Failed to created new account";
			}
			
			if(!sendUserRegistrationCompleted($dbsuffix,$userid))	
        	{
				echo 'Failed to send user confirmation.';
            	return false;
        	}
			
			
			


 
        	
	} 
	
	 function sendUserRegistrationCompleted($dbsuffix,$userid)
    	{
			$db = new MySQL();
		
			$compSettings	= New CompSettings();
		
			$formvar = $db->QuerySingleRowArray("SELECT * FROM ".$dbsuffix."_persons WHERE personid='".$userid."'");
			$email = $db->QuerySingleValue("SELECT emailadd FROM ".$dbsuffix."_emailaccounts WHERE (defaultemail<> 0) and personid=".$formvar["PersonID"]);
			
			$emails["emailadd"]= MySQL::SQLValue($email );
			$verify["verified"]=MySQL::SQLValue(1);
			
			if(!$db->Query(MySQL::BuildSQLUpdate($dbsuffix."_emailaccounts", $verify,$emails)))
			 	die ("Failed to verify email");
				
			$mailer = new PHPMailer();
        
        	$mailer->CharSet = 'utf-8';
        
        	$mailer->AddAddress($email,$formvar['firstname']." ".$formvar['lastname']);
        
        	$mailer->Subject = "Registration Completed!";

        	$mailer->From = $compSettings->Admin;
			$mailer->FromName = $compSettings->CompanyName;            
        
         			
        	$login = GetAbsoluteURLFolder().'/login';
     
        	$mailer->Body ="Hello ".$formvar['firstname']." ".$formvar['lastname'].",<p/>".
        	"You are now registered to ".$compSettings->CompanyName.".<br/>".
        	"Click to login =>.".$login."<br/>".
        	"<p/>".
        	"Regards,<br/>".
        	"DSS Team<br/>".
        	$compSettings->CompanyName;
			
        	if(!$mailer->Send())
        	{
            		return false;
        	}
			return true;
    	}
		
	function GetAbsoluteURLFolder()
    	{
        	$scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        	$scriptFolder .= $_SERVER['HTTP_HOST'];
        	return $scriptFolder;
    	}
	function makeConfirmationMd5($email)
	{
		$randno1 = rand();
		$randno2 = rand();
		return md5($email.$randno1.''.$randno2);
	}
		
?>