
jQuery(document).on('ready', function () {
    $(".inp-card-expiry").mask("99/9999");
    $(document).on('click', '.btn-payment', function () {
        if ($('#frmPayment').valid()) {
            $('#frmPayment').submit();
        }
    });

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

