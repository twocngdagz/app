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
<link rel="stylesheet" href="../styles/ui-gen.php?part&theme=dss&chosen&slick&slick-grid&slick-column&slick-pager&ac">
<script src="../scripts/lib/jquery.event.drag-2.0.min.js"></script>
<script src="../scripts/lib/json2.js"></script>
<script src="../scripts/lib/jsonsql.js"></script>
<script src="../scripts/controls/chosen.jquery.js"></script>
<script src="../scripts/controls/jquery.autocomplete.js"></script>
<script src="../scripts/controls/slick/slick.core.js"></script>
<script src="../scripts/controls/slick/slick.grid.js"></script>
<script src="../scripts/controls/slick/slick.dataview.js"></script>
<script src="../scripts/controls/slick/slick.rowselectionmodel.js"></script>
<script src="../scripts/controls/slick/slick.autotooltips.js"></script>
<script src="../scripts/controls/slick/slick.groupitemmetadataprovider.js"></script>
<style>
.inlinetext {
	border: none;
	padding:3px;
	margin-bottom:2px;
	background: #eee;
}
.inlinetext:hover {
	background: #eee url(../styles/images/edit.png) right no-repeat;
}
.bold {
	font-weight:bold;
}
.blue {
	color:#903;
}
.italic {
	font-style:italic;
}
.center {
	text-align:center;
}
.hasPlaceholder {
	color: #777;
}
.tabbed_area {
	padding-right:25px;
	padding-bottom:10px;
}
.content {
	padding:10px;
	height:300px;
	width:100%;
	border:1px solid #aaa;
}
#c1_1 input {
	width:140px;
	border:1px solid #999;
	padding:4px 4px 4px 9px;
	border-radius:5px;
	color:#444;
}
#c1_1 select {
	width:155px;
}
ul.tabs {
	padding:0px;
}
ul.tabs li {
	list-style:none;
	display:inline;
}
ul.tabs li a {
	padding:8px 14px 6px 14px;
	text-decoration:none;
	font-weight:bold;
	text-transform:uppercase;
	border:1px solid #aaa;
}
ul.tabs li a:hover {
	background-color:#FFFFFF;
	border-color:#2f343a;
}
ul.tabs li a.active {
	background-color:#ffffff;
	color:#282e32;
	border:1px solid #AAA;
	border-bottom: 1px solid #ffffff;
}
ul.tabs {
	padding:0px;
	margin-bottom:6px;
}
.content ul {
	padding:0px 20px 0px 20px;
}
#c1_2, #c1_2, #c1_3 {
	display:none;
}
.content ul li {
	list-style:none;
	border-bottom:1px solid #d6dde0;
	padding-bottom:15px;
}
.content ul li a {
	text-decoration:none;
	color:#3e4346;
}
.content ul li a small {
	color:#8b959c;
	font-size:9px;
	text-transform:uppercase;
	position:relative;
	left:4px;
	top:0px;
}
.folder:hover {
	background:url(../styles/images/folder_open.png) no-repeat right;
}
.content ul li:last-child {
	border-bottom:none;
}
.ui-dialog .slick-cell.editable {
	z-index: 1005;
}
.ui-dialog .slick-headerrow-column {
	z-index: 1005;
}
.link {
	cursor:pointer;
	color:#930;
}
.link:hover {
	border-bottom:solid 1px #000000
}
</style>
</head>

<div id="settings" style="padding:10px;margin:5px;">
  <div class="tabbed_area">
    <ul class="tabs">
      <li><a href="javascript:tabSwitch_1(1,3,1,1);" id="1_1" class="active">Appearance</a></li>
      <li><a href="javascript:tabSwitch_1(2,3,1,1);" id="1_2" class="active">Filters</a></li>
      <li><a href="javascript:tabSwitch_1(3,3,1,1);" id="1_3">Widgets</a></li>
    </ul>
    <div id="c1_1" class="content">
      <div style="padding:2px">
        <table>
          <tr valign="top">
            <td  width="100"><a>Select Theme:</a></td>
            <td><select id="gender" name="gender"  data-placeholder="Select Option" value="" >
                <option></option>
                <option value="0">Default</option>
                <option value="1">DSS</option>
              </select></td>
          </tr>
          <tr valign="top">
            <td  width="100"><a>Export Location</a></td>
            <td ><input id="dateofbirth" name="dateofbirth" placeholder="Birth Date" value="" class="folder"/></td>
          </tr>
          <tr>
            <td><a>Language</a></td>
            <td><select id="gender" name="gender"  data-placeholder="Select Option" value="" >
                <option></option>
                <option value="0">English</option>
                <option value="1">Deutch</option>
              </select></td>
          </tr>
            </tr>
          
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
        </table>
      </div>
    </div>
    <div id="c1_2" class="content">
      <div style="padding:2px"> </div>
      <div class="grid-header" style="width:100%"> <a class="fbuttonadd" onClick="filter.addForm()">Add Criteria</a> </div>
      <div  class="gridbox" id="filterbox" style="clear:both;height:275px;width:100%" ></div>
    </div>
    <div id="c1_3" class="content">
      <div style="padding:2px"> </div>
    </div>
  </div>
  <button onClick="filter.update()" style="float:right;margin-bottom:5px;">Update</button>
</div>
<div id="filterboxform" style="width:560px" >
  <div class="grid-header" style="width:100%"> <a style="padding-left:2px;font-weight:bold">Apply to: </a>
    <input id="moduleid" title="Changing value will clear your current list of filters." />
    <select id="op" style="display:none">
      <option value="AND">AND</option>
      <option value="OR">OR</option>
    </select>
  </div>
  <div id="filterboxadd" style="height:150px;border:1px solid #999;clear:both;"> </div>
</div>
<script>

		var module;
		var gridAdd;
		var gridMain;
		var dataView;
		var dataView2;	
		var lastgroup;
		
		$(document).ready(function(e) {
            tabSwitch_1(1,3,1,1);
			$(".dp").datepicker();
			$("button").button();
			$("#c1_1 select").chosen({
				max: 10	
			});
			var d = new Date();
			$.ajax({
				type: "GET",
				url: "../api/saveFilter.php?c&a="+readCookie("_uid")+"&d="+d.toString()
			}).done(function(dat){ 
				if(dat)
					filter.init($.parseJSON(dat));
				else
					filter.init();
			});
			
			filter.initForm();
			
			$("#moduleid").autocomplete("../api/getModuleList.php", {
								multiple: false,
								mustMatch: true
						  }).showResults().result(function(event, data, formatted) {
							  	module = null;
								dataView2.beginUpdate(); 
  								dataView2.getItems().length = 0; 
  								dataView2.endUpdate();
								gridAdd.invalidate();
								lastgroup=0;
								$("#op").hide();
								if(data)
								{
							       
									var result = jsonsql.query("SELECT itemid,groupid,filter FROM json where (itemid=='"+data[1]+"') order by groupid desc",dataView.getItems());
									if(result.length>0){
										lastgroup = result[0].groupid;
									
										$("#op").show();
										
									} 
									module = data;
									gridAdd.setOptions({enableAddRow:true});			
								} else {
									gridAdd.setOptions({enableAddRow:false});		
								}
						  }).tooltip({position:{my:"left top-40",at:"left top"}});

			
			$("#filterboxform").dialog({
				modal:true,
				autoOpen:false,
				width:600,
				resizable:false,
				parent:"c1_2",
				title: "Add Filter",
				height:300,
				draggable:false,
				buttons: {
					"Cancel": function (){
						$(this).dialog("close");	
					},
					"Add": function(){
						gridAdd.getEditorLock().commitCurrentEdit();	
						var items = dataView2.getItems();

						for (var i = 0, l = items.length; i < l; i++) {
							if(!items[i]["itemid"]||!items[i]['dataStorage']||!items[i]['value']||!items[i]['operator'])
							{
								
								notify.notify("All fields are required.");
								return;	
							}
						}
						for (var i = 0, l = items.length; i < l; i++) {
							dataView.addItem(items[i]);
						}
						groupByDuration();
						notify.close();
						$(this).dialog("close");
					}
				}
			});
        });


		//Function for tabs switching
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
		
		//Slick editor 
		(function($) {
			$.extend(true, window, {
				"Slick": {
				  "Editors": {
					"AutoComplete": AutoComplete,
					"YesNo":YesNo
				  },
				  "Formatters": {
					"Remove":Remove,
					"RemoveTemp":RemoveTemp  
				  }
				}
			  });
			 function Remove(row, cell, value, columnDef,dataContext){
				 return "<span class='delete' onClick='filter.delete("+dataContext["id"]+")'>Delete</a>";
			 }
			 function RemoveTemp(row, cell, value, columnDef,dataContext){
				 return "<span class='delete' onClick='filter.deleteTemp("+dataContext["id"]+")'>Delete</a>";
			 }
			 function YesNo(args) {
					var $select;
					var defaultValue;
					var scope = this;
		
					this.init = function() {
			
						$select = $("<INPUT style='left:50%' type=checkbox value='true' class='editor-checkbox' hideFocus>");
						$select.appendTo(args.container);
						$select.focus();
					};
		
					this.destroy = function() {
						$select.remove();
					};
		
					this.focus = function() {
						$select.focus();
					};
		
					this.loadValue = function(item) {
						defaultValue = item[args.column.field];
						if (defaultValue)
							$select.attr("checked", "checked");
						else
							$select.removeAttr("checked");
					};
		
					this.serializeValue = function() {
						return $select.attr("checked");
					};
		
					this.applyValue = function(item,state) {
						alert(state);
						item[args.column.field] = (state=="checked")?1:0;
						args.column.dataStorage = (state=="checked")?["Yes",1]:["No",0];
					};
		
					this.isValueChanged = function() {
						return ($select.attr("checked") != defaultValue);
					};
		
					this.validate = function() {
						return {
							valid: true,
							msg: null
						};
					};
		
					this.init();
        	}
   			 function AutoComplete(args){
					var $input;
					var defaultValue;
					var scope = this;
				
					this.init = function () {
					 $input = $("<input type='text' class='editor-text'/>")
						  .appendTo(args.container)
						  .bind("keydown.nav", function (e) {
							if (e.keyCode === $.ui.keyCode.LEFT || e.keyCode === $.ui.keyCode.RIGHT || e.keyCode === $.ui.keyCode.UP || e.keyCode === $.ui.keyCode.DOWN) {
							  e.stopImmediatePropagation();
							}
						  })
						  .focus()
						  .autocomplete(args.column.source, {
								multiple: ((args.column.multiple)?true:false),
								mustMatch: ((args.column.mustMatch)?true:false),
								autoFill: ((args.column.autoFill)?true:false)
						  }).showResults().result(function(event, data, formatted) {
        						args.column.dataStorage = data;
   						  });
					}
		
					this.destroy = function () {
					  $input.unautocomplete();
					  $input.remove();
					  
					};
				
					this.focus = function () {
					  $input.focus();
					};
				
					this.getValue = function () {
					  return $input.val();
					};
				
					this.setValue = function (val) {
					  $input.val(val);
					};
				
					this.loadValue = function (item) {
					  defaultValue = item[args.column.field] || "";
					  $input.val(defaultValue);
					  $input[0].defaultValue = defaultValue;
					  $input.select();
					};
				
					this.serializeValue = function () {
					  return $input.val();
					};
				
					this.applyValue = function (item, state) {
					  item[args.column.field] = state;
					};
				
					this.isValueChanged = function () {
					  return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
					};
				
					this.validate = function () {
					  if (args.column.validator) {
						var validationResults = args.column.validator($input.val());
						if (!validationResults.valid) {
						  return validationResults;
						}
					  }
				
					  return {
						valid: true,
						msg: null
					  };
					};
				
					this.init();
				}
		})( jQuery );
		
		//Filter jscript prototype
		function groupByDuration() {
		  dataView.setGrouping([
		  {
			getter: "applyto",
			formatter: function (g) {
			  return "Module:  " + g.value + "  <span style='color:green'>(" + g.count + " items)</span>";
			}
		  },
		  {
			getter: "groupid",
			formatter: function (g) {
				var items = g.rows;
				var result = jsonsql.query("SELECT groupid FROM json where order by groupid asc",g.rows);
				var maxGroup = 0;
				if(result.length>0){
							maxGroup = result[0].groupid;	
									
				} 
				var str = "<span class='arg'><a class='bold blue'>"+((items[0].groupid>maxGroup)?items[0].filter+" ":"")+"(</a>";
				var op ="";
				for (var i = 0, l = items.length; i < l; i++) {
					if(i>0)op=" OR ";
					str=str+op+items[i].field+"<a class='bold blue'>"+items[i].operator+"</a>'"+items[i].value+"'";	
				}
			  return str+"<a class='bold blue'>)</a></span>"	;
			},
			collapsed: true
		  }
		])};
		var filter = 
		{
			"init": function(a){
				  var grid;
				  
				  var columns = [
					  {id: "field", name: "<div style='margin-top:5px;text-align:center'>Field</div>", field: "field", editor: Slick.Editors.AutoComplete, width:50, mustMatch:true, dataStorage:[],source:"days.txt",toolTip:"List of fields you want to include in your filter."},
					  {id: "operator", name: "<div style='margin-top:5px;text-align:center'>Condition</div>", field: "operator", editor: Slick.Editors.AutoComplete,maxWidth:80,cssClass:"center", mustMatch:true,dataStorage:[],source:["LIKE","=",">","<"]},
					  {id: "value", name: "<div style='margin-top:5px;text-align:center'>Value</div>", field: "value", editor: Slick.Editors.AutoComplete, width:100,mustMatch:true,dataStorage:[]},
					  {id:"id",name:"",field:"id",formatter:Slick.Formatters.Remove,maxWidth:50}
				  ];
			  
				  var options = {
					enableCellNavigation: true,
					editable:true,
					forceFitColumns:true
					
				  };
				  




				  var groupItemMetadataProvider = new Slick.Data.GroupItemMetadataProvider();
				  dataView = new Slick.Data.DataView({
					groupItemMetadataProvider: groupItemMetadataProvider,
					inlineFilters: true
				  });
  				  
				  $("#filterbox").css("width",$(".tabbed_area").width());
				  grid = new Slick.Grid("#filterbox", dataView, columns, options);	
				  $("#filterbox").css("width","100%");
				  grid.registerPlugin(groupItemMetadataProvider);
				
				  // wire up model events to drive the grid
				  dataView.onRowCountChanged.subscribe(function (e, args) {
					grid.updateRowCount();
					grid.render();
				  });
				
				  dataView.onRowsChanged.subscribe(function (e, args) {
					grid.invalidateRows(args.rows);
					grid.render();
				  });

				  grid.onBeforeEditCell.subscribe(function(e,args){
					 try {
						if(args.column.id=="field" && args.item['itemid'])
							args.column.source = "../../api/getFieldlist.php?module="+module[1];
						if(args.column.id=="value" && args.item["dataStorage"][5] == 1 && args.item["field"]){
							args.column.source= "../../api/getValueList.php?tbl="+ args.item["dataStorage"][2]+"&value="+args.item["dataStorage"][3]+"&valueid="+args.item["dataStorage"][4]; 
					 	}
						if(args.column.id=="value" && args.item["dataStorage"][5] == 2 && args.item["field"]){
							
							args.column.editor = Slick.Editors.YesNo;	
					 	}
						if(args.column.id=="applyto" && args.item["field"]){
							args.column.source= "../../api/getModuleList.php?field="+args.item["dataStorage"][1];	
						}
						if(args.column.id=="operator" && args.item["field"]){
							args.column.source=args.item["dataStorage"][7].split(",");	
						}
						
					 } catch(e){};
				  });
				  grid.onCellChange.subscribe(function(e, args) {
					 if(grid.getColumns()[args.cell].id=="field")
					 {
						args.item["dataStorage"] = grid.getColumns()[args.cell].dataStorage; 
						args.item["operator"]=null;
						args.item["value"]=null;
						grid.invalidate();
					 }
					 if(grid.getColumns()[args.cell].id=="value")
					 {
						args.item["values"] = grid.getColumns()[args.cell].dataStorage; 
					 }
				  });
				 if(a){
					dataView.beginUpdate(); 
  					dataView.setItems(a);
  					dataView.endUpdate();
					groupByDuration();
				 }
				 gridMain=grid;
			},	
			"initForm": function(){
				  var grid;
				  var columns = [
					  {id: "field", name: "<div style='margin-top:5px;text-align:center'>Field</div>", field: "field", editor: Slick.Editors.AutoComplete, mustMatch:true, dataStorage:[],toolTip:"List of fields you want to include in your filter."},
					  {id: "operator", name: "<div style='margin-top:5px;text-align:center'>Condition</div>", field: "operator", editor: Slick.Editors.AutoComplete,maxWidth:60,cssClass:"center", mustMatch:true,dataStorage:[],source:[]},
					  {id: "value", name: "<div style='margin-top:5px;text-align:center'>Value</div>", field: "value", editor: Slick.Editors.AutoComplete, mustMatch:true,dataStorage:[]	 },
					  {id:"id",name:"",field:"id",formatter:Slick.Formatters.RemoveTemp,maxWidth:50}
				  ];
			  	  
				  var options = {
					enableCellNavigation: true,
					enableAddRow: true,
					editable:true,
					forceFitColumns:true
					
				  };
				  
				  function comparer(a, b) {
					  var x = a[sortcol], y = b[sortcol];
					  return (x == y ? 0 : (x > y ? 1 : -1));
				  }
				  
				  dataView2 = new Slick.Data.DataView();
  
				  grid = new Slick.Grid("#filterboxadd", dataView2, columns, options);	
				
				  // wire up model events to drive the grid
				  dataView2.onRowCountChanged.subscribe(function (e, args) {
					grid.updateRowCount();
					grid.render();
				  });
				
				  dataView2.onRowsChanged.subscribe(function (e, args) {
					grid.invalidateRows(args.rows);
					grid.render();
				  });

				  grid.onAddNewRow.subscribe(function (e, args) {
					  if(dataView2.getLength()==0)
					  	var result = jsonsql.query("SELECT id FROM json order by id desc",dataView.getItems());
					  else
					  	var result = jsonsql.query("SELECT id FROM json order by id desc",dataView2.getItems());
					  var maxID=0;
					  if(result.length>0)maxID=result[0]["id"];
					  
					  args.item["id"] = maxID+1;

					  args.item["applyto"] = module[0];
					  args.item["itemid"] = module[1];
					  args.item["dataStorage"] = args.column.dataStorage;
					  
					  args.item["groupid"]= lastgroup+1;
					  args.item["filter"]= $("#op").val();
					  var item = args.item;
					  dataView2.beginUpdate();
					  dataView2.addItem(args.item);
					  dataView2.endUpdate();
					  grid.updateRowCount();
					  grid.render();
					  
					   
				  });
				  grid.onBeforeEditCell.subscribe(function(e,args){
					 args.column.source= [];
					 try {
						if(args.column.id=="field" && module)
							args.column.source = "../../api/getFieldlist.php?module="+module[1];
						if(args.column.id=="value" && args.item["dataStorage"][5] == 1 && args.item["field"]){
							args.column.source= "../../api/getValueList.php?tbl="+ args.item["dataStorage"][2]+"&value="+args.item["dataStorage"][3]+"&valueid="+args.item["dataStorage"][4]; 
					 	}
						if(args.column.id=="applyto" && args.item["field"]){
							args.column.source= "../../api/getModuleList.php?field="+args.item["dataStorage"][1];	
						}
						if(args.column.id=="value" && args.item["dataStorage"][5] == 2 && args.item["field"]){
							
							args.column.editor = Slick.Editors.YesNo;	
					 	}
						if(args.column.id=="operator" && args.item["field"]){
							args.column.source=args.item["dataStorage"][7].split(",");	
						}
					 } catch(e){};
				  });
				  grid.onCellChange.subscribe(function(e, args) {
					 if(grid.getColumns()[args.cell].id=="field")
					 {
						args.item["dataStorage"] = grid.getColumns()[args.cell].dataStorage; 
						args.item["operator"]=null;
						args.item["value"]=null;
						grid.invalidate();
					 }
					 if(grid.getColumns()[args.cell].id=="value")
					 {
						args.item["values"] = grid.getColumns()[args.cell].dataStorage; 
					 }
				  });
				  
				  
				  gridAdd =grid;
			},
			
			"addForm": function(){
				module = null;
				dataView2.beginUpdate(); 
  				dataView2.getItems().length = 0; 
  				dataView2.endUpdate();
				gridAdd.setOptions({enableAddRow:false});
				$("#op").val("AND").prop('selected',true);
				$("#filterboxform").dialog("open");	
				$("#moduleid").val('');
			},
			
			"update":function(){
				runsql("../../api/saveFilter.php?a="+readCookie("_uid")+"&b="+JSON.stringify(dataView.getItems()),'',"notify");	
				gridMain.invalidate();
				window.external.sendArgument("refreshInfo");
			},
			"delete":function(a){
				dataView.deleteItem(a);
				dataView.refresh();
			},
			"deleteTemp":function(a){
				dataView2.deleteItem(a);
				dataView2.refresh();
			}
		}
		

		
		
		
</script> 
