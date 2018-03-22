/*  validation for Staff 
 * By @Ahsan Ahamad
 * Date : 15 Jan. 2018
 */


$(function () {
    /* phone number formate*/
    $(".inp-phone").mask("999-999-9999");
    $(".inp-card-expiry").mask("99/9999");

// validation for staff and admin company profile or admin 

    $("#addStaff").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "first_name": {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
            "last_name": {
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
            "last_name": {
                required: "Please enter last name",
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
        /*submitHandler: function (form) {
            form.submit();
        }*/
    });

    $(".confirmBeforeSave").on('click',function(){
        
        var permissionLevel = $(".sel-level").val();
         if(permissionLevel == 1){
        
        //$("#confirmMessage").html("Are you sure you want allow all permission to this user ?");
        ecoConfirm("Are you sure you want allow all permission to this user ?",function
                ecoAlert(findreturn) {
                if (findreturn == true) {
                    $("#addStaff").submit();
                }else{
                    return false;
                }
          });
         }else{
           $("#addStaff").submit();
         }
        return false;
    })

});

