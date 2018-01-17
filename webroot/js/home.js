/*  validation for Home page 
* By @Ahsan Ahamad
* Date : 16th Nov. 2017
*/

   $(document).ready(function() {
    var x = 1;
        var max_fields_limit = 10; //set limit for maximum input fields
        
        $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
            e.preventDefault();
            if(x < max_fields_limit){ //check conditions
                x++; //counter increment
   
                $('.input_fields_container').last().append('<div><div class="form-group"> <label for="CategoryName" class="col-sm-3 control-label"></label><div class="col-sm-8"><input class="form-control required" type="text" id="attribute'+x+'" name="attribute[]"/></div><div class="col-sm-1"><a href="#" class="label label-danger remove_field" style="margin-left:10px;"><i class="fa fa-minus"></i></a></div></div></div>'); //add input field
            }
           
        });  
          var arrid = []; 
        $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
            var id = $(this).data('id');
            arrid.push(id)
             $('#remove_attribute_id').val(arrid);
                e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
        })
    });

  
$(function(){
    $("#edit_home").validate({
    debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       title: "required",
        description: "required",
      },
    messages: {
      title: "Please enter a title",
      description: "Please enter a description",
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
  
   $("#edit_subcription").validate({
     debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
       name: "required",
       // sub_category_id: "required",
        description: "required",
        "attribute[]": "required",
        
      },
      messages: {
      name: "Please enter a name",
     // sub_category_id: "Please enter a sub_ category",
      description: "Please enter a description",
      "attribute[]": "Please enter a attribute",
       },
    submitHandler: function(form) {
      form.submit();
    }
  });
  

});

