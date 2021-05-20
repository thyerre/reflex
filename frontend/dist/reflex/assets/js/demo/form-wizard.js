
// Form-Wizard.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -


$(document).on('nifty.ready', function() {



    // FORM WIZARD
    // =================================================================
    // Require Bootstrap Wizard
    // http://vadimg.com/twitter-bootstrap-wizard-example/
    // =================================================================


    // MAIN FORM WIZARD
    // =================================================================
    $('#main-wz').bootstrapWizard({
        tabClass		: 'wz-steps',
        nextSelector	: '.next',
        previousSelector	: '.previous',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#main-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            var wdt = 100/$total;
            var lft = wdt*index;

            $('#main-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});


            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#main-wz').find('.next').hide();
                $('#main-wz').find('.finish').show();
                $('#main-wz').find('.finish').prop('disabled', false);
            } else {
                $('#main-wz').find('.next').show();
                $('#main-wz').find('.finish').hide().prop('disabled', true);
            }
        }
    });




    // CLASSIC STYLE
    // =================================================================
    $('#cls-wz').bootstrapWizard({
        tabClass		: 'wz-classic',
        nextSelector	: '.next',
        previousSelector	: '.previous',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#cls-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            var wdt = 100/$total;
            var lft = wdt*index;
            $('#cls-wz').find('.progress-bar').css({width:$percent+'%'});

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#cls-wz').find('.next').hide();
                $('#cls-wz').find('.finish').show();
                $('#cls-wz').find('.finish').prop('disabled', false);
            } else {
                $('#cls-wz').find('.next').show();
                $('#cls-wz').find('.finish').hide().prop('disabled', true);
            }
        }
    });




    // BUBBLE NUMBERS
    // =================================================================
    $('#step-wz').bootstrapWizard({
        tabClass		: 'wz-steps',
        nextSelector	: '.next',
        previousSelector	: '.previous',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#step-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = (index/$total) * 100;
            var wdt = 100/$total;
            var lft = wdt*index;
            var margin = (100/$total)/2;
            $('#step-wz').find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});


            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#step-wz').find('.next').hide();
                $('#step-wz').find('.finish').show();
                $('#step-wz').find('.finish').prop('disabled', false);
            } else {
                $('#step-wz').find('.next').show();
                $('#step-wz').find('.finish').hide().prop('disabled', true);
            }
        }
    });



    // FORM WIZARD WITH TOOLTIP
    // =================================================================
    $('#cir-wz').bootstrapWizard({
        tabClass		    : 'wz-steps',
        nextSelector	    : '.next',
        previousSelector    : '.previous',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#cir-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = (index/$total) * 100;
            var margin = (100/$total)/2;
            $('#cir-wz').find('.progress-bar').css({width:$percent+'%', 'margin': 0 + 'px ' + margin + '%'});

            navigation.find('li:eq('+index+') a').trigger('focus');


            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#cir-wz').find('.next').hide();
                $('#cir-wz').find('.finish').show();
                $('#cir-wz').find('.finish').prop('disabled', false);
            } else {
                $('#cir-wz').find('.next').show();
                $('#cir-wz').find('.finish').hide().prop('disabled', true);
            }
        }
    })




    // FORM WIZARD WITH VALIDATION
    // =================================================================
    $('#bv-wz').bootstrapWizard({
        tabClass		    : 'wz-steps',
        nextSelector	    : '.next',
        previousSelector	: '.previous',
        onTabClick          : function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#bv-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;
            var $percent = ($current/$total) * 100;
            var wdt = 100/$total;
            var lft = wdt*index;

            $('#bv-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#bv-wz').find('.next').hide();
                $('#bv-wz').find('.finish').show();
                $('#bv-wz').find('.finish').prop('disabled', false);
            } else {
                $('#bv-wz').find('.next').show();
                $('#bv-wz').find('.finish').hide().prop('disabled', true);
            }
        },
        onNext: function(){
            isValid = null;
            $('#bv-wz-form').bootstrapValidator('validate');


            if(isValid === false)return false;
        }
    });




    // FORM VALIDATION
    // =================================================================
    // Require Bootstrap Validator
    // http://bootstrapvalidator.com/
    // =================================================================

    var isValid;
    $('#bv-wz-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
        },
        fields: {
        username: {
            message: 'The username is not valid',
            validators: {
                notEmpty: {
                    message: 'The username is required.'
                }
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'The email address is required and can\'t be empty'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        },
        firstName: {
            validators: {
                notEmpty: {
                    message: 'The first name is required and cannot be empty'
                },
                regexp: {
                    regexp: /^[A-Z\s]+$/i,
                    message: 'The first name can only consist of alphabetical characters and spaces'
                }
            }
        },
        lastName: {
            validators: {
                notEmpty: {
                    message: 'The last name is required and cannot be empty'
                },
                regexp: {
                    regexp: /^[A-Z\s]+$/i,
                    message: 'The last name can only consist of alphabetical characters and spaces'
                }
            }
        },
        phoneNumber: {
            validators: {
                notEmpty: {
                    message: 'The phone number is required and cannot be empty'
                },
                digits: {
                    message: 'The value can contain only digits'
                }
            }
        },
        address: {
            validators: {
                notEmpty: {
                    message: 'The address is required'
                }
            }
        }
        }
    }).on('success.field.bv', function(e, data) {
        // $(e.target)  --> The field element
        // data.bv      --> The BootstrapValidator instance
        // data.field   --> The field name
        // data.element --> The field element

        var $parent = data.element.parents('.form-group');

        // Remove the has-success class
        $parent.removeClass('has-success');


        // Hide the success icon
        //$parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
    }).on('error.form.bv', function(e) {
        isValid = false;
    });



});
