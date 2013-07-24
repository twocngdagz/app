	var notify = {
		'notify': function(a,b,c){
			$('#notify').html(a);
			if(c)$('#notify').addClass(c);
			$(".noticebox").each(function(index, element) {
                $(this).css("right",10).css("bottom",10);	
            });
			$(".noticebox").fadeIn('fast');
			if(!b)var t=setTimeout(function(){	$(".noticebox").fadeOut('fast');},20000);
			
		},
		'close': function(){
			$(".noticebox").fadeOut('fast');
		},
		'clear': function(){
			$(".noticebox").val('');
		}
	};
	
	$(document).ready(function(e) {
		$("html").append('<div class="noticebox""><div style="text-align:center"><a id="notify" align="center"></a></div></div>');
	});
