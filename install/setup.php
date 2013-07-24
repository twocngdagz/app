<?PHP 
	error_reporting(0);
	if(isset($_POST["rewrite"])){		
			$dbhandle= mysql_connect($_POST["dbhost"],$_POST["dbusername"],$_POST["dbpass"]);
			if (!$dbhandle){
				die("Cannot connect to server. Please check your configuration.");
			}else{
				require_once("../includes/connection.php");
				$wdConnect = New MySQL();
				if($_POST['rewrite'] == "y"){
					if($wdConnect->changeConfig($_POST["dbhost"],$_POST["dbusername"],$_POST["dbpass"],$_POST["dbname"],$_POST["suffix"])){
								if(run_query_batch($dbhandle, $_POST["file"],$_POST["suffix"],$_POST["dbname"])){
									echo "../". $_POST["file"]."";
								}else {
									echo "SQL". $_POST["file"]." failed to write database.";
								}
					}
				}else {
					if(run_query_batch($dbhandle, $_POST["file"],$_POST["suffix"],$_POST["dbname"])){
						echo "../". $_POST["file"]."";
					}else {
						echo "SQL". $_POST["file"]." failed to write database.";
					}
				}
			}
	}
	function run_query_batch($handle, $filename="",$prefix='',$dbname='wdtemp'){
	  if (! ($fd = fopen($filename, "r")) ) {
		echo ("Failed to open $filename: " . msql_error() . "<br>");
	  }
	  $stmt='';
	  while (!feof($fd)) {
		$line = fgets($fd, 32768);
		$stmt = "$stmt$line";
		if (!preg_match("/;/", $stmt)) {
		  continue;
		}
		$stmt = preg_replace("/;/", "", $stmt);
		$stmt = preg_replace("/xxx/",$prefix."_",$stmt);
		$stmt = preg_replace("/master/",$prefix."_".$dbname,$stmt);
		if(!mysql_query($stmt, $handle) )  echo "Query failed: " . mysql_error() . "<br>";
	
		 
		$stmt = "";
	  }
	  fclose($fd);
	  return true;
	}
?>
