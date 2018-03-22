
jQuery(document).on('ready', function () {
    $(".inp-phone").mask("999-999-9999");
    $(".inp-card-expiry").mask("99/9999");
    $('#mult-drop1').multiselect({
        numberDisplayed: 5
    });
    $('#sel-add-opeations-1').multiselect({
        numberDisplayed: 5
    });
 
    /* Register Company Employee - START  */
    $(document).on('click', '.srchCompanyName', function () {
        $('.registred-company-list').removeClass('hide');
        $('#srchCompanyId-error').css('display','none');
    });

    $(document).on('blur', '.srchCompanyName', function () {
    });

    $("body").click(function (event) {
        if (event.target.id != "" && event.target.id != "") {
        } else {
            $('.registred-company-list').addClass('hide');
        }
    });


// Find Registered Company 
    $(document).on('keyup', '.srchCompanyName', function () {  
        $('.loader-outer-block').css('display','none');
        $('.srchCompanyId').val('');
        $('#srchCompanyId-error').css('display','none');
        var keyword = $('.srchCompanyName').val();
        if(keyword != '' && keyword.length >= 3 ){
            $.ajax({
                url: "/customs/autoCompany",
                type: "Post",
                dataType: 'html',
                data: {keyword: $('.srchCompanyName').val()},
                beforeSend: function (xhr) {
                    $('.loader-outer-block').css('display','none');
                },
                success: function (response) {
                    $('.loader-outer-block').css('display','none');
                    if (response != '') {
                        $('.ul-company-list').html(response);
                        $('.company-not-found').addClass('hide');
                    } else {
                        $('.company-not-found').removeClass('hide');
                    }
                }
            });
        } else {
            $('.loader-outer-block').css('display','none');
            $('.ul-company-list').html('');
            $('.company-not-found').removeClass('hide');
        }
        
    });

    $(document).on('click', '.lbl-company-list', function () {
        $('.srchCompanyName').val($(this).data('company-name'));
        $('.srchCompanyId').val($(this).data('company-id'));
        $('.registred-company-list').addClass('hide');
        $('.div-register-company-employee').removeClass('hide');
        $('.div-register-company').addClass('hide');
    });

    // Submit Company Employee Form
    $(document).on('click', '.btn-sign-up-employee', function () {
        if(parseInt($('.srchCompanyId').val()) > 0){
            $('.employeeCompanyId').val($('.srchCompanyId').val());
            if ($('#frmEmployee').valid()) {
                $('#frmEmployee').submit();    
                $('.loader-outer-block').delay(200).fadeIn('slow');
            }
        } else {
            $('#srchCompanyId-error').css('display','block');
            var list = $('.div-company-search');
            $('html, body').animate({scrollTop: list.offset().top},'slow');
            
        }
    });

// Validate Company Employee Form
    $("#frmEmployee").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Employee[first_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Employee[last_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Employee[position]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Employee[phone]": {
                required: true,
                maxlength: 15,
            },
            "Employee[email]": {
                required: true,
                email:true,
                maxlength: 40,
                
                remote: {
                    url: "/customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        email: function () {
                            return $("#employee-email").val();
                        },
                        id: function () {
                            return ''; //$("#employee-email").data('id');
                        },
                    }
                },
            },

            "Employee[password]": {
                required: true,
                minlength: 8,
                alphanumspecial:true
            },
            "Employee[confirm_password]": {
                required: true,
                equalTo: "#employee_password",
            },
        },
        messages: {            
            "Employee[first_name]": {
                required: "Please enter first name",
                 lettersonly: 'Character only.',
            },
            "Employee[last_name]": {
                required: "Please enter last name",
                 lettersonly: 'Character only.',
            },
            "Employee[position]": {
                required: "Please enter position",
                 lettersonly: 'Character only.',
            },
            "Employee[email]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Employee[phone]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15"  
            },
            "Employee[password]": {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long",
                alphanumspecial: 'Combination of alphabets,special characters & numeric values required.'
            },
            "Employee[confirm_password]": {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above",
                alphanumspace: 'Can only contain only letters, numbers and spaces.' 
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    /* Register Company Employee - END  */
        

    /* Register New Company - START  */
    $(document).on('click', '.btn-register-company', function () {
        $('.div-register-company').removeClass('hide');
        $('.div-register-company-employee').addClass('hide');
        $('.srchCompanyName').val('');
        $('.srchCompanyId').val('');
    });

    signUpStep();
    resetAddressFields();
    $(document).on('click', '.btn-sign-up-previous, .btn-sign-up-next, .btn-sign-up-payment', function () {
        var signUpCurrentStep = $('.sign-up-button-container').data('current-step');
        var buttonName = $(this).data('button-name');

        if (buttonName == 'next' && signUpCurrentStep == '1') {
            //if(true){
            if ($('#frmSignUpExits').valid()) {
                $('.sign-up-button-container').data('current-step', '2');
            }
        } else if (buttonName == 'next' && signUpCurrentStep == '2') {
            //if(true){
            if ($('#frmSignUpExits').valid()) {
                $('.sign-up-button-container').data('current-step', '3');
            }
        } else if (buttonName == 'previous' && signUpCurrentStep == '2') {
            $('.sign-up-button-container').data('current-step', '1');
        } else if (buttonName == 'next' && signUpCurrentStep == '3') {            
            //if(true){
            if ($('#frmSignUpExits').valid()) {
                
                $('.sign-up-button-container').data('current-step', '4');
            }
        } else if (buttonName == 'previous' && signUpCurrentStep == '3') {
            $('.sign-up-button-container').data('current-step', '2');
        } else if (buttonName == 'payment') {
            //if(true){
            if ($('#frmSignUpExits').valid()) {                
                $('.sel-add-operation').each(function(){
                  var addressCount = $(this).attr('data-add-count') ; 
                  $('#inp-add-operations-'+addressCount).val($('#sel-add-operation-'+addressCount).val());
                });                
                $('#frmSignUpExits').submit();
                $('.loader-outer-block').delay(200).fadeIn('slow');
            }
        }else if (buttonName == 'previous' && signUpCurrentStep == '4') {
            $('.sign-up-button-container').data('current-step', '3');
        } else {
            //if(true){
            if ($('#frmSignUpExits').valid()) {
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
            $('.a-sign-up').removeClass('a-sign-up-current');
            $('.div-sign-up').removeClass('div-sign-up-current');
            $('.div-sign-up-company').addClass('div-sign-up-current');
            $('.a-sign-up-company').addClass('a-sign-up-current');
            $('.div-company-search').removeClass('hide');
            changeTabColor('sign-up-company');
        } else if (signUpCurrentStep == '2') {
            $('.div-sign-up-contact').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('a-sign-up-current');
            $('.div-sign-up').removeClass('div-sign-up-current');
            $('.div-sign-up-company').addClass('div-sign-up-current');
            $('.a-sign-up-company').addClass('a-sign-up-current');
            $('.div-company-search').addClass('hide');
            changeTabColor('sign-up-contact');
        } else if (signUpCurrentStep == '3') {
            $('.div-sign-up-address').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('a-sign-up-current');
            $('.div-sign-up').removeClass('div-sign-up-current');
            $('.div-sign-up-company').addClass('div-sign-up-current');
            $('.a-sign-up-company').addClass('a-sign-up-current');
            $('.div-company-search').addClass('hide');
            changeTabColor('sign-up-address');
        } else if (signUpCurrentStep == '4') {
            $('.div-sign-up-pricing').removeClass('hide');
            $('.btn-sign-up-next').addClass('hide');
            $('.btn-sign-up-previous').removeClass('hide');
            $('.btn-sign-up-payment').removeClass('hide');
            $('.a-sign-up').removeClass('a-sign-up-current');
            $('.div-sign-up').removeClass('div-sign-up-current');
            $('.div-sign-up-company').addClass('div-sign-up-current');
            $('.a-sign-up-company').addClass('a-sign-up-current');
            $('.div-company-search').addClass('hide');
            changeTabColor('sign-up-pricing');
        } else {
            $('.div-sign-up-company').removeClass('hide');
            $('.btn-sign-up-next').removeClass('hide');
            $('.btn-sign-up-previous').addClass('hide');
            $('.btn-sign-up-payment').addClass('hide');
            $('.a-sign-up').removeClass('a-sign-up-current');
            $('.div-sign-up').removeClass('div-sign-up-current');
            $('.div-sign-up-company').addClass('div-sign-up-current');
            $('.a-sign-up-company').addClass('a-sign-up-current');
            $('.div-company-search').removeClass('hide');
            changeTabColor('sign-up-company');
        }

        if($('.div-register-company').length >0) {
            var list = $('.div-register-company');

            $('html, body').animate({scrollTop: list.offset().top},'slow');
        }
    }
    
    
    
    var tabArray = ['sign-up-company','sign-up-contact','sign-up-address','sign-up-pricing'];
    function changeTabColor(tabName){
        $('.li-sign-up').removeClass('tab-checked');
        $.each(tabArray,function(index,value){
            $('.li-'+value).addClass('tab-checked');
            if(value == tabName){
                return false;
            }
        }); 
        selectSubscriptionPlan('.panel-pricing-'+$('.subscription-plan-id').val());
        return true;      
    }
    
    /* Toggle Work-Operation for Company-Address  -- START  */
    toggleCompanyOperation();
    $(document).on('click', '.chk-company-operation', function () {
        toggleCompanyOperation();
    });
    
    function toggleCompanyOperation(){
        if($('.chk-company-operation').prop('checked') == true){


            var checkIffilledAnyValue = 0; 
            $('.additional-address-block .additional-address').each(function () { 


                $('.additional-address-block .additional-address').find("input[type = 'text']").each(function() {
                    if(this.value != "") {
                        checkIffilledAnyValue++;
                    }
                });

                $('.additional-address-block .additional-address .multiselect-container>li').each(function(){
                    if($(this).hasClass("active")){
                      checkIffilledAnyValue++;
                    }
                });



                if(checkIffilledAnyValue > 0){
                    $(this).find('input').prop("disabled", false);
                    $(this).find('.sel-add-operation').multiselect('enable'); 
                }else{
                    $(this).find('input').prop("disabled", true);
                    $('.additional-address-block .additional-address').find('.sel-add-operation').multiselect('disable');
                }
                
            });

            /*added by vipin*/
          /* var nodes = document.getElementById("check_box_checked").getElementsByTagName('*');
            for(var i = 0; i < nodes.length; i++){
                 nodes[i].disabled = true;
            }
           $('.add-address').prop("disabled", true);*/
           //$(".multiselect").prop('disabled', true);
        /*added by vipin*/


            $('.row-sel-company-operation').removeClass('hide');
            $('.col-sel-company-operation').removeClass('hide');
        } else {

             $('.additional-address-block .additional-address').each(function () { 

                    $(this).find('input').prop("disabled", false);
                    $('.additional-address-block .additional-address').find('.sel-add-operation').multiselect('disable');
            });

             /*added by vipin*/
          /* var nodes = document.getElementById("check_box_checked").getElementsByTagName('*');
            for(var i = 0; i < nodes.length; i++){
                 nodes[i].disabled = false;
            }
          $('.add-address').prop("disabled", false);*/
         // $(".multiselect").prop('disabled', false);
        /*added by vipin*/

           $('.multiselect-container>li').each(function(){
             $(this).removeClass("active");
            });
            $('#mult-drop1').val('')
            $('#mult-drop1').multiselect('refresh');
            $('.row-sel-company-operation').addClass('hide');
            $('.col-sel-company-operation').addClass('hide');
        }

        resetAddressFields();
    }
    /* Toggle Work-Operation for Company-Address  -- END  */
    
    /* Click Event for Sign-up Tab   -- START  */
    $(document).on('click', '.li-sign-up', function () {
        $('.li-sign-up').removeClass('active');
        var tabName = $(this).data('tab-name');
        $.each(tabArray,function(index,value){
            var curentStep = index + 1;
            $('.sign-up-button-container').data('current-step', curentStep);
            signUpStep();
            
            if(!$('#frmSignUpExits').valid()) {            
                return false;
            }            
            if(value == tabName){
                return false;
            }
        });
    });
    /* Click Event for Sign-up Tab   -- END  */

    /* Add & Remove Additional Address & Location   -- START  */
    $(document).on('click', '.add-address', function () {

        if($('.additional-address-block .additional-address').find('input').is('[disabled=disabled]')){
          $('.additional-address-block .additional-address').find('input').prop("disabled", false);
           $('.additional-address-block .additional-address').find('.sel-add-operation').multiselect('enable');  
        }else{
        $('.additional-address-block').append($('.additional-address-html').html());
        resetAddressFields();
     }
    });



    $(document).on('click', '.additional-address-block .remove-address', function () {

        

        /*---check if value present in 3 step--*/
        var chiled = $('.additional-address-block .remove-address').length;
        if(chiled == 1){
          checkIfvaluePresent();    
        }else{
        
        /*-----check if value present in 3 step---*/
       if($('.chk-company-operation').prop('checked') == true){
            $(this).parents('.additional-address').remove();
        } else {
            if ($('.additional-address-block .remove-address').length > 1) {
                $(this).parents('.additional-address').remove();
            }
        }    
        resetAddressFields();
        }       

    });

     function checkIfvaluePresent(){
         
         var cnt = 0;
            $('.multiselect-container>li').each(function(){
             if($(this).hasClass("active")){
              cnt++;
            }
            });
         if(cnt>=1){   
         $('.additional-address-block .additional-address').find('input').prop("disabled", true);
         $('.additional-address-block .additional-address').find('.sel-add-operation').multiselect('disable');
         }else{
            $('.additional-address-block .additional-address').find('input').prop("disabled", false);
         $('.additional-address-block .additional-address').find('.sel-add-operation').multiselect('enable');
         }  

     }


    function resetAddressFields() { 
        // Add Additonal Location & Operation if Company-Info not mark as a Operation and Locations & Operations Tab is empty


        if($('.chk-company-operation').prop('checked') != true && $('.additional-address-block .remove-address').length == 0){
            $('.additional-address-block').append($('.additional-address-html').html());
        }
        
        var addressSerial = 1;
        


        $('.additional-address-block .additional-address').each(function () {                    
            $(this).find('.inp-add-title').attr('id','inp-add-title-'+addressSerial);
            $(this).find('.inp-add-line1').attr('id','inp-add-line1-'+addressSerial);
            $(this).find('.inp-add-line2').attr('id','inp-add-line2-'+addressSerial);
            $(this).find('.inp-add-phone').attr('id','inp-add-phone-'+addressSerial);
            $(this).find('.inp-add-email').attr('id','inp-add-email-'+addressSerial);
            $(this).find('.sel-add-operation').attr('id','sel-add-operation-'+addressSerial);
            $(this).find('.sel-add-operation-error').attr('id','sel-add-operation-'+addressSerial+'-error');            
            $(this).find('.sel-add-operation-error').attr('for','sel-add-operation-'+addressSerial);   
            $(this).find('.sel-add-operation').attr('data-add-count',addressSerial);
            $(this).find('.inp-add-operations').attr('id','inp-add-operations-'+addressSerial);
            $(this).find('.inp-add-operations').attr('data-add-count',addressSerial);


           if($('.chk-company-operation').prop('checked') == false){
                var selectedOperation = $('#sel-add-operation-'+addressSerial).val();
                $('#sel-add-operation-'+addressSerial).multiselect('rebuild');
                $('#sel-add-operation-'+addressSerial).val(selectedOperation);
                $('#sel-add-operation-'+addressSerial).multiselect('refresh');
            }

            addressSerial++;


        });



        
        // Toggle Remove-Address Icon
        if($('.chk-company-operation').prop('checked') == true){
            $('.additional-address-block .remove-address').removeClass('hide');
        } else {
            if ($('.additional-address-block .remove-address').length > 1) {
                $('.additional-address-block .remove-address').removeClass('hide');
            } else {
                //$('.additional-address-block .remove-address').addClass('hide');
            }
        }
    }
    /* Add & Remove Additional Address & Location   -- END  */
    
    /* Select & Toggle Subscription Plan   -- START  */
    $(document).on('click', '.panel-pricing', function () {
        selectSubscriptionPlan($(this));
    });
    
    selectSubscriptionPlan('.panel-pricing-'+$('.subscription-plan-id').val());
    function selectSubscriptionPlan(element){
        
        // get Additional Location
        var locationCount = $('.additional-address-block .inp-add-title').filter(function () {return !!this.value;}).length;
        // add Company-Address in Additional-Address 
        if($('.chk-company-operation').prop('checked') == true){
            locationCount = locationCount + 1;
        }        
        var chargableAmount = 500;
        if(locationCount >5){
            chargableAmount = 1000;
        } else if(locationCount <=5 && locationCount >3){
            chargableAmount = 750;;
        }
        
        var planId = $(element).data('plan-id');
        var planPrice = $(element).data('plan-price');
                
        var chargableAmount = 500;
        if(locationCount <=3 ){
            chargableAmount = planPrice;
            $('.panel-pricing').removeClass('select');
            $(element).addClass('select');
            $('.panel-pricing .btn-subscription-plan').html('Available');
            $('.panel-pricing.select .btn-subscription-plan').html('Selected');
       } else if(locationCount <=5 && locationCount >3){
           $('.panel-pricing-1 .btn-subscription-plan').html('Not Available');
           if(planId != 1){
                chargableAmount = planPrice;
                $('.panel-pricing').removeClass('select');
                $(element).addClass('select');
                $('.panel-pricing-2 .btn-subscription-plan').html('Available');
                $('.panel-pricing-3 .btn-subscription-plan').html('Available');
                $('.panel-pricing.select .btn-subscription-plan').html('Selected');
           } else {
               chargableAmount = 750; 
               planId = 2;
               $('.panel-pricing').removeClass('select');
               $('.panel-pricing-2').addClass('select');
               $('.panel-pricing-3 .btn-subscription-plan').html('Available');
               $('.panel-pricing.select .btn-subscription-plan').html('Selected');
           }            
        } else if(locationCount > 5){
            chargableAmount = 1000;   
            planId = 3;
            $('.panel-pricing').removeClass('select');
            $('.panel-pricing-3').addClass('select');
            $('.panel-pricing .btn-subscription-plan').html('Not Available');
            $('.panel-pricing.select .btn-subscription-plan').html('Selected');
        }
        $('.chargable-location').html(locationCount);
        $('.subscription-plan-id').val(planId);        
        $('.chargable-amount').html(parseFloat(chargableAmount).toFixed(2));
    }
    /* Select & Toggle Subscription Plan   -- END  */
    

//End attechement Document 
    $("#frmSignUpExits").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Company[name]": {
                required: true,
                nameLetters: true,
                 maxlength: 50,
                remote: {
                    url: "/customs/checkUniqueComapny",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        company: function () {
                            return $("#company-name").val();
                        },
                        id: function () {
                            return ''; 
                        },
                    }
                },
            },
            "Company[address_1]": {
                required: true,
                maxlength: 80,
            },

            "Company[phone]": {
                required: true,
                maxlength: 15,
            },

            "Company[email]": {
                required: true,
                email:true,
                maxlength: 40,
                remote: {
                    url: "/customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        email: function () {
                            return $("#contact-email").val();
                        },
                        id: function () {
                            return ''; 
                        },
                    }
                },
            },
            
            "Company[operation_id][]":{
                required: true,
            },

            "Contact[first_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[last_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[position]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[phone]": {
                required: true,
                maxlength: 15,
            },
            "Contact[email]": {
                required: true,
                email:true,
                maxlength: 40,
                
                remote: {
                    url: "/customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        email: function () {
                            return $("#contact-email").val();
                        },
                        id: function () {
                            return '';
                        },
                    }
                },
            },

            "Contact[password]": {
                required: true,
                minlength: 8,
                alphanumspecial:true
            },
            "Contact[confirm_password]": {
                required: true,
                equalTo: "#contact_password",
            },           
            
            "Address[title][]": {
                required: true,
                maxlength: 30,
                 letterspace: true,
            },
            "Address[address_1][]": {
                required: true,
                maxlength: 30,
            },
            "Address[phone][]": {
                required: true,
                maxlength: 30,
                
            },
            "Address[email][]": {
                required: true,
                email:true,
                maxlength: 40,
               
            },
            "Address[operation_id][][]":{
                required: true,
            },
            
            "Payment[card_holder]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Payment[card_number]": {
                required: true,
                number: true,
                maxlength: 16,
            },
            "Payment[cvv]": {
                required: true,
                number: true,
                maxlength: 4,
            },
            "Payment[expiry]": {
                required: true,
            },

        },
        messages: {
            "Company[name]": {
                required: "Please enter company name",
                remote: "company name is already exists",
                letterspace: 'Character only.',
                maxlength: "Maximum characters are 30",
            },
            "Company[address_1]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Company[phone]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },

            "Company[email]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Company[operation_id][]":{
                required: 'Please select work-operations',
            },
            "Address[title][]": {
                required: "Please enter company name",
                remote: "company name is already exists",
                 lettersonly: 'Character only.',
            },
            "Address[address_1][]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Address[phone][]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },

            "Address[email][]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },

            "Contact[first_name]": {
                required: "Please enter first name",
                 lettersonly: 'Character only.',
            },
            "Contact[last_name]": {
                required: "Please enter last name",
                 lettersonly: 'Character only.',
            },
            "Contact[position]": {
                required: "Please enter position",
                 lettersonly: 'Character only.',
            },
            "Contact[email]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Contact[phone]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15"  
            },
            "Contact[password]": {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long",
                alphanumspecial: 'Combination of alphabets,special characters & numeric values required.'
            },
            "Contact[confirm_password]": {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as password",
                alphanumspace: 'Can only contain only letters, numbers and spaces.' 
            },

            "Address[title][]": {
                required: "Please enter address label",
                remote: "company name is already exists",
                 lettersonly: 'Character only.',
            },
            "Address[address_1][]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Address[phone][]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
                number: "Enter only number",
            },

            "Address[email][]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Address[operation_id][][]":{
                required: 'Please select work-operations',
            },

            "Payment[card_holder]": {
                required: "Please enter cared holder name",
                 lettersonly: 'Character only.',
            },
            "Payment[card_number]": {
                required: "Please enter cared number",
                number: "Please enter only number",
            },
            "Payment[cvv]": {
                required: "Please enter cared number",
                number: "Please enter only number",
                maxlength: "Please enter only 3 digit number",
            },
            "Payment[expiry]": {
                required: "Please enter cared expiry date",

            },

        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    /* Register New Company - END  */
    
    $("#editProfile").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Company[name]": {
                required: true,
                nameLetters: true,
                 maxlength: 30,
                remote: {
                    url: "/customs/checkUniqueComapny",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        company: function () {
                            return $("#company-name").val();
                        },
                        id: function () {
                            return $("#company-name").data('id');
                        },
                    }
                },
            },
            "Company[address_1]": {
                required: true,
                maxlength: 80,
            },

            "Company[phone]": {
                required: true,
                maxlength: 15,
            },

            "Company[email]": {
                required: true,
                maxlength: 40,
                remote: {
                    url: "/customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        email: function () {
                            return $("#company-email").val();
                        },
                        id: function () {
                            return $("#company-email").data('id');
                        },
                    }
                },
            },

            "Contact[first_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[last_name]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[position]": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "Contact[phone]": {
                required: true,
                maxlength: 15,
            },
            "Contact[email]": {
                required: true,
                maxlength: 40,
                
                remote: {
                    url: "/customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {                        
                        $('.loader-outer-block').css('display','none');
                    },
                    data: {
                        email: function () {
                            return $("#contact-email").val();
                        },
                        id: function () {
                            return $("#contact-email").data('id');
                        },
                    }
                },
            },

            "Contact[password]": {
                required: true,
                minlength: 8,
                alphanumspecial:true
            },
            "Contact[confirm_password]": {
                required: true,
                minlength: 8,
                equalTo: "#contact_confirm_password",
                alphanumspecial:true
            },            
            "Address[title][]": {
                required: true,
                maxlength: 30,
                 letterspace: true,
            },
            "Address[address_1][]": {
                required: true,
                maxlength: 30,
            },
            "Address[phone][]": {
                required: true,
                maxlength: 30,
                
            },
            "Address[email][]": {
                required: true,
                maxlength: 40,
           
            },
            "Address[operation_id][][]":{
                required: true,
            }
         

        },
        messages: {
            "Company[name]": {
                required: "Please enter company name",
                remote: "company name is already exists",
                letterspace: 'Character only.',
                maxlength: "Maximum characters are 30",
            },
            "Company[address_1]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Company[phone]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },

            "Company[email]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Address[title][]": {
                required: "Please enter company name",
                remote: "company name is already exists",
                 lettersonly: 'Character only.',
            },
            "Address[address_1][]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Address[phone][]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },

            "Address[email][]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },

            "Contact[first_name]": {
                required: "Please enter first name",
                 lettersonly: 'Character only.',
            },
            "Contact[last_name]": {
                required: "Please enter last name",
                 lettersonly: 'Character only.',
            },
            "Contact[position]": {
                required: "Please enter position",
                 lettersonly: 'Character only.',
            },
            "Contact[email]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Contact[phone]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15"  
            },
            "Contact[password]": {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long",
                alphanumspace: 'Can only contain only letters, numbers and spaces.'   
            },
            "Contact[confirm_password]": {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above",
                alphanumspace: 'Can only contain only letters, numbers and spaces.' 
            },
            "Address[title][]": {
                required: "Please enter address label",
                remote: "company name is already exists",
                 lettersonly: 'Character only.',
            },
            "Address[address_1][]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80",
            },
            "Address[phone][]": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
                number: "Enter only number",
            },

            "Address[email][]": {required: "Please enter  email address",
                remote: "Email address is already exists"
            },
            "Address[operation_id][][]":{
                required: 'Please select work-operations',
            }

        },
        submitHandler: function (form) {
            form.submit();
        }
    });

   

});


function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " requird";
            // and set the current valid status to false
            valid = false;
        }
    }
}



