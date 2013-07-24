<?PHP
	ob_start();
	session_start();
	include("../../includes/connection.php");
	$db = new MySQL();
	$db->open();
	$targetFolder = dirname(dirname(dirname( $_SERVER['SCRIPT_FILENAME']))).'/utils/images/profiles/'; 
	$isProfilePicExist = "../styles/images/default.png";
	if (file_exists($targetFolder . '/'.$db->translate($_COOKIE["__amsuid"]).".jpg")) {
		$isProfilePicExist= "../utils/images/profiles/".$db->translate($_COOKIE["__amsuid"]).".jpg?var=".rand();
	}
	
	$db->Query("SELECT country_id as id,name FROM ".$db->getPrefix()."_countries");
	$stack = array();
	$db->MoveFirst();
	while (! $db->EndOfSeek()) {
		$row = $db->Row();
	   	array_push($stack, array($row->id,$row->name));
	}
	$countries = $stack;
?>
</head>
<div id="profilebox" style="padding:10px;margin:5px">
  <table width="300px">
    <tr id="editprofile">
      <td><img src="<?PHP echo $isProfilePicExist ?>" style="height:120px;width:100px;padding:5px;margin:5px;border:solid 1px #999;" id="image_upload" class="profilebig"/><a id="changephoto">&nbsp;</a></td>
      <td valign="top"><div style="margin:5px;">
           <input type="hidden" value="<?PHP $db->translate($_COOKIE["__amsuid"]);?>" name="PersonID" id="PersonID"/>
          <input id="firstname" name="firstname"  placeholder="First Name" value="" class="inlinetext bold"/><br/>
          <input id="lastname" name="lastname" placeholder="Last Name" value="" class="inlinetext bold"/><br/>
          <a class="italic">My Position</a>
        </div></td><td><button onclick="updatePerson()" style="position:absolute;top:15px;right:15px;">Update & Close</button></td>
    </tr>
    </table>
        <div class="tabbed_area">
        <ul class="tabs">
          <li><a href="javascript:tabSwitch_1(1,3,1,1);" id="1_1" class="active">Basic Info</a></li>
           <li><a href="javascript:tabSwitch_1(2,3,1,1);" id="1_2" class="active">Contact</a></li>
          <li><a href="javascript:tabSwitch_1(3,3,1,1);" id="1_3">Other Info</a></li>
        </ul>
        <div id="c1_1" class="content">
          <div style="padding:2px">
			<table>
            <tr valign="top">
              <td  width="100"><a>Gender</a></td>
              <td> <select id="gender" name="gender"  data-placeholder="Select Option" value="" ><option></option><option value="0">Male</option><option value="1">Female</option></select></td>
              <td rowspan="10"><div id="map"><img class='map' src="../styles/images/world.gif"/></div></td>
            </tr>
            <tr valign="top">
              <td  width="100"><a>Birthdate</a></td>
              <td >  <input id="dateofbirth" name="dateofbirth" placeholder="Birth Date" value="" class="dp"/></td>
            </tr>
            <tr>
              <td><a>Language</a></td>
              <td><input id="language" name="language" placeholder="Language" value="" /></td>
            </tr>
            <tr>
              <td><a>Address</a></td>
              <td><input id="location" name="address" placeholder="Location" value="" /></td>
            </tr>
            <tr>
              <td><a>City</a></td>
              <td><input id="city" name="city" placeholder="Location" value=""/></td>
            </tr>
             <tr>
              <td><a>Country</a></td>
              <td><select id="country" name="nationalitycountry" data-placeholder="Select your country" value="" ><option></option>
             <?PHP 
			 	foreach($countries as $value => $text) {
					echo '<option value="', $text[0], '"';
					echo '>', $text[1], '</option>';
				}	
			?>
              </select></td>
            </tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><tr><td>&nbsp;</td></tr><tr><tr><td>&nbsp;</td></tr><tr>
          </table>
          </div>
        </div>
        <div id="c1_2" class="content">
          <div style="padding:2px"> </div>
          	<table>
            <tr valign="top">
              <td  width="100"><a>Contact number</a></td>
              <td><input id="contactnumber" name="contactnumber" placeholder="contactnumber" value=""/></td>
            </tr>
            </table>
    </div>
        <div id="c1_3" class="content">
          <div style="padding:2px">
            <div class="grid-header"></div>
            <div  class="gridbox" id="gridbox" style="height:250px;width:100%;" ></div>
            <div id="pager" style="width:100%;height:20px;"></div>
          </div>
        </div>
    </div>
	
</div>
<div id="upload" style="display:none">
	<div>
	<form action="../utils/images/profiles/upload.php" method="post" name="sleeker" id="uploadform"  target="response" enctype="multipart/form-data">
        <input type="hidden" name="profileid" value="<?PHP echo $db->translate($_COOKIE["__amsuid"]);?>" />
        <p><input type="file" name="file" /></p>
        <iframe name="response" id="uploadresponse" style="display:none" ></iframe>
		<div id="upload_area">Maximum file size is 1mb.</div>
        <br/>
        <button style="float:right;margin-bottom:5px;" >Upload</button>
    </form>
    </div>
</div>
<script>
		var hide=true;
		tabSwitch_1(1,3,1,1);
		$("#image_upload").mouseover(function(e) {
            $("#changephoto").show();
        });
		$("#image_upload").mouseout(function(e){
			hide =true;
			setTimeout(hideEditButton,300);
		})
		$("#changephoto").mouseover(function(e){
			hide=false;
		});
		$("#changephoto").click(function(e) {
			$("#upload").dialog({
				modal:true,
				title: "Upload photo",
				height:150,
				resizable:false
			});
        });
		
		$("#uploadresponse").load(function(e) {
           var response = $(this).contents().find("html").find("body").html();
			 notify.notify(response);
			 if (response.length>0) {
				  $("#upload_area").html("Maximum file size is 1mb.");
				  $("#upload button").button("enable");
				  $("#upload").dialog("close");
				  var d = new Date();      
				  $(".profilebig").attr("src","../utils/images/profiles/<?PHP echo $db->translate($_COOKIE["__amsuid"]); ?>.jpg?s="+d.toTimeString()	);
				  $(".profilesmall").attr("src","../utils/images/profiles/small/<?PHP echo $db->translate($_COOKIE["__amsuid"]); ?>.jpg?s="+ d.toTimeString()	);
			 }
		 });
		
		$("#uploadform").submit(function(e) {
            $("#upload button").button("disable");
			$("#upload_area").html("Uploading...");
        });
				
		function updatePerson(){
			validates('profilebox',1,'../admin/accounts/acc-cmd.php',true).pipe(function(s)
				{
					var result = $("#notify").html();
					
					if(result == "Account sucessfully updated.")
					{
						setCookie("_ufn",$("#firstname").val(),7);
						setCookie("_uln",$("#lastname").val(),7);
						$("#forms").dialog("close");
					}
				});	
		}
		function hideEditButton(){
			if(hide)$("#changephoto").hide();	
		}
		
		function tabSwitch_1(active, number, tab_prefix, content_prefix) { 
			tab_prefix = tab_prefix + "_" ;
			content_prefix = "c"+content_prefix+ "_"; 
			for (var i=1; i < number+1; i++) {  
			  document.getElementById(content_prefix+i).style.display = 'none';  
			  document.getElementById(tab_prefix+i).className = '';  
			}  
			document.getElementById(content_prefix+active).style.display = 'block';  
			document.getElementById(tab_prefix+active).className = 'active';      
		} 
		
		

		function setOptions(){
			
            $("select").chosen({
		 		max_selected_options: 5	
			});
			
			
			$(".dp").datepicker();
			$("#city,#country,#location").change(function(e) {
            	$("#map").html('<img src="http://maps.googleapis.com/maps/api/staticmap?center='+$("#location").val()+","+$("#city").val()+","+$("#country option:selected").text()+'&zoom=14&size=300x300&sensor=false" class="map"/>')
        	});
			$("button").button();
			
			x = runsql("../admin/accounts/acc-cmd.php", "save=4&useridedit=<?PHP echo $db->translate($_COOKIE["__amsuid"]);?>","profilebox",'',true);
			x.pipe(function(){
			$('.inlinetext').each(function(index, element) {
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
			
			$("select").trigger("liszt:updated");
			$("#map").html('<img src="http://maps.googleapis.com/maps/api/staticmap?center='+$("#location").val()+","+$("#city").val()+","+$("#country option:selected").text()+'&zoom=14&size=300x300&sensor=false" class="map"/>')
			});
        };
</script>
