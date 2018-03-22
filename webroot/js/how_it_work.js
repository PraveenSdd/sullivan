/*  validation for faq 
* By @Ahsan Ahamad
* Date : 23rd Nov. 2017
*/
$(function() {
  $("#howItWork").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       
         "title":{
             required :true, 
             maxlength: 40,
         },
         "description": {
              required :true, 
         },
      },
    messages: {
        "title": {
                required: "Please enter title",
                maxlength: "Maximum characters are 40.",
            },
        "description": {
                    required: "Please enter description",
            },
   },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

