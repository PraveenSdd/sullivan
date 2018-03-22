/*  validation for Location 
* By @Ahsan Ahamad
* Date : 17 Nov. 2017
*/
  
$(function(){
    $(".inp-phone").mask("999-999-9999");
    $('.sel-location-operation').multiselect({
        numberDisplayed: 5
    });
    
    toggleLocationOperation();
    $(document).on('click', '.chk-company-operation', function () {
        toggleLocationOperation();
    });
    
    function toggleLocationOperation(){
        if($('.chk-company-operation').length >0) {
            if($('.chk-company-operation').prop('checked') == true){
                $('.col-sel-company-operation').removeClass('hide');
            } else {
                $('.col-sel-company-operation').addClass('hide');
            }
        }
    }
    
    $("#user_locations").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
        "operation_id[]": "required",
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
                maxlength: 30
            },
        address1: "required",
        
        
      },
      messages: {
      'operation_id[]': "Please select operations",
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

