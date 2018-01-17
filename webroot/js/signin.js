/*  validation for signup 
 * By @Ahsan Ahamad
 * Date : 23rd Nov. 2017
 */


$(document).ready(function () {
    $("#signIn").on('click', function () {

        $("#signin").validate({
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
            },
            messages: {
                email: "Please enter a valid email address",
                password: "Please enter a password",
            },
            submitHandler: function (form) {
                $.ajax({
                    url: "/users/ajaxLogin",
                    type: "Post",
                    data: $('#signin').serialize(),
                    success: function (response) {
                        if (response == 'success') {
                            window.location = '/dashboard';
                        } else {
                            $('#msg').html(response);
                        }
                    }
                });
            }
        });

    });

});



