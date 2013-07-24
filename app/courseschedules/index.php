<?PHP
	include("../../includes/connection.php");
	$db = new MySQL;
	$db->Open();
	if(!$db->Login()){
		header("Location:../../login");
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1; charset=utf-8;">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="X-UA-Compatible" content="IE=10" />
<link rel="stylesheet" href="../../styles/ui-gen.php?theme=dss&chosen&messi&ac&slider&uidp&form&scroll&slick&slick-grid&slick-column&slick-pager&mobi&ios">
<style>
.slick-cell {
	padding-left:1px;
}
#content {
	float:left;
}
.cell-inner {
	font-weight:bold;
}
/* alternating offsets */
.slick-row .cell-inner {
	background: #444;
	color:#fff;
	filter:alpha(opacity=90);
}
.slick-row[row$="1"] .cell-inner, .slick-row[row$="3"] .cell-inner, .slick-row[row$="5"] .cell-inner, .slick-row[row$="7"] .cell-inner, .slick-row[row$="9"] .cell-inner {
	margin-right: 0;
}
#classes .slick-row.active {
	background: rgb(198,217,241);
}
.tcenter {
	text-align:center;
}
.tright {
	text-align:right;
}
.slick-header-columns {
	line-height:25px;
	text-align:center;
	height:25px;
}
.slick-header-column {
	background: url(../../styles/images/header_background.jpg);
	color:#fff;
}
#header {
	height:70px;
}
#top-ribbon {
	border-top: 1px solid #fff;
	width:100%;
}
#leftnav, #content {
	top:71px;
}
.topnav {
	background:url(../../styles/images/gradient3.png);
	background-size:cover;
	opacity:.9;
	padding-left:20px;
	width:99.2%;
}
.left {
	padding:2px 5px 2px 5px;
	line-height:20px;
	word-wrap:break-word;
	word-break:break-all;
}
.chzn-drop{

}
.chzn-container-single .chzn-single,.chzn-results,.chzn-search{
	margin:-1px 0px 0px -2px;
	padding: 0px 0px 0px 5px;
}
.chzn-container chzn-container-single{
	width:100% !important;
}
.chzn-container-single,.chzn-container, .chzn-single {
	color:inherit!important;
	border-radius:0px!important;
	 border: 0px solid #aaaaaa;
 	 -webkit-box-shadow: 0 0 0px #ffffff inset, 0 1px 1px rgba(0,0,0,0.1);
  	-moz-box-shadow   : 0 0 0px #ffffff inset, 0 1px 1px rgba(0,0,0,0.1);
  	box-shadow        :0px;
	font-size:inherit;
	background-image:none!important;
	
	margin:0px;
}

.multiselect {
	background:#fff;
	width: 200px;
    height:10em;
    border:solid 1px #c0c0c0;
    overflow:auto;
	margin: 2px 5px 2px 0px;
	
}

.ui-menu-item:hover{
border-color: silver;
background: white;

}
.multiselect label {
    display:block;
	overflow-style:auto;
	
	white-space: nowrap;
	overflow: hidden;
	width:100%;

}
 
.multiselect-on {
    color:#ffffff;
    background-color:#000099;
}

</style>
<script src="../../scripts/lib/jquery.js"></script>
<script src="../../scripts/lib/jquery-ui.js"></script>
<script src="../../scripts/lib/jsonsql.js"></script>
<script src="../../scripts/lib/json2.js"></script>
<script src="../../scripts/lib/jquery.event.drag-2.0.min.js"></script>
<script src="../../scripts/lib/jquery.scrollto.js"></script>
<script src="../../scripts/lib/underscore.js"></script>

<script src="../../scripts/core/notify.js"></script>
<script src="../../scripts/core/ui-gen.js"></script>
<script src="../../scripts/core/frmcmd.js"></script>
<script src="../../scripts/utils/date.js"></script>


<script src="../../scripts/controls/slick/slick.core.js"></script>
<script src="../../scripts/controls/slick/slick.grid.js"></script>
<script src="../../scripts/controls/slick/slick.dataview.js"></script>
<script src="../../scripts/controls/slick/slick.rowselectionmodel.js"></script>

<script src="../../scripts/controls/slick/slick.headermenu.js"></script>
<script src="../../scripts/controls/slick/slick.pager.js"></script>
<script src="../../scripts/controls/jquery.scroll.js"></script>
<script src="../../scripts/controls/jquery-ui-timepicker-addon.js"></script>
<script src="../../scripts/controls/messi.min.js"></script>
<script src="../../scripts/controls/chosen.jquery.js"></script>

<script src="../../scripts/controls/mobi/mobiscroll.core.js" type="text/javascript"></script>
<script src="../../scripts/controls/mobi/mobiscroll.datetime.js" type="text/javascript"></script>
<script src="../../scripts/controls/mobi/mobiscroll.ios.js" type="text/javascript"></script>


<script src="slick.editors.js"></script>
<script src="table-to-csv.js"></script>
<body>
<div id="header">
  <div id="title">Course Schedules</div>
  <div id="top-ribbon">
    <ul class="topnav">
      <li style="padding-left:20px;background:url(../../styles/images/txt.png) no-repeat 0px 6px;background-size: 15px 15px"><a onClick="action.export()" href="#">Export</a> </li>
      <li style="padding-left:20px;background:url(../../styles/images/refresh.png) no-repeat 0px 6px;background-size: 15px" onClick="action.refresh()"><a href="#">Refresh</a> </li>
      <li style="float:right;padding-left:20px;background:url(../../styles/images/arrow_undo.png) no-repeat 0px 6px;background-size: 15px" onClick="refreshgrid()"><a href="../">Back</a> </li>
    </ul>
  </div>
</div>
<div style="clear:both"></div>
<div id="leftnav" style="z-index:auto;color:rgb(55,96,146);"  >
  <div onClick="action.slide('0')"   class="dashmenu">
    <div style="background: transparent url(../../styles/images/details.png) no-repeat 0px 2px;background-size:20px 20px;" class="dashmenuicon"></div>
    <a class="dashmenulink" >Classes</a> </div>
  <div  onClick="action.slide('1')" class="dashmenu">
    <div style="background: transparent url(../../styles/images/details.png) no-repeat 0px 2px;background-size:20px 20px;" class="dashmenuicon"></div>
    <a class="dashmenulink" >Courses</a> </div>
</div>
<div id="content" >
  <div id="hero-slider">
    <div class="mask">
      <div class="slider-body">
        <div class="panel" id="panel-0">
          <div style="margin:10px 10px 0px 10px;padding:8px;" class="modDetail"  >
            <label><b>Course Title: </b><input style="width:150px;padding:2px;font-size:12px;display:inline-block" id="coursetitles"/><a id="coursetitlebutton" style='height:20px;margin-left:0px;margin-top:-4px;' class="ui-button ui-widget ui-state-default ui-button-icon-only custom-combobox-toggle ui-corner-right ui-state-hover"><span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-s"></span><span class="ui-button-text"></span></a></label>
            <div id="myGrid0" style="background:white;width:100%;border:1px solid #999;" data-id="1"></div>
            <div id="pager0" style="z-index:auto;width:100%;height:30px;" ></div>
          </div>
        </div>
        <div class="panel" id="panel-1">
          <div style="margin:10px 10px 0px 10px;padding:8px;" class="modDetail"  >
            <div id="myGrid1" style="background:white;width:100%;border:1px solid #999;" ></div>
            <div id="pager1" style="z-index:auto;width:100%;height:30px;" ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
<script>
 	var grid= [];
  	var data = []; 
	var dataView = [];
	var pager = [];
	var searchString = [];
	var acString= [];
	var options = [];
	var columns = [];
	var unlocked = {};
	var slider = 0;
	var header = [];
	var columnFilters = [];
	$(document).ready(function(){
		$("#content").width($(window).width()-$("#leftnav").width());
		$("#content, #leftnav,.mask,.panel").height($(window).height()-71);
		$("#myGrid0,#myGrid1").height($("#content").height()-85);
		action.init();
		$("#coursetitles,coursetitlebutton").click(function(e) {
			if(grid[0].getColumns()[grid[0].getColumnIndex("courseid")].data)
           $("#coursetitles").autocomplete({
			source:grid[0].getColumns()[grid[0].getColumnIndex("courseid")].data,
			minLength:0,
			change: function (event, ui) {
					var column = grid[0].getColumns()[grid[0].getColumnIndex("courseid")]
					var items = [];
				 	if (!ui.item) {
						  this.value = '';
						  addFilter(column,{id:0,item:items});
						  return;
						  
					  } else
					{
						items.push(ui.item.id);
						addFilter(column,{id:0,item:items});
					 }
			 },
			 select: function(event,ui){
					var column = grid[0].getColumns()[grid[0].getColumnIndex("courseid")]
					var items = [];
					items.push(ui.item.id);
					addFilter(column,{id:0,item:items});
			 }
				
			}).autocomplete( "search", "" );
        });
	});	
	
	function valRequired(a){
	
		if(a.length ==0 || a==undefined || a== null)
		{
			new Messi('This field is required.', {title: 'Required',modal:true, titleClass: 'anim warning', buttons: [{id: 0, label: 'Close', val: 'X'}]});
			return {valid:false};	
		}
		return {valid:true}
	}
	function newItem(a){
		  var newitem = {};
		  if(a==1)
		  {
			  newitem["id"]=0;
			  newitem["courseid"] = "(New)";
			  newitem["title"]= "";
			  newitem["description"]="";
			  newitem["fee"]="";
		  }
		  if(a==0)
		  {
			  newitem["id"]=0;
			  newitem["classid"] = "(New)";
			  newitem["endtime"] = "00:00";
			  newitem["starttime"] = "00:00";
			  newitem["courseid"] ="";
			  newitem["bath"] ="";
			  newitem["capacity"]= "";
		  }
		  
		  return newitem;
	}
	function convertDbl(a){
			if(!a) return -99999999;
			return parseFloat(a);	
	}

	function gridFilter(item,args){
		for (var columnId in columnFilters[args.id]) {
		  if (columnId !== undefined && columnFilters[args.id][columnId].length !== 0) {
			var c = grid[args.id].getColumns()[grid[args.id].getColumnIndex(columnId)];
			if(!_.contains(columnFilters[args.id][columnId],item[c.field]))
				return false;
		  }
		}
		
		return true;	
	}

	
	function addFilter(column,args){
		    if (args.id==0 &&  args.item.length>1 )	$("#coursetitles").val('');
			columnFilters[args.id][column.id] = args.item;
			$("#"+grid[args.id].getUID()+column.field+ " .slick-filter").remove();
			if(args.item.length >0)	$("#"+grid[args.id].getUID()+column.field).append('<span class="slick-filter"></span>'); 

			dataView[args.id].refresh();
	}	
	var action = {
		"init": function()
		{
			this.slide("0");
			for (var z =0;z<2;z++)
			{
				dataView[z] = 	new Slick.Data.DataView({id:z});
		
				grid[z] = new Slick.Grid("#myGrid"+z, dataView[z], columns[z], options[z]);
				pager[z] = new Slick.Controls.Pager(dataView[z], grid[z], $("#pager"+z));
				dataView[z].setFilterArgs({
						id: z
  				});
  				dataView[z].setFilter(gridFilter);
				columnFilters[z] = [];
				header[z]= new Slick.Plugins.HeaderMenu({});
				grid[z].registerPlugin(header[z]);
				
				header[z].onCommand.subscribe(function(e, args) {
      				switch(args.command)
					{
						case "sort-asc":
							action.sortColumn(args.grid.getOptions().id,[{sortCol:args.column,sortAsc:1}]);
							break;	
						case "sort-desc":
							action.sortColumn(args.grid.getOptions().id,[{sortCol:args.column,sortAsc:0}]);
							break;	
					}
    			});
			
				grid[z].onColumnsReordered.subscribe(function(e, args) {
						if(!_.isUndefined(this.getSortColumns()[0].columnId)){
							var c = this.getColumns()[this.getColumnIndex(this.getSortColumns()[0].columnId)];
							action.sortColumn(this.getOptions().id,[{sortCol: c,sortAsc:this.getSortColumns()[0].sortAsc}] );
						}
						for (var columnId in columnFilters[this.getOptions().id]) {
							var c = this.getColumns()[this.getColumnIndex(columnId)];
		  					if (columnId !== undefined && columnFilters[this.getOptions().id][columnId].length !== 0) {
										$("#"+this.getUID()+c.field).append('<span class="slick-filter"></span>'); 
			
							} else {
								$("#"+this.getUID()+c.field+ " .dslick-filter").remove();
							}
		 				}
				
				});
				grid[z].onActiveCellChanged.subscribe(function(e,args){
					var id = this.getOptions().id;
				
					if(typeof  unlocked[id]!='undefined')
						
					 if(args.row!=unlocked[id].row && typeof unlocked[id].row!='undefined')
					 {
						Messi.ask(unlocked[id].info,
							function(val){
								if(val=='Y')
								{
									dataView[id].beginUpdate();
									dataView[id].updateItem(0,newItem(id));
									dataView[id].endUpdate();
									dataView[id].refresh();
									grid[id].invalidate();
									unlocked[id]= {};
									grid[id].gotoCell(args.row,args.cell,true);
									return;	
								}
						});
						grid[id].setActiveCell(unlocked[id].row,unlocked[id].cell);
						grid[id].editActiveCell();
					 } else if( typeof unlocked[id].row!='undefined')
					 {
						unlocked[id].row=args.row;
						unlocked[id].cell=args.cell;
					 }
				});
				grid[z].onCellChange.subscribe(function(e,args){
					var id = this.getOptions().id;
					unlocked[id]={};
					
					if(args.item.id==0)
					{
							if(id==1)
								if(args.item.title.length == 0 || args.item.fee.length ==0 || args.item.coursecode.length ==0) 
								{	
									unlocked[id]= {row:args.row,cell:args.cell}
									unlocked[id].info = "Course Code, Title and Fee are required. Do you want to discard the new record?"
									return;
								}
							if(id==0)		
		
								if(args.item.day.length == 0 || args.item.starttime.length ==0 || args.item.endtime.length ==0 || args.item.bath.length ==0 || args.item.courseid.length==0 || args.item.capacity.length ==0) 
								{	
									unlocked[id]= {row:args.row,cell:args.cell}
									unlocked[id].info = "All fields are required. Do you want to discard the new record?"
									return;
								}
							
							notify.notify("Processing request...");
							var item = args.item;
							item["on"] = id;
							item["cmd"] =1;
							sendAjax("GET","modClasses.php?d="+new Date().valueOf(),item).done(function(dat){
									if(dat.length>1)
									{
										var data = $.parseJSON(dat);
										dataView[id].beginUpdate();
										dataView[id].addItem(data[0]);
										dataView[id].deleteItem(0);
										dataView[id].addItem(newItem(id));
										dataView[id].endUpdate();
										dataView[id].refresh();
										grid[id].invalidate();
										notify.close();
									}
							});
								
					} else 
					{
						
						var item = args.item;
						item["on"] = id;
						item["cmd"] = 2;
						sendAjax("GET","modClasses.php?d="+new Date().valueOf(),item);
					}
				});
				dataView[z].onRowCountChanged.subscribe(function(e, args) {
					var id= this.getOptions().id;
					grid[id].updateRowCount();
					grid[id].render();
				});
			
				dataView[z].onRowsChanged.subscribe(function(e, args) {
					var id= this.getOptions().id;
					grid[id].invalidateRows(args.rows);
					grid[id].render();
				});
				
				acString[z]="";
				searchString[z]="";
		
		
				this.refreshgrid(z);
			}
	
		},
		"sortColumn": function(id,sortCols){
					var cols = sortCols;
					grid[id].setSortColumn(cols[0].sortCol.id,cols[0].sortAsc);
				
					
					dataView[id].deleteItem(0);
					dataView[id].sort(function (dataRow1, dataRow2) {
						for (var i = 0, l = cols.length; i < l; i++) {
						
							var field = cols[i].sortCol.field;
							var sign = cols[i].sortAsc ? 1 : -1;
							var value1 =cols[i].sortCol.converter? cols[i].sortCol.converter(dataRow1[field]):dataRow1[field]?dataRow1[field]:"", value2 =cols[i].sortCol.converter? cols[i].sortCol.converter(dataRow2[field]):dataRow2[field]?dataRow2[field]:"";
												
							var result = (value1 == value2 ? 0 : (value1 > value2 ? 1 : -1)) * sign;
							if (result != 0) {
								return result;
								}
							}
						return 0;
					});  
					
					
					$("#myGrid"+id+" .slick-header-column-sorted").each(function(index, element) {
                        $(this).removeClass("slick-header-column-sorted");
                    });
					$("#myGrid"+id+" .slick-sort-indicator").remove();
					
					if(cols[0].sortAsc) 
								$("#"+grid[id].getUID()+cols[0].sortCol.field).addClass("slick-header-column-sorted").append('<span class="slick-sort-indicator slick-sort-indicator-asc"></span>');
							else
								$("#"+grid[id].getUID()+cols[0].sortCol.field).addClass("slick-header-column-sorted").append('<span class="slick-sort-indicator slick-sort-indicator-desc"></span>'); 
					dataView[id].addItem(newItem(id));
					grid[id].invalidate();
					grid[id].render();
		},
		"export": function(){
			var a =slider;
			var filename="";
			if(a==0)filename ="Class List -" + new Date().toString("yyyy/MM/dd");
	
			if(a==1)filename ="Course List -" + new Date().toString("yyyy/MM/dd");
					
			$("#myGrid"+a).table2CSV({
				grid: grid[a],
				dataview: dataView[a],
				filename: filename
			});
		},
		"refreshgrid": function(a){
			var item = {};
			item["on"]= a;
			item["cmd"] =0;
			return sendAjax("GET","modClasses.php?d="+new Date().valueOf(),item).done(function(dat) {
					if(dat.length>1)
					{
						var data = $.parseJSON(dat);
						data.push(newItem(a));
						dataView[a].beginUpdate();
						dataView[a].setItems(data);
						dataView[a].endUpdate();
						dataView[a].refresh();
						grid[a].invalidate();
						grid[a].render();
						action.poll(a,dataView[a],_.max(data, function(data){ return Date.parse(data.dateupdated); }).dateupdated);
						
					} else {
						
							dataView[a].beginUpdate();
							dataView[a].addItem(newItem(a));
							dataView[a].endUpdate();
							grid[a].invalidate();
							grid[a].render();
						
						
					}
			});	
		},
		"slide":function(a){
			slider = a;
			$(".mask").scrollTo($('#panel-'+a),500);
			Slick.GlobalEditorLock.cancelCurrentEdit();
		},
		"refresh":function(){
			notify.notify("Refreshing...");
			$(".slick-header-column-sorted").each(function(index, element) {
                   $(this).removeClass("slick-header-column-sorted");
            });
			$(".slick-sort-indicator").remove();
			for(var i=0;i<2;i++){
					this.refreshgrid(i).done(function(){notify.close()});
			}
		},
		"poll":function(a,b,c){
			
				var dView = b;
				var time = (c)?c:"1990/12/1";	
				$.ajax({
					url: "modClasses.php",
					type:"GET",
					data:{cmd:a,on:"5",time:time,d:new Date().valueOf()},
					success: function(data){
        				if(data){	
							for(var d=0;d<data.length;d++){
									dView.beginUpdate();
									dView.updateItem(data[d].id,data[d]);
									dView.endUpdate();	
							}
							time = _.max(data, function(data){ return Date.parse(data.dateupdated); }).dateupdated;
						}	
    				}, dataType: "json",
					complete: function(){action.poll(a,dView,time)}, 
					timeout: 30000 
				});		
		}
		
	}
	
  	columns[0] = [
		{id:"classid",name:"Code",converter: convertDbl,cssClass:"tright", field:"classid", dataType:"number",  converter: convertDbl, maxWidth:60,formatter:TextFormatter},
		{id:"day",name:"Day of", field:"day", validator: valRequired, dataType:"string", width:100,formatter:TextFormatter,editor:ChosenCellEditor,dataurl:"days.php",formatter:waitFormatter,asyncPostRender:SelectFormatter,disablesearch:true},
		{id:"starttime",name:"Start Time",validator: valRequired, dataType:"time", field:"starttime",cssClass:"tcenter",width:80,formatter:timeFormatter, editor:TimeCellEditor},
		{id:"endtime", name:"End Time",validator: valRequired, dataType:"time", field:"endtime",  cssClass:"tcenter",width:80,minWidth:50,formatter:timeFormatter, editor:TimeCellEditor},
		{id:"courseid",name:"Course Title",validator: valRequired,dataType:"string", field:"courseid", editor:ChosenCellEditor,dataurl:"modClasses.php?on=2",dataCheck:true, width:250,formatter:waitFormatter,asyncPostRender:SelectFormatter },
		{id:"trainors",name:"Trainer(s)",validator: valRequired,dataType:"string", field:"trainors",  editor:ChosenCellEditor,dataurl:"modClasses.php?on=3",dataCheck:true, width:180,formatter:waitFormatter,asyncPostRender:SelectFormatter,multiple:true,array:true },
		{id:"bath",name:"Bath",field:"bath",validator: valRequired, width:180,formatter:TextFormatter,editor:TextCellEditor },
		{id:"capacity",name:"Capacity",field:"capacity",converter: convertDbl, validator: valRequired,dataType:"number", cssClass:"tcenter",width:60,editor:IntegerCellEditor,formatter:TextFormatter },
		{id:"open",name:"Open",field:"open", converter: convertDbl, cssClass:"tcenter",dataType:"number",width:60,rformatter:TextFormatter }
	
	]
	columns[1] = [
		{id:"courseid",name:"ID",cssClass:"tright", dataType:"number" , field:"courseid", maxWidth:40,converter: convertDbl, formatter:TextFormatter},
		{id:"coursecode", validator: valRequired,name:"Code",field:"coursecode", width:50,minWidth:50,editor:TextCellEditor,formatter:TextFormatter},
		{id:"title", validator: valRequired,name:"Course Title", field:"title", width:100,minWidth:50,editor:TextCellEditor,formatter:TextFormatter},
		{id:"description",name:"Description",field:"description", width:250,formatter:TextFormatter,editor:TextCellEditor },
		{id:"fee",name:"Fee",field:"fee",dataType:"number", validator: valRequired, cssClass:"tright",converter: convertDbl, maxWidth:80,formatter:TextFormatter,editor:IntegerCellEditor }	
	]
	
	for(var a =0; a< columns.length;a++){
	 for (var i = 0; i < columns[a].length; i++) {
		columns[a][i].header = {
		  menu: {
			items: [
			  {
				iconImage: "../../styles/images/sort-asc.gif",
				title: "Sort Ascending",
				command: "sort-asc"
			  },
			  {
				iconImage: "../../styles/images/sort-desc.gif",
				title: "Sort Descending",
				command: "sort-desc"
			  },
			  {
				function:"divider",
				type:'custom'
			  },
			  {
				  function: "clearfilter",
				  iconImage:"../../styles/images/clearfilter.png",
				  title: "Clear filter from \"" + columns[a][i].name +"\"",
				  disabled: true
			  },
			  {
				  function:"filter",
				  type:'custom'  
			   },
			     {
				function:"divider",
				type:'custom'
			  },
			  {
				function: "search",
				type:'custom'
			  }
			]
		  }
		};
	  }
	}
	options[0]= {
		id:0,
		forceFitColumns:true,
		editable: true,
		enableAddRow:false,
		enableCellNavigation: true,
		multiColumnSort: true,
		searchTooltip:"Type Class Code, Day of, Course Tile or Trainors",
		asyncEditorLoading:true,
    	enableAsyncPostRender: true
		
	};
	
	options[1]= {
		id:1,
		forceFitColumns:true,
		editable: true,
		enableCellNavigation: true,
		multiColumnSort: true,
		searchTooltip:"Type Course Code or Title"
	};
	
	function myFilter(item, args) {
		if (args.searchString != "" && item["id"].substr(0,9).indexOf(args.searchString) == -1 && item["pos"].substr(0,9).indexOf(args.searchString) == -1  && item["supplierduns"].indexOf(args.searchString) == -1 )
				return false;
		return true;
	}
	
	function updateFilter(a) {
	
		dataView[a].setFilterArgs({
			acString: acString[a],
			searchString: searchString[a]
		});
		dataView[a].setFilter(myFilter);
		dataView[a].refresh();
	}

	function comparer(a,b) {
		var x = a[sortcol], y = b[sortcol];
		return (x == y ? 0 : (x > y ? 1 : -1));
	}
	$(".grid-header .ui-icon")
		.addClass("ui-state-default ui-corner-all")
		.mouseover(function(e) {
			$(e.target).addClass("ui-state-hover")
		})
		.mouseout(function(e) {
			$(e.target).removeClass("ui-state-hover")
	});
		 
		
</script>