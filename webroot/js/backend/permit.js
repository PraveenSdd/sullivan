/*  validation for agency 
 * By @Praveen Soni
 * Date : 26 Jan. 2018
 */

/**
 * 
 * HINT
 * Block 1 - Permit
 * Block 2 - Permit-Agency
 * Block 3 - Permit-Operation
 * Block 4 - Permit-Form
 * Block 5 - Permit-Instruction
 * Block 6 - Permit-Document
 * Block 7 - Permit-Deadline
 * Block 8 - Permit-Alert 
 * 
 */

$(document).ready(function () {

    /**
     * Block - 1
     * Permit Block 
     */

    /* Validate Permit Form  - Start */
    $("#frmPermit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Permit[name]": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/admin/permits/checkPermitUniqueName/",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display', 'none');
                    },
                    data: {
                        name: function () {
                            return $("#permit-name").val();
                        },
                        id: function () {
                            return $("#permit-name").data('id');
                        },
                    },
                },
            },
            "Permit[description]": {
                required: true,
                maxlength: 160,
            },
        },
        messages: {
            "Permit[name]": {
                required: "Please enter permit name",
                maxlength: "Maximum characters are 120.",
                remote: "Permit is already exist."
            },
            "Permit[description]": {
                required: "Please enter description",
                maxlength: "Maximum characters are 160."
            },
        },
    });
    /* Validate Agency Form  - END */

    /* Save Agency  - START */
    function savePermitData() {
        var responseFlag = false;
        $.ajax({
            url: "/admin/permits/savePermitData",
            type: "POST",
            data: $('#frmPermit').serialize(),
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function (responce)
            {
                responseFlag = responce.flag;
                if (responce.flag) {
                    pNotifySuccess('Permit', responce.msg);
                    $('.inp-permit-name').attr('data-id', responce.permit_id);
                    $('.inp-permit-id').val(responce.permit_id);
                } else {
                    pNotifyError('Permit', responce.msg);
                }
            }
        });
        return responseFlag;
    }
    /* Save Permit  - END */


    /**
     * Block - 2
     * Permit Agency Block 
     */

    /* Permit-Agency - START */
    $(document).on("click", ".btnPermitAgencyModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitAgencyModal($(this));
                }
            }
        } else {
            openPermitAgencyModal($(this));
        }
    });


    function openPermitAgencyModal(element) {
        $('#permitAgencyModal .modelTitle').html($(element).data('title'));
        $('#selPermitAgency').val('');
        $('#selPermitAgencyContact').val('');
        $('#inpPermitAgencyId').val('');

        var agencyId = $(element).data('agency-id');
        if ($('.tr-related-permit-agency').length > 0 && agencyId <= 0) {
            element = $('.tr-related-permit-agency .btnPermitAgencyModal');
            agencyId = $(element).data('agency-id');
        }
        $('#inpPermitAgencyId').val($(element).data('permit-agency-id'));
        if (agencyId > 0) {
            $('#selPermitAgency').val(agencyId).trigger('change');
        }
        $('#permitAgencyModal').modal('toggle');
    }

    $(document).on('change', '.sel-permit-agency', function () {
        $('#selPermitAgencyContact').val([]).trigger('change');
        getContactListByAgencyId($(this).val(), '');
    });

    function getContactListByAgencyId(agencyId) {
        $.ajax({
            url: "/admin/agencies/getContactListByAgencyId/" + agencyId,
            type: "Post",
            dataType: 'html',
            async: false,
            data: {agencyId, agencyId},
            success: function (response) {
                if (response) {
                    $('#selPermitAgencyContact').html(response);
                    // Reset agency-contact-person 
                    // Check Agency is exist or not
                    if ($('.tr-related-permit-agency').length > 0) {
                        var savedAgencyId = $('.tr-related-permit-agency .btnPermitAgencyModal').data('agency-id');
                        // Check exist agency-id and change/selected agency-id is equal or not
                        if (savedAgencyId == agencyId) {
                            // if exist agency-id and change/selected agency-id is equal then select agency-contact-person
                            var agencyContactId = $('.tr-related-permit-agency .btnPermitAgencyModal').data('agency-contact-id');
                            agencyContactId = String(agencyContactId);
                            if (agencyContactId.indexOf(',') >= 0) {
                                $('#selPermitAgencyContact').val(agencyContactId.split(',')).trigger('change');
                            } else {
                                $('#selPermitAgencyContact').val([agencyContactId]).trigger('change');
                            }
                        } else {
                            // if exist agency-id and change/selected agency-id is not equal then reset agency-contact-person
                            $('#selPermitAgencyContact').val([]).trigger('change');
                        }
                    }
                }
            }
        });
    }


    // Save Agency-Permit Data
    $(".subPermitAgency").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitAgency').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedAgency",
                type: "POST",
                data: {permit_id: permitId, agency_id: $('#selPermitAgency').val(), contact_person: $('#selPermitAgencyContact').val(), permit_agency_id: $('#inpPermitAgencyId').val()},
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Agency', responce.msg);
                        $('#permitAgencyModal').modal('toggle');
                        getRelatedAgency(permitId);
                    } else {
                        pNotifyError('Agency', responce.msg);
                    }
                }
            });
        }
    });

    /* check Agency-Permit-Form validation */
    $("#frmPermitAgency").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitAgency[agency_id]": {
                required: true,
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 3,
            },

        },
        messages: {
            "PermitAgency[agency_id]": {
                required: 'Please select agency',
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 'Max limit is 3',
            },
        }
    });


    function getRelatedAgency(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedAgency/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-agency-block').html(responce);
            }
        });
    }

    /* View Agency-Contact Detail - Start */
    $(document).on('click', '.btnViewContactPersonModal', function () {
        var agencyContactId = $(this).data('agency-contact-id');
        if (agencyContactId) {
            $.ajax({
                url: "/admin/agencies/getAgencyContactInfoById/" + agencyContactId,
                type: "Post",
                dataType: 'html',
                success: function (response) {
                    if (response) {
                        $('.agency-contact-person-details-block').html(response);
                        $('#viewContactPersonModal').modal('toggle');

                    }
                }
            });
        } else {
            $(".contactPerson").html();
        }
    });
    /* View Agency-Contact Detail - END */

    /* Permit-Agency - END */

    /**
     * Block - 3
     * Permit Operation Block 
     */

    /* Permit-Operation - START */
    $(document).on("click", ".btnPermitOperationModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitOperationModal($(this));
                }
            }
        } else {
            openPermitOperationModal($(this));
        }
    });


    function openPermitOperationModal(element) {
        $('#permitOperationModal .modelTitle').html($(element).data('title'));
        $('#selPermitOperation').val('');
        $('#inpPermitOperationId').val($(element).data('permit-operation-id'));
        var operationId = $(element).data('operation-id');
        var permitId = $('.inp-permit-name').attr('data-id');
        $.ajax({
            url: "/admin/permits/getUnAssignedOperationList/" + permitId,
            type: "Post",
            dataType: 'html',
            async: false,
            data: {assinedOperationId: operationId},
            success: function (response) {
                if (response) {
                    $('#selPermitOperation').html(response);
                    if (operationId > 0) {
                        $('#selPermitOperation').val([operationId]).trigger('change');
                    }
                }
            }
        });
        $('#permitOperationModal').modal('toggle');
    }


    // Save Operation-Permit Data
    $(".subPermitOperation").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitOperation').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedOperation",
                type: "POST",
                data: {permit_id: permitId, operation_id: $('#selPermitOperation').val(), permit_operation_id: $('#inpPermitOperationId').val()},
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Operation', responce.msg);
                        $('#permitOperationModal').modal('toggle');
                        getRelatedOperation(permitId);
                    } else {
                        pNotifyError('Operation', responce.msg);
                    }
                }
            });
        }
    });

    /* check Operation-Permit-Form validation */
    $("#frmPermitOperation").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitOperation[operation_id][]": {
                required: true,
            },
        },
        messages: {
            "PermitOperation[operation_id][]": {
                required: 'Please select operation',
            },
        }
    });


    function getRelatedOperation(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedOperation/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-operation-block').html(responce);
            }
        });
    }
    /* Permit-Operation - END */


    /**
     * Block - 4
     * Permit Form Block 
     */

    /* Permit-Form - START */
    $(document).on("click", ".btnPermitFormModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitFormModal($(this));
                }
            }
        } else {
            openPermitFormModal($(this));
        }
    });


    function openPermitFormModal(element) {
        $('#permitFormModal .modelTitle').html($(element).data('title'));
        $('.inp-permit-form-block').html('');
        $('.inp-permit-form-block').last().append($('.inp-permit-form-block-html').html());
        resetPermitFormField();
        var permitFormId = $(element).data('permit-form-id');
        $('.inp-permit-form-block .inp-permit-form-id').val(permitFormId);
        $('.inp-permit-form-block .inp-permit-form-name').val($(element).data('permit-form-name'));
        if (permitFormId > 0) {
            $('.inp-permit-form-block .inp-permit-form-file').removeClass('required');
        }
        $('#permitFormModal').modal('toggle');
    }

    // Save Permit-Form Data
    $(".frmPermitForm").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitForm').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedForm/" + permitId,
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
                        getRelatedForm(permitId);
                    } else {
                        pNotifyError('Form', responce.msg);
                    }
                }
            });
        }
    });

    /* check Agency-Permit-Form validation */
    $("#frmPermitForm").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitAgency[agency_id]": {
                required: true,
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 3,
            },

        },
        messages: {
            "PermitAgency[agency_id]": {
                required: 'Please select agency',
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 'Max limit is 3',
            },
        }
    });


    function getRelatedForm(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedForm/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-form-block').html(responce);
            }
        });
    }

    // Add & Remove Permit Form input-fields -  END    
    $(document).on('click', '.permit-form-add', function () {
        $('.inp-permit-form-block').last().append($('.inp-permit-form-block-html').html());
        resetPermitFormField();
    });

    $(document).on('click', '.permit-form-remove', function () {
        if ($('.inp-permit-form-block .inp-permit-form-field').length > 1) {
            $(this).parents('.inp-permit-form-field').remove();
        }
        resetPermitFormField();
    });

    function resetPermitFormField() {
        var inpFieldCount = 1;
        $('.inp-permit-form-block .inp-permit-form-field').each(function () {
            $(this).find('.inp-field-count').html(inpFieldCount);
            $(this).find('.inp-permit-form-id').attr('name', 'PermitForm[' + inpFieldCount + '][id]');
            $(this).find('.inp-permit-form-id').attr('id', 'PermitForm' + inpFieldCount + 'Id');
            $(this).find('.inp-permit-form-name').attr('name', 'PermitForm[' + inpFieldCount + '][name]');
            $(this).find('.inp-permit-form-name').attr('id', 'PermitForm' + inpFieldCount + 'Name');
            $(this).find('.inp-permit-form-file').attr('name', 'PermitForm[' + inpFieldCount + '][file]');
            $(this).find('.inp-permit-form-file').attr('id', 'PermitForm' + inpFieldCount + 'File');
            $(this).find('.inp-permit-form-sample').attr('name', 'PermitForm[' + inpFieldCount + '][sample][]');
            $(this).find('.inp-permit-form-sample').attr('id', 'PermitForm' + inpFieldCount + 'Sample');
            inpFieldCount++;

            $(this).find('.inp-permit-form-name').rules("remove");
            $(this).find('.inp-permit-form-name').rules("add", {
                required: true,
                alphanumspace: true
            });
            $(this).find('.inp-permit-form-file').rules("remove");
            $(this).find('.inp-permit-form-file').rules("add", {
                extension: "pdf",
                required: true
            });

            $(this).find('.inp-permit-form-sample').rules("remove");
            $(this).find('.inp-permit-form-sample').rules("add", {
                extension: "pdf|doc|docx",

            });
        });

        if ($('.inp-permit-form-block .inp-permit-form-field').length > 1) {
            $('.permit-form-remove').removeClass('hide');
        } else {
            $('.permit-form-remove').addClass('hide');
        }
    }
    // Add & Remove Permit Form input-fields -  END




    /* Permit-Form - END */

    /**
     * Block - 5
     * Permit Instruction Block 
     */

    /* Permit-Instruction - START */
    $(document).on("click", ".btnPermitInstructionModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitInstructionModal($(this));
                }
            }
        } else {
            openPermitInstructionModal($(this));
        }
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

    // Save Permit-Instruction Data
    $(".frmPermitInstruction").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitInstruction').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedInstruction/" + permitId,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Instruction', responce.msg);
                        $('#permitInstructionModal').modal('toggle');
                        getRelatedInstruction(permitId);
                    } else {
                        pNotifyError('Instruction', responce.msg);
                    }
                }
            });
        }
    });

    /* check Agency-Permit-Instruction validation */
    $("#frmPermitInstruction").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitInstruction[name]": {
                required: true,
            },
            "PermitInstruction[file]": {
                required: true,
                extension: "pdf|docx|doc",
            },

        },
        messages: {
            "PermitInstruction[name]": {
                required: 'Please enter name',
            },
            "PermitInstruction[file]": {
                maxlength: 'Please upload file',
            },
        }
    });


    function getRelatedInstruction(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedInstruction/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-instruction-block').html(responce);
            }
        });
    }
    /* Permit-Instruction - END */

    /**
     * Block - 6
     * Permit Documents Block 
     */

    /* Permit-Documents - START */
    $(document).on("click", ".btnPermitDocumentModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitDocumentModal($(this));
                }
            }

        } else {
            openPermitDocumentModal($(this));
        }
    });


    function openPermitDocumentModal(element) {
        $('#permitDocumentModal .modelTitle').html($(element).data('title'));
        getUnAssignedDocumentList();
        $('#permitDocumentModal').modal('toggle');
    }

    function getUnAssignedDocumentList() {
        var permitId = $('.inp-permit-name').attr('data-id');
        $.ajax({
            url: "/admin/permits/getUnAssignedDocumentList/" + permitId,
            type: "Post",
            dataType: 'html',
            async: false,
            success: function (response) {
                if (response) {
                    $('#selPermitDocument').html(response);
                }
            }
        });
    }

    // Save Permit-Document Data
    $(".subPermitDocument").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitDocument').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedDocument/" + permitId,
                type: "POST",
                data: $('#frmPermitDocument').serialize(),
                dataType: 'Json',
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Document', responce.msg);
                        $('#permitDocumentModal').modal('toggle');
                        getRelatedDocument(permitId);
                    } else {
                        pNotifyError('Document', responce.msg);
                    }
                }
            });
        }
    });

    /* check Agency-Permit-Document validation */
    $("#frmPermitDocument").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitDocument[document_id][]": {
                required: true,
            },

        },
        messages: {
            "PermitDocument[document_id][]": {
                required: 'Please select document',
            },
        }
    });


    function getRelatedDocument(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedDocument/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-document-block').html(responce);
            }
        });
    }

    // Open New-Document Modal
    $(document).on("click", ".btnPermitDocumentAddModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitDocumentAddModal($(this));
                }
            }

        } else {
            openPermitDocumentAddModal($(this));
        }
    });

    function openPermitDocumentAddModal(element) {
        $('#permitDocumentAddModal .modelTitle').html('Add New Document');
        $('.inp-permit-document-block').html($('.inp-permit-document-block-html').html());
        resetPermitDocumentField();
        $('#permitDocumentAddModal').modal('toggle');
    }

    // Save New-Document Data
    $(".subPermitDocumentAdd").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitDocumentAdd').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveDocument/",
                type: "POST",
                data: $('#frmPermitDocumentAdd').serialize(),
                dataType: 'Json',
                success: function (responce)
                {
                    if (responce.flag) {

                        pNotifySuccess('Document', responce.msg);
                        getUnAssignedDocumentList();
                        $('#permitDocumentAddModal').modal('toggle');
                    } else {
                        pNotifyError('Document', responce.msg);
                    }
                }
            });
        }
    });


    /* check New-Document validation */
    $("#frmPermitDocumentAdd").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Document[name][]": {
                required: true,
            },
        },
        messages: {
            "Document[name][]": {
                required: 'Please enter document name',
            },
        }
    });

    // Add & Remove Permit Document input-fields -  END    
    $(document).on('click', '.permit-document-add', function () {
        $('.inp-permit-document-block').last().append($('.inp-permit-document-block-html').html());
        resetPermitDocumentField();
    });

    $(document).on('click', '.permit-document-remove', function () {
        if ($('.inp-permit-document-block .inp-permit-document-field').length > 1) {
            $(this).parents('.inp-permit-document-field').remove();
        }
        resetPermitDocumentField();
    });

    function resetPermitDocumentField() {
        var inpFieldCount = 1;
        $('.inp-permit-document-block .inp-permit-document-field').each(function () {
            $(this).find('.inp-field-count').html(inpFieldCount);
            $(this).find('.inp-document-name').attr('id', 'DocumentName' + inpFieldCount);
            inpFieldCount++;
        });

        if ($('.inp-permit-document-block .inp-permit-document-field').length <= 1) {
            $('.inp-permit-document-block .permit-document-remove').addClass('hide');
        } else {
            $('.permit-document-remove').removeClass('hide');
        }
    }
    // Add & Remove Permit Document input-fields -  END
    /* Permit-Documents - END */

    /**
     * Block - 7
     * Permit Deadline Block 
     */

    /* Permit-Deadline - START */
    $(document).on("click", ".btnPermitDeadlineModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitDeadlineModal($(this));
                }
            }
        } else {
            openPermitDeadlineModal($(this));
        }
    });


    function openPermitDeadlineModal(element) {
        $('#permitDeadlineModal .modelTitle').html($(element).data('title'));
        $('.inp-deadline-id').val($(element).data('deadline-id'));
        $('.inp-deadline-date').val($(element).data('deadline-date'));
        console.log($(element).data('deadline-time'));
        $('.inp-deadline-time').val($(element).data('deadline-time'));
        $('#permitDeadlineModal').modal('toggle');
    }

    // Save Permit-Deadline Data
    $(".subPermitDeadline").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitDeadline').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedDeadline/" + permitId,
                type: "POST",
                data: $('#frmPermitDeadline').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Deadline', responce.msg);
                        $('.btnPermitDeadlineModal').data('title', 'Edit Deadline');
                        $('.btnPermitDeadlineModal').attr('title', 'Edit Deadline');
                        $('.btnPermitDeadlineModal').data('deadline-date', $("#inpPermitDeadlineDate").val());
                        $('.btnPermitDeadlineModal').data('deadline-time', $("#inpPermitDeadlineTime").val());
                        $('.btnPermitDeadlineModal').data('deadline-id', responce.id);
                        $('.btnPermitDeadlineModal').html('Edit Deadline');
                        $('#permitDeadlineModal').modal('toggle');
                        getRelatedDeadline(permitId);
                    } else {
                        pNotifyError('Deadline', responce.msg);
                    }
                }
            });
        }
    });

    /* check Permit-Deadline validation */
    $("#frmPermitDeadline").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitDeadline[date]": {
                required: true,
            },
            "PermitDeadline[time]": {
                required: true,
            },

        },
        messages: {
            "PermitDeadline[date]": {
                required: 'Please select date',
            },
            "PermitDeadline[time]": {
                required: 'Please select time',
            },
        }
    });


    function getRelatedDeadline(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedDeadline/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-deadline-block').html(responce);
            }
        });
    }
    /* Permit-Deadline - END */


    /**
     * Block - 8
     * Permit Alert Block 
     */

    /* Permit-Alert - START */
    $(document).on("click", ".btnPermitAlertModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0) {
            if ($('#frmPermit').valid()) {
                if (savePermitData()) {
                    openPermitAlertModal($(this));
                }
            }
        } else {
            openPermitAlertModal($(this));
        }
    });


    function openPermitAlertModal(element) {
        $('#permitAlertModal .modelTitle').html($(element).data('title'));
        resetAlertFields();
        $('.inp-alert-id').val($(element).data('alert-id'));
        $('.inp-alert-type').val($(element).data('alert-type')).trigger('change');
        $('.inp-alert-staff').attr('data-alert-staff-id', $(element).data('alert-staff-id'));
        $('.inp-alert-company').attr('data-alert-company-id', $(element).data('alert-company-id'));
        $('.inp-alert-operation').attr('data-alert-operation-id', $(element).data('alert-operation-id'));
        $('.inp-alert-title').val($(element).data('alert-title'));
        $('.inp-alert-date').val($(element).data('alert-date'));

        $('.inp-alert-time').val($(element).data('alert-time'));
        $('.inp-alert-notes').val($(element).data('alert-notes'));
        var alertRepeat = $(element).data('alert-repeat');
        if (alertRepeat) {
            $('.inp-alert-repeat').prop('checked', true);
            $('.inp-alert-interval').val($(element).data('alert-interval')).attr('disabled', false);
            $('.inp-alert-interval-type').val($(element).data('alert-interval-type')).attr('disabled', false);
            $('.inp-alert-end-date').val($(element).data('alert-end-date')).attr('disabled', false);
        } else {
            $('.inp-alert-repeat').prop('checked', false);
            $('.inp-alert-interval').val('').attr('disabled', true);
            $('.inp-alert-interval-type').val('').attr('disabled', true);
            $('.inp-alert-end-date').val('').attr('disabled', true);
        }


        toggleAlertType($(element).data('alert-permit-id'));

        $('#permitAlertModal').modal('toggle');
    }

    // Save Permit-Alert Data
    $(".subPermitAlert").on('click', function (e) {
        e.preventDefault();
        if ($('#frmPermitAlert').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            $.ajax({
                url: "/admin/permits/saveRelatedAlert/" + permitId,
                type: "POST",
                data: $('#frmPermitAlert').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Alert', responce.msg);
                        $('#permitAlertModal').modal('toggle');
                        getRelatedAlert(permitId);
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
            "PermitAlert[interval_value]": {
                required: true,
            },
            "PermitAlert[interval_type]": {
                required: true,
            },
            "PermitAlert[alert_end_date]": {
                required: true,
            }

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
            "PermitAlert[interval_value]": {
                required: 'Please enter interval',
            },
            "PermitAlert[interval_type]": {
                required: 'Please select interval type',
            },
            "PermitAlert[alert_end_date]": {
                required: 'Please select end date.',
            }
        }
    });


    function getRelatedAlert(permitId) {
        $.ajax({
            url: "/admin/permits/getRelatedAlert/" + permitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.permit-alert-block').html(responce);
            }
        });
    }
    /* Permit-Alert - END */





});



    