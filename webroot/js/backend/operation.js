/* validation for Operation 
 * By @Ahsan Ahamad
 * Date : 5 Jan. 2018
 */

$(document).ready(function () {
    //***************** add Permit validation *****************************\\
    $("#frmOperation").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 120,
            },
            "description": {
                /// required: true,
                maxlength: 160,

            },
        },
        messages: {
            "name": {
                required: "Please enter operation type",
                maxlength: "Maximum characters are 120.",
            },
            "short_description": {
                //  required: "Please enter notes",
                maxlength: "Maximum characters are 160."
            },
        },
    });

    /*** start   code for add agency value from admin permit**/
    $(".addOperationPermit").click(function () {
        if ($("#frmOperation").length == 1) {
            if ($("#frmOperation").valid()) {
                var formId = $('.inp-operation-name').attr('data-id');
                if (formId > 0) {
                    openOperationPermitModal($(this));
                } else {
// code for saving data
                    saveOperationData();
                    openOperationPermitModal($(this));
                }

            }
        } else {
            openOperationPermitModal($(this));
        }
    });

    /* @Function: saveOperationData() 
     * @Description: save and update operation form admin
     * @param type: msg
     * @By @Ahsan Ahamad
     * @Date : 10th Jan. 2017
     */
    function saveOperationData() {
        $.ajax({
            url: "/admin/operations/saveOperationData",
            type: "POST",
            data: {name: $('.inp-operation-name').val(), description: $('.inp-operation-description').val(), id: $('.inp-operation-nam').attr('data-id')},
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function (responce)
            {
                if (responce.flag) {
                    pNotifySuccess('Operation Type', responce.msg);
                    $('.addicons').attr('data-operationId', responce.operation_id);
                    $('.addOperationId').val(responce.operation_id);
                    $('.inp-operation-name').attr('data-id', responce.operation_id);
                } else {
                    pNotifyError('Operation Type', responce.msg);

                }

            }
        });
    }

    /* @Function: openOperationPermitModal() 
     * @Description: open operation permit modal form admin
     * @param type: msg
     * @By @Ahsan Ahamad
     * @Date : 10th Jan. 2017
     */
    function openOperationPermitModal(element) {

        var title = $(element).data('title');
        var operationId = $('.inp-operation-name').attr('data-id');
        $.ajax({
            url: "/admin/operations/getOperationPermit",
            type: "POST",
            beforeSend: function (xhr) {
                $('.loader-outer-block').css('display', 'none');
            },
            data: {operationId: operationId},
            type: "Post",
            dataType: 'html',
            async: false,
            success: function (response)
            {
//                if (responce.flag) {
//                    pNotifySuccess('Operation Type', responce.msg);
//                    $('.formId').attr('default', responce.formId);
//                }
                if (response) {
                    $('#categotyId').html(response);
                    if (operationId > 0) {
                        $('#categotyId').val([operationId]).trigger('change');
                    }
                }
            }
        });
        $('.modelTitle').html(title);
        $('.addOperationId').val(operationId);
        $("#frmOperation").val([operationId]).trigger('change');
        $('#operationPermitModel').modal('toggle');

    }

//** code add for permit ***\\
    $("#AddOperationPermit").on('submit', function (e) {
        e.preventDefault();
        if ($('#AddOperationPermit').valid()) {
            $.ajax({
                url: "/admin/operations/addOperationPermit",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Operation Type', responce.msg);
                        $('#operationPermitModel').modal('toggle');
                        getReleatedOperationPermit(responce.operation_id);


                    } else {
                        pNotifyError('Operation Type', responce.msg);
                        $('#operationPermitModel').modal('toggle');
                    }

                }
            });
        }
    });

    //**  code get all related permit  **\\
    function getReleatedOperationPermit(operation_id) {
        $.ajax({
            url: "/admin/operations/getReleatedOperationPermit/" + operation_id,
            type: "POST",
            data: {formId: 2},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-block').html(responce);
            }
        });
    }

    //***code validation permit  ****\\

    $("#AddOperationPermit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "permit_id[]": {
                required: true,
            },

        },
        messages: {
            "permit_id[]": {
                required: "Please select Permit",
            },
        },
    });

//***************** code edit conatct agencyl  *****************************\\  
    $(document).on('click', ".editAgencyConatct", function () {

        $('.inp-agency-name').attr('data-id', $(this).data('contactid'));
        $('.addCategoryId').val($(this).data('categoryid'));
        $('.agencyContactId').val($(this).data('contactid'));
        $('.conatctName').val($(this).data('conatcname'));
        $('.conatctPosition').val($(this).data('conatcposition'));
        $('.conatctEmail').val($(this).data('conatcemail'));
        $('.conatctPhone').val($(this).data('conatcphone'));
        $('.conatctAddress').val($(this).data('conatcaddress'));
        $('#contactPersonModel').modal('toggle');
    });


    //*** add Permit validation **\\
    $("#frmOperation").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 120,
            },
            "description": {
                required: true,
                maxlength: 160,

            },
        },
        messages: {
            "name": {
                required: "Please enter operation type",
                maxlength: "Maximum characters are 120."
            },
            "short_description": {
                required: "Please enter notes",
                maxlength: "Maximum characters are 160."
            },
        },
    });



// check permit of the operation exit or not
    /*$(document).on('change', '.permitOperations', function () {
     var prmitId = $(this).val();
     var operationId = $('#addOperationId').val();
     $.ajax({
     url: "/admin/operations/checkOperationPermit",
     type: "POST",
     data: {'prmitId':prmitId,'operationId':operationId},
     dataType: 'JSON',
     cache: false,
     async: false,
     success: function (responce)
     {
     if (responce.flag) {
     pNotifyError('Operation', responce.msg);
     
     } 
     }
     });
     
     });*/

    $(document).on('click', '.btn-form-submit', function () {
        if ($("#frmOperation").valid()) {
            $("#frmOperation").submit();
            displayLoder();
        }
    });

    /* Permit-Alert - START */
    $(document).on("click", ".btnOperationAlertModal", function () {
        var operationId = $('.inp-operation-name').attr('data-id');
        if (operationId <= 0) {
            if ($('#frmOperation').valid()) {
                if (saveOperationData()) {
                    openOperationAlertModal($(this));
                }
            }
        } else {
            openOperationAlertModal($(this));
        }
    });


    function openOperationAlertModal(element) {
        $('#operationAlertModal .modelTitle').html($(element).data('title'));
        resetAlertFields();
        var operationId = $('.inp-operation-name').attr('data-id');
        console.log(operationId);
        $('.inp-alert-id').val($(element).data('alert-id'));
        $('.inp-alert-type').val(4).trigger('change');
        $('.inp-alert-staff').attr('data-alert-staff-id', $(element).data('alert-staff-id'));
        $('.inp-alert-company').attr('data-alert-company-id', $(element).data('alert-company-id'));
        $('.inp-alert-operation').attr('data-alert-operation-id', operationId);
        $('.inp-alert-title').val($(element).data('alert-title'));
        $('.inp-alert-date').val($(element).data('alert-date'));
        $('.inp-alert-time').val($(element).data('alert-time'));
        $('.inp-alert-notes').val($(element).data('alert-notes'));
        toggleAlertType(1);
        var alertRepeat = $(element).data('alert-repeat');
        if (alertRepeat) {
            $('.inp-alert-repeat').prop('checked', true);
            $('.inp-alert-interval').val($(element).data('alert-interval')).attr('disabled',false);
            $('.inp-alert-interval-type').val($(element).data('alert-interval-type')).attr('disabled',false);
             $('.inp-alert-end-date').val($(element).data('alert-end-date')).attr('disabled',false);
        } else {
            $('.inp-alert-repeat').prop('checked', false);
            $('.inp-alert-interval').val('').attr('disabled',true);
            $('.inp-alert-interval-type').val('').attr('disabled',true);
            $('.inp-alert-end-date').val('').attr('disabled',true);
        }
        $('.inp-alert-type').attr('disabled', 'disabled');
        $('.inp-alert-operation').attr('disabled', 'disabled');
        $('#operationAlertModal').modal('toggle');
    }

    // Save Permit-Alert Data
    $(".subOperationAlert").on('click', function (e) {
        e.preventDefault();
        if ($('#frmOperationAlert').valid()) {
            var operationId = $('.inp-operation-name').attr('data-id');
            $.ajax({
                url: "/admin/operations/saveRelatedAlert/" + operationId,
                type: "POST",
                data: $('#frmOperationAlert').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Alert', responce.msg);
                        $('#operationAlertModal').modal('toggle');
                        getRelatedAlert(operationId);
                    } else {
                        pNotifyError('Alert', responce.msg);
                    }
                }
            });
        }
    });

    /* check Operation-Alert validation */
    $("#frmOperationAlert").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "OperationAlert[alert_type_id]": {
                required: true,
            },
            "OperationAlert[staff_id][]": {
                required: false,
            },
            "OperationAlert[company_id][]": {
                required: true,
            },
            "OperationAlert[operation_id][]": {
                required: true,
            },
            "OperationAlert[title]": {
                required: true,
                maxlength: 120,
            },
            "OperationAlert[date]": {
                required: true,
            },
            "OperationAlert[time]": {
                required: true,
            },
            "OperationAlert[notes]": {
                required: true,
            },
            "OperationAlert[is_repeated]": {
                required: false,
            },
            "OperationAlert[interval_value]": {
                required: true,
            },
            "OperationAlert[interval_type]": {
                required: true,
            },
            "OperationAlert[alert_end_date]": {
                required: true,
            }

        },
        messages: {
            "OperationAlert[alert_type_id]": {
                required: 'Please select alert type',
            },
            "OperationAlert[staff_id][]": {
                required: 'Please select staff',
            },
            "OperationAlert[company_id][]": {
                required: 'Please select copmany',
            },
            "OperationAlert[operation_id][]": {
                required: 'Please select operation',
            },
            "OperationAlert[title]": {
                required: 'Please enter title',
            },
            "OperationAlert[date]": {
                required: 'Please select date',
            },
            "OperationAlert[time]": {
                required: 'Please select time',
            },
            "OperationAlert[notes]": {
                required: 'Please enter notes',
            },
            "OperationAlert[is_repeated]": {
                required: 'Please select repeat',
            },
            "OperationAlert[interval_value]": {
                required: 'Please enter interval',
            },
            "OperationAlert[interval_type]": {
                required: 'Please select interval type',
            },
            "OperationAlert[alert_end_date]": {
                required: 'Please select end date.',
            }
        }
    });


    function getRelatedAlert(operationId) {
        $.ajax({
            url: "/admin/operations/getRelatedAlert/" + operationId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.operation-alert-block').html(responce);
            }
        });
    }
    /* Operation-Alert - END */


});
















    