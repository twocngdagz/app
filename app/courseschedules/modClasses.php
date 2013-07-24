	<?PHP
require_once("../../includes/connection.php");
 if(isset($_GET['on']))
 {
	 $on = $_GET['on'];
	 $cmd =  isset($_GET["cmd"])?$_GET['cmd']:"";
	 
	 $db = new MySQL();
	 $db->Open();
	 
	 switch($on)
	 {
		case 0:
			switch($cmd)
			{
				case 0:
					$db->Query("SELECT ".$db->getPrefix()."_classes.*,".$db->getPrefix()."_classes.classid as id,trainors FROM (".$db->getPrefix()."_classes left join (SELECT classid,GROUP_CONCAT(personid) as trainors FROM ".$db->getPrefix()."_classes_trainors Group BY classid) as trainors on trainors.classid=".$db->getPrefix()."_classes.classid)");
					echo $db->GetJSON();
					break;
				case 1:
					if(isset($_GET["day"]))$values["day"]= MySQL::SQLValue($_GET["day"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["starttime"]))$values["starttime"]= MySQL::SQLValue($_GET["starttime"],MySQL::SQLVALUE_TIME);
					if(isset($_GET["endtime"]))$values["endtime"] = MySQL::SQLValue($_GET["endtime"],MySQL::SQLVALUE_TIME);
					if(isset($_GET["capacity"]))$values["capacity"] = MySQL::SQLValue($_GET["capacity"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["courseid"]))$values["courseid"] = MySQL::SQLValue($_GET["courseid"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["bath"]))$values["bath"] = MySQL::SQLValue($_GET["bath"]);
					$values["createdby"]= MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]),MySQL::SQLVALUE_NUMBER);
					$values["dateupdated"] =MySQL::SQLValue(date("m/d/Y H:i:s"),MYSQL::SQLVALUE_DATETIME);
					$values["updatedby"]=MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]),MySQL::SQLVALUE_NUMBER);
					$result = $db->Query(MySQL::BuildSQLInsert($db->getPrefix()."_classes",$values));	
					if($result)
					{
						$db->Query("SELECT *,classid as id FROM ".$db->getPrefix()."_classes WHERE classid=".$db->GetLastInsertID());
						echo $db->GetJSON();
					
					}else 
						echo $db->Error();
					break;
				case 2:
					if(isset($_GET["day"]))$values["day"]= MySQL::SQLValue($_GET["day"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["starttime"]))$values["starttime"]= MySQL::SQLValue($_GET["starttime"],MySQL::SQLVALUE_TIME);
					if(isset($_GET["endtime"]))$values["endtime"] = MySQL::SQLValue($_GET["endtime"],MySQL::SQLVALUE_TIME);
					if(isset($_GET["capacity"]))$values["capacity"] = MySQL::SQLValue($_GET["capacity"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["courseid"]))$values["courseid"] = MySQL::SQLValue($_GET["courseid"],MySQL::SQLVALUE_NUMBER);
					if(isset($_GET["bath"]))$values["bath"] = MySQL::SQLValue($_GET["bath"]);
					$values["dateupdated"] =MySQL::SQLValue(date("m/d/Y H:i:s"),MYSQL::SQLVALUE_DATETIME);
					$values["updatedby"]=MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]),MySQL::SQLVALUE_NUMBER);
					$filter["classid"] =  MySQL::SQLValue($_GET["classid"],MySQL::SQLVALUE_NUMBER);
					if($db->Query(MySQL::BuildSQLUpdate($db->getPrefix()."_classes",$values,$filter)))
					{
						if(!is_array($_GET['trainors']))return;
						$db->Query(MySQL::BuildSQLDelete($db->getPrefix()."_classes_trainors",$filter));
						foreach($_GET["trainors"] as $key=>$val)
						{
							$values =  Array();
							$values["personid"] = MySQL::SQLValue( $val,MySQL::SQLVALUE_NUMBER);
							$values["classid"] =  MySQL::SQLValue($_GET["classid"],MySQL::SQLVALUE_NUMBER);
							$db->Query(MySQL::BuildSQLInsert($db->getPrefix()."_classes_trainors",$values));
						}
					
					}
					break;
			}
			break;
		case 1:
			switch($cmd)
			{
				case 0:
					$db->Query("SELECT *,courseid as id FROM ".$db->getPrefix()."_courses");
					echo $db->GetJSON();
					break;
				case 1:
					if(isset($_GET["coursecode"]))$values["coursecode"]= MySQL::SQLValue($_GET["coursecode"]);
					if(isset($_GET["title"]))$values["title"]= MySQL::SQLValue($_GET["title"]);
					if(isset($_GET["description"]))$values["description"] = MySQL::SQLValue($_GET["description"]);
					if(isset($_GET["fee"]))$values["fee"] = MySQL::SQLValue($_GET["fee"],MySQL::SQLVALUE_NUMBER);
					$values["createdby"]= MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]),MySQL::SQLVALUE_NUMBER);
					$result = $db->Query(MySQL::BuildSQLInsert($db->getPrefix()."_courses",$values));	
					if($result)
					{
						$db->Query("SELECT *,courseid as id FROM ".$db->getPrefix()."_courses WHERE courseid=".$db->GetLastInsertID());
						echo $db->GetJSON();
					
					}else 
						echo $db->Error();
					break;
				case 2:
					if(isset($_GET["coursecode"]))$values["coursecode"]= MySQL::SQLValue($_GET["coursecode"]);
					if(isset($_GET["title"]))$values["title"]= MySQL::SQLValue($_GET["title"]);
					if(isset($_GET["description"]))$values["description"] = MySQL::SQLValue($_GET["description"]);
					if(isset($_GET["fee"]))$values["fee"] = MySQL::SQLValue($_GET["fee"],MySQL::SQLVALUE_NUMBER);
					$values["dateupdated"] =MySQL::SQLValue(date("m/d/Y H:i:s"),MYSQL::SQLVALUE_DATETIME);
					$values["updatedby"]=MySQL::SQLValue($db->translate($_COOKIE["__amsuid"]),MySQL::SQLVALUE_NUMBER);
					$filter["courseid"] =  MySQL::SQLValue($_GET["courseid"],MySQL::SQLVALUE_NUMBER);
					$db->Query(MySQL::BuildSQLUpdate($db->getPrefix()."_courses",$values,$filter));
					break;
			}
			break;
		case 2:
			$db->Query("SELECT title as value,courseid as id FROM ".$db->getPrefix()."_courses");
	 		echo $db->GetJSON();
			break;
		case 3:
			$db->Query("SELECT Concat(firstname,' ',lastname) as value,".$db->getPrefix()."_persons.personid as id FROM (".$db->getPrefix()."_persons inner join ".$db->getPrefix()."_roles on ".$db->getPrefix()."_roles.personid=".$db->getPrefix()."_persons.PersonID) WHERE groupid=2");
	 		echo $db->GetJSON();
			break;
		case 4:
			$query = "SELECT classid as id,CONCAT( DATE_FORMAT( starttime,  '%h:%i %p' ) ,  ' - ', DATE_FORMAT( endtime,  '%h:%i %p' ) ,  ' - ', coursecode,  ' - ', trainors ) AS ".
					  " class FROM (SELECT classes.classid, courseid, starttime, endtime, trainors".
					  	" FROM (SELECT DAY , classes.classid AS classid, courseid, starttime, endtime, trainors".
					    	" FROM (SELECT classid, GROUP_CONCAT( trainor SEPARATOR  '/' ) AS trainors".
								" FROM (SELECT classid, firstname AS trainor".
									" FROM dss_classes_trainors AS trainors ".
										" LEFT JOIN dss_persons AS persons ON trainors.personid = persons.PersonID".
										" ) AS trainors".
										" GROUP BY classid".
										" ) AS trainor".
									" LEFT JOIN dss_classes AS classes ON trainor.classid = classes.classid".
								") AS classes".
							" LEFT JOIN dss_classes_trainors AS trainors ON trainors.classid = classes.classid".
							" WHERE personid =".$db->getPersonID()." AND DAY =".$cmd.
						") AS classes".
					" LEFT JOIN dss_courses AS courses ON courses.courseid = classes.courseid order by starttime";
			$db->Query($query);
			echo $db->GetJSON();
			break;
		 case 5:
		 	switch($cmd)
			{
				case 0:
					$counter = 0;
					while($counter<25 && !$db->HasRecords("SELECT ".$db->getPrefix()."_classes.*,".$db->getPrefix()."_classes.classid as id,trainors FROM (".$db->getPrefix()."_classes left join (SELECT classid,GROUP_CONCAT(personid) as trainors FROM ".$db->getPrefix()."_classes_trainors Group BY classid) as trainors on trainors.classid=".$db->getPrefix()."_classes.classid) WHERE DATEUpdated>'".$_GET['time']."' AND updatedby<>".$db->translate($_COOKIE["__amsuid"])))
					{
						sleep(1);
						$counter = $counter + 1;
					}
					echo $db->GetJSON();
					break;
				case 1:
					$counter = 0;
					while($counter<25 && !$db->HasRecords("SELECT *,courseid as id FROM ".$db->getPrefix()."_courses WHERE DATEUpdated>'".$_GET['time']."' AND updatedby<>".$db->translate($_COOKIE["__amsuid"])))
					{
						sleep(1);
						$counter = $counter + 1;
					}
					echo $db->GetJSON();
					break;
			}
			break;
	 }	
 }	
?>