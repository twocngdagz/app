<?PHP
ob_start();
	function dynRoot(){$relativeDir="";$levels = substr_count($_SERVER['PHP_SELF'],"/"); for ($i=0; $i < $levels - 1; $i++){$relativeDir ="../"; }return $relativeDir; } 
	define('__ROOT__',((dynRoot())?dynRoot():"/"));
	require_once(__ROOT__."includes/config/dbconfig.php");
	$Settings = New Settings();
?>
<title>Installation</title>
<link href="<?PHP echo __ROOT__;?>styles/ui-gen.php?form&slider&password&pbar&dialog" rel="stylesheet" type="text/css"/>
<style>
.ui-progressbar-value {
	background-image: url(images/pbar-ani.gif);
}
</style>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/frmwzrd.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.ui.core.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.effects.core.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.effects.slide.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.scrollto.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/notify.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.ui.widget.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.ui.progressbar.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.ui.dialog.js"></script>
<script src="<?PHP echo __ROOT__;?>scripts/jquery.ui.position.js"></script>
<script type="text/javascript">
	var page1='';
	var page2='';
	var page3='';
	
    $(document).ready(function(){
        $( "#install" ).formToWizard();
	    $( "#config" ).show("slide",500);
    });
		
	function runsql(url,data,element,num){
			if(num>1){
				$('#step0Next').html('Next >');
				page1=1;
				nextpage(0);
				$("#pbar").dialog("close");
			 	return false;
			}
			$.ajax({
			type: 'POST',
	        url: url,
			data: data,
			success: function(dat){
				dats = dat;
				$("#"+element).html(dat);
				}
			}).done(function() { 
					
					var myobj= new Array("dbhost","dbname","dbusername","dbpass","cdbpass","suffix");
	    			var handle = TestRequiredInput(myobj);
					var x =num/1 * 100;
					$("#pbar").dialog({title:"Installing files... "+x.toFixed(0)+"%"}).dialog("open");
				$(function() {
					$( "#pbar00" ).progressbar({
					value: x
				});
	});
  					runsql("setup.php","rewrite=n"+handle[1]+"&file=import/part00_"+(num+1)+".sql","pdesc",(num+1));
			});        			
	}
	
	function SaveSettings(){
	    var myobj= new Array("dbhost","dbname","dbusername","dbpass","cdbpass","suffix");
	    var handle = TestRequiredInput(myobj);
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
				runsql("setup.php","rewrite=y"+handle[1]+"&file=import/part00_-1.sql","pdesc",-1);
			
			
					
		  	};  
	 	};
	  					
	}

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
			
	function TestRequiredInput(objValue){
    	    var ret = 1;
	    	var data= "";
      		for (x in objValue){
			data = data +"&"+ $("#"+objValue[x]).attr("id")+"="+$("#"+objValue[x]).attr("value");
    			if($("#"+objValue[x]).attr("value").length == 0)
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
	    if(b=="next" && a==2) {createaccount();};
	    if(a==1 && page2==1)return true;
	    if(b=="next" && a==1) {savecomp();};
	    if(a==0 && page1==1)return true;
	    if(b=="next" && a==0) {SaveSettings();};
        };

	function savecomp(){
	    var myobj= new Array("cname","wname","admin","csupport");
	    var handle = TestRequiredInput1(myobj);
	    if (handle) { 
		$.ajax({
			type: "post",
  			url: 'admin/settings/setup.php',
			data: "rewrite_com=y&cname="+$("#cname").attr("value")+"&wname="+$("#wname").attr("value")+"&tsupport="+$("#tsupport").attr("value")+"&csupport="+$("#csupport").attr("value")+"&accounting="+$("#accounting").attr("value")+"&hresource="+$("#hresource").attr("value")+"&admin="+$("#admin").attr("value")+"&random="+$("#random").attr("value"),
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
	
</script>
<input style="display:none" id="nextstep"/>
<?PHP
	if(isset($_GET['code'])){
		$code = "'".$_GET['code']."'";
		echo '<body onload="verifyshow('.$code.')">';
	}
?>
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
            <td><input class="hideacc"  type="text" name='dbname' value="<?PHP echo $Settings->dbname;?>"id='dbname' title="Enter your database name"/></td>
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
        <legend>Create Administrator</legend>
        <table  id="Step1">
          <tr>
            <td><label>Username:</label></td>
            <td><input type="text" id="uname" title="Enter desired username"/>
              </span></td>
          <tr>
            <td/>
            <td><span class="error" id="error_fname"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>Create Password:</label></td>
            <td><input type="text" id="pwd" title="Create password"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_lname"></span></td>
          </tr>
            </tr>
          
          <tr>
            <td><label>Confirm Password:</label></td>
            <td><input type="text" id="vpwd" title="Verify password"/></td>
          <tr>
            <td/>
            <td><span class="error" id="error_lname"></span></td>
          </tr>
            </tr>
          
        </table>
      </fieldset>
    </form>
  </div>
</div>

</body>
<script>
    var pwdwidget = new PasswordWidget('pwd','pwd');
    pwdwidget.MakePWDWidget();
    function verifyshow(code){
		nextpage(2);
		$("#code").val(code);
		$("#step0").hide();$('.prev').hide();
    };
    function verify(){
		var ret = 0;
		ret1 = validateInput("code","req","- Required");
		ret2 = validateInput("uname","req","- Required");
		ret3 = validateInput("npass_id","minlen","- Minimum 6 characters","6");
		ret4 = validateInput("rpass","minlen","- Minimum 6 characters","6");
		ret5 = validateInput("rpass","compare","- Password do not match","npass_id");
		ret= ret1+ret2+ret3+ret4+ret5;
		if(ret==0) {	
			Verifydata();
		}
    };

    function createaccount(){
	var ret = 0;
	ret = ret + validateInput("fname","req","- Required");
	ret = ret + validateInput("lname","req","- Required");
	ret = ret + validateInput("email","req","- Required");
	ret = ret + validateInput("email","email","- Invalid Email Address");
	
	if(ret==0) {	
		Register();
	}
    };

   
   function Verifydata(){
	$.ajax({
	type: "POST",
	url: "admin/settings/register.php",
	data: "verify=y&code="+$("#code").val()+"&uname="+$("#uname").val()+"&pass="+$("#rpass").val(),
	success: function(data){
			if(data.length<2){
				window.location.replace("/dashboard");
			} else{
				notify.notify(data);
			}
				
	}
	});        			
    };

</script>
<div class="noticebox"" >
  <div style="text-align:center"><span onclick='hidenotify()' class="ui-icon ui-icon-close" style="float:right"></span> <a id="notify" align="center"></a><a id="notify0" align="center"></a> </div>
</div>
<div id="pbar">
  <div id="pbar00"></div>
  <div id="pdesc"></div>
</div>
