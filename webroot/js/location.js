/*  validation for Location 
* By @Ahsan Ahamad
* Date : 17 Nov. 2017
*/
  
$(function(){
    $("#user_locations").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
        "industry_id[]": "required",
     //  state_id: "required",
        "email":{
          required: true,
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
        phone: {
                required: true,
                maxlength: 15,
            },
        title: {
                required: true,
                maxlength: 30,
                 letterspace: true,
            },
        address1: "required",
        
        
      },
      messages: {
      country_id: "Please select industry",
       email: {required:"Please enter  email address",
            remote: "Email address is already exists"},
         
       phone:{  required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },
      title: {
                required: "Please enter company name",
                remote: "company name is already exists",
                 lettersonly: 'Character only.',
            },
      address1: "Please enter a address",
     
  },
    submitHandler: function(form) {
      form.submit();
    }
  });
  /* change status of location */
    $(".getStates").on('change', function () {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: "/Customs/getStates",
                type: "Post",
                dataType: 'html',
                data: {id: countryId},
                success: function (response) {
                    if (response) {
                        $('#statelist').html(response);
d                    }
                }
            });
        } else {
            $("#statelist").html();
        }
    });

});

