<?PHP
	ob_start();
	session_start();
	include("../includes/connection.php");
	$db = new MySQL;
	$db->Open();
	if(!$db->Login()){
		header("Location:../login");
	}
	//Get target within ams folder
	$targetFolder = dirname(dirname( $_SERVER['SCRIPT_FILENAME'])).'/utils/images/profiles/small'; 
	$isProfilePicExist = 0;
	if (file_exists($targetFolder . '/'.$db->translate($_COOKIE["__amsuid"]).".jpg")) {
		$isProfilePicExist= 1;
	}
?>
<html>
<head>
<title>Dashboard</title>
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="X-UA-Compatible" content="IE=10" />
<link rel="stylesheet" href="../styles/ui-gen.php?theme=dss&form&scroll&jqgrid&chat">
<script data-main="../scripts/app" src="../scripts/lib/require.js"></script>
<script src="../scripts/lib/jquery.js"></script>
<script src="../scripts/lib/jquery-ui.js"></script>
<script src="../scripts/lib/json2.js"></script>
<script src="../scripts/lib/underscore.js"></script>
<script src="../scripts/utils/date.js"></script>
<script src="../scripts/core/notify.js"></script>
<script src="../scripts/core/ui-gen.js"></script>

<script src="../scripts/core/frmcmd.js"></script>
<script src="../scripts/controls/jquery.gridster.js"></script>
<script src="../scripts/controls/messi.min.js"></script>
<style>
#forms * {
	font-size: 11px;
}
.gridster li {
	box-shadow: 4px 2px 2px 0px #aaa;
	border-radius:4px;
	background:#eee;
}
#chatbox {
	bottom:5px;
}
#chatcontent li:hover {
	cursor:pointer;
	background: lightblue;
}
.slick-cell.editable {
	z-index: 1005;
}
.slick-headerrow-column {
	z-index: 1005;
	width:100px;
}
.slick-header-columns {
	line-height:25px;
	text-align:center;
	height:25px;
}
.slick-cell{
	padding:4px;	
}
.slick-header-column {
	background: url(../styles/images/header_background.jpg);
	color:#fff;
}
#status {
	margin-top:5px;
	border:none;
	height:20px;
	box-shadow:none;
}
#statustext {
	border:none;
	padding:none;
	font-size:11px;
	float:right;
 	position;
	relative;
	background: none;
	width:60px;
}
.dd-selected {
	padding:2px;
}
.gridtitle {
	background:#ddd;
	padding-left:5px;
	margin-bottom:10px;
	height:34px;
	color:rgb(55,96,146);
	border: 1px #ddd solid;
	line-height:30px;
	font-size:14px;
	font-weight:bold;
}
.gridimg {
	height:30px;
	width:30px;
	padding:4px;
	cursor:pointer;
	float:left;
}
.gridtext {
	float:left;
}
</style>
</head>
<body>
<div id="header">
  <div style="float:left" id="title">Main Menu - <?PHP echo $_COOKIE["__amsufn"]." ". $_COOKIE["__amsuln"];?></div>
  <div onClick="menu.logout()" style="cursor:pointer; width:50px; float:right; background: transparent url(../styles/images/logout.png) no-repeat;background-size:45px 45px;" id="title">&nbsp;</div>
</div>
<div id="leftnav">
  <table id="profiletable" style="color:#fff" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="middle" rowspan="4"><img class="profile profilesmall" src="<?PHP if($isProfilePicExist==1)echo "../utils/images/profiles/small/".$db->translate($_COOKIE["__amsuid"]).".jpg?=var=".rand() ;else echo "../styles/images/contactpic.png"; ?>"/></td>
      <td valign="middle"><br/>
        <a class="profilename" id="fname"><?PHP echo $_COOKIE["__amsufn"];?> </a><br/>
        <a class="profilename" id="lname"><?PHP echo $_COOKIE["__amsuln"];?></a><br/>
        <a class="profilename" style="font-size:10px;font-style:italic"><?PHP echo (($db->translate($_COOKIE["__amsuid"])==3)?"Owner":"");?></a></td>
    <tr>
      <td >&nbsp;</td>
    </tr>
  </table>
  <div style="border-top:1px solid #fff;padding:3px;">&nbsp;</div>
  <div class="dashmenu" onClick="menu.profile()">
    <div style="background: transparent url(../styles/images/profile.png) no-repeat;	background-size:20px 20px;" class="dashmenuicon"></div>
    <a class="dashmenulink" >Profile</a> </div>
  <div class="dashmenu"  onclick="menu.settings()">
    <div style="background: transparent url(../styles/images/settings.png) no-repeat;	background-size:25px 25px;" class="dashmenuicon1"></div>
    <a class="dashmenulink">Settings</a> </div>
  <div id="chatbox">
    <div style="padding:5px;"><img src="../styles/images/chat.gif" height="20px"><img src="../styles/images/window.png" height="20px"><a class="dashmenulink" style="float:right">Virtual Office</a>
      <div style="clear:both;width:50px"><span id="status"></span></div>
    </div>
    <div id="chatcontent" style="clear:both" >
      <ul style="list-style:none" id="chatlist">
        <div align="center"><b><i>Loading</i></b> <img src="../styles/images/ajax.gif" width="30px" height="10px" style="margin-left:10px"/></div>
      </ul>
    </div>
  </div>
</div>
<div  id="content">
  <div class="gridster" style="height:100%;" >
    <ul style="background:none; list-style-type:none;margin-left:15px;">
      <li id="grid1" run="courseschedules" data-row="1" data-col="1" data-sizex="4" data-sizey="3">
        <div class="gridtitle"><img src="../styles/images/app.png" title="Click to launch Course Schedules main menu." onClick="window.location.replace('courseschedules')" class="gridimg"/><a style="gridtext">My Class Schedules</a><a class="fullsize" style="float:right;padding-right:10px">x</a></div>
      </li>
      <li  id="grid2" data-row="1" data-col="2" data-sizex="2" data-sizey="2">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">Announcements</a></div>
      </li>
      <li  id="grid3" run="calendar" data-row="1" data-col="1" data-sizex="4" data-sizey="4">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">My Calendar</a></div>
      </li>
      <li id="grid4" data-row="3" data-col="1" data-sizex="4" data-sizey="2">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">Messages</a></div>
      </li>
      <li id="grid5" data-row="5" data-col="1" data-sizex="2" data-sizey="1">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">Overdue Payments</a></div>
      </li>
      <li id="grid6" data-row="6" data-col="1" data-sizex="2" data-sizey="1">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">Waiting List</a></div>
      </li>
      <li id="grid7" data-row="5" data-col="3" data-sizex="4" data-sizey="2">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">2013 Revenue</a></div>
      </li>
      <li id="grid8" data-row="5" data-col="5" data-sizex="2" data-sizey="2">
        <div class="gridtitle"><img src="../styles/images/app.png" class="gridimg"/><a style="gridtext">Reports</a></div>
      </li>
    </ul>
  </div>
</div>
<div id="forms"  style="display:none;"> </div>
</body>
<script>
	var chatbox = new Array();
	var intervals = new Array();
	$(document).ready(function(){
		$("#content").width($(window).width()-$("#leftnav").width()-20);
		$("#content, #leftnav").height($(window).height()-46);
		$("#chatbox").height($("#content").height()-220);
		
		$(window).resize(function(e) {
            $("#content").width($(window).width()-180);
			$("#content").height($(window).height()-(($.browser.msie)?50:100));
			$("#leftnav").height($(window).height()-50);
			$("#chatbox").height($("#content").height()-220);
		
        });
		
		$("body").disableSelection();

		
		
		//Load virtual office		
		require(['controls/virtualoffice'],function(){
			virtualoffice.option.serverDate = <?PHP echo "'".date("m/d/Y H:i:s")."'";?>;
			virtualoffice.init();
		});
		
		//Load gridters
		$(".gridimg").tooltip();
		$(".gridster").hide();
		
		require(['controls/jquery.scroll'],function(){
			$(".gridster").mCustomScrollbar({
					autoDraggerLength:false,
					theme:"dark",
					scrollButtons:{
						enable:true
					},
					advanced:{
						updateOnContentResize: true
					}
			});
			
			
		});
		$(".gridtitle").mousedown(function(e) {
            $(this).css("cursor","pointer");
        });
		$(".gridtitle").mouseup(function(e) {
            $(this).css("cursor","default");
        });
		//Load widgets positions
		sendAjax("POST","../api/storage.php","type=load").done(function(dat){
			if(dat)
			{
				
				var data = $.parseJSON(dat);
				 for(var i=0; i<data.length; i++)
				{
					if($("#"+data[i].id).length>0)
					{
						$("#"+data[i].id)
							.attr("data-row",data[i].row)
							.attr("data-col",data[i].col);
							//.attr("data-sizex",data[i].sizex)
							//.attr("data-sizey",data[i].sizey);
					}
				}
			}
			//show the grid after setting each elements properties
			$(".gridster").show();
			
			var gridster = $(".gridster ul").gridster({
        		widget_margins: [5, 5],
        		widget_base_dimensions: [130,80],
				draggable: {
					handle: ".gridtitle, .gridtext",
					stop: function(e){
						var griddata =[];
						$(".gridster ul li").each(function(index, element) {
							var ul =new Object();
							ul.id = $(this).attr("id");
							ul.row = $(this).attr("data-row");
							ul.col = $(this).attr("data-col");
							ul.sizex = $(this).attr("data-sizex");
							ul.sizey = $(this).attr("data-sizey");
							
							griddata[griddata.length]=ul;
						});
						sendAjax("POST","../api/storage.php","type=save&value="+JSON.stringify(griddata));	
					}
				}	
    		}).data('gridster');
			widget.load();
		});
		
		require(['../scripts/controls/jquery.ddslick.min.js'],function(){
			$('#status').ddslick({
					data: ddData,
					width:40,
					truncateDescription: true,
					selectText: "Set status",
					defaultSelectedIndex: 0
			});
		});
	});
	 var menu = 
	 { 
		'refresh': function(){
		 		var d = new Date();
				$(".profilebig").attr("src","../utils/images/profiles/<?PHP echo $db->translate($_COOKIE["__amsuid"]); ?>.jpg?s="+d.toTimeString()	);
				$(".profilesmall").attr("src","../utils/images/profiles/small/<?PHP echo $db->translate($_COOKIE["__amsuid"]); ?>.jpg?s="+ d.toTimeString()	); 
	 			$("#fname").html(readCookie("_ufn").replace(/%20/," "));
				$("#lname").html(readCookie("_uln").replace(/%20/," "));
		},
		'logout':  function(){
			notify.notify("Signing out...");
			window.location.replace("../login/logout.php"); 
		}, 
		'profile':function (){
				 	var d =new Date();
					$(".formcss").remove();
					var link= $("<link class='formcss'/>");
					link.attr({
							type: 'text/css',
							rel: 'stylesheet',
							href: 'forms/profile.css?d='+ d.toTimeString()
					});
					$("head").append( link ); 
					require(['css!../styles/ui-gen.php?theme=dss&part&messi&chosen&','controls/chosen.jquery'],function(){
						runsql("forms/profile.php?d="+new Date().valueOf(),"","forms").pipe(function(s){
							$("#forms").dialog({title:"Profile",modal:true,width:640,resizable:false});
								setOptions();
							});
					});
					
		},
		'settings':function (){
					alert("In Progress..");return;
			 		var d =new Date();
				 	runsql("forms/settings.php?="+ d.toTimeString(),"","forms").pipe(function(s){$("#forms").dialog({title:"Profile",modal:true,width:640,resizable:false});}).done();
		} 
	 };	
	 
	 
	 
	 require(["utils/jquery.idle-timer"], function($) {
		(function($){
			var timeout = 60000;
			var d = new Date();
			$(document).bind("idle.idleTimer", function(){
				sendAjax("GET","../api/messaging.php","cmd=1&status=2&d="+d.valueOf());
			});
				
			$(document).bind("active.idleTimer", function(){
				sendAjax("GET","../api/messaging.php","cmd=1&status=1&d="+d.valueOf());
			});			
			$.idleTimer(timeout);
		 });
	 });
	 
	 var ddData = [
                {
                   // text: "Online",
                    value: "1",
                    imageSrc: "../styles/images/online.png"
                },
                {
                   // text: "Offline",
                    value: "2",
                    imageSrc: "../styles/images/idle.png"
                },
                {
                    //text: "Away",
                    value: "3",
                    imageSrc: "../styles/images/offline.png"
                }
     ];
	 
	 var widget = 
	 {
		"load":function(){
			$(".gridster ul li").each(function(index, element) {
				var obj = $(this);
				if(typeof obj.attr("run")!= "undefined")
				{
					$.getScript("widgets/"+obj.attr("run")+".js",function(){
							widget[obj.attr("run")](obj);
				
					});
					
					
				}
                	
            });
		}
	 }
</script>
