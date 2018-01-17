
jQuery(document).on('ready', function () {
     
    $(document).on('click', '.btn-register-company', function () {
        alert(1);
        $('.div-register-company').removeClass('hide');
    });
    
    signUpStep();
    resetAddressFields();
    $(document).on('click', '.btn-sign-up-previous, .btn-sign-up-next, .btn-sign-up-payment', function () {
        var signUpCurrentStep = $('.sign-up-button-container').data('current-step');
        var buttonName = $(this).data('button-name');

        if (buttonName == 'next' && signUpCurrentStep == '1') {
            //if ($('#frmSignUpExits').valid()) {
            if (true) {
                $('.sign-up-button-container').data('current-step', '2');
            }
        } else if (buttonName == 'next' && signUpCurrentStep == '2') {
            //if ($('#frmSignUpExits').valid()) {
            if (true) {
                $('.sign-up-button-container').data('current-step', '3');
            }
        } else if (buttonName == 'previous' && signUpCurrentStep == '2') {
            $('.sign-up-button-container').data('current-step', '1');
        } else if (buttonName == 'next' && signUpCurrentStep == '3') {
            $('.sign-up-button-container').data('current-step', '4');
        } else if (buttonName == 'previous' && signUpCurrentStep == '3') {
            $('.sign-up-button-container').data('current-step', '2');
        } else if (buttonName == 'next' && signUpCurrentStep == '4') {
            $('.sign-up-button-container').data('current-step', '5');
        } else if (buttonName == 'payment') {
            //if ($('#frmSignUpExits').valid()) {
            if (true) {
                $('.sign-up-button-container').data('current-step', '4');
                //$('#frmSignUpExits').submit();
            }
        } else {
            //if ($('#frmSignUpExits').valid()) {
            if (true) {
                $('.sign-up-button-container').data('current-step', '2');
            }
        }
        signUpStep();
    });

    function signUpStep() {
        $('.div-sign-up').addClass('hide');
        var signUpCurrentStep = $('.sign-up-button-container').data('current-step');        
        if (signUpCurrentStep == '1') {
            $('.div-sign-up-company').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').addClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').removeClass('hide');
        } else if (signUpCurrentStep == '2') {
            $('.div-sign-up-contact').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').addClass('hide');
        } else if (signUpCurrentStep == '3') {
            $('.div-sign-up-industry').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').addClass('hide');
        } else if (signUpCurrentStep == '4') {
            $('.div-sign-up-address').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').addClass('hide');
        } else if (signUpCurrentStep == '5') {
            $('.div-sign-up-pricing').removeClass('hide');
            $('.btn-sign-up-next').addClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').removeClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').addClass('hide');
        } else {
            $('.div-sign-up-company').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').addClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('.a-sign-up-current');
            $('.div-sign-up').removeClass('.div-sign-up-current');
            $('.div-sign-up-company').addClass('.div-sign-up-current');
            $('.a-sign-up-company').addClass('.a-sign-up-current');
            $('.div-company-search').removeClass('hide');
        }
    }

    
    $(document).on('click', '.add-address', function () {
        $('.additional-address-block').append($('.additional-address-html').html());
        resetAddressFields();
    });

    $(document).on('click', '.additional-address-block .remove-address', function () {
        if($('.additional-address-block .remove-address').length > 1){
            $(this).parents('.additional-address').remove();
        }
        resetAddressFields();
    });
    function resetAddressFields() {        
        var addressSerial = 1;
        $('.additional-address-block .additional-address-html').each(function () {            
            addressSerial++;
        });
        
        if($('.additional-address-block .remove-address').length > 1){
            $('.additional-address-block .remove-address').removeClass('hide');
        } else {
            $('.additional-address-block .remove-address').addClass('hide');
        }
    }

//End attechement Document 



    /*
     $('#frmSignUpExits').validate({
     focusInvalid: true,
     debug: false,
     onkeyup: false,
     rules: {
     'data[User][organization_name]': {
     required: true,
     charDotComma: true
     },
     'data[User][email]': {
     required: true,
     email: true
     },
     'data[User][home_phone]': {
     required: true
     },
     'data[User][mobile]': {
     required: true
     },
     'data[User][firstname]': {
     required: true,
     nameLetters: true,
     minlength: 3,
     maxlength: 15
     },
     'data[User][lastname]': {
     required: true,
     nameLetters: true,
     minlength: 3,
     maxlength: 15
     },
     'data[User][address]': {
     required: true
     },
     'data[User][city]': {
     required: true,
     nameLetters: true
     },
     'data[User][zip]': {
     required: true,
     alphanumspace: true,
     maxlength: 15
     },
     'data[User][username]': {
     required: true,
     alphanumeric: true,
     minlength: 6,
     maxlength: 15,
     remote: {
     url: "/users/uniqueUsername/",
     type: "post",
     beforeSend: function (xhr) {
     //$('#preloader').css('display', 'none');
     },
     data: {
     username: function () {
     return $("#UserUsername").val();
     },
     }
     }
     },
     'data[User][password]': {
     required: true,
     minlength: 6,
     maxlength: 15,
     alphanumspecial: true
     },                
     'data[User][cardNo]': {
     required: true,
     creditcard: true
     },
     'data[User][cvv]': {
     required: true,
     number: true,
     minlength: 3,
     maxlength: 4
     },
     'data[User][exp_month]': {
     required: true,
     number: true,
     minlength: 1,
     maxlength: 2,
     monthFormat: true,
     checkMonth: true
     },
     'data[User][exp_year]': {
     required: true,
     number: true,
     checkYear: true,
     minlength: 4,
     maxlength: 4
     },
     'data[User][coupon_code]': {
     required: false,
     },
     'data[User][is_agreement]': {
     required: true,                    
     },
     },
     messages: {
     'data[User][organization_name]': {
     required: 'Please enter organization name.',
     lettersonly: 'Character only.'
     },
     'data[User][email]': {
     required: 'Please enter email.',
     email: 'Invalid email.'
     },
     'data[User][home_phone]': {
     required: 'Please enter phone no.'
     },
     'data[User][mobile]': {
     required: 'Please enter mobile no.'
     },
     'data[User][firstname]': {
     required: 'Please enter first name.',
     minlength: 'Should contain atleast 3 charaters',
     maxlength: 'Should contain atmost 15 charaters',
     },
     'data[User][lastname]': {
     required: 'Please enter last name.',
     minlength: 'Should contain atleast 3 charaters',
     maxlength: 'Should contain atmost 15 charaters',
     },
     'data[User][address]': 'Please enter your address.',
     'data[User][city]': {
     required: 'Please enter city.',
     lettersonly: 'Characters only.'
     },
     'data[User][zip]': {
     required: 'Please enter zip code.',
     maxlength: 'Maximum 15 digit allowed.',
     alphanumspace: 'Can only contain only letters, numbers and spaces.'
     },
     'data[User][username]': {
     required: 'Please enter username.',
     minlength: 'Should contain atleast 6 charaters.',
     maxlength: 'Should contain atmost 15 charaters.',
     alphanumeric: 'Can only contain only letters and numbers.',
     remote: 'Username is already exist.'
     },
     'data[User][password]': {
     required: 'Please enter password.',
     minlength: 'Minimum length required is 6.',
     maxlength: 'Maximum length required is 15.',
     alphanumspecial: 'Combination of alphabets,special characters & numeric values required.'
     },
     'data[User][cardNo]': {
     required: 'Please enter a valid credit card no.',
     creditcard: 'Please enter a valid credit card no.'
     },
     'data[User][cvv]': {
     required: 'Please enter a valid cvv no.',
     minlength: 'Should be atleast 3 digit no.',
     maxlength: 'Should be atmost 4 digit no.'
     },
     'data[User][exp_month]': {
     required: 'Please enter a valid month.',
     maxlength: 'Not a valid month.'
     },
     'data[User][exp_year]': {
     required: 'Please enter a valid year.',
     minlength: 'Not a valid year.',
     maxlength: 'Not a valid year.'
     },
     'data[User][is_agreement]': {
     required: 'Please check the terms of use.',                   
     },
     },
     invalidHandler: function (form, validator) {
     if (!validator.numberOfInvalids())
     return;
     $('html, body').animate({
     scrollTop: $(validator.errorList[0].element).offset().top - 200
     }, 300);
     }
     });
     
     */


});


