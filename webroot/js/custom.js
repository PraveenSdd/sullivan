/*  validation for category 
 * By @Ahsan Ahamad
 * Date : 3 Nov. 2017
 */

$(function () {

    $('.deleteConfirm').removeAttr('onclick');

    //Initialize Select2 Elements
    var select2Flag = $('.chk-disable-select2').data('flag');
    if (select2Flag != 1) {
        $('.select2').select2();
    }
    $(document).on("click", ".checkDocSecurity", function (e) {
        return checkSecurity($(this).data('security-type-id'));
    });
    if ($('.inp-alert-date').length > 0) {//check class exist or not
        $(".inp-alert-end-date").on("dp.change", function (e) {
            setTimeout(() => {
                $('.inp-alert-date').data("DateTimePicker").maxDate(e.date);
            }, 0);
        });
        $(".inp-alert-date").on("dp.change", function (e) {
            $('.inp-alert-end-date').data("DateTimePicker").minDate(e.date);
        });
        $('.inp-alert-end-date').datetimepicker({
            format: 'MM-DD-YYYY',
            useCurrent: false, //Important! See issue #1075
        });
    }


});

/* permissionAlertModal - START */
/**
 * @description Open for permission denied alert
 * @element/popup location - src/Template/Element/modal/permission_alert_modal
 * @type function
 * $return true/false
 */
function permissionAlertModal(returnFlag) {
    var permissionAlertModal = $("#permissionAlertModal");
    permissionAlertModal.find("[data-return-flag]").unbind().click(function ()
    {
        permissionAlertModal.modal({show: false});

    });
    permissionAlertModal.find("[data-return-flag]").click(function () {
        var returnValue = $(this).data('return-flag');
        returnFlag(returnValue);
    });
    permissionAlertModal.modal({show: true, keyboard: false, });
}
// How to call permissionAlertModal() function
/*
 permissionAlertModal(function permissionAlert(returnFlag) {
 if (returnFlag != true) {
 return false;
 }
 });
 */
/* permissionAlertModal - END */

/* securityAlertModal - START */
/**
 * @description Open for document/permit/forms
 * @element/popup location - src/Template/Element/modal/security_alert_modal
 * @type function
 * $return true/false
 */
function securityAlertModal(returnFlag) {
    var securityAlertModal = $("#securityAlertModal");
    securityAlertModal.find("[data-return-flag]").unbind().click(function ()
    {
        securityAlertModal.modal({show: false});

    });
    securityAlertModal.find("[data-return-flag]").click(function () {
        var returnValue = $(this).data('return-flag');
        returnFlag(returnValue);
    });
    securityAlertModal.modal({show: true, keyboard: false, });
}
function checkSecurity(securityTypeId) {
    var accessFlag = true;
    var loggedRoleId = $('.logged-role-permission').data('role-id');
    if (securityTypeId > 0) {
        if (securityTypeId == 4 && (loggedRoleId == 1 || loggedRoleId == 4)) {
            accessFlag = false;
        } else if (securityTypeId == 3 && loggedRoleId != 2) {
            accessFlag = false;
        } else if (securityTypeId == 2 && (loggedRoleId == 3 || loggedRoleId == 4)) {
            accessFlag = false;
        }
    }
    if (!accessFlag) { 
        //function define in custome.js
        securityAlertModal(function securityAlert(returnFlag) {
            if (returnFlag != true) {
                accessFlag = false;
            }
        });
        accessFlag = false;
    }
    return accessFlag;
}
// How to call securityAlertModal() function
/*
 securityAlertModal(function securityAlert(returnFlag) {
 if (returnFlag != true) {
 return false;
 }
 });
 */
/* securityAlertModal - END */

/* ecoConfirm - START */
/**
 * @description Open for confirmation
 * @element/popup location - src/Template/Element/modal/confirm_alert_modal
 * @type string
 * @type function
 * $return true/false
 */
function ecoConfirm(msg, returnStatus) {
    console.log(msg);
    var confirmBox = $("#confirmAlertModal");
    confirmBox.find("#confirmMessage").text(msg);
    confirmBox.find("[data-return-flag]").unbind().click(function ()
    {
        confirmBox.modal({show: false});

    });
    confirmBox.find("[data-return-flag]").click(function () {
        var setStatus = $(this).data('return-flag');
        returnStatus(setStatus);
    });
    confirmBox.modal({show: true, keyboard: false, });
    ;
}
// How to call ecoConfirm() function
/*
 ecoConfirm(StringMessage, function ecoAlert(findreturn) {
 if (findreturn == true) {
 return true;
 } else {
 return false;
 }
 });
 */

$(document).on('click', '.deleteConfirm', function (event) {
    var element = $(this);
    event.preventDefault();
    ecoConfirm('Are you sure to perform this action?', function ecoAlert(findreturn) {
        if (findreturn == true) {
            $(element).prev('form').submit();
        } else {
            return false;
        }
    });
});

/* ecoConfirm - END */

$(document).on('click', '.myalert-delete', function (event) {

    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var title = $(this).data('title');
    var subModel = $(this).data('submodelname');
    var foreignId = $(this).data('foreignid');
    var redirect = $(this).data('url');
    event.preventDefault();
    var urllink = $(this).attr('href');
    var url = "/customs/deleteStatus";

    var path = window.location.href;
    if (path.indexOf('admin') >= 0) {
        url = "/admin/customs/deleteStatus";
    }
    ecoConfirm("Are you sure you want to " + title + " this user ?", function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: url, //"/Customs/deleteStatus",
                type: "POST",
                data: {id: id,
                    model: model,
                    title: title,
                    subModel: subModel,
                    foreignId: foreignId,
                },
                success: function (data) {
                    if (redirect) {
                        window.location = redirect;
                    } else {
                        window.location.reload();
                    }
                }
            });
        } else {
            return false;
        }
    });
});





$(document).on('click', '.myalert-verify', function (event) {

    var id = $(this).data('id');
    var model = $(this).data('modelname');
    var title = $(this).data('title');
    var subModel = $(this).data('submodelname');
    var foreignId = $(this).data('foreignid');
    var redirect = $(this).data('url');
    event.preventDefault();
    var urllink = $(this).attr('href');
    var url = "/customs/verifyStaff";

    var path = window.location.href;
    if (path.indexOf('admin') >= 0) {
        url = "/admin/customs/verifyStaff";
    }

    ecoConfirm("Are you sure you want to " + title + " this user ?", function
            ecoAlert(findreturn) {
        if (findreturn == true) {
            $.ajax({
                url: url, //"/Customs/deleteStatus",
                type: "POST",
                dataType: 'JSON',
                data: {id: id,
                    model: model,
                    title: title,
                    subModel: subModel,
                    foreignId: foreignId,
                },
                success: function (data) {
                    console.log('data', data);
                    if (redirect) {
                        window.location = redirect;
                    } else {
                        window.location.reload();
                    }
                }
            });
        } else {
            return false;
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
//$(window).load(function () {
//  $('.loader-outer-block').delay(300).fadeOut('slow');
//});

function displayLoder() {
    $('.loader-outer-block').delay(200).fadeIn('slow');
}
function hideLoder() {
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

$(document).ready(function () {
    $(document).on('click', '.action-txt', function () {
        $('.advance-search-panel').removeClass('hide');
    });
    $(document).on('click', '.advance-search-panel .asp-control', function () {
        $('.advance-search-panel').addClass('hide');
    });

});


/**
 *  CODE FOR ALERT -- START
 */
$(document).on('change', '.inp-alert-type', function () {
    toggleAlertType(0);
});

/**
 * 
 * @param int setValueFlag if 1 = set value on basis of data attribute 
 * @returns {undefined}
 */
function toggleAlertType(setValueFlag) {
    $('.inp-alert-staff').attr('disabled', 'disabled');
    $('.inp-alert-staff').val('').trigger('change');
    $('.inp-alert-company').attr('disabled', 'disabled');
    $('.inp-alert-company').val('').trigger('change');
    $('.inp-alert-operation').attr('disabled', 'disabled');
    $('.inp-alert-operation').val('').trigger('change');

    var select2Flag = $('.chk-disable-select2').data('flag');
    if (select2Flag == 1) {
        $('.inp-alert-multi').multiselect('disable');
        $('.inp-alert-multi').val('').multiselect('refresh');
    }


    var alertTypeId = $('.inp-alert-type').val();
    if (alertTypeId == 2) {
        $('.inp-alert-staff').attr('disabled', false);
        if (setValueFlag) {
            var alertStaffIds = $('.inp-alert-staff').attr('data-alert-staff-id');
            alertStaffIds = String(alertStaffIds);
            if (alertStaffIds.indexOf(',') >= 0) {
                $('.inp-alert-staff').val(alertStaffIds.split(',')).trigger('change');
            } else {
                $('.inp-alert-staff').val([alertStaffIds]).trigger('change');
            }
        }
    } else if (alertTypeId == 3) {
        $('.inp-alert-company').attr('disabled', false);
        if (setValueFlag) {
            var alertCompanyIds = $('.inp-alert-company').attr('data-alert-company-id');
            alertCompanyIds = String(alertCompanyIds);
            if (alertCompanyIds.indexOf(',') >= 0) {
                $('.inp-alert-company').val(alertCompanyIds.split(',')).trigger('change');
            } else {
                $('.inp-alert-company').val([alertCompanyIds]).trigger('change');
            }
        }
    } else if (alertTypeId == 4) {
        $('.inp-alert-operation').attr('disabled', false);
        if (setValueFlag) {
            var alertOperationIds = $('.inp-alert-operation').attr('data-alert-operation-id');
            alertOperationIds = String(alertOperationIds);
            if (alertOperationIds.indexOf(',') >= 0) {
                $('.inp-alert-operation').val(alertOperationIds.split(',')).trigger('change');
            } else {
                $('.inp-alert-operation').val([alertOperationIds]).trigger('change');
            }
        }
    } else if (alertTypeId == 5) {
        $('.inp-alert-multi').multiselect('enable');
        if (setValueFlag) {
            var alertStaffIds = $('.inp-alert-staff').attr('data-alert-staff-id');
            alertStaffIds = String(alertStaffIds);
            if (alertStaffIds.indexOf(',') >= 0) {
                $('.inp-alert-multi').val(alertStaffIds.split(',')).multiselect('refresh');
            } else {
                $('.inp-alert-multi').val([alertStaffIds]).multiselect('refresh');
            }
        }
    }
}

$(document).on('click', '.inp-alert-repeat', function () {
    toggleAlertRepeat(0);
});

/**
 * 
 * @param int setValueFlag if 1 = set value on basis of data attribute 
 * @returns {undefined}
 */
function toggleAlertRepeat(setValueFlag) {
    if ($('.inp-alert-repeat').prop('checked')) {
        $('.inp-alert-interval').attr('disabled', false);
        $('.inp-alert-interval-type').attr('disabled', false);
        $('.inp-alert-end-date').attr('disabled', false);
    } else {
        $('.inp-alert-interval').attr('disabled', 'disabled');
        $('.inp-alert-interval-type').attr('disabled', 'disabled');
        $('.inp-alert-end-date').attr('disabled', 'disabled');
    }
    if (setValueFlag <= 0) {
        $('.inp-alert-interval').val('');
        $('.inp-alert-interval-type').val('');
        $('.inp-alert-end-date').val('');
    }
}

function resetAlertFields() {
    $('.inp-alert-id').val('');
    $('.inp-alert-type').val('').trigger('change');
    $('.inp-alert-staff').attr('disabled', 'disabled');
    $('.inp-alert-staff').val('').trigger('change');
    $('.inp-alert-staff').attr('data-alert-staff-id', '');
    $('.inp-alert-company').attr('disabled', 'disabled');
    $('.inp-alert-company').val('').trigger('change');
    $('.inp-alert-company').attr('data-alert-company-id', '');
    $('.inp-alert-operation').attr('disabled', 'disabled');
    $('.inp-alert-operation').val('');
    $('.inp-alert-operation').attr('data-alert-operation-id', '');
    $('.inp-alert-operation').trigger('change');
    $('.inp-alert-title').val('');
    $('.inp-alert-date').val('');
    $('.inp-alert-time').val('');
    $('.inp-alert-notes').val('');

    // Additional Fields
    $('.inp-alert-permit-id').val('');
}

/**
 *  CODE FOR ALERT -- END
 */
/**
 *  CODE FOR Deadline -- START
 */
$(document).on('change', '.inp-deadline-type', function () {
    toggleDeadlineType(0);
});

/**
 * 
 * @param int setValueFlag if 1 = set value on basis of data attribute 
 * @returns {undefined}
 */
function toggleDeadlineType(setValueFlag) {
    $('.inp-deadline-document').attr('disabled', 'disabled');
    $('.inp-deadline-document').val('').trigger('change');
    $('.inp-deadline-permit-form').attr('disabled', 'disabled');
    $('.inp-deadline-permit-form').val('').trigger('change');


    var select2Flag = $('.chk-disable-select2').data('flag');
    if (select2Flag == 1) {
        $('.inp-deadline-multi').multiselect('disable');
        $('.inp-deadline-multi').val('').multiselect('refresh');
    }
    var deadlineTypeId = $('.inp-deadline-type').val();
    if (deadlineTypeId == 1) {//Form
        $('.inp-deadline-permit-form').multiselect('enable');
        $('.inp-deadline-document').multiselect('disable').val('').multiselect('refresh');
        if (setValueFlag) {
            var deadlinePermitFormIds = $('.inp-deadline-permit-form').attr('data-deadline-permit-form-id');
            deadlinePermitFormIds = String(deadlinePermitFormIds);
            if (deadlinePermitFormIds.indexOf(',') >= 0) {
                $('.inp-deadline-permit-form').val(deadlinePermitFormIds.split(',')).multiselect('refresh');
            } else {
                $('.inp-deadline-permit-form').val([deadlinePermitFormIds]).multiselect('refresh');
            }
        }
    } else if (deadlineTypeId == 2) {//Document
        $('.inp-deadline-document').multiselect('enable');
        $('.inp-deadline-permit-form').multiselect('disable').val('').multiselect('refresh');
        if (setValueFlag) {
            var deadlineDocumentIds = $('.inp-deadline-document').attr('data-deadline-document-id');
            deadlineDocumentIds = String(deadlineDocumentIds);
            if (deadlineDocumentIds.indexOf(',') >= 0) {
                $('.inp-deadline-document').val(deadlineDocumentIds.split(',')).multiselect('refresh');
            } else {
                $('.inp-deadline-document').val([deadlineDocumentIds]).multiselect('refresh');
            }
        }
    } else {
        $('.inp-deadline-document').multiselect('disable').val('').multiselect('refresh');
        $('.inp-deadline-permit-form').multiselect('disable').val('').multiselect('refresh');
    }
}

function resetDeadlineFields() {
    $('.inp-deadline-id').val('');
    $('.inp-deadline-type').val('').trigger('change');
    $('.inp-deadline-document').attr('disabled', 'disabled');
    $('.inp-deadline-permit-form').attr('disabled', 'disabled');
    $('.inp-deadline-document').val('').trigger('change');
    $('.inp-deadline-permit-form').val('').trigger('change');
    $('.inp-deadline-date').val();
    $('.inp-deadline-time').val();
}

$(document).on('change', '#location-id', function () {
    var locationId = $(this).val();
    $.ajax({
        url: "/permits/getOperationList",
        type: "POST",
        data: {'location_id': locationId},

        success: function (responce)
        {
            $("#operation-id").html(responce);
        }
    });

});






