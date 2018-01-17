/*  validation for alert 
 * By @Ahsan Ahamad
 * Date : 23rd Nov. 2017
 */
$(function () {
    $("#add_alerts").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            alert_type_id: "required",
            "company_id": "required",
            "industry_id": "required",
            title: "required",
            notes: "required",
        },
        messages: {
            alert_type_id: "Please select alert type",
            "company_id": "Please select companies",
            "industry_id": "Please select industries",
            title: "Please enter a title",
            notes: "Please enter a notes"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    
/* code for on change disabled staff on forntend*/
    $(".alertTypeFront").on('change', function () {
//  id 3 for company 
        if ($(".alertTypeFront").val() == 3) {
           jQuery('.multiselect').attr("disabled", false);
           jQuery('.multiselect').removeClass("disabled");
        }else{
               jQuery('.multiselect').attr("disabled", true);
           jQuery('.multiselect').addClass("disabled");
            
        }
   });
   
    
/* code for on change alert type disable menus*/
    $(".alertType").on('change', function () {
//  id 3 for company 
        if ($(".alertType").val() == 3) {
            $('#industriesList').attr('disabled', 'disabled');
            $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', false);
        }
//  id 4 for industry 
        else if ($(".alertType").val() == 4) {
            $('#industriesList').attr('disabled', false);
            $('#companiesList').attr('disabled', 'disabled');
            $('#staffList').attr('disabled', 'disabled');
        }
//  id 4 for admin staff 
        else if ($(".alertType").val() == 2) {
            $('#staffList').attr('disabled', false);
            $('#companiesList').attr('disabled', 'disabled');
            $('#industriesList').attr('disabled', 'disabled');
        }else{
             $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', 'disabled');
            $('#industriesList').attr('disabled', 'disabled');
        }
    });


});


$('#chkRepetition').on('click',function(){    
    enableDisableAlert();
});

/*  @@Function:enableDisableAlertInterval()
 * @Description: enable disable alert related to inertval  ajax
 * @param type: chkRepetition
 * @By @Ahsan Ahamad
 * @Date : 12th Dec. 2017
 */ 
function enableDisableAlertInterval(chkRepetition){
    if($('#chkRepetition').prop('checked') == true){
        $('#interval').attr('disabled',false);
        $('#intervalType').attr('disabled',false);
    } else {
        $('#interval').attr('disabled',true);
        $('#intervalType').attr('disabled',true);
    }
}
$('.permitRepetition').on('click',function(){    
    enableDisableAlert();
});

/*  @@Function:enableDisableAlert()
 * @Description: enable disable alert related to permit ajax
 * @param type: chkRepetition
 * @By @Ahsan Ahamad
 * @Date : 12th Dec. 2017
 */ 

function enableDisableAlert(chkRepetition){
    if($('.permitRepetition').prop('checked') == true){
        $('#interval').attr('disabled',false);
        $('#intervalType').attr('disabled',false);
    } else {
        $('#interval').attr('disabled',true);
        $('#intervalType').attr('disabled',true);
    }
}
