/*
Slick Grid Editors customized for SDI Creator only
Last Modified: 11/30/2012
Modified by:Sherwin Vizcara, DataStream Solutions, Inc.
*/
var loadcl=false;
(function($) {
    var SlickEditor = {
		//status formatter
		StatusFormatter : function(row, cell, value, columnDef,dataContext){
			var stat="<span class='offline' style='width:25px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
			switch(value)
			{
				case 2:
					stat="<span class='online' style='width:25px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
					break;
				case 1:
					stat="<span class='idle' style='width:25px'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
					break;
			}
			return stat;
		},
		CommandFormatter : function(row, cell, value, columnDef, dataContext) {
		   return  "<span onclick='window.external.downloadFile("+dataView.getItemByIdx(row).fileid+")' class='save'>&nbsp;</span><span onclick='window.external.createPDF("+dataView.getItemByIdx(row).fileid+")'  class='pdf'>&nbsp;</span>";
 		},
		IMEPOSFormatter:function(row, cell, value, columnDef, dataContext) {
			var arr = [];
			arr = dataContext.req.split("|");
			return '<div style="font-size:9px" align="center">'+arr[0]+"<br/>Pos"+arr[1]+"</div>";
		},
		IMEPOSFormatter2:function(row, cell, value, columnDef, dataContext) {
			var arr = [];
			arr = dataContext.pos.split("|");
			return '<div style="font-size:9px" align="center">'+arr[0]+"<br/>Pos"+arr[1]+"</div>";
		},
		IMERYG: function(row, cell, value, columnDef, dataContext) {
			
			if(value=="Complete")
				return '<div style="background:rgb(230,214,12);height:100%;font-weight:bold;padding:2px;">'+value+'</div>';
			
			if(value=="Incomplete")
				return '<div style="background:rgb(192,0,0);color:white;height:100%;font-weight:bold;padding:2px;">'+value+'</div>';
			return  '<div style="background:rgb(79,98,40);color:white;height:100%;font-weight:bold;padding:2px;">'+value+'</div>';
		},
		IMEPO:function(row, cell, value, columnDef, dataContext) {
			
			return "<div style='float:left;height:100%;width:50px;font-size:9px;margin:-1px;border-right:1px dotted silver;' align='center'>"+dataContext[columnDef.id+"povalue"]+"</div><div style='float:left;width:49px;font-size:9px;' align='center'>"+dataContext[columnDef.id+"savings"]+"</div>";

		},
		IMEStat:function(row, cell, value, columnDef, dataContext) {
			var app =dataContext.status;
			if(app==2)
				return "<div style='height:100%;background: rgb(208,235,179) url(../styles/images/green.png) no-repeat 5px 3px;font-size:9px;background-size:20px 20px;font-weight:bold;line-height:30px;color:white' align='center'>&nbsp;</div>";
			if(app==1)
				return "<div style='height:100%;background: rgb(255,255,204) url(../styles/images/yellow.png) no-repeat 5px 3px;font-size:9px;background-size:20px 20px;font-weight:bold;line-height:30px;color:black' align='center'>&nbsp;</div>";
			return "<div style='height:100%;background: rgb(242,220,219) url(../styles/images/red.png) no-repeat 5px 3px;font-size:9px;background-size:20px 20px;font-weight:bold;line-height:30px;color:white' align='center'>&nbsp;</div>";
		},
		//Selector formatter
        SelectorCellFormatter : function(row, cell, value, columnDef, dataContext) {
            return (!dataContext ? "" : row);
        },
		//Percent complete cell formatter
        PercentCompleteCellFormatter : function(row, cell, value, columnDef, dataContext) {
            if (value == null || value === "")
                return "-";
            else if (value < 50)
                return "<span style='color:red;font-weight:bold;'>" + value + "%</span>";
            else
                return "<span style='color:green'>" + value + "%</span>";
        },
		//Graphical Percent Complete Cell Formatter
        GraphicalPercentCompleteCellFormatter : function(row, cell, value, columnDef, dataContext) {
            if (value == null || value === "")
                return "";
            var color;
            if (value < 30)
                color = "red";
            else if (value < 70)
                color = "silver";
            else
                color = "green";
            return "<span class='percent-complete-bar' style='background:" + color + ";width:" + value + "%'></span>";
        },
		//Yes No Cell formatter
        YesNoCellFormatter : function(row, cell, value, columnDef, dataContext) {
          	return value ? "Yes" : "No";			
        },
		//Incomplete uploaded published cell formatter
		IPUCellFormatter: function (row,cell,value,columnDef,dataContext){
			var color;
			var value;
			
			switch (value)
			{
				case "I":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:red'>Incomplete</div>";
					break;
				case "U":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:green'>Uploaded</div>";
					break;
				case "P":
					return "<div style='color:black;font-weight:bold;height:100%;width:100%;background-color:yellow'>Published</div>";
					break;
			}
			
		
		},
		IPU2CellFormatter: function (row,cell,value,columnDef,dataContext){
			var color;
			var value;
			switch (value)
			{
				case "A":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:red'>To Be Uploaded</div>";
					break;
				case "B":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:red'>Incomplete</div>";
					break;
				case "C":
					return "<div style='color:black;font-weight:bold;height:100%;width:100%;background-color:yellow'>Pending Buyer</div>";
					break;
				case "D":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:green'>Complete</div>";
					break;
				case "E":
					return "<div style='color:white;font-weight:bold;height:100%;width:100%;background-color:green'>Uploaded</div>";
					break;
			}
			
		
		},
		
        BoolCellFormatter : function(row, cell, value, columnDef, dataContext) {
            return (value=="Yes") ? "<img src='css/images/hovery.png'>" : "";
        },
  		BoolCellFormatter2 : function(row, cell, value, columnDef, dataContext) {
            return (value==1) ? "<div align='center'><img style='text-align:middle' src='css/images/hovery.png'></div>" : "";
        },

        TaskNameFormatter : function(row, cell, value, columnDef, dataContext) {
            // todo:  html encode
            var spacer = "<span style='display:inline-block;height:1px;width:" + (2 + 15 * dataContext["indent"]) + "px'></span>";
            return spacer + " <img src='images/expand.gif'>&nbsp;" + value;
        },

        ResourcesFormatter : function(row, cell, value, columnDef, dataContext) {
            var resources = dataContext["resources"];

            if (!resources || resources.length == 0)
                return "";

            if (columnDef.width < 50)
                return (resources.length > 1 ? "<center><img src='images/user_identity_plus.gif' " : "<center><img src='../images/user_identity.gif' ") +
                        " title='" + resources.join(", ") + "'></center>";
            else
                return resources.join(", ");
        },

        StarFormatter : function(row, cell, value, columnDef, dataContext) {
            return (value) ? "<img src='css/images/bullet_star.png' align='absmiddle'>" : "";
        },


        TextCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;
			
            this.init = function() {
				
                $input = $("<INPUT type=text class='editor-text' />")
                    .appendTo(args.container);
				
            };
            this.destroy = function() {
                $input.remove();
            };

            this.focus = function() {
                $input.focus();
            };
		
            this.getValue = function() {

                return $input.val();
            };

            this.setValue = function(val) {
                $input.val(val);
            };

            this.loadValue = function(item) {
				
                defaultValue = item[args.column.field] || "";
                $input.val(defaultValue);
				
                $input[0].defaultValue = defaultValue;
                $input.select();
            };

            this.serializeValue = function() {
                return $input.val();
            };

            this.applyValue = function(item,state) {
				
                item[args.column.field] = state.replace(/\'/g,"").replace(/\"/g,"");
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
            };

            this.validate = function() {
                if (args.column.validator) {
                    var validationResults = args.column.validator($input.val());
                    if (!validationResults.valid)
                        return validationResults;
                }

                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },
		FolderBrowserEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;
			
            this.init = function() {
                $input = $("<input type=text readonly style='background:transparent' class='editor-folder2'/>")
                    .appendTo(args.container)
                    .focus() 
				$input.width($input.width()-15);
				$input2 = $("<input type=text readonly class='editor-folder'/>")
				              .appendTo(args.container)
                    .bind("click", function(e) {
						$input.focus();
                       window.external.getDir(defaultValue);
					   
                    })
                    
				
            };

            this.destroy = function() {
                $input.remove();
            };

            this.focus = function() {
                $input.focus();
            };

            this.getValue = function() {

                return $input.val();
            };

            this.setValue = function(val) {
                $input.val(val);cont=true;
            };
			this.reSet = function(val){
				 var s= grid.getActiveCell();
			 	dataView.getItemByIdx(dataView.getRowById(107)).Val =  defaultValue;
			 	dataView.refresh();grid.render();
				$input.val(defaultValue);
			};
            this.loadValue = function(item) {
				
                defaultValue = item[args.column.field] || "";
               
				$input.val(defaultValue);
				
                $input[0].defaultValue = defaultValue;
                //$input.select();
            };

            this.serializeValue = function() {
                return $input.val();
            };

            this.applyValue = function(item,state) {
				loadcl=false;
				if(state==null || state.length==0  ) {
					if(defaultValue.length==0){
						state=deffolder;
					}
					else 
					{
						state=item[args.column.field];
					}
				}
				
				if(cont!=true){ item[args.column.field]= defaultValue;return};
                item[args.column.field] = state;
				loadcl=true;
				changed=true;
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
            };

            this.validate = function() {
                if (args.column.validator) {
                    var validationResults = args.column.validator($input.val());
                    if (!validationResults.valid)
                        return validationResults;
                }

                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },

        IntegerCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;

            this.init = function() {
                $input = $("<INPUT type=text class='editor-text' />");

                $input.bind("keydown.nav", function(e) {
                    if (e.keyCode === $.ui.keyCode.LEFT || e.keyCode === $.ui.keyCode.RIGHT) {
                        e.stopImmediatePropagation();
                    }
                });

                $input.appendTo(args.container);
                $input.focus().select();
            };

            this.destroy = function() {
                $input.remove();
            };

            this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                defaultValue = item[args.column.field];
                $input.val(defaultValue);
                $input[0].defaultValue = defaultValue;
                $input.select();
            };

            this.serializeValue = function() {
                return parseInt($input.val(),10) || 0;
            };

            this.applyValue = function(item,state) {
                item[args.column.field] = state;
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
            };

            this.validate = function() {
                if (isNaN($input.val()))
                    return {
                        valid: false,
                        msg: "Please enter a valid integer"
                    };

                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },

        DateCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;
            var calendarOpen = false;

            this.init = function() {
                $input = $("<INPUT type=text class='editor-text' />");
                $input.appendTo(args.container);
                $input.focus().select();
                $input.datepicker({
       
					dateFormat: "dd.mm.yy",
					maxDate:0,
                    buttonImage: "css/images/calendar.gif",
                    beforeShow: function() { calendarOpen = true },
                    onClose: function() { calendarOpen = false }
                });
                $input.width($input.width() - 18);
            };

            this.destroy = function() {
                $.datepicker.dpDiv.stop(true,true);
                $input.datepicker("hide");
                $input.datepicker("destroy");
                $input.remove();
            };

            this.show = function() {
                if (calendarOpen) {
                    $.datepicker.dpDiv.stop(true,true).show();
                }
            };

            this.hide = function() {
                if (calendarOpen) {
                    $.datepicker.dpDiv.stop(true,true).hide();
                }
            };

            this.position = function(position) {
                if (!calendarOpen) return;
                $.datepicker.dpDiv
                    .css("top", position.top + 30)
                    .css("left", position.left);
            };

            this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                defaultValue = item[args.column.field];
                $input.val(defaultValue);
                $input[0].defaultValue = defaultValue;
                $input.select();
            };

            this.serializeValue = function() {
                return $input.val();
            };

            this.applyValue = function(item,state) {
                item[args.column.field] = state;
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
            };

            this.validate = function() {
                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },

        YesNoSelectCellEditor : function(args) {
            var $select;
            var defaultValue;
            var scope = this;

            this.init = function() {
                $select = $("<SELECT tabIndex='0' class='editor-yesno'><OPTION value='Yes'>Yes</OPTION><OPTION value='No'>No</OPTION></SELECT>");
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
		
                $select.val(((defaultValue = item[args.column.field])=="Yes") ? "Yes" : "No");
                $select.select();
            };

            this.serializeValue = function() {
                return ($select.val() == "Yes");
            };

            this.applyValue = function(item,state) {
				
                item[args.column.field] = (state)?"Yes":"No";
            };
           
            this.isValueChanged = function() {
                return ($select.val() != defaultValue);
            };

            this.validate = function() {
                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },
 YesNoNASelectCellEditor : function(args) {
            var $select;
            var defaultValue;
            var scope = this;

            this.init = function() {
                $select = $("<SELECT tabIndex='0' class='editor-yesno'><OPTION value='Yes'>Yes</OPTION><OPTION value='No'>No</OPTION><OPTION value='NA'>NA</OPTION></SELECT>");
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
		
                $select.val(((defaultValue = item[args.column.field])=="Yes") ? "Yes" : "No");
                $select.select();
            };

            this.serializeValue = function() {
                return ($select.val() == "Yes");
            };

            this.applyValue = function(item,state) {
				
                item[args.column.field] = (state)?"Yes":"No";
            };
           
            this.isValueChanged = function() {
                return ($select.val() != defaultValue);
            };

            this.validate = function() {
                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },
        YesNoCheckboxCellEditor : function(args) {
            var $select;
            var defaultValue;
            var scope = this;

            this.init = function() {
	
                $select = $("<INPUT style='left:50%' type=checkbox value='true' class='editor-checkbox' hideFocus>");
                $select.appendTo("<div align='center'></div").appendTo(args.container);
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
				
                item[args.column.field] = (state=="checked")?-1:0;
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
        },

        PercentCompleteCellEditor : function(args) {
            var $input, $picker;
            var defaultValue;
            var scope = this;

            this.init = function() {
                $input = $("<INPUT type=text class='editor-percentcomplete' />");
                $input.width($(args.container).innerWidth() - 25);
                $input.appendTo(args.container);

                $picker = $("<div class='editor-percentcomplete-picker' />").appendTo(args.container);
                $picker.append("<div class='editor-percentcomplete-helper'><div class='editor-percentcomplete-wrapper'><div class='editor-percentcomplete-slider' /><div class='editor-percentcomplete-buttons' /></div></div>");

                $picker.find(".editor-percentcomplete-buttons").append("<button val=0>Not started</button><br/><button val=50>In Progress</button><br/><button val=100>Complete</button>");

                $input.focus().select();

                $picker.find(".editor-percentcomplete-slider").slider({
                    orientation: "vertical",
                    range: "min",
                    value: defaultValue,
                    slide: function(event, ui) {
                        $input.val(ui.value)
                    }
                });

                $picker.find(".editor-percentcomplete-buttons button").bind("click", function(e) {
                    $input.val($(this).attr("val"));
                    $picker.find(".editor-percentcomplete-slider").slider("value", $(this).attr("val"));
                })
            };

            this.destroy = function() {
                $input.remove();
                $picker.remove();
            };

            this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                $input.val(defaultValue = item[args.column.field]);
                $input.select();
            };

            this.serializeValue = function() {
                return parseInt($input.val(),10) || 0;
            };

            this.applyValue = function(item,state) {
                item[args.column.field] = state;
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ((parseInt($input.val(),10) || 0) != defaultValue);
            };

            this.validate = function() {
                if (isNaN(parseInt($input.val(),10)))
                    return {
                        valid: false,
                        msg: "Please enter a valid positive number"
                    };

                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },

        StarCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;

            function toggle(e) {
                if (e.type == "keydown" && e.which != 32) return;

                if ($input.css("opacity") == "1")
                    $input.css("opacity", 0.5);
                else
                    $input.css("opacity", 1);

                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            this.init = function() {
                $input = $("<IMG src='css/images/bullet_star.png' align=absmiddle tabIndex=0 title='Click or press Space to toggle' />")
                    .bind("click keydown", toggle)
                    .appendTo(args.container)
                    .focus();
            };

            this.destroy = function() {
                $input.unbind("click keydown", toggle);
                $input.remove();
            };

            this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                defaultValue = item[args.column.field];
                $input.css("opacity", defaultValue ? 1 : 0.2);
            };

            this.serializeValue = function() {
                return ($input.css("opacity") == "1");
            };

            this.applyValue = function(item,state) {
                item[args.column.field] = state;
            };

            this.isValueChanged = function() {
                return defaultValue != ($input.css("opacity") == "1");
            };

            this.validate = function() {
                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },

        /*
         * An example of a "detached" editor.
         * The UI is added onto document BODY and .position(), .show() and .hide() are implemented.
         * KeyDown events are also handled to provide handling for Tab, Shift-Tab, Esc and Ctrl-Enter.
         */
        LongTextCellEditor : function (args) {
            var $input, $wrapper;
            var defaultValue;
            var scope = this;

            this.init = function() {
                var $container = $("body");

                $wrapper = $("<DIV style='z-index:10000;position:absolute;background:white;padding:5px;border:3px solid gray; -moz-border-radius:10px; border-radius:10px;'/>")
                    .appendTo($container);

                $input = $("<TEXTAREA hidefocus rows=5 style='backround:white;width:250px;height:80px;border:0;outline:0'>")
                    .appendTo($wrapper);

                $("<DIV style='text-align:right'><BUTTON>Save</BUTTON><BUTTON>Cancel</BUTTON></DIV>")
                    .appendTo($wrapper);

                $wrapper.find("button:first").bind("click", this.save);
                $wrapper.find("button:last").bind("click", this.cancel);
                $input.bind("keydown", this.handleKeyDown);

                scope.position(args.position);
                $input.focus().select();
            };

            this.handleKeyDown = function(e) {
                if (e.which == $.ui.keyCode.ENTER && e.ctrlKey) {
                    scope.save();
                }
                else if (e.which == $.ui.keyCode.ESCAPE) {
                    e.preventDefault();
                    scope.cancel();
                }
                else if (e.which == $.ui.keyCode.TAB && e.shiftKey) {
                    e.preventDefault();
                    grid.navigatePrev();
                }
                else if (e.which == $.ui.keyCode.TAB) {
                    e.preventDefault();
                    grid.navigateNext();
                }
            };

            this.save = function() {
                args.commitChanges();
            };

            this.cancel = function() {
                $input.val(defaultValue);
                args.cancelChanges();
            };

            this.hide = function() {
                $wrapper.hide();
            };

            this.show = function() {
                $wrapper.show();
            };

            this.position = function(position) {
                $wrapper
                    .css("top", position.top - 5)
                    .css("left", position.left - 5)
            };

            this.destroy = function() {
                $wrapper.remove();
            };

            this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                $input.val(defaultValue = item[args.column.field]);
                $input.select();
            };

            this.serializeValue = function() {
                return $input.val();
            };

            this.applyValue = function(item,state) {
                item[args.column.field] = state;
            };

            this.isValueChanged = function() {
                return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
            };

            this.validate = function() {
                return {
                    valid: true,
                    msg: null
                };
            };

            this.init();
        },
		SelectCellEditor : function(args) {
        	var defaultValue;
       	 	var scope = this;
		
        this.init = function() {
           	var i = 0;
			option_str="" ;
			
            while( i < selectvalue.length ){
              v = selectvalue[i];
			 
              option_str += "<OPTION link='"+v.id+"' value='"+v.text+"'>"+v.text+"</OPTION>";
			  i++;
            }
            $select = $("<SELECT tabIndex='0' class='editor-select'>"+ option_str +"</SELECT>");
            $select.appendTo(args.container);
           
        };

        this.destroy = function() {
			
            $select.remove();
        };
  		this.getValue = function() {

                return $select.val();
            };
        this.focus = function() {
            $select.focus();
        };

        this.loadValue = function(item) {
			selectitem = item;
            defaultValue = item[args.column.field];
            $select.val(defaultValue); 
        };

        this.serializeValue = function() {
             return $select.val();
            
        };
		this.setValue = function(val,selectitem) {
			
			selectitem[args.column.field] =val;

		};
        this.applyValue = function(item,state) {
	
            item[args.column.field] = state;
		
        };

        this.isValueChanged = function() {
            return ($select.val() != defaultValue);
        };

        this.validate = function() {
            return {
                valid: true,
                msg: null
            };
        };

        this.init();
    }

    };

    $.extend(window, SlickEditor);

})(jQuery);
var msg;var res4="";var main;var selectedval;
(function( $ ) {
		$.widget( "ui.combobox",{
			_create: function() {
					var input,
					that = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $( "<span>" )
						.addClass( "ui-combobox" )
						.insertAfter( select );
							
				function removeIfInvalid(element) {
					var value = $( element ).val(),
						matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
						valid = false;
					select.children( "option" ).each(function() {
						if ( $( this ).text().match( matcher ) ) {
							this.selected = valid = true;
							return false;
						}
					});	
					if ( !valid) {
						// remove invalid value, as it didn't match anything
						$( element )
							.val( "" )
						select.val( "" );
						input.data( "autocomplete" ).term = "";
						return false;
					}
					
				}

				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( " ui-combobox-input" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {

							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							that._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item  )
								return removeIfInvalid( this );
							
						}
						
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" )
					.keyup(function(e) {
                        		if(input.val()== "" && res4 == true){
								window.external.EnableWizard(false);
							} 
                    });
					
				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-combobox-toggle" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							removeIfInvalid( input );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});

			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

