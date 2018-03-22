
 // validation for letters only
 $.validator.addMethod("letterspace", function (value, element) {
       return this.optional(element) || /^[a-z \s ]+$/i.test(value);
    }, "Character only.");
    
    $.validator.addMethod("lettersonly", function (value, element) {
       return this.optional(element) || /^[a-z\s]+$/i.test(value);
    }, "Character only.");
    

//  validation for charater, comma and .
    $.validator.addMethod("charDotComma", function (value, element) {
       return this.optional(element) || /^[a-z,.-\s]+$/i.test(value);
    }, "Character only (except - . , ).");

    // validation for alphanumeric character with spaces allowed
    $.validator.addMethod("alphanumspace", function(value, element) {
       return this.optional(element) || /^[a-z0-9_ ]+$/i.test(value);
    },"Can contain only letters, numbers and spaces.");
    
    // validation for alphanumeric character with spaces allowed
    $.validator.addMethod("nameLetters", function(value, element) {
       return this.optional(element) || /^[a-z0-9-_ ()]+$/i.test(value);
    },"Can contain only letters, numbers, hyphen and spaces.");

       // validation for alphanumeric character without spaces
    $.validator.addMethod("alphanumeric", function(value, element) {
       return this.optional(element) || /^[a-z0-9.\-]+$/i.test(value);
    },"Can only contain only letters and numbers.");

 // validation for combination of alphanumeric and special character without spaces
    $.validator.addMethod("alphanumspecial", function(value, element) {
      return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);},"Combination of alphabets,special characters & numeric values required."); 
  
  // validation for allowing decimal values for 2 places
  
   jQuery.validator.addMethod("numDecimal", function(value, element) {
        return this.optional(element) || /^\d{0,10}(\.\d{0,2})?$/i.test(value);
    }, "Only two decimal places allowed.");

   // validation for month MM format

    jQuery.validator.addMethod("monthFormat",function (value, element) {
        var check = false;
        var re = /1[0-2]|0[1-9]/;
        if (re.test(value)) {
                check = true;
        } else {
            check = false;
        }
        return this.optional(element) || check;
        },"Use MM format.");


    // validation for year for credit card

    $.validator.addMethod("checkYear", function(value,element) {

        year_result = false;
        card_year = value;
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        if(card_year >= currentYear) {
          year_result = true; 
        } else {
          year_result = false; 
        }  
    return this.optional(element) || year_result;
    },'Invalid year');  

   // validation for month for credit card       
    $.validator.addMethod("checkMonth", function(value,element) {

        var result = false; 
        card_month = value;

         if(card_month >= 1 && card_month <= 12) {
            result = true;             
        } else {
              result = false;     
           }
        return this.optional(element) || result;
    },'Invalid month');  

  // validation to check if updated amount is more than new amount
  
  // validation for month for credit card       
    $.validator.addMethod("checkAmount", function(value,element) {
        var result = false;
        var old_amt = parseFloat($('#old_amount').val()); 
        new_amount = parseFloat(value);
        console.log(old_amt + value);
         if(new_amount > old_amt) {
            result = false;             
        } else {
              result = true;     
           }
        return this.optional(element) || result;
    },"New amount can't be greater than old amount.");  
    


// validation for value must be greater than zero (0)
jQuery.validator.addMethod("greaterThanZero", function (value, element) {
    return this.optional(element) || (value>0);
}, "Value can not be zero.");

// validation for value must be greater than zero (0)
jQuery.validator.addMethod("zeroAndNinetyNine", function (value, element) {
     var result = false;
     value = parseFloat(value);
     if(value < 0 || value > 99) {
        result = false;             
     } else {
          result = true;     
     }
    return this.optional(element) || result;
}, "Please enter value between 0 & 99");

// validation for value must be greater than zero (0)
jQuery.validator.addMethod("validClientId", function (value, element) {
    var result = false;
    value = jQuery('#InvoiceSendTo').val();
    value = parseFloat(value);
     if(value > 0 ) {
        result = true;             
     } else {
          result = false;     
     }
    return this.optional(element) || result;
}, 'Please select a client.'); 

jQuery.validator.addMethod("recurringLimit", function (value, element, params) {
    params.paymentGateway = 'recurring';
    params.transactionLimit = '18';
    var result = true;
    var paymentGatewayId = jQuery('#InvoiceGatewayId').val();
    value = parseInt(value);
    if(paymentGatewayId != '' && value > 0){
        if(paymentGatewayId == 1 && value >52){
            params.paymentGateway = 'payflow pro';
            params.transactionLimit = '52';
            result = false; 
        } else if(paymentGatewayId == 2 && value >24){
            params.paymentGateway = 'stripe';
            params.transactionLimit = '24';
            result = false; 
        } else if(paymentGatewayId == 3 && value >18){
            params.paymentGateway = 'authorize.net';
            params.transactionLimit = '18';
            result = false; 
        } else if(paymentGatewayId == 4 && value >18){
            params.paymentGateway = 'beanstream';
            params.transactionLimit = '18';
            result = false; 
        } else if(paymentGatewayId == 6 && value >60){
            params.paymentGateway = 'sprucebooks processing';
            params.transactionLimit = '60';
            result = false; 
        } else if(paymentGatewayId == 7 && value >52){
            params.paymentGateway = 'paypal standard';
            params.transactionLimit = '52';
            result = false; 
        }
    }
    return this.optional(element) || result;
}, function(params, element) {
    return "Maximum transactions for " + params.paymentGateway + " are " + params.transactionLimit;
});  


