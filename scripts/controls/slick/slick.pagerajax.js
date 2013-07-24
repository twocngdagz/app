(function($) {
    function SlickGridPager(dataView, grid, $container,settings)
    {
        var $status;
		var $paging;
        function init()
        {
			populate(0);
            constructPagerUI();
        }

		function populate(start)
		{
			$.ajax({
				url:settings.source,
				type:"POST",
				dataType:"json",
				data:{start:start,end:settings.pageSize}
			}).done(function(a){
				dataView = new Array();
				if(a)
				{
					dataView.setItems(a.items,settings.id);
					updatePager(a.paging);
					$paging = a.paging;
				}
				dataView.refresh();
				grid.invalidate;
			});		
		}
		function getNavState()
		{
			var cannotLeaveEditMode = !Slick.GlobalEditorLock.commitCurrentEdit();
			var pagingInfo = $paging;
			var lastPage = Math.floor($paging.totalRows/settings.pageSize);

            return {
                canGotoFirst:	!cannotLeaveEditMode && settings.pageSize != 0 && pagingInfo.pageNum > 0,
                canGotoLast:	!cannotLeaveEditMode && settings.pageSize != 0 && pagingInfo.pageNum != lastPage,
                canGotoPrev:	!cannotLeaveEditMode && settings.pageSize != 0 && pagingInfo.pageNum > 0,
                canGotoNext:	!cannotLeaveEditMode && settings.pageSize != 0 && pagingInfo.pageNum < lastPage,
                pagingInfo:		pagingInfo,
                lastPage:		lastPage
            }
        }

        function setPageSize(n)
        {
         	settings.pageSize =n;
        }

        function gotoFirst()
        {
            if (getNavState().canGotoFirst)
                populate(0)
        }

        function gotoLast()
        {
            var state = getNavState();
            if (state.canGotoLast)
                populate($paging.lastPage);
        }

        function gotoPrev()
        {
            var state = getNavState();
            if (state.canGotoPrev)
				populate($paging.pageNum-1);
               
        }

        function gotoNext()
        {
            var state = getNavState();
            if (state.canGotoNext)
                dapopulate($paging.pageNum+1)
        }

        function constructPagerUI()
        {
            $container.empty();

            var $nav = $("<span class='slick-pager-nav' />").appendTo($container);
            var $settings = $("<span class='slick-pager-settings' />").appendTo($container);
            $status = $("<span class='slick-pager-status' />").appendTo($container);

            $settings
                    .append("<span class='ui-state-default ui-corner-all ui-icon-container'><span style='float:left' id='search' class='ui-icon ui-icon-search' title='Toggle search panel'/></span><input style='width:200px;display:none;margin: 0px 5px 0px 5px;' id='txtSearch'/><span class='slick-pager-settings-expanded' style='display:none'>Show: <a data=0>All</a><a data='-1'>Auto</a><a data=25>25</a><a data=50>50</a><a data=100>100</a></span>");

            $settings.find("a[data]").click(function(e) {
                var pagesize = $(e.target).attr("data");
                if (pagesize != undefined)
                {
                    if (pagesize == -1)
                    {
                        var vp = grid.getViewport();
                        setPageSize(vp.bottom-vp.top);
                    }
                    else
                        setPageSize(parseInt(pagesize));
                }
            });

            var icon_prefix = "<span class='ui-state-default ui-corner-all ui-icon-container'><span class='ui-icon ";
            var icon_suffix = "' /></span>";

            $(icon_prefix + "ui-icon-lightbulb" + icon_suffix)
                    .click(function() { $(".slick-pager-settings-expanded").toggle() })
                    .appendTo($settings);

            $(icon_prefix + "ui-icon-seek-first" + icon_suffix)
                    .click(gotoFirst)
                    .appendTo($nav);

            $(icon_prefix + "ui-icon-seek-prev" + icon_suffix)
                    .click(gotoPrev)
                    .appendTo($nav);

            $(icon_prefix + "ui-icon-seek-next" + icon_suffix)
                    .click(gotoNext)
                    .appendTo($nav);

            $(icon_prefix + "ui-icon-seek-end" + icon_suffix)
                    .click(gotoLast)
                    .appendTo($nav);

            $container.find(".ui-icon-container")
                    .hover(function() {
                        $(this).toggleClass("ui-state-hover");
                    });

            $container.children().wrapAll("<div class='slick-pager' />");
        }


        function updatePager(pagingInfo)
        {
            var state = pagingInfo;

            $container.find(".slick-pager-nav span").removeClass("ui-state-disabled");
            if (!state.canGotoFirst) $container.find(".ui-icon-seek-first").addClass("ui-state-disabled");
            if (!state.canGotoLast) $container.find(".ui-icon-seek-end").addClass("ui-state-disabled");
            if (!state.canGotoNext) $container.find(".ui-icon-seek-next").addClass("ui-state-disabled");
            if (!state.canGotoPrev) $container.find(".ui-icon-seek-prev").addClass("ui-state-disabled");


            if (pagingInfo.pageSize == 0)
                $status.text("Showing all " + pagingInfo.totalRows + " rows");
            else
                $status.text("Showing page " + (pagingInfo.pageNum+1) + " of " + (Math.floor(pagingInfo.totalRows/pagingInfo.pageSize)+1));
        }



        init();
    }

    // Slick.Controls.Pager
    $.extend(true, window, { Slick: { Controls: { Pager: SlickGridPager }}});
})(jQuery);
