/*  validation for faq 
* By @Ahsan Ahamad
* Date : 23rd Nov. 2017
*/
$(function() {
  $("#add_faqs").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       
         question: "required",
         answer: "required",
      },
    messages: {
        question: "Please enter a question",
        answer: "Please enter a answer"
   },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

