(function ($) {
  // register namespace
  $.extend(true, window, {
    "Slick": {
      "Plugins": {
        "HeaderMenu": HeaderMenu
      }
    }
  });


  /***
   * A plugin to add drop-down menus to column headers.
   *
   * USAGE:
   *
   * Add the plugin .js & .css files and register it with the grid.
   *
   * To specify a menu in a column header, extend the column definition like so:
   *
   *   var columns = [
   *     {
   *       id: 'myColumn',
   *       name: 'My column',
   *
   *       // This is the relevant part
   *       header: {
   *          menu: {
   *              items: [
   *                {
   *                  // menu item options
   *                },
   *                {
   *                  // menu item options
   *                }
   *              ]
   *          }
   *       }
   *     }
   *   ];
   *
   *
   * Available menu options:
   *    tooltip:      Menu button tooltip.
   *
   *
   * Available menu item options:
   *    title:        Menu item text.
   *    disabled:     Whether the item is disabled.
   *    tooltip:      Item tooltip.
   *    command:      A command identifier to be passed to the onCommand event handlers.
   *    iconCssClass: A CSS class to be added to the menu item icon.
   *    iconImage:    A url to the icon image.
   *
   *
   * The plugin exposes the following events:
   *    onBeforeMenuShow:   Fired before the menu is shown.  You can customize the menu or dismiss it by returning false.
   *        Event args:
   *            grid:     Reference to the grid.
   *            column:   Column definition.
   *            menu:     Menu options.  Note that you can change the menu items here.
   *
   *    onCommand:    Fired on menu item click for buttons with 'command' specified.
   *        Event args:
   *            grid:     Reference to the grid.
   *            column:   Column definition.
   *            command:  Button command identified.
   *            button:   Button options.  Note that you can change the button options in your
   *                      event handler, and the column header will be automatically updated to
   *                      reflect them.  This is useful if you want to implement something like a
   *                      toggle button.
   *
   *
   * @param options {Object} Options:
   *    buttonCssClass:   an extra CSS class to add to the menu button
   *    buttonImage:      a url to the menu button image (default '../images/down.gif')
   * @class Slick.Plugins.HeaderButtons
   * @constructor
   */
  function HeaderMenu(options) {
    var _grid;
    var _self = this;
    var _handler = new Slick.EventHandler();
    var _defaults = {
      buttonCssClass: null,
      buttonImage: "../../styles/images/down.gif"
    };
    var $menu;

    var $activeHeaderColumn;


    function init(grid) {
      options = $.extend(true, {}, _defaults, options);
      _grid = grid;
      _handler
        .subscribe(_grid.onHeaderCellRendered, handleHeaderCellRendered)
        .subscribe(_grid.onBeforeHeaderCellDestroy, handleBeforeHeaderCellDestroy);

      // Force the grid to re-render the header now that the events are hooked up.
      _grid.setColumns(_grid.getColumns());

      // Hide the menu on outside click.
      $(document.body).bind("mousedown", handleBodyMouseDown);
    }


    function destroy() {
      _handler.unsubscribeAll();
      $(document.body).unbind("mousedown", handleBodyMouseDown);
    }

    function handleBodyMouseDown(e) {

      if ($menu && !$.contains($menu[0], e.target ) && !$(e.target).hasClass()) {
        hideMenu();
      }
    }


    function hideMenu() {

      if ($menu) {
        $menu.remove();
        $menu = null;
        $activeHeaderColumn
          .removeClass("slick-header-column-active");
      }
    }

    function handleHeaderCellRendered(e, args) {
      var column = args.column;
      var menu = column.header && column.header.menu ;
	
      if (menu && !column.disableheader) {
        var $el = $("<div></div>")
          .addClass("slick-header-menubutton")
          .data("column", column)
          .data("menu", menu);

        if (options.buttonCssClass) {
          $el.addClass(options.buttonCssClass);
        }

        if (options.buttonImage) {
          $el.css("background-image", "url(" + options.buttonImage + ")");
        }

        if (menu.tooltip) {
          $el.attr("title", menu.tooltip);
        }

        $el
          .bind("click", showMenu)
          .appendTo(args.node);
      }
    }


    function handleBeforeHeaderCellDestroy(e, args) {
      var column = args.column;

      if (column.header && column.header.menu) {
        $(args.node).find(".slick-header-menubutton").remove();
      }
    }


    function showMenu(e) {

      var $menuButton = $(this);
      var menu = $menuButton.data("menu");
      var columnDef = $menuButton.data("column");

      // Let the user modify the menu or cancel altogether,
      // or provide alternative menu implementation.
      if (_self.onBeforeMenuShow.notify({
          "grid": _grid,
          "column": columnDef,
          "menu": menu
        }, e, _self) == false) {
        return;
      }


      if (!$menu) {
        $menu = $("<ul class='slick-header-menu'></ul>")
          .appendTo(document.body).css("z-index",2000);
      }
      $menu.empty();


      // Construct the menu items.
      for (var i = 0; i < menu.items.length; i++) {
   
		var item = menu.items[i];

        var $li = $("<li class='slick-header-menuitem'></li>")
          .data("command", item.command || '')
          .data("column", columnDef)
          .data("item", item)
          .bind("click", handleMenuItemClick)
          .appendTo($menu);

        if (item.disabled) {
          $li.addClass("slick-header-menuitem-disabled");
        }

        if (item.tooltip) {
          $li.attr("title", item.tooltip);
        }

        var $icon = $("<div class='slick-header-menuicon'></div>")
          .appendTo($li);

        if (item.iconCssClass) {
          $icon.addClass(item.iconCssClass);
        }

		
        if (item.iconImage) {
          $icon.css("background-image", "url(" + item.iconImage + ")");
		  if(item.disabled)$icon.css("opacity",.5)
        }

        var $container = $("<div class='slick-header-menucontent'></span>").width(200);
		if(item.disabled)$li.removeClass('slick-header-menuitem');
		if(item.title)$container.text(item.title);
        if(item.function){
			
			switch(item.function)
			{ 
				
				case "search": 
					$li.removeClass('slick-header-menuitem');
					var $searchInput = $("<input placeholder='Search "+columnDef.name+" ...' class='slick-search'/>");
					$("<span style='display:none'>a</span>").appendTo($container);
				    $searchInput.appendTo($container);
					var multiselect = $('<div class="multiselect"></div');
					var parent = $('<label></label>').appendTo(multiselect);
					var $ok = $("<input value='OK' type='button'/>").css("float","right").button();
				    var $cancel = $("<input value='Cancel' type='button'/>").css("float","right").button();
					parent.html('<input type="checkbox" name="select" value=""/>(Select All)');
				
					$searchInput.keyup(function(e){
						if(e.which==32)$searchInput.val($searchInput.val()+" ");
						if(e.which==13)$ok.click();
						multiselect.html('');
						if($searchInput.val().length==0)
						{
							parent.appendTo(multiselect);
							parent.html('<input type="checkbox" name="select" value=""/>(Select All)');
						}
						else
							{
								parent.appendTo(multiselect);
								parent.html('<input type="checkbox" name="select" value=""/>(Select All Search Results)');
								$("<label><input type=\"checkbox\" name=\"selectadd\" value=\"\"/>Add current selection to filter</label>").appendTo(multiselect);
							}
						if(columnDef.data)
						{
							var items = [];
							var items2 =_.sortBy(_.uniq(_.compact(_.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field))),function(num){return (columnDef.converter)?columnDef.converter(num):num});
							for (var zz=0;zz<items2.length;zz++)
							{
								var zzResult = _.findWhere(columnDef.data,{id:items2[zz]});
								if(zzResult)items.push(zzResult);
							}
						}
						else
							var items =_.filter(_.sortBy(_.uniq(_.compact(_.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field))),function(num){return (columnDef.converter)?columnDef.converter(num):num}), function(num){ return num.toLowerCase().match(new RegExp($searchInput.val().toLowerCase(), "g")); });
						
						
						
						var itemcount=0;
						var blank = _.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field);
						if((_.contains(blank,"")) || (_.contains(blank,null))) items.push({id:"",value:"(Blanks)"});
						for(var z=0;z<items.length;z++){
							
							if(((items[z].value)?items[z].value:items[z]).toLowerCase().match(new RegExp($searchInput.val().toLowerCase(), "g")))
							{
								var label = $("<label></label>").text((_.isUndefined(items[z].value))?((items[z])?items[z]:""):((items[z].value)?items[z].value:""));
								var input = $("<input type='checkbox' name='option' value='"+((_.isUndefined(items[z].id))?((items[z])?items[z]:""):((items[z].id)?items[z].id:""))+"'/>");								input.prependTo(label);	
								label.appendTo(multiselect);
								itemcount++;
							}
						}
					
						if(itemcount ==0)
						{
							multiselect.html("<div style='padding:10px;text-align:center'>No items to select</div>");
						}
						multiselect.multiselect(columnDef,_grid.getOptions().id);	
					});
					
					
					if(columnDef.data)
						{
							var items = [];
							var items2 =_.sortBy( _.uniq(_.compact(_.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field))),function(num){return (columnDef.converter)?columnDef.converter(num):num});
							for (var zz=0;zz<items2.length;zz++)
							{
								var zzResult = _.findWhere(columnDef.data,{id:items2[zz]});
								if(zzResult)items.push(zzResult);
							}
						}
					else
						var items =_.sortBy( _.uniq(_.compact(_.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field))),function(num){return (columnDef.converter)?columnDef.converter(num):num});
					var itemcount=0;

					var blank = _.pluck(dataView[_grid.getOptions().id].getItems(),columnDef.field);
					if((_.contains(blank,"")) || (_.contains(blank,null))) items.push({id:"",value:"(Blanks)"});
					for(var z=0;z<items.length;z++){
						var label = $("<label></label>").text((!_.isObject(items[z]))?((items[z])?items[z]:""):((items[z].value)?items[z].value:""));
						var input = $("<input type='checkbox' name='option' value='"+((!_.isObject(items[z]))?((items[z])?items[z]:""):((items[z].id)?items[z].id:""))+"'/>");
						input.prependTo(label);	
						label.appendTo(multiselect);
						itemcount++;
					}
					
					if(itemcount ==0)
					{
						multiselect.html("<div style='padding:10px;text-align:center'>No items to select</div>");
					}
				   	multiselect.appendTo($container).multiselect(columnDef,_grid.getOptions().id);

					 $cancel.click(function(){
						hideMenu(); 
					 });
					 
					 $ok.click(function(){
						
						var itemFinal =[];
							
						if($searchInput.val().length>0) {
							if(!_.isUndefined(columnFilters[_grid.getOptions().id][columnDef.id]))itemFinal = columnFilters[_grid.getOptions().id][columnDef.id];
							if(multiselect.find("input:checkbox[name=selectadd]").prop("checked"))
							{
								multiselect.find("input:checked[name=option]").each(function(){
										itemFinal.push($(this).val());
								});
							}
							else
							{
								itemFinal = []
								multiselect.find("input:checked[name=option]").each(function(){
										itemFinal.push($(this).val());
								});
							}
							itemFinal  = _.uniq(itemFinal);
						} 
						else 
							if(!multiselect.find("input:checkbox[name=select]").prop("checked") && $searchInput.val().length==0)
								multiselect.find("input:checked[name=option]").each(function(){
										itemFinal.push($(this).val());
								});
						addFilter(columnDef,{id:_grid.getOptions().id,item:itemFinal});
						hideMenu();
					 });
					 
					 $cancel.appendTo($container);
					 $ok.appendTo($container);
					
					break;
				case "clearfilter":
				
					if(!_.isUndefined(columnFilters[_grid.getOptions().id][columnDef.id]))
					{
						if(columnFilters[_grid.getOptions().id][columnDef.id].length!=0){
						$li.removeClass("slick-header-menuitem-disabled");
						$li.addClass('slick-header-menuitem');
						$icon.css("opacity",1);
						$li.click(function(){
							addFilter(columnDef,{id:_grid.getOptions().id,item:[]});
							hideMenu();
						})}
					}
					break;
				case "divider":
					$li.removeClass('slick-header-menuitem');
					break;
				case "filter":
					var $dataType= (columnDef.dataType)?columnDef.dataType:"string";
					var $a = $("<a style='width:100%;padding:0px' text-align='left'></a>");
					
					var $ul = $("<ul class='slick-header-menu'></ul>");
					
					var $equals = $li.clone().html('');
					$container.clone().text("Equals...").appendTo($equals);
					$equals.click(function(){
						new Messi('This function will be available soon.', {title: 'In Progress', titleClass: 'info', buttons: [{id: 0, label: 'Close', val: 'X'}]});
					})
					
					var $notequal= $li.clone().html('');
					$container.clone().text("Does Not Equal...").appendTo($notequal);
					$notequal.click(function(){
						new Messi('This function will be available soon.', {title: 'In Progress', titleClass: 'info', buttons: [{id: 0, label: 'Close', val: 'X'}]});
					});
					switch($dataType)
					{
						case "string":
							
							$a.text("Text Filter").appendTo($container);
							$("<span class='ui-menu-icon ui-icon ui-icon-carat-1-e'></span>").appendTo($a);
							$equals.appendTo($ul);
							$notequal.appendTo($ul);
							$ul.appendTo($li);
							break;
						case "number":
							$a.text("Number Filter").appendTo($container);
							$("<span class='ui-menu-icon ui-icon ui-icon-carat-1-e'></span>").appendTo($a);
							$equals.appendTo($ul);
							$notequal.appendTo($ul);
							$ul.appendTo($li);
							break;
						case "time":
							$a.text("Time Filter").appendTo($container);
							$("<span class='ui-menu-icon ui-icon ui-icon-carat-1-e'></span>").appendTo($a);
							$equals.appendTo($ul);
							$ul.appendTo($li);
							break;
					}
					
					
			}
			
		}
		$container.appendTo($li);
      	
	  }
		

      // Position the menu.
	 var intLeft  =  $(this).offset().left-$menu.width()+10;
	 var intTop = $(this).offset().top + $(this).height()-8;
	 if(intTop+$menu.height()>$(window).height())intTop=intTop - $menu.height();
	 if (intLeft < 0) intLeft = $(this).offset().left;
      $menu
        .css("top", intTop)
        .css("left", intLeft)
	  $menu.menu();

      // Mark the header as active to keep the highlighting.
      $activeHeaderColumn = $menuButton.closest(".slick-header-column");
      $activeHeaderColumn
        .addClass("slick-header-column-active");
    }


    function handleMenuItemClick(e) {
		
      var command = $(this).data("command");
      var columnDef = $(this).data("column");
      var item = $(this).data("item");
	  var type = item.type;
	  
      if (item.disabled || type == 'custom') {
        return;
      }

      hideMenu();

      if (command != null && command != '') {
        _self.onCommand.notify({
            "grid": _grid,
            "column": columnDef,
            "command": command,
            "item": item
          }, e, _self);
      }

      // Stop propagation so that it doesn't register as a header click event.
      e.preventDefault();
      e.stopPropagation();
    }

    $.extend(this, {
      "init": init,
      "destroy": destroy,

      "onBeforeMenuShow": new Slick.Event(),
	  "onMenuElementCreated": new Slick.Event(),
      "onCommand": new Slick.Event()
    });
  }
})(jQuery);

jQuery.fn.multiselect = function(column,id) {
    $(this).each(function() {
		var checkbox = $(this).find("input:checkbox[name='select']")
        var checkboxes = $(this).find("input:checkbox([name='option'])");
		checkboxes.each(function(){
			$(this).click(function(){
				if(!$(this).prop("checked"))
					$(checkbox).prop("checked",false);
				else
				{
					var i=0;
					checkboxes.each(function(){
						if(!$(this).prop("checked")) i++;	
						
					})
					if(i==0)$(checkbox).prop("checked",true);
				}
			});
			
			if(!_.isUndefined(columnFilters[id][column.id]))
			{
				if(columnFilters[id][column.id].length ==0)
					$(this).prop("checked",true);
				else 
					if(_.contains(columnFilters[id][column.id],$(this).val()))
						$(this).prop("checked",true);
			}
			else
				$(this).prop("checked",true);
		})
		if(!_.isUndefined(columnFilters[id][column.id]))if((columnFilters[id][column.id].length ==0))checkbox.prop("checked",true);
        checkbox.click(function(){
			
				if($(this).prop("checked"))
				{
					checkboxes.each(function(){
							$(this).prop("checked",true)
					})
				}
				else
					checkboxes.each(function(){
							$(this).prop("checked",false)
					})
				
		})
    });
};