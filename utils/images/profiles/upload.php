<?php 

 define ("MAX_SIZE","1000");

 $errors=0;
 
 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
        $image =$_FILES["file"]["name"];
 		$uploadedfile = $_FILES['file']['tmp_name'];

  if ($image) 
  {
  		$filename = stripslashes($_FILES['file']['name']);
        $extension = getExtension($filename);
 	 	$extension = strtolower($extension);
 		if (($extension != "jpg") && ($extension != "jpeg") 
		&& ($extension != "png") && ($extension != "gif")) 
		  {
		echo 'Invalid file format.';
		$errors=1;
		  }
		 else
		{
   			$size=filesize($_FILES['file']['tmp_name']);
 
			if ($size > MAX_SIZE*1024)
			{
			 echo "Maximum file size limit is 1mb." ;
			 $errors=1;
			}
 
			if($extension=="jpg" || $extension=="jpeg" )
			{
			$uploadedfile = $_FILES['file']['tmp_name'];
			$src = imagecreatefromjpeg($uploadedfile);
			}
			else if($extension=="png")
			{
			$uploadedfile = $_FILES['file']['tmp_name'];
			$src = imagecreatefrompng($uploadedfile);
			}
		else 
		{
			$src = imagecreatefromgif($uploadedfile);
		}
 
		list($width,$height)=getimagesize($uploadedfile);

$newwidth=126;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

$newwidth1=64;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,
 $width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, 
$width,$height);
$targetFolder = '/utils/images/profiles';
$filename =   getcwd(). "/". $_POST['profileid'].'.jpg';
$filename1 = getcwd() . "/small/".  $_POST['profileid'].'.jpg';

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
}
}
}
//If no errors registred, print the success message

 if( !$errors) 
 {
   // mysql_query("update SQL statement ");
  echo "Image Uploaded Successfully!";

 } else  echo "failed";
 function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 ?>