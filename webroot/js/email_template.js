/*  validation for faq 
* By @Ahsan Ahamad
* Date : 23rd Nov. 2017
*/
$(function() {
  $("#emailTemplate").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       
         "EmailTemplates[subject]":{
             required :true, 
             maxlength: 40,
         },
         
      },
    messages: {
        "EmailTemplates[subject]": {
                required: "Please enter subject",
                maxlength: "Maximum characters are 40.",
            },
        
   },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

