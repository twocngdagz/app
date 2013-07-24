<?PHP
	ob_start();
	require_once("../includes/config/dbconfig.php");
	require_once("../includes/config/company_config.php");
	$Settings = New Settings();
?>
<title>Installation</title>
<link href="../styles/ui-gen.php?form&slider&password&pbar&dialog" rel="stylesheet" type="text/css"/>
<style>
.ui-progressbar-value {
	background-image: url(images/pbar-ani.gif);
}
</style>
<script src="../scripts/lib/jquery.js"></script>
<script src="../scripts/lib/jquery-ui.js"></script>
<script src="../scripts/core/notify.js"></script>
<script src="../scripts/core/ui-gen.js"></script>
<script src="../scripts/utils/frmwzrd.js"></script>
<script src="../scripts/utils/validator.js"></script>
<script src="../scripts/utils/pwdwidget.js"></script>

<script type="text/javascript">
	var page1='';
	var page2='';
	var page3='';
	var now = new Date();
	var start= now.getTime();
    $(document).ready(function(){
        $( "#install" ).formToWizard();
    });

	function runsql(url,data,element,num){
			var now= new Date();
			if(num>0){
				page1=1;
				$("#pbar").dialog("close");
				notify.notify("Installation completed.");
				nextpage(0);
			 	return false;
			}
			$.ajax({
			type: 'POST',
	        url: url,
			data: data,
			success: function(dat){
					if(dat!="Cannot connect to server. Please check your configuration.")
					{
						$("#"+element).html(dat);
					} else { $("#pbar").dialog("destroy");}
				}
			}).done(function(dat) {
					if(dat=="Cannot connect to server. Please check your configuration.")
					{
						notify.notify(dat);
					}
						else
					{ 
						var myobj= new Array("dbhost","dbname","dbusername","dbpass","cdbpass","suffix");
						var handle = testrequiredinput(myobj);
						var x =num/6 * 100;
						$("#pbar").dialog({title:"Installing files... "+x.toFixed(0)+"% " }).dialog("open");
							$(function() {
								$( "#pbar00" ).progressbar({
								value: x
							});
						});
						runsql("setup.php","rewrite=n"+handle[1]+"&file=import/dump_"+(num+1)+".sql","pdesc",(num+1));
					}
			});        			
	}
	function saveComp(){
	    var myobj= new Array("cname","wname","admin","csupport");
	    var handle = testrequiredinput(myobj);
	    if (handle) { 
		$.ajax({
			type: "post",
  			url: '../admin/accounts/acc-cmd.php',
			data: "save=2&cname="+$("#cname").val()+"&wname="+$("#wname").val()+"&tsupport="+$("#tsupport").val()+"&csupport="+$("#csupport").val()+"&accounting="+$("#accounting").val()+"&hresource="+$("#hresource").val()+"&admin="+$("#admin").val()+"&random="+$("#random").val(),
  			success: function(data) {
    			 if(data.length>10){
    				notify.notify(data);
				 } else {
					notify.notify("Company configuration saved.");
					$('#step1Next').html('Next >');
					page2=1;
					nextpage(1);
				}
			}
  		});
	    }
  	}
	function saveSettings(){
	    var myobj= new Array("dbhost","dbname","dbusername","dbpass","cdbpass","suffix");
	    var handle = testrequiredinput(myobj);
 		if (handle[0]==1) {  
		    if($("#dbpass").attr("value")!=$("#cdbpass").attr("value")){
				$("#registration_dbpass_errorloc").html("-Password do not match");	
		    } else {
				$("#registration_dbpass_errorloc").html("");
				$( "#pbar" ).dialog({
					autoOpen: false,
					resizable: false,
					width:500,
					height:100,
					modal: true,
					title: "Preparing resources..."
				});
				$("#pbar").dialog("open");
				runsql("setup.php","rewrite=y"+handle[1]+"&file=import/dump.sql","pdesc",0);		
				
		  	};  
	 	};
	
	}
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

    function createAccount(){
		var ret = 0;
		ret = ret + validateInput("fname","req","- Required");
		ret = ret + validateInput("lname","req","- Required");
		ret = ret + validateInput("email","req","- Required");
		ret = ret + validateInput("email","email","- Invalid Email Address");
		
		if(ret==0) {	
			register();
		}
    };

    function register(){
		$.ajax({
		type: "POST",
		url: "../admin/accounts/acc-cmd.php",
		data: "save=-1&fname="+$("#fname").val()+"&lname="+$("#lname").val()+"&emailadd="+$("#email").val(),
		success: function(data){
				if(data.length<2){
						notify.notify("Account successfuly created. <br/> Please check your email for verification code.");
						$('#step2Next').html('Next >');
						page3=1;
						nextpage(2);
				} else{
						notify.notify(data);
				}
				
		}
		});        			
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
	function nextpage(a){
			var stepName = "step" + a;
			$("#" + stepName).hide();
        	$("#step" + (a + 1)).toggle("slide");
        	selectStep(a + 1);
	}
	function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
    }		
	function testrequiredinput(objValue){
    	    var ret = 1;
	    	var data= "";
      		for (x in objValue){
			data = data +"&"+ $("#"+objValue[x]).attr("id")+"="+$("#"+objValue[x]).val();
    			if($("#"+objValue[x]).val().length == 0)
				{ 
					ret = 0;	
         			$('#registration_'+objValue[x]+'_errorloc').html("required");
       			} else {
				
				$('#registration_'+objValue[x]+'_errorloc').html("");
			}
      		};
			return  Array(ret,data);
    }
	function buttonFunction(a,b){
	    if(b=='submit') verify();
	    if(a==2 && page3==1)return true;
	    if(b=="next" && a==2) 	createAccount()
	    if(a==1 && page2==1)return true;
	    if(b=="next" && a==1) 	saveComp();
	    if(a==0 && page1==1)return true;
	    if(b=="next" && a==0)	saveSettings();
     };

	
</script>
<input style="display:none" id="nextstep"/>
<div id="centerpos" align="center">
  <div  id="main" align="left" class="form">
    <h3>Installation Setup</h3>
    <form  style="padding-bottom:10px;" id="install" title="Database Installation" action="">
      <fieldset >
        <legend>Database Configuration</legend>
        <table id="config">
          <tr>
            <td><label for='dbhost' >Server Name:</label></td>
            <td><input class="hideacc" type="text" name='dbhost' value="<?PHP echo $Settings->dbhost;?>" id='dbhost' title="Enter your database server here"/></td>
            <td><span id='registration_dbhost_errorloc' class='error'></span></td
			>
          </tr>
          <tr>
            <td><label for='dbname' >Database Username: </label></td>
            <td><input  class="hideacc" type="text" name='dbusername' value="<?PHP echo $Settings->dbusername;?>"maxlength="20" id='dbusername' title="Enter your database username"/></td>
            <td><span id='registration_dbusername_errorloc' class='error'></span></td>
          </tr>
          <tr>
            <td><label for='dbpass' >Database Password:</label></td>
            <td><input class="hideacc"  type='password' name='dbpass'  id='dbpass' maxlength="20" title="Enter your database password"/></td>
            <td><span id='registration_dbpass_errorloc' class='error'></span></td>
          </tr>
          <tr>
            <td><label for='cdbpass' >Confirm Password: </label></td>
            <td><input class="hideacc" type='password' name='cdbpass' maxlength="20" id='cdbpass' title="Confirm your database password"/></td>
            <td><span id='registration_cdbpass_errorloc' class='error'></span></td>
          </tr>
          <tr>
            <td><label for='dbname' >Database Name:</label></td>
            <td><input class="hideacc"  type="text" name='dbname' value="<?PHP echo $Settings->dbname;?>" id='dbname' title="Enter your database name"/></td>
            <td><span id='registration_dbname_errorloc' class='error'></span></td>
          </tr>
          <tr>
            <td><label for='suffix' >Prefix: </label></td>
            <td><input class="hideacc"  type="text" name='suffix' value="<?PHP echo $Settings->dbsuffix;?>" maxlength="3" id='suffix' title="Enter your database prefix name"/></td>
            <td><span id='registration_suffix_errorloc' class='error'></span></td>
          </tr>
        </table>
      </fieldset>
      <fieldset>
            	<legend>Account Setup</legend>
		    <table>			
			<tr>
			    <td><label for='dbhost' >Company Name:</label></td>
        		    <td><input class="hideacc" type="text" name='cname'  value="<?PHP echo $CompSettings->CompanyName;?>" id='cname' title="Enter your company name here"/></td><td><span id='registration_cname_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='suffix' >Website Name: </label></td>
        		    <td><input class="hideacc" type="text" name='wname' value="<?PHP echo $CompSettings->WebsiteName;?>" id='wname' title="Enter your website link"/></td><td><span id='registration_wname_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='dbname' >Technical Support Email: </label></td>
        		    <td><input  class="hideacc" type="text" name='tsupport' value="<?PHP echo $CompSettings->TechnicalSupport;?>"   id='tsupport' title="Enter your technical support email"/></td><td><span id='registration_dbusername_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='dbpass' >Client Support Email:</label></td>
              		    <td></a><input class="hideacc" type='text' name='csupport' value="<?PHP echo $CompSettings->ClientSupport;?>" id='csupport'  /></td><td><span id='registration_csupport_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='cdbpass' >Accounting Email: </label></td>
        		    <td></a><input class="hideacc"  type='text' name='accounting' value="<?PHP echo $CompSettings->CompanyName;?>" id='accounting' title="Enter your accounting email"/></td><td><span id='registration_cdbpass_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='dbname' >Human Resource Email:</label></td>
        		    <td><input class="hideacc" type="text" name='hresource' value="<?PHP echo $CompSettings->HumanResource;?>" id='hresource' title="Enter your human resource email"/></td><td><span id='registration_dbname_errorloc' class='error'></span></td>
			</tr>
			<tr>
			    <td><label for='suffix' >Admin Email: </label></td>
        		    <td><input class="hideacc" type="text" name='admin' value="<?PHP echo $CompSettings->Admin;?>" id='admin' title="Enter your admin email"/></td><td><span id='registration_admin_errorloc' class='error'></span></td>
			</tr>
			<tr>	
			    <td><label for='suffix' >Random Key: </label></td>
        		    <td></a><input class="hideacc"  type="text" value="<?PHP echo $CompSettings->Random;?>" name='random' id='random' title="Enter random key"/></td><td><span id='registration_suffix_errorloc' class='error'></span></td>
			</tr>
		    </table> 
            </fieldset>
      <fieldset >
        <legend>Create Administrator</legend>
        <table  id="Step1">
          <tr>
            <td><label>First Name:</label></td>
            <td><input type="text" id="fname"/>
              </span></td>
          <tr>
            <td/>
            <td><span class="error" id="error_fname"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>Last Name:</label></td>
            <td><input type="text" id="lname"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_lname"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>Email Address:</label></td>
            <td><input type="text" id="email"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_email"></span></td>
          </tr>
            </tr>
          
        </table>
      </fieldset>
      <fieldset>
        <legend>Verify account</legend>
        <table id="Step2" >
          <tr>
            <td><label>Verification Code*:</label></td>
            <td><input type="text" id="code"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_code"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>User Name:</label></td>
            <td><input type="text" id="uname"/>
              </span></td>
          <tr>
            <td/>
            <td><span class="error" id="error_uname"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>New Password:</label></td>
            <td><div class='pwsdwidgetdiv' id='npass' ></div>
              <span class="error" id="error_npass_id"></span></td>
          </tr>
            </tr>
          <tr>
            <td><label>Re-enter Password:</label></td>
            <td><input type="password" id="rpass"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_rpass"></span></td>
          </tr>
            </tr>
          <tr>
            <td colspan=2><a><i>*Please check your email for verification code.<i></a></td>
          </tr>
        </table>
      </fieldset>
    </form>
  </div>
</div>

</body>
<script>
    var pwdwidget = new PasswordWidget('npass','npass');
    pwdwidget.MakePWDWidget();
</script>
<div class="noticebox"" >
  <div style="text-align:center"><span onclick='notify.close()' class="ui-icon ui-icon-close" style="float:right"></span> <a id="notify" align="center"></a> </div>
</div>
</div>
<div id="pbar">
  <div id="pbar00"></div>
  <div id="pdesc"></div>
</div>
