	<script type="text/javascript" src="../scripts/lib/jquery.js" ></script>  
	<link href="../styles/ui-gen.php?form&slider&password&cbox" rel="stylesheet" type="text/css"/>
	<script src="../scripts/core/notify.js"></script>
	<script src="../scripts/core/ui-gen.js"></script>
	<script src="../scripts/lib/jquery-ui.js"></script>
	<script src="../scripts/utils//frmwzrd.js"></script>
	<script src="../scripts/utils/validator.js"></script>
  	<script src="../scripts/utils/pwdwidget.js" ></script>  

<script>
	$(document).ready(function(){
	    $("#register").formToWizard();
		callback();
        });
	function animate (code){
		if(code){	
			$("#code").val(code);
		};
	};

	function callback(){
		$("#centerpos").css("display","inline");
		$("#login").addClass('centerposafter');
		$( "#td" ).show("slow");
		
	};
	
	function buttonFunction(a,b){
		if(b=="next" && a ==0)verify();
	}
</script>

<?PHP
	if(isset($_GET['code'])){
		$code = "'".$_GET['code']."'";
		echo '<body onload="animate('.$code.')">';
	};
?>

<div style="display:none" id="centerpos" align="center">
	<div id="hero-slider" style="margin:5%"; >
	    <div class="mask">
		<div class="panel" id="panel-1"><input id="nextstep" style="display:none">
			<div id="main" align="left" class="form">&nbsp;
        		<form id="register" title="Database Installation" action=""> 
             		<fieldset>
            			<legend>Verify account</legend>
                   			<table id="Step2" >
         					
						<tr>
	  		 				<td><label>Verification Code*:</label></td><td><input type="text" id="code"/></td><tr><td/><td><span class="error" id="error_code"></span></td></tr>
	 					</tr>
						<tr>
	  						<td><label>User Name:</label></td><td><input type="text" id="uname"/></span></td><tr><td/><td><span class="error" id="error_uname"></span></td></tr>
	 					</tr>
	 					<tr>
	  						<td><label>New Password:</label></td><td><div class='pwsdwidgetdiv' id='npass' ></div><span class="error" id="error_npass_id"></span></td></tr>
	 					</tr>
						<tr>
	  		 				<td><label>Re-enter Password:</label></td><td><input type="password" id="rpass"/></td><tr><td/><td><span class="error" id="error_rpass"></span></td></tr>
	 					</tr>
						<tr>
	  		 				<td colspan=2><a><i>*Please check your email for verification code.<i></a>
                       				</td></tr>
        				</table>
            			</fieldset>
        		</form>
   			</div>	
	        </div>
	    </div>
	</div>
<div>
<body>
<script>
    var pwdwidget = new PasswordWidget('npass','npass');
    pwdwidget.MakePWDWidget();
    
    function verify(){
		var ret = 0;
		ret1 = validateInput("code","req","- Required");
		ret2 = validateInput("uname","req","- Required");
		ret3 = validateInput("npass_id","minlen","- Minimum 6 characters","6");
		ret4 = validateInput("rpass","minlen","- Minimum 6 characters","6");
		ret5 = validateInput("rpass","compare","- Password do not match","npass_id");
		ret= ret1+ret2+ret3+ret4+ret5;
		if(ret==0) {
			verifyData();
		}
    };

 

   function verifyData(){
		$.ajax({
		type: "POST",
		url: "../admin/accounts/acc-cmd.php",
		data: "save=3&code="+$("#code").val()+"&uname="+$("#uname").val()+"&pass="+$("#rpass").val(),
		success: function(data){
				if(data.length<2){
					window.location.replace("/");
				} else{
					notify.notify(data);
				}
		}
		});        			
    };
   
</script>
<div class="noticebox"" >
	<div style="text-align:center"><span onclick='hidenotify()' class="ui-icon ui-icon-close" style="float:right"></span>
		<a id="notify" align="center"></a>
	</div>
</div>