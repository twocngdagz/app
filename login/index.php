<?php 
	ob_start();
	session_start();
	// Require PFBC, MySQL connection, and Jscryption plugins
	require_once("../includes/connection.php");
	require_once("../includes/jcryption.php");
	require_once("logs.php");
	//Create new object of MySQL connection
	$db = new MySQL();
	//Open connection
	$db->open();
	
	// Set the RSA key length
	$keyLength = 1024;
	// Create a new jCryption object
	$jCryption = new jCryption();
	
	//Check arguments for logging in
	if(isset($_GET["generateKeypair"])) {
		 session_unset(); 
		// Include some RSA keys
		require_once("../includes/100_1024_keys.inc.php");
		// Pick a random key from the array
		$keys = $arrKeys[mt_rand(0, 100)];
		// Save the RSA key into session
		$_SESSION["e"] = array("int" => $keys["e"], "hex" => $jCryption->dec2string($keys["e"], 16));
		$_SESSION["d"] = array("int" => $keys["d"], "hex" => $jCryption->dec2string($keys["d"], 16));
		$_SESSION["n"] = array("int" => $keys["n"], "hex" => $jCryption->dec2string($keys["n"], 16));
		// Generate reponse
		$arrOutput = array(
			"e" => $_SESSION["e"]["hex"],
			"n" => $_SESSION["n"]["hex"],
			"maxdigits" => intval($keyLength*2/16+3)
		);
		// Convert the response to JSON, and send it to the client
		echo json_encode($arrOutput);
		exit();
	// Else if the GET parameter "decrypttest" is set
	} elseif (isset($_GET["handshake"])) {
		// Decrypt the client's request
		$key = $jCryption->decrypt($_POST['key'], $_SESSION["d"]["int"], $_SESSION["n"]["int"]);
		// Remove the RSA key from the session
		unset($_SESSION["e"]);
		unset($_SESSION["d"]);
		unset($_SESSION["n"]);
		// Save the AES key into the session
	
		$_SESSION["key"] = $key;
		// JSON encode the challenge
		echo json_encode(array("challenge" => AesCtr::encrypt($key, $key, 256)));
		exit();
	}
	
	
	if(isset($_POST["form"])) {
		//Validate login details
			if(isset($_POST["username"])) {
				// Set the RSA key length
				$keyLength = 1024;
				// Create a new jCryption object
				$jCryption = new jCryption();
				

				$username =  $_POST['username'];
				$password =  $_POST['password'];
			
				$values["username"] = MySQL::SQLValue($username);
				$values["password"] = MySQL::SQLValue(md5($password));
				$phash = md5(rand());
				$email = $username;
				
				function get_domain($email)
				{
					$domain = implode('.',
						array_slice( preg_split("/(\.|@)/", $email), -2)
					);
					return strtolower($domain);
				}
				if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)) { 
						if($db->HasRecords("SELECT userid,username,firstname,lastname FROM (".$db->getPrefix()."_emailaccounts INNER JOIN ".$db->getPrefix()."_persons on ".$db->getPrefix()."_emailaccounts.personid=".$db->getPrefix()."_persons.personid) INNER JOIN ".$db->getPrefix()."_users on ".$db->getPrefix()."_emailaccounts.personid=".$db->getPrefix()."_users.personid WHERE emailadd='".$email."'")){
							define('INSTALL_PATH',"../mail/");
							require_once '../mail/program/include/iniset.php';
							$RCMAIL = rcmail::get_instance();

							$domain = 	"www.".get_domain($username);
							if(!$RCMAIL->login($username, $password, $domain, true)) die ("Invalid username/password.");

							$row = $db->Row();
							$expire=time()+60*60*60;
							setcookie("__amsuid",AesCtr::encrypt($row->userid, $phash , 256),$expire,"/");
							setcookie("__amsuin",AesCtr::encrypt($row->username,$phash , 256),$expire,"/");
							setcookie("__amsuip",AesCtr::encrypt($password,$phash , 256),$expire,"/");
							setcookie("__amsufn",$row->firstname,$expire,"/");
							setcookie("__amsuln",$row->lastname,$expire,"/");
							$log = new Logs();
							$log->InsertLog("Logged in",$row->userid,$phash);
							 
									
							 die ("");
						} else {
							die ("Invalid username/password.");
								
						}
				} 
				else { 
					if($db->HasRecords("SELECT userid,username,firstname,lastname FROM ".$db->getPrefix()."_persons INNER JOIN ".$db->getPrefix()."_users on ".$db->getPrefix()."_persons.personid=".$db->getPrefix()."_users.personid WHERE username='".$username."' and password='".md5($password)."'")){
						 $row = $db->Row();
						 $expire=time()+60*60*60;
						 setcookie("__amsuid",AesCtr::encrypt($row->userid, $phash , 256),$expire,"/");
						 setcookie("__amsuin",AesCtr::encrypt($row->username,$phash , 256),$expire,"/");
						 setcookie("__amsuip",AesCtr::encrypt($password,$phash , 256),$expire,"/");
						 setcookie("__amsufn",$row->firstname,$expire,"/");
						 setcookie("__amsuln",$row->lastname,$expire,"/");
						 $log = new Logs();
						 $log->InsertLog("Logged in",$row->userid,$phash);
						 die ("");
					};
					die ("Invalid username/password.");
					exit();
				}
			};
	}
		//Get target within ams folder
	$targetFolder = dirname(dirname( $_SERVER['SCRIPT_FILENAME'])).'/utils/images/profiles/small'; 
	$isProfilePicExist = 0;
	
	if(isset($_COOKIE["__amsuid"])){
		if (file_exists($targetFolder . '/'.$db->translate($_COOKIE["__amsuid"]).".jpg")) {
			$isProfilePicExist= 1;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<title>Login - AMS</title>
<link href="../styles/ui-gen.php?form" rel="stylesheet" type="text/css"/>
<script src="../scripts/lib/jquery.js"></script>
<script src="../scripts/lib/jquery-ui.js"></script>
<script src="../scripts/core/notify.js"></script>
<script src="../scripts/core/ui-gen.js"></script>
<script src="../scripts/core/frmcmd.js"></script>
<script src="../encrypt/jquery.jcryption.min.js"></script>
<script>
	$(document).ready(function(){
	    callback();
		$("button").button();
		$("#loginnow").submit(function(e) {
     		e.preventDefault(); 
			loginnow();
		});
    });
	function callback(){
		$("#login").addClass('centerposafter');
		$( "#centerpos" ).show('drop',{direction:'up'},800);
	};
</script>
<style>
.form {
	background: url(../styles/images/login-bg.jpg);
}
#loginnow .pfbc-label label {
	font-weight: bold;
	color: #333;
}
#loginnow .pfbc-label em {
	font-size: .9em;
	color: #888;
}
#loginnow .pfbc-label strong {
	color: #990000;
}
#loginnow .pfbc-textbox, #loginnow .pfbc-textarea, #loginnow .pfbc-select {
	border: 1px solid #ccc;
	font-size: 14px;
}
#loginnow .pfbc-textbox, #loginnow .pfbc-textarea {
	padding: 7px;
}
#loginnow .pfbc-select {
	padding: 6px 7px;
}
#loginnow img.pfbc-loading {
	position: absolute;
	top: 50%;
	right: .5em;
	margin-top: -8px;
	border: 0;
}
#loginnow {
	width:330px;
	margin: 0 auto;
}
#loginnow .pfbc-element {
	padding-bottom: .5em;
}
#loginnow .user {
	border:none;
	float:left;
	padding-bottom: .5em;
}
#loginnow .pfbc-label {
	width: 80px;
	float: left;
	padding-right: 5px;
}
#loginnow .pfbc-buttons {
	text-align: right;
}
#loginnow .pfbc-textbox, #loginnow .pfbc-textarea, #loginnow .pfbc-select, #loginnow .pfbc-right {
	width: 200px;
	float:left;
}
.labeluser {
	font-size:25px;
	line-height:35px;
	font-weight:bold;
}
.hasPlaceholder {
	color: #777;
}
#loginnow .pfbc-right {
	float: right;
	margin-right:20px;
}
</style>
<div style="display:none" id="centerpos" >
  <div class="mask" >
    <div  style="width:400px" class="form">
      <div  style="padding-left:20px;width:380px;background:url(../styles/images/kad2.jpg) no-repeat;background-size:100% 100%;" class="header" >
    
      </div>    <div id="version" style="float:right;margin-top:5px;font-size:9px">1.0.0.0</div>
      <form  id="loginnow" style="padding:20px;"  >
        <img src="<?PHP if($isProfilePicExist==1)echo "../utils/images/profiles/".$db->translate($_COOKIE["__amsuid"]).".jpg?=var=".rand() ;else echo "../styles/images/contactpic.png"; ?>" height="80" width="80" style="padding:5px;margin-top:5px;float:left;border:1px solid #ddd"/>
        <input type="hidden" name="form" value="loginnow" id="loginnow-element-0"/>
        <div style="float:right" id="pfbc-element-0" class="pfbc-element"><br/>
          <div class="pfbc-right">
				<input type="text" name="username" class="pfbc-textbox" placeholder="username" id="username"/>
          </div>
        </div>
        <div id="pfbc-element-1" class="pfbc-element">
          <div class="pfbc-right">
            <input type="password" class="pfbc-textbox" name="password" placeholder="password" id="password"/>
          </div>
        </div>
        
        <div class="pfbc-element pfbc-buttons" style="padding-top: 5px; padding-bottom: 10px; border-bottom-style: none;">
         
          <button type="submit" value="Login" name="" style="margin-top:15px" id="submit" role="button" aria-disabled="false">Login</button>
        </div>
      </form>
      <div style="padding: 0px 20px 0px 20px;"><span style="float:left;margin-top:-40px;font-weight:bold;font-size:9px;font-style:italic;vertical-align:middle;line-height:20px">Powered by:&nbsp;</span><img style="margin-top:-20px;padding-left:10px;" src="../styles/images/logo.png" height="30px" width="20px"/><span style="float:right;height:12px" id="stat"></span></div>
    </div>
  </div>
</div>
</div>
<body>
<script>
	
    function loginnow(){
		$("#submit").button("disable").css("padding-right", "1.1em").append("<img class=\"pfbc-loading\" src=\"../includes/PFBC/Resources/loading.gif\"/>");
		//notify.notify("Authenticating...");
		//var hashpassword ="<?PHP echo md5(rand()); ?>";
		//var d = new Date();
		//$.jCryption.authenticate(hashpassword, "index.php?generateKeypair=true&d="+d.toString(), "index.php?handshake=true&d="+d.toString(), function(AESKey) {
			notify.notify("Logging in...");
			var username = $("#username").val();
			var password = $("#password").val();
			$.ajax({
				type: "POST",
				url: "index.php",
				data:{
							username: username,
							password: password,
							form: "loginnow"
				},
				success: function(data){
					
					if(data.length<2){
						window.location.replace("../app");
					}else{
						notify.notify(data);
					};
				}
			}).done(function(){$("#submit").button("enable").css("padding-right", "0.1em").find("img").remove()});;        		
		//}, function() {
		//	notify.notify("Authentication failed.");
		//	$("#submit").button("enable").find("img").remove();
		//});
			
    };
	jQuery(function() {
	   jQuery.support.placeholder = false;
	   test = document.createElement('input');
	   if('placeholder' in test) jQuery.support.placeholder = true;
	});
	// This adds placeholder support to browsers that wouldn't otherwise support it. 
	$(function() {
	   if(!$.support.placeholder) { 
		  var active = document.activeElement;
			  $('input').each(function(index, element) {
					$(this).focus(function () {
						 if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
							$(this).val('').removeClass('hasPlaceholder');
						 }
					}).blur(function () {
						 if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
							$(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
						 }
					});
					$(':text').blur();
					$(this).focus();
					$('form:eq(0)').submit(function () {
					$(':text.hasPlaceholder').val('');
			  });
			});
	   }
	});
</script>
</html>