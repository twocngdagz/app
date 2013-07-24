
	function setactivepage (url){
			runsql(url,'',"jsbody");
	}
	
	function clears(form){
		jQuery("#"+form+" .pfbc-error").remove();
		var $inputs = $('#'+ form+' :text');
		var values = {};
		$inputs.each(function() {
			$(this).val('')
    	});
	}

	function validates(form,save,url,parent,closeform){
			var $inputs = $('#'+form+' :input');
			var $datstr='';
		
			$inputs.each(function() {
					if ($(this).attr("type") != "radio" && $(this).attr("type") != "checkbox" && $(this).attr("name") != undefined && $(this).attr("name").length>0){
						
						$datstr= $datstr + "&" + $(this).attr("name")+"="+ $(this).val();
					} else if ($(this).attr("type") == "checkbox" && $(this).attr("name") !=undefined && $(this).attr("name") !="")
							{
							
								$datstr= $datstr + "&" + $(this).attr("name")+"="+(($(this).attr("checked"))?1:0);	
					} else {
						
						if($(this).is(':checked')){ $datstr= $datstr + "&" + $(this).attr("name")+"="+ $(this).val()};
					} 	
					
			});
	
			notify.clear();
	
			var g = runsql(url,"&save="+save+$datstr,"notify");	
			try{jQuery("#"+form+" button[type=submit] span.ui-button-text").css("padding-right", "1em").find("img").remove();
			jQuery("#"+form+" button[type=submit]").button("enable");}catch(e){}
			if(!closeform)$("#"+((parent)?parent:form)).dialog('close');
			return g;
		};
		
	function runsql(url,data,element,type,setForm){
			notify.notify("Processing request...");
			dType='';
			var d = $.Deferred();
			if(!type)type="POST";
			if(setForm) dType="JSON";
	
		 	$.ajax({
				type: type,
				url: url,
				data: data,
				dataType: dType
			}).done( function(dat){
						notify.close();
						dats = dat;	
						if(element && !setForm)$("#"+element).html(dat);
						if(setForm){
							
								var $inputs = $('#'+element+ " :input");
									
								$inputs.each(function() {
								
									try {
										if($(this).attr("type") == "text"  && $(this).attr("name") !=undefined && $(this).attr("name") !="" ) {
											$(this).val(dats[0][$(	this).attr("name")]);
										} else if ($(this).attr("type") == "radio" && $(this).attr("name") !=undefined && $(this).attr("name") !="" )
										{
											var $input2 = $('#'+element+ " :radio");
											$input2.each(function(){
											
												if($(this).val()==dats[0][$(this).attr("name")]) $(this).prop("checked",true);
											});
										} else if ($(this).attr("type") == "checkbox" && $(this).attr("name") !=undefined && $(this).attr("name") !="")
										{
												$(this).attr("checked",false);	
												if(1==dats[0][$(this).attr("name")]) $(this).prop("checked",true);
			
										} else if ($(this).attr("dateformat")!=undefined && $(this).attr("dateformat") !="" && $(this).attr("name") !=undefined && $(this).attr("name") !="")
										{	
												var myDate = new Date(dats[0][$(this).attr("name")]);
												$(this).val($.datepicker.formatDate($(this).attr("dateformat"), myDate));		
										} else if ($(this).attr("multiple")!=undefined && $(this).attr("name") !=undefined && $(this).attr("name") !="")
										{	
										
												$(this).val('');
												
												if(dats[0][$(this).attr("name").substr(0,$(this).attr("name").length-2)]!= null)
										
										{		var values =(dats[0][$(this).attr("name").substr(0,$(this).attr("name").length-2)]).split(",");
												
													$(this).val(values);
										}
												if($(this).hasClass("chzn-done"))$(this).trigger("liszt:updated");
										} else{
										
											$(this).val(dats[0][$(this).attr("name")]);
										}
										} catch (err){}
								});
						}
						d.resolve(dat);
					}); 
					return d.promise(); 
					    			
	}