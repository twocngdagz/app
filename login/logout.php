<?PHP
	if(!isset($_COOKIE['__amsuid']))header("Location:../");
	include_once("logs.php");
	require_once("../includes/jcryption.php");
	$log = new Logs();
	$log->InsertLog("Logged out",AesCtr::decrypt($_COOKIE["__amsuid"],$_COOKIE["__amstoken"], 256),9);
	$expire = 0;
	setcookie("__amsuid","",$expire,"/");
	setcookie("__amsuin","",$expire,"/");
	setcookie("__amsuip","",$expire,"/");
	setcookie("__amstoken","",$expire,"/");
	header("Location:../");
?>
