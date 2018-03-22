
jQuery(document).on('ready', function () {
    $(".inp-card-expiry").mask("99/9999");
    $(document).on('click', '.btn-payment', function () {
        if ($('#frmPayment').valid()) {
            $('#frmPayment').submit();
        }
    });
    
    $(document).on('click', '.panel-pricing', function () {
        selectSubscriptionPlan($(this));
    });
    
    selectSubscriptionPlan('.panel-pricing-3');
    function selectSubscriptionPlan(element){
        var locationCount = $('#frmPayment').data('location');
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
        $('.subscription-plan-id').val(planId);        
        $('.chargable-amount').html(parseFloat(chargableAmount).toFixed(2));
    }
    

//***************** validation of payment field from forntend *****************************\\


    $("#frmPayment").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Company[email]": {
                required: true,
                email: true,
                maxlength: 40,
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
            "Company[email]": {
                required: "Please enter  email address",
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

});

