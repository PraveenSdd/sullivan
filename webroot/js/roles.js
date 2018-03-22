/*  validation for roles 
* By @Ahsan Ahamad
* Date : 3 Nov. 2017
*/
 $(function(){
    $("#roles").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
        name: "required",
      },
      messages: {
      name: "Please enter a name",
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});

    