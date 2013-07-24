<?PHP
	require_once("includes/connection.php");
	$db = new MySQL();
	if (!$db->Open()){
		header("Location:install");
		die('');
	}
	if(!$db->Login()){
		
		header("Location:login");
	}
	else
	{
		header("Location:app");
	}
?>

=
