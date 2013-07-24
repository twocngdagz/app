	var calendar = {
		"calendar": function(a){
				require(["css!../styles/ui-gen.php?theme=dss&part&fc&","controls/fullcalendar.min"],function(){
					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth();
					var y = date.getFullYear();
					
					var div = $('<div id="'+a.attr("id")+'content" style="margin:10px"><b><i>Loading</i></b> <img src="../styles/images/ajax.gif" width="30px" height="10px" style="margin-left:10px"/> </div>');
					div.appendTo(a);
					div.html('');
					$('#'+a.attr("id")+'content').fullCalendar({
						aspectRatio:3,
		
						viewDisplay: function(view) {
		  
						},
						header: {
							left: 'prev,next today',
							center: 'title',
							right: 'month,agendaWeek,agendaDay'
						},
						allDaySlot:false,
						//editable: true,
						events: [
							{
								id: 999,
								title: 'WSI - Modi',
								start: new Date(y, m,d, 8, 30),
								allDay: false
							},
							{
								id: 999,
								title: 'Repeating Event',
								start: new Date(y, m, d+4, 16, 0),
								allDay: false
							},
							{
								title: 'Meeting',
								start: new Date(y, m, d, 10, 30),
								allDay: false
							},
							{
								title: 'Lunch',
								start: new Date(y, m, d, 12, 0),
								end: new Date(y, m, d, 14, 0),
								allDay: false
							},
							{
								title: 'Birthday Party',
								start: new Date(y, m, d+1, 19, 0),
								end: new Date(y, m, d+1, 22, 30),
								allDay: false
							},
							{
								title: 'Click for Google',
								start: new Date(y, m, 28),
								end: new Date(y, m, 29),
								url: 'http://google.com/'
							}
						]
					});
				});
			}
	}
	_.extend(widget,calendar)	
