/*  validation for agency 
 * By @Praveen Soni
 * Date : 05 Feb. 2018
 */

/**
 * 
 * HINT
 * Block 1 - Permit Change Status
 * Block 2 - View/ Left Modal
 * Block 3 - Permit-Alert
 * Block 4 - Permit-Form
 * Block 5 - Permit-Document
 * Block 6 - Permit-Instruction
 * Block 7 - Permit-Deadline
 * 
 */

$(document).ready(function () {
    /*Permit status block*/
    $("#frmUserPermitLog").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "UserPermitLogs[notes]": {
                required: true,
                maxlength: 255,
            },
            "UserPermitLogs[renewable_date]": {
                required: true,
            }

        },
        messages: {
            "UserPermitLogs[notes]": {
                required: 'Please enter notes.',
            },
            "UserPermitLogs[renewable_date]": {
                required: 'Please select date.',
            }
        }
    });

    $(".subUserPermitLog").on('click', function (e) {
        e.preventDefault();
        if ($('#frmUserPermitLog').valid()) {
            $.ajax({
                url: "/permits/changeUserPermitStatus",
                type: "POST",
                data: $('#frmUserPermitLog').serialize(),
                success: function (responce)
                {
                    $('#permitActionModal').modal('toggle');
                    var res = JSON.parse(responce);
                    if (res.statusCode == 200) {
                        $("#success").show();
                        $("#success").html("Status has been updated sucessfully");
                    } else {
                        $("#success").show();
                        $("#success").html("Status has been updated sucessfully");
                    }
                    setTimeout(function () {
                        $("#success").hide();
                        $("#error").hide();
                    }, 3000);
                }
            });
        }
    });

    /**
     * Block - 1
     * Block 1 - Permit Change Status
     */
    /* Change Status of Permit  - START */
    $(".change-status").on('change', function () {
        $(".ren-date").addClass("hide");
        $('.inp-permit-renewable-date').rules("remove");
        $(".inp-selected-text").html($(this).find('option:selected').text());
        $("#userpermitlogs-status-id").val($(this).val());
        $("#userpermitlogs-permit-id").val($(this).attr('permit_id'));
        $("#userpermitlogs-user-location-id").val($(this).attr('user_location_id'));
        $("#userpermitlogs-operation-id").val($(this).attr('operation_id'));
        if ($(this).val() == 4) {//accepted
            $('.inp-permit-renewable-date').rules("add", {
                required: true,
            });
            $(".ren-date").removeClass("hide");
            $('.inp-permit-renewable-date').datetimepicker({
                format: 'MM-DD-YYYY',
                minDate: new Date()
            });
        }
        $('#permitActionModal').modal('toggle');
        return false;
//        var status_id = $(this).val();
//        var permit_id = $(this).attr('permit_id');
//        var user_location_id = $(this).attr('user_location_id');
//        var operation_id = $(this).attr('operation_id');
//        $.ajax({
//            url: "/users/changeUserPermitStatus",
//            type: "POST",
//            data: {'status_id': status_id, 'permit_id': permit_id, 'user_location_id': user_location_id, 'operation_id': operation_id},
//
//            success: function (responce)
//            {
//                var res = JSON.parse(responce);
//                if (res.statusCode == 200) {
//
//                    $("#success").show();
//                    $("#success").html("Status has been updated sucessfully");
//
//
//                } else {
//                    $("#success").show();
//                    $("#success").html("Status has been updated sucessfully");
//                }
//
//                setTimeout(function () {
//                    $("#success").hide();
//                    $("#error").hide();
//                }, 3000);
//
//            }
//        });

    });
    /* Change Status of Permit  - START */

    /**
     * Block - 2
     * View/ Left Modal
     */


    /**
     * Block - 3
     * Permit Alert Block 
     */

    /* Permit-Alert - START */
    $('.inp-alert-multi').multiselect({
        numberDisplayed: 5
    });

    $(document).on("click", ".btnPermitAlertModal", function () {
        openPermitAlertModal($(this));
    });


    function openPermitAlertModal(element) {
        $('#permitAlertModal .modelTitle').html($(element).data('modal-title'));
        resetAlertFields();
        $('.inp-alert-id').val($(element).data('alert-id'));
        $('.inp-alert-type').val($(element).data('alert-type')).trigger('change');
        $('.inp-alert-staff').attr('data-alert-staff-id', $(element).data('alert-staff-id'));
        $('.inp-alert-title').val($(element).data('alert-title'));
        if (new Date($(element).data('alert-date')).getTime() >= new Date().getTime()) {
            $('.inp-alert-date').val($(element).data('alert-date'));
        }
        $('#inptUserPreviousPermitDocumentId').val($(element).data('permit-document-id'));//set for previous permit alert
        $('#inptUserPermitId').val($(".inp-user-permit-id").data('id'));//set for previous permit alert
        $('.inp-alert-time').val($(element).data('alert-time'));
        $('.inp-alert-notes').val($(element).data('alert-notes'));
        toggleAlertType($(element).data('alert-permit-id'));
        $('#permitAlertModal').modal('toggle');
    }

    // Save Permit-Alert Data
    $(".subPermitAlert").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitAlert').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            var operationId = $('.inp-operation-name').attr('data-id');
            var locationId = $('.inp-location-name').attr('data-id');
            var userPermitId = $(".inp-user-permit-id").attr('data-id');
            $.ajax({
                url: "/permits/saveRelatedAlert/" + permitId + "/" + locationId + "/" + operationId + "/" + userPermitId,
                type: "POST",
                data: $('#frmPermitAlert').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Alert', responce.msg);
                        $('#permitAlertModal').modal('toggle');
                        //getRelatedAlert(permitId);
                    } else {
                        pNotifyError('Alert', responce.msg);
                    }
                }
            });
        }
    });

    /* check Permit-Alert validation */
    $("#frmPermitAlert").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitAlert[alert_type_id]": {
                required: true,
            },
            "PermitAlert[staff_id][]": {
                required: false,
            },
            "PermitAlert[company_id][]": {
                required: true,
            },
            "PermitAlert[operation_id][]": {
                required: true,
            },
            "PermitAlert[title]": {
                required: true,
                maxlength: 120,
            },
            "PermitAlert[date]": {
                required: true,
            },
            "PermitAlert[time]": {
                required: true,
            },
            "PermitAlert[notes]": {
                required: true,
            },
            "PermitAlert[is_repeated]": {
                required: false,
            },
            "PermitAlert[interval]": {
                required: true,
            },
            "PermitAlert[interval_type]": {
                required: true,
            },

        },
        messages: {
            "PermitAlert[alert_type_id]": {
                required: 'Please select alert type',
            },
            "PermitAlert[staff_id][]": {
                required: 'Please select staff',
            },
            "PermitAlert[company_id][]": {
                required: 'Please select copmany',
            },
            "PermitAlert[operation_id][]": {
                required: 'Please select operation',
            },
            "PermitAlert[title]": {
                required: 'Please enter title',
            },
            "PermitAlert[date]": {
                required: 'Please select date',
            },
            "PermitAlert[time]": {
                required: 'Please select time',
            },
            "PermitAlert[notes]": {
                required: 'Please enter notes',
            },
            "PermitAlert[is_repeated]": {
                required: 'Please select repeat',
            },
            "PermitAlert[interval]": {
                required: 'Please enter interval',
            },
            "PermitAlert[interval_type]": {
                required: 'Please select interval type',
            },
        }
    });
    /* Permit-Alert - END */

    /**
     * Block - 4
     * Permit Form Block 
     */

    /* Permit-Form - START */
    $(document).on("click", ".btnPermitFormModal", function () {
        if (checkSecurity($(this).data('security-type-id'))) {
            openPermitFormModal($(this));
        }
    });

    $(document).on("change", "#frmPermitForm.igb-file-txt", function () {
        alert();
    });


    function openPermitFormModal(element) {
        $('#permitFormModal .modelTitle').html($(element).data('modal-title'));
        $('.inp-permit-form-id').val($(element).data('permit-form-id'));
        $('#permitFormModal').modal('toggle');
        $('#permitform-security-type-id').val($(element).data('security-type-id'));
    }

    // Save Permit-Form Data
    $(".frmPermitForm").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitForm').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            var userPermitId = $(".inp-user-permit-id").attr('data-id');
            $.ajax({
                url: "/permits/saveRelatedForm/" + permitId + "/" + userPermitId,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Form', responce.msg);
                        $('#permitFormModal').modal('toggle');
                        getRelatedForm(permitId, userPermitId);
                    } else {
                        pNotifyError('Form', responce.msg);
                    }
                }
            });
        }
    });



    /* check Permit-Form validation */
    $("#frmPermitForm").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitForm[security_type_id]": {
                required: true,
            },
            "PermitForm[file_text]": {
                required: true,
                extension: "pdf",
            }
        },
        messages: {
            "PermitForm[security_type_id]": {
                required: 'Please select security option',
            },
            "PermitForm[file_text]": {
                required: 'Please upload filled form',
                extension: "Only pdf file allowed",
            }
        }
    });

    function getRelatedForm(permitId, userPermitId) {
        $.ajax({
            url: "/permits/getRelatedForm/" + permitId + "/" + userPermitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-form-block').html(responce);
            }
        });
    }

    $(document).on('blur, change', '.inp-permit-form-file', function (e) {
        var fileName = $('.inp-permit-form-file').val().split('\\').pop();
        $('.inp-permit-form-file-text').val(fileName);
    });

    /* Permit-Form - END */


    /**
     * Block - 5
     * Permit Documents Block 
     */

    /* Permit-Documents - START */
    $(document).on("click", ".btnPermitDocumentModal", function () {
        if (checkSecurity($(this).data('security-type-id'))) {
            openPermitDocumentModal($(this));
        }
    });


    function openPermitDocumentModal(element) {
        $('#permitDocumentModal .modelTitle').html($(element).data('modal-title'));
        $('.inp-permit-document-id').val($(element).data('permit-document-id'));
        $('.inp-document-id').val($(element).data('document-id'));
        $('#permitDocumentModal').modal('toggle');
        $('#permitdocument-security-type-id').val($(element).data('security-type-id'));
    }

    // Save Permit-Document Data
    $(".frmPermitDocument").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitDocument').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            var userPermitId = $(".inp-user-permit-id").attr('data-id');
            $.ajax({
                url: "/permits/saveRelatedDocument/" + permitId + "/" + userPermitId,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Document', responce.msg);
                        $('#permitDocumentModal').modal('toggle');
                        getRelatedDocument(permitId, userPermitId);
                    } else {
                        pNotifyError('Document', responce.msg);
                    }
                }
            });
        }
    });

    /* check Permit-Document validation */
    $("#frmPermitDocument").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitDocument[file_text]": {
                required: true,
                extension: "pdf|doc|docx",
            },
            "PermitDocument[security_type_id]": {
                required: true,
            },

        },
        messages: {
            "PermitDocument[file_text]": {
                required: 'Please upload document',
            },
            "PermitDocument[security_type_id]": {
                required: 'Please select security option',
            },
        }
    });

    function getRelatedDocument(permitId, userPermitId) {
        $.ajax({
            url: "/permits/getRelatedDocument/" + permitId + "/" + userPermitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-document-block').html(responce);
            }
        });
    }

    $(document).on('blur, change', '.inp-permit-document-file', function (e) {
        var fileName = $('.inp-permit-document-file').val().split('\\').pop();
        $('.inp-permit-document-file-text').val(fileName);
    });



    /* Permit-Documents - END */

    /**
     * Block - 6
     * Permit Instruction Block 
     */

    /* Permit-Instruction - START */
    $(document).on("click", ".btnPermitInstructionModal", function () {
        openPermitInstructionModal($(this));
    });


    function openPermitInstructionModal(element) {
        $('#permitInstructionModal .modelTitle').html($(element).data('title'));
        var permitInstructionId = $(element).data('permit-instruction-id');
        $('#inpPermitInstructionId').val(permitInstructionId);
        $('#inpPermitInstructionName').val($(element).data('instruction-name'));
        if (permitInstructionId > 0) {
            $('#inpPermitInstructionFile').removeClass('required');
        } else {
            $('#inpPermitInstructionFile').addClass('required');
        }
        $('#permitInstructionModal').modal('toggle');
    }

    /* Permit-Instruction - END */

    /*--------For download after click "download" start from here============*/

//    $(document).on('click', '.btnDownloadForm', function () {
//        var permit_id = $('.inp-permit-name').attr('data-id');
//        var userPermitId = $(".inp-user-permit-id").attr('data-id');
//
//        var file_name = $(this).data('file-name');
//        var tableName = $(this).data('attachment-table');
//        window.open('/permits/downloadFullForm?permit_id=' + permit_id + '&userPermitId=' + userPermitId + '&file_name=' + file_name + '&table_name=' + tableName);
//    })
    /*=========For Download after click "download" end here===================*/


    /**
     * Block - 7
     * Permit Alert Block 
     */

    /* Permit-Deadline - START */
    $('.inp-deadline-multi').multiselect({
        numberDisplayed: 1
    });

    $(document).on("click", ".btnPermitDeadlineModal", function () {
        openPermitDeadlineModal($(this));
    });


    function openPermitDeadlineModal(element) {
        $('#permitDeadlineModal .modelTitle').html($(element).data('modal-title'));
        resetDeadlineFields();
        $('.inp-deadline-id').val($(element).data('deadline-id'));
        $('.inp-is-renewable').val($(element).data('renewable-value'));
        $('.inp-deadline-type').val($(element).data('deadline-type')).trigger('change');
        $('.inp-deadline-document').attr('data-deadline-document-id', $(element).data('deadline-document-id'));
        $('.inp-deadline-permit-form').attr('data-deadline-permit-form-id', $(element).data('deadline-permit-form-id'));
        $('.inp-deadline-date').val($(element).data('deadline-date'));
        $('.inp-deadline-time').val($(element).data('deadline-time'));
        toggleDeadlineType($(element).data('deadline-permit-id'));
        $('#permitDeadlineModal').modal('toggle');
    }

    // Save Permit-Alert Data
    $(".subPermitDeadline").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitDeadline').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            var operationId = $('.inp-operation-name').attr('data-id');
            var locationId = $('.inp-location-name').attr('data-id');
            var userPermitId = $('.inp-user-permit-id').attr('data-id');
            $.ajax({
                url: "/permits/saveRelatedDeadline/" + permitId + "/" + userPermitId,
                type: "POST",
                data: $('#frmPermitDeadline').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Deadline', responce.msg);
                        $('#permitDeadlineModal').modal('toggle');
                        getRelatedDeadline(permitId, userPermitId, operationId, locationId);
                        $('.removeDeadlineBtn').remove();
                    } else {
                        pNotifyError('Deadline', responce.msg);
                    }
                }
            });
        }
    });

    function getRelatedDeadline(permitId, userPermitId, operationId, locationId) {
        $.ajax({
            url: "/permits/getRelatedDeadline/" + permitId + "/" + userPermitId + "/" + operationId + "/" + locationId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-deadline-block').html(responce);
            }
        });
    }
    $(document).on("click", ".btnEditDeadline", function () {
        openPermitDeadlineModal($(this));
    });

    /* check Permit-Alert validation */
    $("#frmPermitDeadline").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Deadlines[date]": {
                required: true,
            },
            "Deadlines[time]": {
                required: true,
            }
        },
        messages: {
            "Deadlines[date]": {
                required: 'Please select date',
            },
            "Deadlines[time]": {
                required: 'Please select time',
            }
        }
    });
    /* Permit-Deadline - END */

});



    