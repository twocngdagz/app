/*
Slick Grid Editors customized for Kick 
Last Modified: 11/30/2012
Modified by:Sherwin Vizcara, DataStream Solutions, Inc.
*/
var loadcl=false;
(function($) {
    var SlickEditor = {
		TextFormatter: function(row,cell,value,columnDef, dataContext){
			
			return "<div class='left'>"+((value)?_.escape(value):"")+"</div>";
		},
		waitFormatter:function(row,cell,value,columnDef,dataContext){
			return "<div class='left'>wait...</div>";
		},
		timeFormatter: function(row,cell,value,columnDef,dataContext){
			if(!value)return "";
			return "<div class='left'>"+ new Date.parse(value).toString("hh:mm tt")+"</div>";;
		},
		SelectFormatter: function(cellNode, row, dataContext, colDef){
				if(!dataContext[colDef.field] || dataContext[colDef.field].length ==0)
					{$(cellNode).html("");
					return}
				if(!colDef.data)
				{
					sendAjax("GET",colDef.dataurl,"").done(function(a){
						var values=[];
						colDef.data = $.parseJSON(a);
						_.each(colDef.data,function(a){
							if(_.contains(dataContext[colDef.field],a.id))
							values.push(a.value);
						});
						//var val= jsonsql.query("select value from json where (id==" +dataContext[colDef.field]+")",colDef.data);
						$(cellNode).html("<div class='left'>"+values.join("/")+"</div>");
						
					});
				} else {
						var values=[];
						_.each(colDef.data,function(a){
							if(_.contains(dataContext[colDef.field],a.id))
								values.push(a.value);
						});
					//var val= jsonsql.query("select value from json where (id==" + dataContext[colDef.field]+")",colDef.data);
					$(cellNode).html("<div class='left'>"+values.join("/")+"</div>");
				}
		},
		DaysFormatter:  function(row, cell, value, columnDef, dataContext) {
			
			switch(parseInt(value)){
				case 1:
					return "<div class='left'>Monday</div>";
					break;
				case 2:
					return "<div class='left'>Tuesday</div>";
					break;
				case 3:
					return "<div class='left'>Wednesday</div>";
					break;
				case 4:
					return "<div class='left'>Thurday</div>";
				case 5:
					return "<div class='left'>Friday</div>";
				case 6:
					return "<div class='left'>Saturday</div>";
				case 0:
					return "<div class='left'>Sunday</div>";
				default:
					return "";
			}
		},
        BoolCellFormatter : function(row, cell, value, columnDef, dataContext) {
            return (value=="Yes") ? "<img src='../../styles/images/hovery.png'>" : "";
        },
  		BoolCellFormatter2 : function(row, cell, value, columnDef, dataContext) {
            return (value==1) ? "<div align='center'><img style='text-align:middle' src='../../styles/images/hovery.png'></div>" : "";
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

				TimeCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;
  

            this.init = function() {
			
                $input = $("<INPUT type=text class='editor-text' />").appendTo(args.container);
                $input.timepicker();
                $input.focus().select();
            };

            this.destroy = function() {
                //$.datepicker.dpDiv.stop(true,true);
              //  $input.timepicker("hide");
               // $input.timepicker("destroy");
	
			    $input.mobiscroll("destroy");
                $input.remove();
            };

  			this.focus = function() {
                $input.focus();
            };

            this.loadValue = function(item) {
                defaultValue = item[args.column.field]
				
				if(defaultValue)
                	//$input.mobiscroll('setDate',new  Date.parse(defaultValue),true)
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
				 if (args.column.validator) {
                    var validationResults = args.column.validator(args.item,args.column,$input.val());
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
        TextCellEditor : function(args) {
            var $input;
            var defaultValue;
            var scope = this;
			
            this.init = function() {
				
                $input = $("<INPUT type=text class='editor-text' />")
                    .appendTo(args.container).addClass((args.column.cssClass)?args.column.cssClass:"");
				
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

                $input.appendTo(args.container).addClass((args.column.cssClass)?args.column.cssClass:"");
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
                return parseFloat($input.val(),10) || 0;
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
		ChosenCellEditor : function(args) {
        var $select;
		var $val = true;
		var selectitem;
        var defaultValue;
        var scope = this;
		
        this.init = function() {
			
			$select = $("<input type='text' value='Loading...' style='font-style:italic;font-size:10px' readonly class='editor-text' />");
			
			$select.appendTo(args.container)
			
			if(!args.column.data || args.column.dataCheck)
				{$select.addClass("ac_loading");
				sendAjax("GET",args.column.dataurl,"d"+new Date().valueOf()).done(function(data){
					$select.removeClass("ac_loading");
					args.column.data = $.parseJSON(data);
					if($val == null) return;
					scope.setData(args.column.data);
				})
				}
			else
          		scope.setData(args.column.data);
			
           
        };
		this.setData = function(a){
			$select.remove();
			$select = $("<select class='select-editor'></select>");
			if(args.column.multiple) $select.attr("multiple",true);
			$select.appendTo(args.container)
			  for(var i =0;i<a.length;i++)
			  {
				 $opt = $("<option></option>");
			
				 $opt.attr("value",a[i].id)
					.text(a[i].value) 
					.appendTo($select)
			  }
			  value = args.item[args.column.field];
			  if  (args.column.array && typeof value!="undefined")
			  	value = (_.isArray(value))?value :value.split(',');
			 
			  $select.chosen({
			  	disable_search: (args.column.disablesearch)?true:false
			  }).change(function(){
					args.container.focus();  
			  }).val(value).trigger("liszt:updated").trigger("liszt:open")
		};
        this.destroy = function() {
			$val = null;
			try{$select.autocomplete("destroy")}catch(e){};
            $select.remove();
			
        };
  		this.getValue = function() {
                return $val();
        };
        this.focus = function() {
            $select.focus();
        };

        this.loadValue = function(item) {

        };

        this.serializeValue = function() {
             return $select.val();
            
        };
		this.setValue = function(val,selectitem) {
			
			selectitem[args.column.field] =val;

		};
        this.applyValue = function(item,state) {
            item[args.column.field] =$select.val();
			
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
		
		
		
		
		SelectCellEditor : function(args) {
        var $select;
		var $val = true;
		var selectitem;
        var defaultValue;
        var scope = this;
		
        this.init = function() {
			$select = $("<input type='text' class='editor-text' />");
			$select.appendTo(args.container);
			
			if(!args.column.data || args.column.dataCheck)
				{
					$select.addClass("ac_loading");
					sendAjax("GET",args.column.dataurl,"").done(function(data){
						$select.removeClass("ac_loading");
						args.column.data = $.parseJSON(data);
						if($val == null) return;
						scope.setData(args.column.data);
					})
				}
			else
          		scope.setData(args.column.data);
			
           
        };
		this.setData = function(a){
		  	$select.autocomplete({
				  source:a,
				  minLength:0,
				  change: function (event, ui) {
					  if (!ui.item) {
						  this.value = '';
						  $val = '';
						  return;
					  }
					  $val = ui.item.id;
					
				  }
			 });
			$select.autocomplete("search",'');
		};
        this.destroy = function() {
			$val = null;
			try{$select.autocomplete("destroy")}catch(e){};
            $select.remove();
			
        };
  		this.getValue = function() {
                return $val();
        };
        this.focus = function() {
            $select.focus();
        };

        this.loadValue = function(item) {
			selectitem = item;
            defaultValue = item[args.column.field];
			if(defaultValue && args.column.data){
				var val= jsonsql.query("select value from json where (id==" + defaultValue+")",args.column.data);
            	$select.val(val[0].value);
				$val= defaultValue;
				val = null;
			} 
        };

        this.serializeValue = function() {
             return $select.val();
            
        };
		this.setValue = function(val,selectitem) {
			
			selectitem[args.column.field] =val;

		};
        this.applyValue = function(item,state) {
            item[args.column.field] = $val;
			
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
		AutoComplete : function(args) {
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
								mustMatch: true,
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

    };

    $.extend(window, SlickEditor);

})(jQuery);
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

