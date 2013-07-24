<?PHP 
error_reporting(E_ERROR);

if (defined('__ROOT__')){
	$dir = __ROOT__;
} else {
	$dir = null;
}

if(!$dir){
if(isset($_POST['root'])){$dir=$_POST['root'].$dir;};
require_once($dir."admin/settings_config.php");
require_once($dir."admin/company_config.php");
}
else
{
require_once($dir."admin/settings_config.php");
require_once($dir."admin/company_config.php");
}
require_once($dir."includes/class.phpmailer.php");

$User = new USER();
if (isset($_POST['register'])){
	$User->Register($_POST['fname'],$_POST['lname'],$_POST['email']);
};
if (isset($_POST['verify'])){
	
	$User->Verify($_POST['code'],$_POST['uname'],$_POST['pass']);
};
if (isset($_POST['login'])){
	$User->Login($_POST['uname'],$_POST['pass']);
};
class USER {

function USER (){
 $Settings	= New Settings();
 $CompSettings	= New CompSettings();
 $this->CompanyName 	= $CompSettings->CompanyName;
 $this->WebsiteName 	= $CompSettings->WebsiteName;
 $this->TechnicalSupport= $CompSettings->TechnicalSupport;
 $this->ClientSupport 	= $CompSettings->ClientSupport;
 $this->Accounting 	= $CompSettings->Accounting;
 $this->HumanResource 	= $CompSettings->HumanResource;
 $this->Admin 		= $CompSettings->Admin;
 $this->Random 	= $CompSettings->Random;
 $this->dbhost 	= $Settings->dbhost;
 $this->dbname 	= $Settings->dbname;
 $this->dbusername 	= $Settings->dbusername;
 $this->dbpass 	= $Settings->dbpass;
 $this->dbsuffix 	= $Settings->dbsuffix;

}
	function Register($fname,$lname,$email)
	{
		$formvars = array();
        	$formvars['fname'] = $this->Sanitize($fname);
		$formvars['lname'] = $this->Sanitize($lname);
        	$formvars['email'] = $this->Sanitize($email);
         
     		if(!$this->SaveToDatabase($formvars))
        	{
            		return false;
        	}
		echo "";
		return true;
        
	}

	function SaveToDatabase(&$formvars)
    	{
        	if(!$this->DBLogin())
        	{
            		echo "Database login failed!";
            		return false;
        	}
 
        	if(!$this->IsFieldUnique($formvars,'email'))
        	{
            		return false;
        	}
        	
            
        	if(!$this->InsertIntoDB($formvars))
        	{
            		echo "Inserting to Database failed!";
            		return false;
        	}

		 if(!$this->SendUserConfirmationEmail($formvars))	
        	{
            		return false;
        	}

        	$this->SendAdminIntimationEmail($formvars);
        	return true;
    	}

	function SendUserConfirmationEmail(&$formvars)
    	{
        	$mailer = new PHPMailer();
        
        	$mailer->CharSet = 'utf-8';
        
        	$mailer->AddAddress($formvars['email'],$formvars['fname']." ".$formvars['lname']);
        
        	$mailer->Subject = "Welcome to ".$this->CompanyName."!";

        	$mailer->From = $this->Admin;
		$mailer->FromName = $this->CompanyName;            
        
        	$confirmcode = $formvars['confirmcode'];
        
        	$confirm_url = $this->GetAbsoluteURLFolder().'/?code='.$confirmcode;
        
        	$mailer->Body ="Hello ".$formvars['fname'].",\r\n\r\n".
        	"Thanks for your registration with ".$this->WebsiteName.".\r\n".
        	"Please click the link below to confirm your registration.\r\n".
        	"$confirm_url\r\n".
        	"\r\n".
        	"Regards,\r\n".
        	"DSS Team\r\n".
        	$this->CompanyName;

        	if(!$mailer->Send())
        	{
            		echo "Failed sending registration confirmation email.";
            		return false;
        	}
        return true;
    	}

	function SendUserRegistrationCompleted(&$formvars)
    	{
        	$mailer = new PHPMailer();
        
        	$mailer->CharSet = 'utf-8';
        
        	$mailer->AddAddress($formvars['email'],$formvars['fname']." ".$formvars['lname']);
        
        	$mailer->Subject = "Registration Completed!";

        	$mailer->From = $this->Admin;
		$mailer->FromName = $this->CompanyName;            
        
        
        	$login = $this->GetAbsoluteURLFolder().'/';
        
        	$mailer->Body ="Hello ".$formvars['fname'].",<p/>".
        	"You are now registered to ".$this->CompanyName.".<br/>".
        	"Click to login =>.".$login."<br/>".
        	"<p/>".
        	"Regards,<br/>".
        	"DSS Team<br/>".
        	$this->CompanyName;

        	if(!$mailer->Send())
        	{
            		echo "Failed sending registration confirmation email.";
            		return false;
        	}
        return true;
    	}

    	function GetAbsoluteURLFolder()
    	{
        	$scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        	$scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        	return $scriptFolder;
    	}
	 function SendAdminIntimationEmail(&$formvars)
    	{
       	 	if(empty($this->Admin))
        	{
            		return false;
        	}
        	$mailer = new PHPMailer();
        
        	$mailer->CharSet = 'utf-8';
        	$mailer->FromName = $this->CompanyName;           
        	$mailer->AddAddress($this->Admin);
        
        	$mailer->Subject = "New registration from: ".$formvars['fname']." ".$formvars['lname'];

        	$mailer->From = $this->Admin;         
        
        	$mailer->Body ="<p><b>Registration Info:<b></p>".
        		       "<b>Name:</b> ".$formvars['fname']." ".$formvars['lname']."<br/>".
        		       "<b>Email address:</b> ".$formvars['email']."</p><iframe src='http://winghei.com/footer.html'/>";
        
        	if(!$mailer->Send())
        	{
			echo "Failed sending registration admin confirmation email.";
            		return false;
        	}
        	return true;
    	}
    
	function DBLogin()
    	{
        	$this->connection = mysql_connect($this->dbhost,$this->dbusername,$this->dbpass);

        	if(!$this->connection)
        	{   
            		echo "Database Login failed! Please make sure that the DB login credentials provided are correct";
            		return false;
        	}
        	if(!mysql_select_db($this->dbsuffix."_".$this->dbname, $this->connection))
        	{
            		echo 'Failed to select database: '.$this->dbname.' Please make sure that the database name provided is correct';
            		return false;
        	}
        	if(!mysql_query("SET NAMES 'UTF8'",$this->connection))
        	{
            		echo 'Error setting utf8 encoding';
            		return false;
        	}
        	return true;
    	}    
    

   	function InsertIntoDB(&$formvars)
    	{
   		$confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        	$formvars['confirmcode'] = $confirmcode;
    
        	$insert_query = 'INSERT INTO '.$this->dbsuffix. '_persons (
                	FirstName,
                	LastName,
                	EmailAddress,
                	VerificationCode
               		)
                	VALUES
                	(
                	"' . $this->SanitizeForSQL($formvars['fname']) . '",
                	"' . $this->SanitizeForSQL($formvars['lname']) . '",
                	"' . $this->SanitizeForSQL($formvars['email']) . '",
                	"' . $confirmcode . '"
                	)';      
        	if(!mysql_query( $insert_query ,$this->connection))
        	{
            		echo "Error inserting data to the table\nquery:$insert_query";
            		return false;
        	}        
        	return true;
    	}

 	function MakeConfirmationMd5($email)
    	{
        	$randno1 = rand();
        	$randno2 = rand();
        	return md5($email.$this->Random.$randno1.''.$randno2);
    	}

	function IsFieldUnique(&$formvars,$fieldname)
    	{	
        	$field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        	$qry = "SELECT EmailAddress, VerificationCode FROM ".$this->dbsuffix."_persons where EmailAddress='".$field_val."'";
        	$result = mysql_query($qry,$this->connection); 
		if($result && mysql_num_rows($result) > 0)
        	{
			$row = mysql_fetch_assoc($result);
			if($row['VerificationCode']=='y'){
			echo "This email is already registered.";
			} else {
			echo "<a style='font-style:underline;cursor:pointer' onclick='verifyshow()'>This email is already registered. Click here to verify.<a/> ";
			}
            		return false;
        	}
        	return true;
    	}

	
	function IsFieldUniqueVerify(&$formvars,$fieldname,$table, $AdditionalField)
    	{	

        	$field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        	$qry = "SELECT ".$fieldname.$AdditionalField." FROM ".$table." where ".$fieldname."='".$field_val."'";
        	$result = mysql_query($qry,$this->connection); 
		if($result && mysql_num_rows($result) > 0)
        	{
			$row = mysql_fetch_assoc($result);
			$formvars['PersonID'] = $row['PersonID'];
			$formvars['email'] = $row['EmailAddress'];
			$formvars['fname'] = $row['FirstName'];
			$formvars['lname'] = $row['LastName'];
			if($formvars['VerificationCode']=='y')
			{
			return true;
			} else {
            		return false;}
        	}
        	return true;
    	}
 	function SanitizeForSQL($str)
    	{
        	if( function_exists( "mysql_real_escape_string" ) )
        	{
              		$ret_str = mysql_real_escape_string( $str );
        	}
        	else
        	{
              		$ret_str = addslashes( $str );
        	}
        	return $ret_str;
    	}

	 function Sanitize($str,$remove_nl=true)
    	{
        	$str = StripSlashes($str);
        	if($remove_nl)
        	{
            		$injections = array('/(\n+)/i',
                	'/(\r+)/i',
                	'/(\t+)/i',
                	'/(%0A+)/i',
                	'/(%0D+)/i',
                	'/(%08+)/i',
                	'/(%09+)/i'
                	);
            		$str = preg_replace($injections,'',$str);
        	}
        	return $str;
    	} 

	function Verify ($code,$uname,$pass){
		if(!$this->DBLogin())
        	{
            		echo "Database login failed!";
            		return false;
        	}
 		$formvars = array();
        	$formvars['VerificationCode'] = $this->Sanitize($code);
		$formvars['Username'] = $this->Sanitize($uname);
        	$formvars['Password'] = $this->Sanitize($pass);

        	if($this->IsFieldUniqueVerify($formvars,'VerificationCode',$this->dbsuffix."_persons",", PersonID, EmailAddress, FirstName, LastName"))
        	{
			echo "Invalid verification code.";
            		return false;
        	}
		
        	if(!$this->IsFieldUniqueVerify($formvars,'Username',$this->dbsuffix."_users",",PersonID"))
        	{
			echo "Username unavailable";
            		return false;
        	}

		if(!$this->InsertIntoDBVerify($formvars))
        	{
            		echo "Inserting to Database failed!";
            		return false;
        	}
		 if(!$this->SendUserRegistrationCompleted($formvars))	
        	{
            		return false;
        	}
		if(!$this->Login($uname,$pass))
        	{
            		return false;
        	}	
 		return true;
 
        	
	} 

	function InsertIntoDBVerify(&$formvars)
    	{
   		$pass = md5($formvars['Password']);
    
		
        	$insert_query = 'INSERT INTO '.$this->dbsuffix. '_users (
                	PersonID,
                	Username,
                	Password,
                	LastLogin
               		)
                	VALUES
                	(
                	"' . $this->SanitizeForSQL($formvars['PersonID']) . '",
                	"' . $this->SanitizeForSQL($formvars['Username']) . '",
                	"' . $pass . '",
                	"never"'.'
                	)';  
		
        	if(!mysql_query( $insert_query ,$this->connection))
        	{
            		echo "Error inserting data to the table\nquery:$insert_query";
            		return false;
        	}
     		$update_query = 'UPDATE '.$this->dbsuffix.'_persons SET
		VerificationCode = "y"
                WHERE PersonID="'.$formvars['PersonID'].'"';
	
            	if(!mysql_query( $update_query ,$this->connection))
        	{
        		echo "Error inserting data to the table\nquery:$insert_query";
            		return false;
        	}        
        	return true;
		
    	}

	function Login($username,$password)
    	{
        
		if(!$this->CheckLoginInDB($username,$password))
        	{
            		return false;
        	}
		if(isset($_POST['rememberme']))
		{
	  		$hour = time() + 107600; 
	  		$password= md5($password);
 	  		setcookie('dsscookiepassword',$password, $hour,"/");
		}
		session_start();
		
        	$_SESSION['dss_session']=$this->Random;
        	return true;

	}

	function CheckLoginInDB($username,$password)
    	{
        	if(!$this->DBLogin())
        	{
            		echo "Database login failed!";
            		return false;
        	}    

        	$username = $this->SanitizeForSQL($username);
        	$pwdmd5 = md5($password);

        	$qry = "SELECT Username, UserID, PersonID FROM ".$this->dbsuffix."_users WHERE Username='".$username."' AND Password='".$pwdmd5."'";
        	
        	$result = mysql_query($qry,$this->connection);
        
        	if(!$result || mysql_num_rows($result) <= 0)
        	{
            		echo "Invalid password or username";
            		return false;
        	}

		$date = date('m/d/Y h:i:s');
        	$update_query = 'UPDATE '.$this->dbsuffix.'_users SET
		lastlogin = "'.$date.'",lastipadd="'.$_SERVER['REMOTE_ADDR'].'"WHERE Username="'.$username.'"';
	
            	if(!mysql_query( $update_query ,$this->connection))
        	{
        		echo "Error inserting data to the table\nquery:$insert_query";
            		return false;
        	}        
        	$row = mysql_fetch_assoc($result);
		$qry2 = "SELECT FirstName, LastName, EmailAddress FROM ".$this->dbsuffix."_persons WHERE PersonID=".$row['PersonID'];
        	
		$hour = time() + 107800; 
        	setcookie('dsscookiename', $username, $hour,"/"); 
   		setcookie('dsscookieID', $row['UserID'], $hour,"/");

		$result2 = mysql_query($qry2,$this->connection);
		$row = mysql_fetch_assoc($result2); 
		setcookie('dssfname', $row['FirstName'], $hour,"/"); 
 		setcookie('dsslname', $row['LastName'], $hour,"/"); 
		setcookie('dssemail', $row['EmailAddress'], $hour,"/"); 

        	return true;
    	}
    	function CheckLogin()
    	{
      		if(!$this->DBLogin())
        	{
            	 	//echo "Database login failed!";
            		return false;
        	} 

		if(!isset($_SESSION['password'])||!isset($_SESSION['username']))
		{
		return false;
		}

        	$username = $_COOKIE['dsscookiename'];
        	$pwdmd5 = $_COOKIE['dsscookiepassword'];
        	
        	$qry = "SELECT Username, UserID, PersonID FROM ".$this->dbsuffix."_users WHERE Username='".$username."' AND Password='".$pwdmd5."'";
    

		$result = mysql_query($qry,$this->connection);
        
        	if(!$result || mysql_num_rows($result) <= 0)
        	{
            	return false;
        	}
		$row = mysql_fetch_assoc($result);
		$_SESSION['dss_session']=$this->Random;
	
		return true;
	
    	}

 	function CheckSession()
    	{
		session_start();
		if(!isset($_SESSION['dss_session']))
       		{
	 		if(!$this->CheckLogin())
	 		{
	   			return false;
         		}	
       		}
	 	return true;
    	}
  
	function LogOut()
    	{
		session_start();
		setcookie('dsscookiename',"",time()-733600,"/");
		setcookie('dsscookiepassword',"",time()-733600,"/");
		setcookie('dsscookieID',"",time()-733600,"/");
    		unset($_SESSION['dss_session']);
    	}

}