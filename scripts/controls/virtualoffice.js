(function(e){e.widget("ui.chatbox",{options:{id:null,idx:null,title:null,user:null,hidden:false,offset:0,width:330,token:(new Date).valueOf(),messageTyping:function(e,t,n,r,i){},messageSent:function(e,t,n,r,i,s){this.boxManager.addMsg(n.first_name,r)},boxClosed:function(e){},boxManager:{init:function(e){this.elem=e},addMsg:function(t,n,r,i,s){var o=this;var u=o.elem.uiChatboxLog;var a=document.createElement("div");u.append(a);e(a).hide();e(a).attr("id",i?i.msgid:"");e(a).addClass(s);var f=false;var l=document.createElement("table");var c=document.createElement("tr");e(c).appendTo(l);a.appendChild(l);if(t){var h=document.createElement("td");var p=document.createElement("a");e(p).appendTo(h);e(h).attr("valign","top");e(p).css("background","#ddd url("+t+") no-repeat").addClass("chatboxpic").attr("width",30);c.appendChild(h)}else{f=true}var d=document.createElement("td");e(d).attr("valign","top").attr("width",r-40);var v=document.createElement(f?"i":"div");var m=document.createElement("span");e(v).appendTo(d);e(v).html("<br/>"+n).addClass("bubble");if(!f&&i){var g=new Date(Date.parse(i.datesent).valueOf()+(virtualoffice.getTimeZone()+4)*6e4*60);var y;if(g.toString("yyyy/MM/dd")==(new Date).toString("yyyy/MM/dd"))y=g.toString("hh:mm");else y=g.toString("yyyy/MM/dd hh:mm");e(m).html(y).prependTo(v).addClass("timestamp");}c.appendChild(d);e(a).addClass("ui-chatbox-msg");e(a).fadeIn();this.elem.uiChatboxLogBox.mCustomScrollbar("update");o._scrollToBottom();if(!o.elem.uiChatboxTitlebar.hasClass("ui-state-focus")&&!o.highlightLock){o.highlightLock=true;o.highlightBox()}},highlightBox:function(){var e=this;e.elem.uiChatboxTitlebar.effect("highlight",{},300);e.elem.uiChatbox.effect("bounce",{times:3},300,function(){e.highlightLock=false;e._scrollToBottom()})},toggleBox:function(){this.elem.uiChatbox.toggle()},_scrollToBottom:function(){var e=this.elem.uiChatboxLogBox;e.mCustomScrollbar("scrollTo","bottom")}}},toggleContent:function(e){this.uiChatboxContent.toggle();if(this.uiChatboxContent.is(":visible")){this.uiChatboxInputBox.focus()}else{}},widget:function(){return this.uiChatbox},_create:function(){var t=this,n=t.options,r=n.title||"No Title",i=(t.uiChatbox=e("<div></div>")).appendTo(document.body).addClass("ui-widget "+"ui-corner-top "+"ui-chatbox").attr("outline",0).attr("id",n.id).focusin(function(){t.uiChatboxTitlebar.addClass("ui-state-focus")}).focusout(function(){t.uiChatboxTitlebar.removeClass("ui-state-focus")}),s=(t.uiChatboxTitlebar=e("<div></div>")).addClass("ui-widget-header "+"ui-corner-top "+"ui-chatbox-titlebar "+"ui-dialog-header").click(function(e){t.toggleContent(e)}).appendTo(i),o=(t.uiChatboxTitle=e('<span id="msgTitle" class="msgT" style="padding-left:15px;float:left"></span>')).html(r).appendTo(s),u=(t.uiChatboxTitlebarClose=e('<a href="#"></a>')).addClass("ui-corner-all "+"ui-chatbox-icon ").attr("role","button").hover(function(){u.addClass("ui-state-hover")},function(){u.removeClass("ui-state-hover")}).click(function(e){i.hide();t.options.boxClosed(t.options.id);return false}).appendTo(s),a=e("<span ></span>").addClass("ui-icon "+"ui-icon-closethick").text("close").appendTo(u),f=(t.uiChatboxTitlebarMinimize=e('<a href="#"></a>')).addClass("ui-corner-all "+"ui-chatbox-icon").attr("role","button").hover(function(){f.addClass("ui-state-hover")},function(){f.removeClass("ui-state-hover")}).click(function(e){t.toggleContent(e);return false}).appendTo(s),l=e("<span></span>").addClass("ui-icon "+"ui-icon-minusthick").text("minimize").appendTo(f),c=(t.uiChatboxContent=e("<div></div>")).addClass("ui-widget-content "+"ui-chatbox-content ").appendTo(i),h=(t.uiChatboxLogBox=e("<div></div>")).addClass("ui-widget-content "+"ui-chatbox-log").appendTo(c),p=(t.uiChatboxLog=t.element).appendTo(h),d=(t.uiChatboxInput=e("<div></div>")).addClass("ui-widget-content "+"ui-chatbox-input").click(function(e){}).appendTo(c),v=(t.uiChatboxInputBox=e("<textarea></textarea>")).addClass("ui-widget-content "+"ui-chatbox-input-box "+"ui-corner-all").TextAreaExpander().appendTo(d).keydown(function(n){if(n.keyCode&&n.keyCode==e.ui.keyCode.ENTER){msg=e.trim(e(this).val());if(msg.length>0){t.options.messageSent(t.options.id,t.options.idx,t.options.user,msg,t.options.token,2)}e(this).val("");return false}else{msg=e.trim(e(this).val());if(n.keyCode&&n.keyCode==e.ui.keyCode.BACKSPACE&&msg.length==1){t.options.messageTyping(t.options.id,t.options.idx,msg,t.options.token,1);return true}if(msg.length==0&&n.keyCode!=e.ui.keyCode.BACKSPACE){t.options.messageTyping(t.options.id,t.options.idx,msg,t.options.token,0)}return true}}).focusin(function(){v.addClass("ui-chatbox-input-focus");var t=e(this).parent().prev();t.scrollTop(t.get(0).scrollHeight)}).focusout(function(){v.removeClass("ui-chatbox-input-focus")});s.find("*").add(s).disableSelection();c.children().click(function(){t.uiChatboxInputBox.focus()});t._setWidth(t.options.width);t._position(t.options.offset);t.options.boxManager.init(t);if(!t.options.hidden){i.show()}t.options.initiated(t.options.id,t.options.idx)},_setOption:function(t,n){if(n!=null){switch(t){case"hidden":if(n)this.uiChatbox.hide();else this.uiChatbox.show();break;case"offset":this._position(n);break;case"width":this._setWidth(n);break}}e.Widget.prototype._setOption.apply(this,arguments)},_setWidth:function(e){this.uiChatboxTitlebar.width(e+"px");this.uiChatboxLog.width(e-30+"px");this.uiChatboxLogBox.mCustomScrollbar({theme:"dark"});this.uiChatboxInputBox.css("width",e-14+"px")},_position:function(e){this.uiChatbox.css("left",e)}})})(jQuery);if(!Array.indexOf){Array.prototype.indexOf=function(e){for(var t=0;t<this.length;t++){if(this[t]==e){return t}}return-1}}(function(e){e.fn.TextAreaExpander=function(t,n){function i(e){e=e.target||e;var t=e.value.length,n=e.offsetWidth;if(t!=e.valLength||n!=e.boxWidth){if(r&&(t<e.valLength||n!=e.boxWidth))e.style.height="0px";var i=Math.max(e.expandMin,Math.min(e.scrollHeight,e.expandMax));e.style.overflow=e.scrollHeight>i?"auto":"hidden";e.style.height=i+"px";e.valLength=t;e.boxWidth=n}return true}var r=!(e.browser.msie||e.browser.opera);this.each(function(){if(this.nodeName.toLowerCase()!="textarea")return;t=e(this).parent().height();var r=this.className.match(/expand(\d+)\-*(\d+)*/i);this.expandMin=t||(r?parseInt("0"+r[1],10):0);this.expandMax=n||(r?parseInt("0"+r[2],10):99999);i(this);if(!this.Initialized){this.Initialized=true;e(this).css("padding-top",0).css("padding-bottom",0);e(this).bind("keyup",i).bind("focus",i)}});return this}})(jQuery);var virtualoffice={option:{serverDate:(new Date).toString("yyyy/MM/dd hh:mm:ss"),apiUrl:"../api/messaging.php"},close:function(e){$("#"+e).remove();clearInterval(intervals[e.substr(4)]);var t=chatbox.indexOf(e.substr(4));chatbox.splice(t,1);this.reposition()},reposition:function(){for(var e=0;e<chatbox.length;e++){$("#chat"+chatbox[e]).css("left",180+(250+20)*e)}},loadMessages:function(e,t,n,r){if(e.length==0)return;var i=e;var s=r?r:1;var o=n?n:"1990/12/1";$.ajax({url:virtualoffice.option.apiUrl,type:"GET",data:{cmd:"2",id:t,time:o,d:(new Date).valueOf(),status:s},success:function(e){if(e){i.find($(".temp")).remove();var t;var n=0;for(var r=0;r<e.length;r++){t=e.length-r-1;if(parseInt(e[r].status)>0)if(Date.parse(e[r].datesent).valueOf()>Date.parse(o).valueOf()&&e[r].status>0)o=e[r].datesent;if(!(e[t].status==0&&$("#user"+e[t].from).attr("status")>1)){if(e[t].status==0&&n==0||e[t].status!=0)i.chatbox("option","boxManager").addMsg(e[t].status!=0?"../utils/images/profiles/small/"+e[t].from+".jpg":null,e[t].status!=0?e[t].message:"Typing...",250,e[t],e[t].status==0?"temp":"");if(e[t].status==0)n++}}if(n>0)s=2;else s=1}i.chatbox("option","_scrollToBottom")},dataType:"json",complete:function(){virtualoffice.loadMessages(e,t,o,s)},timeout:3e4})},checkUsers:function(e,t){var n=e;var r=t?t:"1990/12/1";$.ajax({url:virtualoffice.option.apiUrl,type:"GET",data:{cmd:"0",time:r,d:(new Date).valueOf()},success:function(e){if(e){}},dataType:"json",complete:function(){virtualoffice.loadMessages(e,r)},timeout:3e4})},getTimeZone:function(){var e=new Date;var t=new Date(e.getFullYear(),0,1,0,0,0,0);var n=new Date(e.getFullYear(),6,1,0,0,0,0);var r=t.toGMTString();var i=new Date(r.substring(0,r.lastIndexOf(" ")-1));r=n.toGMTString();var s=new Date(r.substring(0,r.lastIndexOf(" ")-1));var o=(t-i)/(1e3*60*60);var u=(n-s)/(1e3*60*60);var a;if(o==u){a=0}else{var f=o-u;if(f>=0)o=u;a=1}return o+a},attachUser:function(e){var t=$(document.createElement("table"));var n=$(document.createElement("li"));var r=$(document.createElement("tr"));var i=$(document.createElement("td"));var s=$(document.createElement("td"));var o="offline";var u=e.statusmessage;if(e.statusupdate){if(Date.parse(e.statusupdate).valueOf()<Date.parse(this.option.serverDate).valueOf()-5*6e4)e.status="9"}else e.status="9";switch(e.status){case"9":o="offline";u=u?e.statusmessage:"Offline";break;case"2":o="away";u=u?e.statusmessage:"Idle";break;case"3":o="busy";u=u?e.statusmessage:"Busy";break;default:o="online";u=u?e.statusmessage:"Online";break}i.attr("rowspan",2);var a=$((e.img==1?'<img src="../utils/images/profiles/small/'+e.userid+'.jpg"':'<img src="../styles/images/contactpic.png"')+'class="'+o+'">');s.attr("valign","middle").css("padding-left","5px");var f=$('<a style="font-weight:bold">'+e.firstname+" "+e.lastname+'</a><br><a style="font-style:italic;font-size:8px;">'+u+'</a>"');a.appendTo(i);f.appendTo(s);i.appendTo(r);s.appendTo(r);r.appendTo(t);t.appendTo(n);n.attr("data",e.userid).attr("fn",e.firstname).attr("ln",e.lastname).attr("id","user"+e.userid).attr("status",e.status).appendTo($("#chatlist")).click(function(e){var t=$(this);var n=t.attr("data");var r=chatbox.indexOf(n);if(r!=-1)$("#chat"+n+" .ui-chatbox-content").find("textarea").focus();else{var i=document.createElement("div");$(i).chatbox({id:"chat"+n,idx:n,user:t.attr("data"),title:t.attr("fn")+" "+t.attr("ln"),hidden:false,width:250,offset:180+(250+20)*chatbox.length,messageSent:function(e,t,n,r,i,s){if(r){this.boxManager.addMsg(null,"Sending",200,null,"temp");sendAjax("GET",virtualoffice.option.apiUrl,"cmd=3&status="+s+"&to="+t+"&token="+i+e+"&message="+r+"&d="+(new Date).valueOf())}},messageTyping:function(e,t,n,r,i){sendAjax("GET",virtualoffice.option.apiUrl,"cmd=3&status="+i+"&to="+t+"&token="+r+e+"&message="+n+"&d="+(new Date).valueOf())},boxClosed:function(e){virtualoffice.close(e)},initiated:function(e,t){}});chatbox.push(n);$("#chat"+n+" .ui-chatbox-content").find("textarea").focus();virtualoffice.loadMessages($(i),n)}})},load:function(e){var t=e?e:"1990/1/1";sendAjax("GET",virtualoffice.option.apiUrl,"time="+t+"&cmd=0&d="+(new Date).valueOf()).done(function(e){if(e){var n=$.parseJSON(e);$("#chatlist").html("");for(var r=0;r<n.length;r++){if(n[r].statusupdate)if(Date.parse(n[r].statusupdate).valueOf()>Date.parse(t).valueOf())t=n[r].statusupdate;virtualoffice.attachUser(n[r])}}setTimeout(virtualoffice.load(t),1e4)})},init:function(){sendAjax("GET",virtualoffice.option.apiUrl,"cmd=1&status=1&d="+(new Date).valueOf());sendAjax("GET",virtualoffice.option.apiUrl,"cmd=3&status=4&d="+(new Date).valueOf());this.load();require(["controls/jquery.scroll"],function(){$("#chatcontent").mCustomScrollbar({autoDraggerLength:false,theme:"dark",set_height:$("#content").height()-280,advanced:{updateOnContentResize:true}})})}}