/* function for validation category */
$(function(){
    $('#CategoryAddForm').validate({
      debug: false,
      errorClass: "authError",
      onkeyup: false,
      rules: {
        "data[Category][name]":{
          required: true,
          remote: "/admin/categories/checkCategoryUniqueName/",
        },
      },
      messages:{
        "data[Category][name]":{
          required: "Please enter category name",
          remote: "Category name is already exists",
         
        },
      },      
      highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
      }
    });
    $('#pleaseSubmit').click(function(e){
      e.preventDefault();
      if ($('#CategoryAddForm').valid()) {
          $('#loadingImg').show();
            $('#CategoryAddForm').submit();
      }
    });
  });
  
  $(document).ready(function () {
      $('#CategoryName').focus(); 
  });