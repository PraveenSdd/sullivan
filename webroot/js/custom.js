/*  validation for category 
 * By @Ahsan Ahamad
 * Date : 3 Nov. 2017
 */

$(function () {
   
    //Initialize Select2 Elements
    $('.select2').select2();
    
});

$(document).on('click', '.myalert-delete', function (event) {

    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var title = $(this).data('title');
    var subModel = $(this).data('deletesub');
    var sub_id = $(this).data('sub_id');
    var redirect = $(this).data('url');
    event.preventDefault();
    var urllink = $(this).attr('href');
    ecoConfirm("Are you sure you want to delete this ' "+title+"' ?", function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: "/Customs/deleteStatus",
                type: "POST",
                data: {id: id,
                    model: model,
                    title: title,
                    subModel:subModel,
                    sub_id:sub_id
                },
                success: function (data) {
                    if(redirect){
                        window.location = redirect;
                    }else{
                        window.location.reload();
                    }
                }
            });
        } else {
            console.log('false');
        }
    });
});


/* Code For Loader - START */
$(document).ajaxStart(function (e) {
    var $el = $(e.target.activeElement);
    if (!($el.hasClass('hide-ajax-loader'))) {
        $('.loader-outer-block').fadeIn('slow');
    } else {
        $('.loader-outer-block').fadeOut();
        //  hide-ajax-loader - class is found';
    }
});


$(document).ajaxSend(function (e) {
    var $el = $(e.target.activeElement);
    if (($el.hasClass('hide-ajax-loader'))) {
        $('.loader-outer-block').fadeOut();
    }
});


$(document).ajaxStop(function () {
    $('.loader-outer-block').delay(200).fadeOut('slow');
});

$(document).ajaxError(function (event, request, settings) {
    $('.loader-outer-block').delay(200).fadeOut('slow');
});


//windows load event
$(window).load(function () {
    $('.loader-outer-block').delay(300).fadeOut('slow');
});

function displayLoder(){
     $('.loader-outer-block').delay(200).fadeIn('slow');
}
function hideLoder(){
     $('.loader-outer-block').delay(200).fadeOut('slow');
}

/* Code For Loader - END */

$(document).on('keypress', ".inp-phone", function (event) {
    //if the letter is not digit then display error and don't type anything
    if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        return false;
    }
});


//$(".integerValue").keypress(function (e) { 
$(document).on('keypress', ".inp-integer", function (event) {
    //if the letter is not digit then display error and don't type anything
    if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        return false;
    }
});


$(document).on('keypress', ".inp-decimal", function (event) {
    //if the letter is not digit then display error and don't type anything
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        return false;
    } else {
        // check length after decimal point
        if ($(this).val().indexOf('.') != -1 && $(this).val().split(".")[1].length == 2) {
            return false;
        }
    }
});

/*  @@Function:ecoConfirm()
 * @Description: Open confirm alert popup
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Dec. 2017
 */ 

function ecoConfirm(msg, returnStatus) {
    var confirmBox = $("#confirm-modal");
    confirmBox.find("#confirmMessage").text(msg);
    confirmBox.find("[data-returnvalue]").unbind().click(function ()
    {
        confirmBox.modal({show: false});

    });
    confirmBox.find("[data-returnvalue]").click(function () {
        var setStatus = $(this).data('returnvalue');
        returnStatus(setStatus);
    });
    confirmBox.modal({show: true, keyboard: false, });
    ;
}

/*  @@Function: 
 * @Description: On click for change status ajax
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Oct. 2017
 */ 


$(document).on('click', '.myalert-active', function (event) {
    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var status = $(this).data('status');
    var newStatus = $(this).data('newstatus');
    var title = $(this).data('title');
    event.preventDefault();
    var urllink = $(this).attr('href');
    ecoConfirm("Are you sure you want to change the status?", function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: "/Customs/changeStatus",
                type: "POST",
                data: {id: id,
                    model: model,
                    status: status,
                    newStatus: newStatus,
                    title: title
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        } else {
            console.log('false');
        }
    });
});

/*  @@Function: 
 * @Description: js for open search form on index page
 * @param type: msg
 * @By @Ahsan Ahamad
 * @Date : 12th Oct. 2017
 */ 
 
 $(document).ready(function() {
    $(document).on('click', '.action-txt', function(){
        $('.advance-search-panel').removeClass('hide');
    });
    $(document).on('click', '.advance-search-panel .asp-control', function(){
            $('.advance-search-panel').addClass('hide');
    });
                        
        });





