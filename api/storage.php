<?php
require_once("../includes/config/dbconfig.php");
require_once("../includes/connection.php");
$Settings	= New Settings();
$dbsuffix 	= $Settings->dbsuffix;
	/*!
	 *	this is a template included with the jDashboard Plugin for jQuery
	 *	http://codecanyon.net/item/jdashboard/135111
	 *
	 *	Copyright (c) 2010-2012 Sarathi Hansen
	 *	http://www.codecanyon.net/user/sarthemaker
	 *
	 *	fill in the information about your mysql database below:
	 */
	$hostname  = $Settings->dbhost;		// your mysql database hostname
	$username  = $Settings->dbusername;			// your mysql database username
	$password  = $Settings->dbpass;				// your mysql database password
	
	$database  = $dbsuffix.'_'.$Settings->dbname;			// the name of your database
	$tablename = $dbsuffix.'_dashboard';		// the name of the table in which to store the dashboard layouts
	$idfield   = 'userID';			// the field in which to store each users unique id
	$datafield = 'jdashStorage';	// the field in which to store the users dashboard layout
	
	
	/*!
	 *	YOU CAN STOP EDITING HERE
	 */
	$handle    = mysql_connect($hostname, $username, $password);
				 mysql_select_db($database);
	
	$db = new MySQL();
	$db->Open();
	$storageID = $db->translate($_COOKIE['__amsuid']);
	
	$result= $db->HasRecords("SELECT jDashStorage FROM `{$tablename}` WHERE `{$idfield}`='{$storageID}'");
	
	if($_POST['type'] === 'load') {
		
		if($result)
		{
			$value= $db->Row();
			echo stripslashes($value->jDashStorage);
		}
		
	} elseif($_POST['type'] === 'save') {
		
		if($result !== false)
			mysql_query("UPDATE `{$tablename}` SET `{$datafield}`='{$_POST['value']}' WHERE `{$idfield}`='{$storageID}'");
		else
			mysql_query("INSERT INTO `{$tablename}` (`{$idfield}`,`{$datafield}`) VALUES('{$storageID}','{$_POST['value']}')");
	}
	
?>