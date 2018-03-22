/*  validation for agency 
 * By @Praveen Soni
 * Date : 05 Feb. 2018
 */

$(document).ready(function () {
    $("#frmPreviousPermitDocument").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
    });

    function openPreviousPermitModal(element) {
        $('#previousPermitDocumentModal .modelTitle').html($(element).data('modal-title'));
        $('.inp-previous-permit-document-block').html('');
        $('.inp-previous-permit-document-block').last().append($('.inp-previous-permit-document-block-html').html());
        resetPreviousPermitDocumentField();
        var previousPermitId = $(element).data('previous-permit-id');
        $('.inp-previous-permit-document-block .inp-previous-permit-document-id').val(previousPermitId);
        $('.inp-previous-permit-document-block .inp-previous-permit-document-name').val($(element).data('previous-permit-name'));
        $('.inp-previous-permit-document-block .inp-previous-permit-document-expiry-date').val($(element).data('expiry-date'));
        $('.inp-previous-permit-document-block .inp-previous-permit-document-security-type').val($(element).data('security-type-id'));
        if (previousPermitId > 0) {
            $('.inp-previous-permit-document-block .inp-previous-permit-document-file').removeClass('required');
            $(".inp-previous-permit-document-block .previous-permit-document-add").addClass('hide');
        }
        $('#previousPermitDocumentModal').modal('toggle');
    }

    $(document).on("click", ".btnPreviousPermitDocumentModal", function () {
        var permitId = $('.inp-permit-name').attr('data-id');
        if (permitId <= 0 || typeof permitId == 'undefined') {
            if ($('#frmPreviousPermitAdd').valid()) {
                $('#frmPreviousPermitAdd').submit();
            }
        } else {
            openPreviousPermitModal($(this));
        }
    });

    $(document).on('click', '.previous-permit-document-add', function () {
        $('.inp-previous-permit-document-block').last().append($('.inp-previous-permit-document-block-html').html());
        resetPreviousPermitDocumentField();
    });

    $(document).on('click', '.previous-permit-document-remove', function () {
        if ($('.inp-previous-permit-document-block .inp-previous-permit-document-field').length > 1) {
            $(this).parents('.inp-previous-permit-document-field').remove();
        }
        resetPreviousPermitDocumentField();
    });
    function resetPreviousPermitDocumentField() {
        var inpFieldCount = 1;
        $('.inp-previous-permit-document-block .inp-previous-permit-document-field').each(function () {
            $(this).find('.inp-field-count').html(inpFieldCount);
            $(this).find('.inp-previous-permit-document-id').attr('name', 'UserPreviousPermitDocument[' + inpFieldCount + '][id]');
            $(this).find('.inp-previous-permit-document-id').attr('id', 'UserPreviousPermitDocument' + inpFieldCount + 'Id');
            $(this).find('.inp-previous-permit-document-name').attr('name', 'UserPreviousPermitDocument[' + inpFieldCount + '][name]');
            $(this).find('.inp-previous-permit-document-name').attr('id', 'UserPreviousPermitDocument' + inpFieldCount + 'Name');
            $(this).find('.inp-previous-permit-document-file').attr('name', 'UserPreviousPermitDocument[' + inpFieldCount + '][file]');
            $(this).find('.inp-previous-permit-document-file').attr('id', 'UserPreviousPermitDocument' + inpFieldCount + 'File');
            $(this).find('.inp-previous-permit-document-security-type').attr('id', 'UserPreviousPermitDocument' + inpFieldCount + 'security_type_id');
            $(this).find('.inp-previous-permit-document-security-type').attr('name', 'UserPreviousPermitDocument[' + inpFieldCount + '][security_type_id]');
            inpFieldCount++;

            $(this).find('.inp-previous-permit-document-name').rules("remove");
            $(this).find('.inp-previous-permit-document-name').rules("add", {
                required: true,
                alphanumspace: true
            });
            $(this).find('.inp-previous-permit-document-file').rules("remove");
            $(this).find('.inp-previous-permit-document-file').rules("add", {
                extension: "pdf|jpeg|jpg",
            });
            $(this).find('.inp-previous-permit-document-expiry-date').datetimepicker({
                format: 'MM-DD-YYYY',
                minDate: new Date()
            });
            $(this).find('.inp-previous-permit-document-security-type').rules("remove");
            $(this).find('.inp-previous-permit-document-security-type').rules("add", {
                required: true,
            });
        });

        if ($('.inp-previous-permit-document-block .inp-previous-permit-document-field').length > 1) {
            $('.previous-permit-document-remove').removeClass('hide');
        } else {
            $('.previous-permit-document-remove').addClass('hide');
        }
    }

    // Save Permit-Form Data
    $(".frmPreviousPermitDocument").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPreviousPermitDocument').valid()) {
            var permitId = $('.inp-permit-name').attr('data-id');
            var operationId = $('.inp-operation-name').attr('data-id');
            var locationId = $('.inp-location-name').attr('data-id');
            var userPermitId = $('.inp-user-permit-id').attr('data-id');
            $.ajax({
                url: "/previousPermits/savePreviousPermitDocument/" + permitId + "/" + operationId + "/" + locationId + "/" + userPermitId,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Previous Permit', responce.msg);
                        $('#previousPermitDocumentModal').modal('toggle');
                        getUserPreviousPermitList(permitId, operationId, locationId, userPermitId);
                    } else {
                        pNotifyError('Previous Permit', responce.msg);
                    }
                }
            });
        }
    });
    function getUserPreviousPermitList(permitId, operationId, locationId, userPermitId) {
        $.ajax({
            url: "/previousPermits/getUserPreviousPermitList/" + permitId + "/" + operationId + "/" + locationId + "/" + userPermitId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.previous-permit-list-block').html(responce);
            }
        });
    }

    /*Add previous permit start*/
    $("#frmPreviousPermitAdd").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/previousPermits/checkPermitUniqueName",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display', 'none');
                    },
                    data: {
                        name: function () {
                            return $(".inp-previous-permit-name").val();
                        },
                        id: function () {
                            return $(".inp-previous-permit-name").data('id');
                        },
                    },
                },
            },
            "description": {
                required: true,
                maxlength: 160,
            },
            "location_id": {
                required: true
            },
            "operation_id": {
                required: true
            }

        },
        messages: {
            "name": {
                required: "Please enter name.",
                maxlength: "Maximum characters are 120.",
                remote: "Permit name already exist."
            },
            "description": {
                required: "Please enter description.",
                maxlength: "Maximum characters are 160."
            },
            "location_id": {
                required: "Please select location."
            },
            "operation_id": {
                required: "Please select operation."
            }
        }
    });
    /*Add previous permit end*/
});



    