	function pad(n, width, z) {
	  z = z || '0';
	  n = n + '';
	  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}
	
	$(window).scroll(function () { 
		$(".chatbox")
			.animate({"bottom": -($(window).scrollTop())+"px"}, "fast" );
		$(".chatgroup")
			.animate({"bottom": -($(window).scrollTop())+"px"}, "fast" );
	});

	function dataExe(cmd,dataset,data,id)
	{	
		switch(cmd)
		{
			case 0:
				dataset.beginUpdate();
				dataset.setItems(data);
				dataset.endUpdate();
				break;	
			case 1:
				dataset.beginUpdate();
				dataset.addItem(data);
				dataset.endUpdate();
				break;	
			case 2:
				dataset.beginUpdate();
				dataset.updateItem((id)?id:data.id,data);
				dataset.endUpdate();
				break;		
			case 3:
				dataset.beginUpdate();
				dataset.deleteItem(id);
				dataset.endUpdate();
				break;						
		}
	}
	
	function sendAjax(typ,url,dat,msg){
		if(!msg)msg='request';
			 var request = $.ajax({
			type: typ,
			url: url,
			data: dat
			});
		return request;
	};
	
	function setCookie(c_name,value,exdays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value+";path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	
	String.prototype.format = function() {
		var formatted = this;
		for (var i = 0; i < arguments.length; i++) {
			var regexp = new RegExp('\\{'+i+'\\}', 'gi');
			formatted = formatted.replace(regexp, arguments[i]);
		}
		return formatted;
	};
	
	(function() {
		var matched, browser;
	// Use of jQuery.browser is frowned upon.
	// More details: http://api.jquery.com/jQuery.browser
	// jQuery.uaMatch maintained for back-compat
		jQuery.uaMatch = function( ua ) {
			ua = ua.toLowerCase();
	
			var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
				/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
				/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
				/(msie) ([\w.]+)/.exec( ua ) ||
				ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
				[];
	
			return {
				browser: match[ 1 ] || "",
				version: match[ 2 ] || "0"
			};
		};
	
		matched = jQuery.uaMatch( navigator.userAgent );
		browser = {};
	
		if ( matched.browser ) {
			browser[ matched.browser ] = true;
			browser.version = matched.version;
		}
	
	// Chrome is Webkit, but Webkit is also Safari.
		if ( browser.chrome ) {
			browser.webkit = true;
		} else if ( browser.webkit ) {
			browser.safari = true;
		}
	
		jQuery.browser = browser;
	
		jQuery.sub = function() {
			function jQuerySub( selector, context ) {
				return new jQuerySub.fn.init( selector, context );
			}
			jQuery.extend( true, jQuerySub, this );
			jQuerySub.superclass = this;
			jQuerySub.fn = jQuerySub.prototype = this();
			jQuerySub.fn.constructor = jQuerySub;
			jQuerySub.sub = this.sub;
			jQuerySub.fn.init = function init( selector, context ) {
				if ( context && context instanceof jQuery && !(context instanceof jQuerySub) ) {
					context = jQuerySub( context );
				}
	
				return jQuery.fn.init.call( this, selector, context, rootjQuerySub );
			};
			jQuerySub.fn.init.prototype = jQuerySub.fn;
			var rootjQuerySub = jQuerySub(document);
			return jQuerySub;
		};
	
	})();
