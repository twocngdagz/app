var courseschedules = {
	"courseschedules": function(a){
		require(["css!../styles/ui-gen.php?theme=dss&part&slick&slick-grid&slick-column&"],function(){
			require(["slick/slick.core","slick/slick.grid","slick/slick.dataview"],function(){
				var grid;
				var data = new Slick.Data.DataView({id:0});
				var options = {
					id:1,
					forceFitColumns:true,
					 enableColumnReorder: false
				};
				
				var columns = [						
					{id: "day", name: new Date().toString("dddd"), field: "class",selectable:false,focusable:false,cssClass:"tcenter"}
				]
				
				var div = $('<div id="'+a.attr("id")+'content" style="background-color:white;margin:0px 10px 0px 10px;border:1px solid #ddd;height:200px"><div style="margin:20% auto;text-align:center"><img src="../styles/images/ajax.gif" width="30px" height="10px" style="margin-left:10px"/></div></div>');
				div.appendTo(a);
				var item = {};
				item["cmd"] = Date.getDayNumberFromName(new Date().getDayName());
				item["on"]= 4;
				item["d"]= new Date().valueOf();
				sendAjax("GET","courseschedules/modClasses.php",item).done(function(b){
					if(b.length>1)
					{
						var dat = $.parseJSON(b);	
						data.beginUpdate();
						data.setItems(dat);
						data.endUpdate();
					}
					div.html('');
					grid = new Slick.Grid("#"+a.attr("id")+'content', data, columns, options);
				});
				
			});
		});
	}
}
_.extend(widget,courseschedules);