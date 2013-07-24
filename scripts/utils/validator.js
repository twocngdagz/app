/*
  -------------------------------------------------------------------------
            JavaScript Form Validator (gen_validatorv31.js)
              Version 3.1
   Copyright (C) 2003-2008 JavaScript-Coder.com. All rights reserved.
   You can freely use this script in your Web pages.
   You may adapt this script for your own needs, provided these opening credit
    lines are kept intact.
      
   The Form validation script is distributed free from JavaScript-Coder.com
   For updates, please visit:
   http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
   
   Questions & comments please send to support@javascript-coder.com
  -------------------------------------------------------------------------  
*/
function  sfm_show_error_msg(strError,objValue){
        $("#"+objValue).show("shake",100);
	$("#error_"+objValue).html(strError);
}
function validateEmail(email)
{
    var splitted = email.match("^(.+)@(.+)$");
    if(splitted == null) return false;
    if(splitted[1] != null )
    {
      var regexp_user=/^\"?[\w-_\.]*\"?$/;
      if(splitted[1].match(regexp_user) == null) return false;
    }
    if(splitted[2] != null)
    {
      var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
      if(splitted[2].match(regexp_domain) == null) 
      {
       var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
       if(splitted[2].match(regexp_ip) == null) return false;
      }// if
      return true;
    }
return false;
}

function IsCheckSelected(objValue,chkValue)
{
    var selected=false;
   var objcheck = objValue.form.elements[objValue.name];
    if(objcheck.length)
   {
      var idxchk=-1;
      for(var c=0;c < objcheck.length;c++)
      {
         if(objcheck[c].value == chkValue)
         {
           idxchk=c;
          break;
         }//if
      }//for
      if(idxchk>= 0)
      {
        if(objcheck[idxchk].checked=="1")
        {
          selected=true;
        }
      }//if
   }
   else
   {
      if(objValue.checked == "1")
      {
         selected=true;
      }//if
   }//else  

   return selected;
}
function TestDontSelectChk(objValue,chkValue,strError)
{
   var pass = true;
   pass = IsCheckSelected(objValue,chkValue)?false:true;

   if(pass==false)
   {
     if(!strError || strError.length ==0) 
        { 
         strError = "Can't Proceed as you selected "+objValue.name;  
        }//if          
     sfm_show_error_msg(strError,objValue);
     
   }
    return pass;
}
function TestShouldSelectChk(objValue,chkValue,strError)
{
   var pass = true;

   pass = IsCheckSelected(objValue,chkValue)?true:false;

   if(pass==false)
   {
     if(!strError || strError.length ==0) 
        { 
         strError = "You should select"+objValue.name;  
        }//if          
     sfm_show_error_msg(strError,objValue);
     
   }
    return pass;
}
function TestRequiredInput(objValue,strError)
{

var ret = 0;

    if(eval($("#"+objValue).val().length)== 0) 
    { 
       if(!strError || strError.length ==0) 
       { 
         strError = objValue + " : Required Field"; 
       }//if 
        sfm_show_error_msg(strError,objValue);
       ret=1;
    } else {
	$("#error_"+objValue).html('');}
return ret;
}
function TestMaxLen(objValue,strMaxLen,strError)
{
 var ret = 0;
    if(eval($("#"+objValue).val().length) > eval(strMaxLen)) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue + " : "+ strMaxLen +" characters maximum "; 
      }//if 
      sfm_show_error_msg(strError,objValue); 
      ret = 1; 
    } else {
	$("#error_"+objValue).html('');}
return ret;
}
function TestMinLen(objValue,strMinLen,strError)
{
 var ret = 0;
    if(eval($("#"+objValue).val().length) <  eval(strMinLen)) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue + " : " + strMinLen + " characters minimum  "; 
      }//if               
      sfm_show_error_msg(strError,objValue); 
      ret = 1;   
    }else {
	$("#error_"+objValue).html('');}
return ret;
}

function TestCompare(objValue,objValue2,strError)
{
   
    var ret = 0;
     if(eval($("#"+objValue).val().length) == 0) 
     { 
       ret = 1;
     }
    if($("#"+objValue).val().length > 0 && $("#"+objValue).val()!= $("#"+objValue2).val()) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = "Value do not match";
      }//if               
      sfm_show_error_msg(strError,objValue); 
      ret = 1;   
    }else { if (ret==0){
	$("#error_"+objValue).html('');}}
return ret;
}

function TestInputType(objValue,strRegExp,strError,strDefaultError)
{
   var ret = 0;

    var charpos = objValue.value.search(strRegExp); 
    if(objValue.value.length > 0 &&  charpos >= 0) 
    { 
     if(!strError || strError.length ==0) 
      { 
        strError = strDefaultError;
      }//if 
      sfm_show_error_msg(strError,objValue); 
      ret = 1; 
    }//if 
 return ret;
}


function TestEmail(objValue,strError)
{ 
     var ret = 0;
     if(eval($("#"+objValue).val().length) == 0) 
     { 
       ret=1;
     }
     if($("#"+objValue).val().length > 0 && !validateEmail($("#"+objValue).val())) 
     { 
       if(!strError || strError.length ==0) 
       { 
          strError = objValue +": Enter a valid Email address "; 
       }//if                                               
       sfm_show_error_msg(strError,objValue); 
       ret = 1;
     } 
return ret;
}
function TestLessThan(objValue,strLessThan,strError)
{
var ret = true;
     if(isNaN(objValue.value)) 
     { 
       sfm_show_error_msg(objValue.name +": Should be a number ",objValue); 
       ret = false; 
     }//if 
     else
     if(eval(objValue.value) >=  eval(strLessThan)) 
     { 
       if(!strError || strError.length ==0) 
       { 
         strError = objValue.name + " : value should be less than "+ strLessThan; 
       }//if               
       sfm_show_error_msg(strError,objValue); 
       ret = false;                 
      }//if   
return ret;          
}
function TestGreaterThan(objValue,strGreaterThan,strError)
{
var ret = true;
     if(isNaN(objValue.value)) 
     { 
       sfm_show_error_msg(objValue.name+": Should be a number ",objValue); 
       ret = false; 
     }//if 
    else
     if(eval(objValue.value) <=  eval(strGreaterThan)) 
      { 
        if(!strError || strError.length ==0) 
        { 
          strError = objValue.name + " : value should be greater than "+ strGreaterThan; 
        }//if               
        sfm_show_error_msg(strError,objValue);  
        ret = false;
      }//if  
return ret;           
}
function TestRegExp(objValue,strRegExp,strError)
{
var ret = true;
    if( objValue.value.length > 0 && 
        !objValue.value.match(strRegExp) ) 
    { 
      if(!strError || strError.length ==0) 
      { 
        strError = objValue.name+": Invalid characters found "; 
      }//if                                                               
      sfm_show_error_msg(strError,objValue); 
      ret = false;                   
    }//if 
return ret;
}
function TestDontSelect(objValue,dont_sel_value,strError)
{
var ret = true;
     if(objValue.value == null) 
     { 
       sfm_show_error_msg("Error: dontselect command for non-select Item",objValue); 
       ret = false; 
     } 
    else
     if(objValue.value == dont_sel_value) 
     { 
      if(!strError || strError.length ==0) 
       { 
        strError = objValue.name+": Please Select one option "; 
       }//if                                                               
       sfm_show_error_msg(strError,objValue); 
       ret =  false;                                   
      } 
return ret;
}
function TestSelectOneRadio(objValue,strError)
{
   var objradio = objValue.form.elements[objValue.name];
   var one_selected=false;
   for(var r=0;r < objradio.length;r++)
   {
     if(objradio[r].checked == "1")
     {
      one_selected=true;
      break;
     }
   }
   if(false == one_selected)
   {
      if(!strError || strError.length ==0) 
       {
       strError = "Please select one option from "+objValue.name;
      }  
     sfm_show_error_msg(strError,objValue);
   }
return one_selected;
}

function TestFileExtension(objValue,cmdvalue,strError)
{
    var ret=false;
    var found=false;

    if(objValue.value.length <= 0)
    {//The 'required' validation is not done here
        return true;
    }
   
    var extns = cmdvalue.split(";");
    for(var i=0;i < extns.length;i++)
    {
        ext = objValue.value.substr(objValue.value.length - extns[i].length,extns[i].length);
        ext = ext.toLowerCase();
        if(ext == extns[i])
        {
            found=true;break;
        }
    }
    if(!found)
    {
       if(!strError || strError.length ==0) 
       { 
         strError = objValue.name + " allowed file extensions are: "+cmdvalue; 
       }//if 
       sfm_show_error_msg(strError,objValue); 
       ret=false;        
    }
    else
    {
        ret=true;
    }
    return ret;
}


function validateInput(strid,command,strError,value2) 
{
    var ret = true;
    switch(command) 
    { 
        case "req": 
        case "required": 
         { 
         ret = TestRequiredInput(strid,strError)
           break;             
         }//case required 
        case "maxlength": 
        case "maxlen": 
          { 
          ret = TestMaxLen(strid,value2,strError)
             break; 
          }//case maxlen 
        case "minlength": 
        case "minlen": 
           { 
          ret = TestMinLen(strid,value2,strError)
             break; 
            }//case minlen 
	case "compare": 
           { 
          ret = TestCompare(strid,value2,strError)
             break; 
            }//case minlen 
        case "alnum": 
        case "alphanumeric": 
           { 
            ret = TestInputType(objValue,"[^A-Za-z0-9]",strError, 
                  objValue.name+": Only alpha-numeric characters allowed ");
            break; 
           }
        case "alnum_s": 
        case "alphanumeric_space": 
           { 
            ret = TestInputType(objValue,"[^A-Za-z0-9\\s]",strError, 
                  objValue.name+": Only alpha-numeric characters and space allowed ");
            break; 
           }         
        case "num": 
        case "numeric": 
           { 
                ret = TestInputType(objValue,"[^0-9]",strError, 
                  objValue.name+": Only digits allowed ");
                break;               
           }
        case "alphabetic": 
        case "alpha": 
           { 
                ret = TestInputType(objValue,"[^A-Za-z]",strError, 
                  objValue.name+": Only alphabetic characters allowed ");
                break; 
           }
        case "alphabetic_space": 
        case "alpha_s": 
           { 
                ret = TestInputType(objValue,"[^A-Za-z\\s]",strError, 
                  objValue.name+": Only alphabetic characters and space allowed ");
                break; 
           }
        case "email": 
          { 
            ret = TestEmail(strid,strError);
            break; 
          }
        case "lt": 
        case "lessthan": 
         { 
            ret = TestLessThan(objValue,cmdvalue,strError);
              break; 
         }
        case "gt": 
        case "greaterthan": 
         { 
         ret = TestGreaterThan(objValue,cmdvalue,strError);
            break; 
         }//case greaterthan 
        case "regexp": 
         { 
         ret = TestRegExp(objValue,cmdvalue,strError);
           break; 
         }
        case "dontselect": 
         { 
          ret = TestDontSelect(objValue,cmdvalue,strError)
             break; 
         }
      case "dontselectchk":
      {
         ret = TestDontSelectChk(objValue,cmdvalue,strError)
         break;
      }
      case "shouldselchk":
      {
         ret = TestShouldSelectChk(objValue,cmdvalue,strError)
         break;
      }
      case "selone_radio":
      {
         ret = TestSelectOneRadio(objValue,strError);
          break;
      }
      case "file_extn":
      {
         ret = TestFileExtension(objValue,cmdvalue,strError);
         break;
      }      
    }//switch 
   return ret;
}
function VWZ_IsListItemSelected(listname,value)
{
 for(var i=0;i < listname.options.length;i++)
 {
  if(listname.options[i].selected == true &&
   listname.options[i].value == value) 
   {
     return true;
   }
 }
 return false;
}
function VWZ_IsChecked(objcheck,value)
{
 if(objcheck.length)
 {
     for(var c=0;c < objcheck.length;c++)
     {
       if(objcheck[c].checked == "1" && 
        objcheck[c].value == value)
       {
        return true; 
       }
     }
 }
 else
 {
  if(objcheck.checked == "1" )
   {
    return true; 
   }    
 }
 return false;
}
/*
   Copyright (C) 2003-2008 JavaScript-Coder.com . All rights reserved.
*/