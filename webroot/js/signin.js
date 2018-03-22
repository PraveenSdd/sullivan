/*  validation for signup 
 * By @Ahsan Ahamad
 * Date : 23rd Nov. 2017
 */


$(document).ready(function () {
    $(document).on("click", ".red-reg-pg", function () {
        window.location = '/signup';
    });
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
                    dataType:'JSON',
                    success: function (response) {
                        if (response.statusCode == 200) {
                            window.location = '/dashboard';
                        } else {
                            $('#msg').html(response.message);
                        }
                    }
                });
            }
        });

    });

});



