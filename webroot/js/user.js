/* phone number formate and phone extention */
jQuery(document).on('ready', function () {
    $(".inp-phone").mask("999-999-9999");
    $(".inp-card-expiry").mask("99/9999");
    var select2Flag = $('.chk-disable-select2').data('flag');
    if (select2Flag == 1) {
        $('#mult-drop1').multiselect({
            numberDisplayed: 5
        });
    }
});

$(function () {
// validate signup form on keyup and submit
    $("#loginform").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },

        },
        messages: {
            email: "Please enter a valid email address",
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#add_company").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            company: "required",
            first_name: "required",
            phone: {
                required: true,
                maxlength: 15,
            },
            "email": {
                required: true,
                email: true,
                remote: {
                    url: "/Customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('#preloader').css('display', 'none');
                    },
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        id: function () {
                            return $("#email").data('id');
                        },
                    }
                },
            },
            password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            company: "Please enter a country",
            first_name: "Please enter a name",
            email: {required: "Please enter  email address",
                email: "Please enter valid email address",
                remote: "Email address is already exist"},
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long",
            },
            phone: {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },

        },
        submitHandler: function (form) {
            form.submit();
        }
    });

// validation for staff and admin company profile or admin   
    $("#frmStaff").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "first_name": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },

            "email": {
                required: true,
                email: true,
                remote: {
                    url: "/Customs/checkEmailUnique",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('#preloader').css('display', 'none');
                    },
                    data: {
                        email: function () {
                            return $("#email").val();
                        },
                        id: function () {
                            return $("#email").data('id');
                        },
                    }
                },
            },
            "phone": {
                required: true,
                maxlength: 15,
            },

            "password": {
                required: true,
                minlength: 8
            },
            "confirm_password": {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },
            "position": {
                required: true,
                maxlength: 40,
            },
            "permission_id": {
                required: true,

            },
            "Address[address1]": {
                required: true,
                maxlength: 80,
            },
            "Address[city]": {
                required: true,
                maxlength: 40,
            },
            "Address[state_id]": {
                required: true,
                maxlength: 40,
            },
            "Address[zipcode]": {
                required: true,
                maxlength: 10,
            },
        },
        messages: {
            "first_name": {
                required: "Please enter first name",
                lettersonly: 'Character only.',
                maxlength: "Maximum characters are 30"
            },

            "email": {required: "Please enter  email address",
                required: "Please enter valid email address",
                remote: "Email address is already exists"},
            "phone": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },
            "password": {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long"
            },
            "confirm_password": {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            },
            "position": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },
            "permission_id": {
                required: "Please enter permission",
                maxlength: "Maximum characters are 15",
            },
            "Address[address1]": {
                required: "Please enter address",
                maxlength: "Maximum characters are 80",
            },
            "Address[city]": {
                required: "Please enter city",
                maxlength: "Maximum characters are 40",
            },

            "Address[state_id]": {
                required: "Please select state",
            },

            "Address[zipcode]": {
                required: "Please enter zipcode",
                maxlength: "Maximum characters are 10",
            },

        },
    });
    $(document).on('click', '.subStaff', function () {
        if ($('#frmStaff').valid()) {
            var path = window.location.href;
            var confirmd_value = '';
            if (path.indexOf('admin') >= 0) {
                confirmd_value = 1;
            } else {
                confirmd_value = 4;
            }
            var sel_add_state = $(".sel-add-state option:selected").val();
            if (sel_add_state == confirmd_value) {
                ecoConfirm("Are you sure you want to allow all permission for this user?", function
                        ecoAlert(findreturn) {
                    if (findreturn == true) {
                        $('.loader-outer-block').css('display', 'block');
                        $('#frmStaff').submit();
                    } else {
                        return false;
                    }
                });
            } else {
                $('.loader-outer-block').css('display', 'block');
                $('#frmStaff').submit();
            }
            return false;
        }
    });

// validation company edit profile or admin   


    $("#editProfile").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Company[email]": {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },

        },
        messages: {
            email: "Please enter a valid email address",
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


    //validation frontend change edit

    $("#changePassword").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            },

        },
        messages: {
            password: {
                required: "Please enter a password",
                minlength: "Your password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Please enter a confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

//function for set auto generate password 

    $(".generatePassword").on('click', function () {
        var password = generatePass(8);
        $('.password').val(password);
    });

});

//function for auto generate password 

function generatePass(plength) {
    $('.genPassConf').css('display', 'block');
    $('#pass-generate').html('').css('display', 'none');
    var keylistalpha = "abcdefghijklmnopqrstuvwxyz";
    var keylistint = "0123456789";
    var keylistspec = "!@#_{}[]&*^%";
    var temp = '';
    var len = plength / 2;
    var len = len - 1;
    var lenspec = plength - len;
    for (i = 0; i < len; i++)
        temp += keylistalpha.charAt(Math.floor(Math.random() * keylistalpha.length));
    for (i = 0; i < lenspec; i++)
        temp += keylistspec.charAt(Math.floor(Math.random() * keylistspec.length));
    for (i = 0; i < len; i++)
        temp += keylistint.charAt(Math.floor(Math.random() * keylistint.length));
    temp = temp.split('').sort(function () {
        return 0.5 - Math.random()
    }).join('');
    $('.pass').val(temp);
    return temp;
}


