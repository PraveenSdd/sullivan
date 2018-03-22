/*  validation for professional assistance 
* By @Ahsan Ahamad
* Date : 23rd Nov. 2017
*/
$(function() {
  $("#professional_assistance").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       name: {
                required: true,
                maxlength: 30,
                letterspace: true,
            },
        
         email: {
                required: true,
                email: true
        },
          phone: {
                required: true,
                maxlength: 15,
            },
          query: {
                required: true,
                maxlength: 150,
            },      },
    messages: {
        
        name:  {
                required: "Please enter name",
                 lettersonly: 'Character only.',
                 maxlength: "Maximum characters are 30"  
            },
         email: {
                required: "Please enter a email address",
                email: "Please enter a valid email address"
        },     
        phone: {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15",
            },
        query: {
                required: "Please enter query",
                maxlength: "Maximum characters are 150",
            },
   },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

