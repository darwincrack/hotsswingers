//<script>
$(document).ready(function(){
		var $listsbg = <?php echo json_encode(__PostBackground_List__);?>;
		if($('.ossn-wall-container-data').length){
				$('<div id="ossn-wall-postbg" style="display:none;"></div>').insertAfter('.ossn-wall-container-data textarea');
				$.each($listsbg, function(){
					$('#ossn-wall-postbg').append('<span class="" data-postbg-type="'+this['name']+'" style="background:url(\''+this['url']+'\'";background-position: center; background-size: cover;"></div>');
				});
				$('#ossn-wall-form').append('<input class="postbg-input" name="postbackground_type" type="hidden"/>');
		}
		$('body').on('click', '.ossn-wall-container-control-menu-postbg-selector', function(){
				$('.ossn-wall-container-data div').each(function(){
						$id = $(this).attr('id');
						if($id && $id.indexOf('ossn-wall-') >= 0){
								$(this).hide();
						}	
				});
				if($('#ossn-wall-postbg').attr('data-toggle') == 0 || !$('#ossn-wall-postbg').attr('data-toggle')){
					$('#ossn-wall-postbg').attr('data-toggle', 1);
					$('#ossn-wall-postbg').show();
				} else {
					
					$('.ossn-wall-container-data .postbg-container').attr('style', '');
     					$('.ossn-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
					
					$('#ossn-wall-postbg').attr('data-toggle', 0);
					$('#ossn-wall-postbg').hide();
				}
		});
 		$('.ossn-wall-container-data textarea').keyup(function(){
   				var length = $.trim(this.value).length;
				if(length > 125) {
					$('.ossn-wall-container-data .postbg-container').attr('style', '');
     				$('.ossn-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
    			}
		});		
		$('body').on('click', '#ossn-wall-postbg span', function(){
					$type = $(this).attr('data-postbg-type');	
					var i = 0;
					for(i=0;i<=$listsbg.length;i++){
							if($listsbg[i]['name'] == $type){
								$('.ossn-wall-container-data textarea').addClass('postbg-container');
								$('.ossn-wall-container-data .postbg-container').css({
											'background': 'url("'+$listsbg[i]['url']+'")',
											'background-position': 'center',
											'background-size': 'cover',
											'color': $listsbg[i]['color_hex'],
								});
								$('.postbg-input').val($type);
								break;	
							}
					}
		});
		$(document).ajaxComplete(function(event, xhr, settings) {
			var $url = settings.url;
			$pagehandler = $url.replace(Ossn.site_url, '');
			
			if($pagehandler.indexOf('action/wall/post/a') >= 0 || $pagehandler.indexOf('action/wall/post/g') >= 0 || $pagehandler.indexOf('action/wall/post/u') >= 0 || $pagehandler.indexOf('action/wall/post/bpage') >= 0){
					$('.ossn-wall-container-data .postbg-container').attr('style', '');
     				$('.ossn-wall-container-data textarea').removeClass('postbg-container');
					if($('.postbg-input').length){
						$('.postbg-input').val('');
					}
					//hide panel
					$('.ossn-wall-container-data div').each(function(){
						$id = $(this).attr('id');
						if($id && $id.indexOf('ossn-wall-') >= 0){
								$(this).hide();
						}
					});					
			}
			if($pagehandler.indexOf('wall/post/embed') >= 0){
					$data = settings.data;
					$listsdata = $data.split('&');
					if($listsdata.length > 0){
						$.each($listsdata, function($key, $value){
							if($value.indexOf('guid=') >=0){
									$guid = $value.replace('guid=', '');
									$element = $('#activity-item-'+$guid);
									if($element.length && $element.find('.postbg-container')){
											$text = $element.find('.postbg-container').text();
											if($text && $text.length > 125){
												$element.find('.postbg-container').removeClass('postbg-container').attr('style', '');
												$element.find('.postbg-text').removeClass('postbg-text');
											}
									}
							}
						});
					}
			}
		});		
});


/*! iFrame Resizer (iframeSizer.min.js ) - v2.8.3 - 2015-01-29
 *  Desc: Force cross domain iframes to size to content.
 *  Requires: iframeResizer.contentWindow.min.js to be loaded into the target frame.
 *  Copyright: (c) 2015 David J. Bradshaw - dave@bradshaw.net
 *  License: MIT
 */

!function(){"use strict";function a(a,b,c){"addEventListener"in window?a.addEventListener(b,c,!1):"attachEvent"in window&&a.attachEvent("on"+b,c)}function b(){var a,b=["moz","webkit","o","ms"];for(a=0;a<b.length&&!A;a+=1)A=window[b[a]+"RequestAnimationFrame"];A||e(" RequestAnimationFrame not supported")}function c(){var a="Host page";return window.top!==window.self&&(a=window.parentIFrame?window.parentIFrame.getId():"Nested host page"),a}function d(a){return w+"["+c()+"]"+a}function e(a){C.log&&"object"==typeof window.console&&console.log(d(a))}function f(a){"object"==typeof window.console&&console.warn(d(a))}function g(a){function b(){function a(){k(F),i(),C.resizedCallback(F)}g("Height"),g("Width"),l(a,F,"resetPage")}function c(a){var b=a.id;e(" Removing iFrame: "+b),a.parentNode.removeChild(a),C.closedCallback(b),e(" --")}function d(){var a=E.substr(x).split(":");return{iframe:document.getElementById(a[0]),id:a[0],height:a[1],width:a[2],type:a[3]}}function g(a){var b=Number(C["max"+a]),c=Number(C["min"+a]),d=a.toLowerCase(),f=Number(F[d]);if(c>b)throw new Error("Value for min"+a+" can not be greater than max"+a);e(" Checking "+d+" is in range "+c+"-"+b),c>f&&(f=c,e(" Set "+d+" to min value")),f>b&&(f=b,e(" Set "+d+" to max value")),F[d]=""+f}function m(){var b=a.origin,c=F.iframe.src.split("/").slice(0,3).join("/");if(C.checkOrigin&&(e(" Checking connection is from: "+c),""+b!="null"&&b!==c))throw new Error("Unexpected message received from: "+b+" for "+F.iframe.id+". Message was: "+a.data+". This error can be disabled by adding the checkOrigin: false option.");return!0}function n(){return w===(""+E).substr(0,x)}function o(){var a=F.type in{"true":1,"false":1};return a&&e(" Ignoring init message from meta parent page"),a}function p(a){return E.substr(E.indexOf(":")+v+a)}function q(a){e(" MessageCallback passed: {iframe: "+F.iframe.id+", message: "+a+"}"),C.messageCallback({iframe:F.iframe,message:JSON.parse(a)}),e(" --")}function r(){if(null===F.iframe)throw new Error("iFrame ("+F.id+") does not exist on "+y);return!0}function s(a){var b=a.getBoundingClientRect();return h(),{x:parseInt(b.left,10)+parseInt(z.x,10),y:parseInt(b.top,10)+parseInt(z.y,10)}}function u(a){function b(){z=g,A(),e(" --")}function c(){return{x:Number(F.width)+d.x,y:Number(F.height)+d.y}}var d=a?s(F.iframe):{x:0,y:0},g=c();e(" Reposition requested from iFrame (offset x:"+d.x+" y:"+d.y+")"),window.top!==window.self?window.parentIFrame?a?parentIFrame.scrollToOffset(g.x,g.y):parentIFrame.scrollTo(F.width,F.height):f(" Unable to scroll to requested position, window.parentIFrame not found"):b()}function A(){!1!==C.scrollCallback(z)&&i()}function B(a){function b(a){var b=s(a);e(" Moving to in page link (#"+c+") at x: "+b.x+" y: "+b.y),z={x:b.x,y:b.y},A(),e(" --")}var c=a.split("#")[1]||"",d=decodeURIComponent(c),f=document.getElementById(d)||document.getElementsByName(d)[0];window.top!==window.self?window.parentIFrame?parentIFrame.moveToAnchor(c):e(" In page link #"+c+" not found and window.parentIFrame not found"):f?b(f):e(" In page link #"+c+" not found")}function D(){switch(F.type){case"close":c(F.iframe),C.resizedCallback(F);break;case"message":q(p(6));break;case"scrollTo":u(!1);break;case"scrollToOffset":u(!0);break;case"inPageLink":B(p(9));break;case"reset":j(F);break;case"init":b(),C.initCallback(F.iframe);break;default:b()}}var E=a.data,F={};n()&&(e(" Received: "+E),F=d(),!o()&&r()&&m()&&(D(),t=!1))}function h(){null===z&&(z={x:void 0!==window.pageXOffset?window.pageXOffset:document.documentElement.scrollLeft,y:void 0!==window.pageYOffset?window.pageYOffset:document.documentElement.scrollTop},e(" Get page position: "+z.x+","+z.y))}function i(){null!==z&&(window.scrollTo(z.x,z.y),e(" Set page position: "+z.x+","+z.y),z=null)}function j(a){function b(){k(a),m("reset","reset",a.iframe)}e(" Size reset requested by "+("init"===a.type?"host page":"iFrame")),h(),l(b,a,"init")}function k(a){function b(b){a.iframe.style[b]=a[b]+"px",e(" IFrame ("+a.iframe.id+") "+b+" set to "+a[b]+"px")}C.sizeHeight&&b("height"),C.sizeWidth&&b("width")}function l(a,b,c){c!==b.type&&A?(e(" Requesting animation frame"),A(a)):a()}function m(a,b,c){e("["+a+"] Sending msg to iframe ("+b+")"),c.contentWindow.postMessage(w+b,"*")}function n(){function b(){function a(a){1/0!==C[a]&&0!==C[a]&&(i.style[a]=C[a]+"px",e(" Set "+a+" = "+C[a]+"px"))}a("maxHeight"),a("minHeight"),a("maxWidth"),a("minWidth")}function c(a){return""===a&&(i.id=a="iFrameResizer"+s++,e(" Added missing iframe ID: "+a+" ("+i.src+")")),a}function d(){e(" IFrame scrolling "+(C.scrolling?"enabled":"disabled")+" for "+k),i.style.overflow=!1===C.scrolling?"hidden":"auto",i.scrolling=!1===C.scrolling?"no":"yes"}function f(){("number"==typeof C.bodyMargin||"0"===C.bodyMargin)&&(C.bodyMarginV1=C.bodyMargin,C.bodyMargin=""+C.bodyMargin+"px")}function g(){return k+":"+C.bodyMarginV1+":"+C.sizeWidth+":"+C.log+":"+C.interval+":"+C.enablePublicMethods+":"+C.autoResize+":"+C.bodyMargin+":"+C.heightCalculationMethod+":"+C.bodyBackground+":"+C.bodyPadding+":"+C.tolerance}function h(b){a(i,"load",function(){var a=t;m("iFrame.onload",b,i),!a&&C.heightCalculationMethod in B&&j({iframe:i,height:0,width:0,type:"init"})}),m("init",b,i)}var i=this,k=c(i.id);d(),b(),f(),h(g())}function o(a){if("object"!=typeof a)throw new TypeError("Options is not an object.")}function p(a){a=a||{},o(a);for(var b in D)D.hasOwnProperty(b)&&(C[b]=a.hasOwnProperty(b)?a[b]:D[b])}function q(){function a(a){if(!a.tagName)throw new TypeError("Object is not a valid DOM element");if("IFRAME"!==a.tagName.toUpperCase())throw new TypeError("Expected <IFRAME> tag, found <"+a.tagName+">.");n.call(a)}return function(b,c){switch(p(b),typeof c){case"undefined":case"string":Array.prototype.forEach.call(document.querySelectorAll(c||"iframe"),a);break;case"object":a(c);break;default:throw new TypeError("Unexpected data type ("+typeof c+").")}}}function r(a){a.fn.iFrameResize=function(a){return p(a),this.filter("iframe").each(n).end()}}var s=0,t=!0,u="message",v=u.length,w="[iFrameSizer]",x=w.length,y="",z=null,A=window.requestAnimationFrame,B={max:1,scroll:1,bodyScroll:1,documentElementScroll:1},C={},D={autoResize:!0,bodyBackground:null,bodyMargin:null,bodyMarginV1:8,bodyPadding:null,checkOrigin:!0,enablePublicMethods:!1,heightCalculationMethod:"offset",interval:32,log:!1,maxHeight:1/0,maxWidth:1/0,minHeight:0,minWidth:0,scrolling:!1,sizeHeight:!0,sizeWidth:!1,tolerance:0,closedCallback:function(){},initCallback:function(){},messageCallback:function(){},resizedCallback:function(){},scrollCallback:function(){return!0}};b(),a(window,"message",g),window.jQuery&&r(jQuery),"function"==typeof define&&define.amd?define([],q):"object"==typeof exports?module.exports=q():window.iFrameResize=q()}();
//# sourceMappingURL=iframeResizer.map


$( document ).ready(function() {
 $("#iframelives").iFrameResize({"scrolling":false},"iframe");

});