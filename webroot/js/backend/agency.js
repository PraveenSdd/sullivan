/*  validation for agency 
 * By @Praveen Soni
 * Date : 26 Jan. 2018
 */

$(document).ready(function () {

    /* Validate Agency Form  - Start */
    $("#frmAgency").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Agency[name]": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/admin/agencies/checkAgencyUniqueName/",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display', 'none');
                    },
                    data: {
                        name: function () {
                            return $("#agency-name").val();
                        },
                        id: function () {
                            return $("#agency-name").data('id');
                        },
                    },
                },
            },
            "Agency[description]": {
                required: true,
                maxlength: 160,
            },
            "Address[address1]": {
                required: true,
                maxlength: 80,
            },
            "Address[address2]": {
                required: false,
                maxlength: 80,
            },
            "Address[city]": {
                required: true,
                maxlength: 40,
            },
            "Address[state_id]": {
                required: true,
            },
            "Address[zipcode]": {
                required: true,
            },
        },
        messages: {
            "Agency[name]": {
                required: "Please enter agency name",
                maxlength: "Maximum characters are 150.",
                remote: "Agency is already exist."
            },
            "Agency[description]": {
                required: "Please enter agency description",
                maxlength: "Maximum characters are 160.",
            },
            "Address[address1]": {
                required: "Please enter address 1",
                maxlength: "Maximum characters are 80."
            },
            "Address[address2]": {
                required: "Please enter address 2",
                maxlength: "Maximum characters are 80."
            },
            "Address[city]": {
                required: "Please enter city",
            },
            "Address[state_id]": {
                required: "Please select state",
            },
            "Address[zipcode]": {
                required: "Please enter zip code",
            },
        },
    });
    /* Validate Agency Form  - END */

    /* Save Agency  - START */
    function saveAgencyData() {
        var responseFlag = false;
        $.ajax({
            url: "/admin/agencies/saveAgencyData",
            type: "POST",
            data: $('#frmAgency').serialize(),
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function (responce)
            {
                responseFlag = responce.flag;
                if (responce.flag) {
                    pNotifySuccess('Agency', responce.msg);
                    $('.inp-agency-name').attr('data-id', responce.agency_id);
                    $('.inp-agency-id').val(responce.agency_id);

                } else {
                    pNotifyError('Agency', responce.msg);

                }
            }
        });
        return responseFlag;
    }
    /* Save Agency  - END */

    /* Agency-Contact - START */
    $(document).on("click", ".btnAgencyContactPersonModal", function () {
        var agencyId = $('.inp-agency-name').attr('data-id');
        if (agencyId <= 0) {
            if ($('#frmAgency').valid()) {
                if(saveAgencyData()){
                    openAgencyContactModal($(this));
                }
            }
        } else {
            openAgencyContactModal($(this));
        }
    });


    function openAgencyContactModal(element) {
        $('#agencyContactPersonModal .modelTitle').html($(element).data('title'));
        $('#frmAgencyContactPerson').valid();
        $('.agencyContactName').val('');
        $('.agencyContactPosition').val('');
        $('.agencyContactEmail').val('');
        $('.agencyContactPhone').val('');
        $('.agencyContactPhoneExtension').val('');
        $('#inpAgencyContactId').val('');
        $('.agency-contact-additional-address-block').html('');
        var agencyContactId = $(element).data('agency-contact-id');
        if (agencyContactId > 0) {
            $('#inpAgencyContactId').val(agencyContactId);
            $('.agencyContactName').val($(element).data('agency-contact-name'));
            $('.agencyContactPosition').val($(element).data('agency-contact-position'));
            $('.agencyContactEmail').val($(element).data('agency-contact-email'));
            $('.agencyContactPhone').val($(element).data('agency-contact-phone'));
            $('.agencyContactPhoneExtension').val($(element).data('agency-contact-phone-extension'));

            var contactAddressFlag = $(element).data('agency-contact-address');
            if (contactAddressFlag > 0) {
                $.ajax({
                    url: "/admin/agencies/getContactAddressByContactId/" + agencyContactId,
                    type: "Post",
                    dataType: 'html',
                    async: false,
                    success: function (response) {
                        if (response) {
                            $('.agency-contact-additional-address-block').html(response);
                        }
                    }
                });
            }
        }
        $('#agencyContactPersonModal').modal('toggle');
        resetAgencyContactAddressFields();
    }


    // Save Agency-Contact Data
    $(".subAgencyContactPerson").on('click', function (e) {
        e.preventDefault();
        if ($('#frmAgencyContactPerson').valid()) {
            var agencyId = $('.inp-agency-name').attr('data-id');
            $.ajax({
                url: "/admin/agencies/saveAgencyContact/" + agencyId,
                type: "POST",
                data: $('#frmAgencyContactPerson').serialize(),
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Contact Person', responce.msg);
                        getReleateContact(agencyId);
                        $('#agencyContactPersonModal').modal('toggle');
                    } else {
                        pNotifyError('Contact Person', responce.msg);
                    }

                }
            });
        }
    });

    /* check Agency-Contact-Form validation */
    $("#frmAgencyContactPerson").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "AgencyContact[name]": {
                required: true,
                maxlength: 40,
            },
            "AgencyContact[position]": {
                required: true,
                maxlength: 40,
            },
            "AgencyContact[email]": {
                //required: true,
                require_from_group: [1, ".phone-group"],
                maxlength: 40,
                email: true,
            },
            "AgencyContact[phone]": {
                //required: true,
                require_from_group: [1, ".phone-group"],
                maxlength: 15,
            },
            "AgencyContact[phone_extension]": {
                required: false,
                maxlength: 5,
            },
            "Address[address1][]": {
                required: true,
                maxlength: 80,
            },
            "Address[city][]": {
                required: true,
                maxlength: 40,
            },
            "Address[state_id][]": {
                required: true,
            },
            "Address[zipcode][]": {
                required: true,
                maxlength: 10,
            },

        },
        messages: {
            "AgencyContact[name]": {
                required: "Please enter name",
                maxlength: "Maximum characters are 40."
            },
            "AgencyContact[position]": {
                required: "Please enter position",
                maxlength: "Maximum characters are 40"
            },
            "AgencyContact[email]": {
                require_from_group: "Please enter either email address or phone or both",
                maxlength: "Maximum characters are 40.",
                email: 'Please enter valid email addres.',
            },
            "AgencyContact[phone]": {
                require_from_group: "Please enter either email address or phone or both ",
                maxlength: "Maximum characters are 15"
            },
            "AgencyContact[phone_extension]": {
                required: "Please enter phone extension",
                maxlength: "Maximum characters are 5"
            },
            "Address[address1][]": {
                required: "Please enter address1",
                maxlength: "Maximum characters are 80"
            },
            "Address[city][]": {
                required: "Please enter city",
                maxlength: "Maximum characters are 40"
            },
            "Address[zipcode][]": {
                required: "Please enter zip code.",
                maxlength: "Maximum characters are 10"
            },
            "Address[state_id][]": {
                required: "Please select state.",
            },

        },
    });

    $(document).on('click', '.add-address', function () {
        $('.agency-contact-additional-address-block').append($('.additional-address-html').html());
        resetAgencyContactAddressFields();
    });

    $(document).on('click', '.agency-contact-additional-address-block .remove-address', function () {
        if ($('.additional-address-block .additional-address').length > 0) {
            $(this).parents('.additional-address').remove();
        }
        resetAgencyContactAddressFields();
    });

    function resetAgencyContactAddressFields() {
        $(".inp-phone").mask("999-999-9999");
        var addressSerial = 1;
        $('.agency-contact-additional-address-block .additional-address').each(function () {
            $(this).find('.address-count').html(addressSerial);
            $(this).find('.inp-add-id').attr('id', 'inp-add-id-' + addressSerial);
            $(this).find('.inp-add-address1').attr('id', 'inp-add-address1-' + addressSerial);
            $(this).find('.inp-add-address2').attr('id', 'inp-add-address2-' + addressSerial);
            $(this).find('.inp-add-city').attr('id', 'inp-add-city-' + addressSerial);
            $(this).find('.sel-add-state').attr('id', 'sel-add-state-' + addressSerial);
            $(this).find('.inp-add-zipcode').attr('id', 'inp-add-zipcode-' + addressSerial);
            addressSerial++;
        });
        if ($('.agency-contact-additional-address-block .remove-address').length > 0) {
            $('.additional-address-block .remove-address').removeClass('hide');
        } else {
            $('.agency-contact-additional-address-block .remove-address').addClass('hide');
        }
    }

    function getReleateContact(agencyId) {
        $.ajax({
            url: "/admin/agencies/getReleateContact/" + agencyId,
            type: "POST",
            dataType: 'html',
            cache: false,
            success: function (responce)
            {
                $('.agency-contact-person-block').html(responce);
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

    /* Agency-Contact - END */

    /* Agency-Permit - START */
    $(document).on("click", ".btnAgencyPermitModal", function () {
        var agencyId = $('.inp-agency-name').attr('data-id');
        if (agencyId <= 0) {
            if ($('#frmAgency').valid()) {
                if(saveAgencyData()){
                    openAgencyPermitModal($(this));
                }
            }
        } else {
            openAgencyPermitModal($(this));
        }
    });


    function openAgencyPermitModal(element) {
        $('#agencyPermitModal .modelTitle').html($(element).data('title'));
        $('#selAgencyPermit').val('');
        $('#selAgencyPermitContact').val('');
        $('#inpPermitAgencyId').val('');
        var agencyId = $('.inp-agency-name').attr('data-id');
        var permitId = $(element).data('permit-id');
        var agencyContactId = $(element).data('agency-contact-id');
        $('#inpPermitAgencyId').val($(element).data('permit-agency-id'));
        $.ajax({
            url: "/admin/permits/getUnAssignedPermitList/",
            type: "Post",
            dataType: 'html',
            async: false,
            data: {assinedPermitId: permitId},
            success: function (response) {
                if (response) {
                    $('#selAgencyPermit').html(response);
                    $('.sel-agency-permit').val([permitId]).trigger('change');
                }
            }
        });

        $.ajax({
            url: "/admin/agencies/getContactListByAgencyId/" + agencyId,
            type: "Post",
            dataType: 'html',
            async: false,
            data: {agencyId, agencyId},
            success: function (response) {
                if (response) {
                    $('#selAgencyPermitContact').html(response);
                    agencyContactId = String(agencyContactId);
                    if (agencyContactId.indexOf(',') >= 0) {
                        $('#selAgencyPermitContact').val(agencyContactId.split(',')).trigger('change');
                    } else {
                        $('#selAgencyPermitContact').val([agencyContactId]).trigger('change');
                    }
                }
            }
        });
        $('#agencyPermitModal').modal('toggle');
    }


    // Save Agency-Permit Data
    $(".subAgencyPermit").on('click', function (e) {
        e.preventDefault();
        if ($('#frmAgencyPermit').valid()) {
            var agencyId = $('.inp-agency-name').attr('data-id');
            $.ajax({
                url: "/admin/agencies/saveReleatedPermit",
                type: "POST",
                data: {permit_id: $('#selAgencyPermit').val(), agency_id: agencyId, contact_person: $('#selAgencyPermitContact').val(), permit_agency_id: $('#inpPermitAgencyId').val()},
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Permit', responce.msg);
                        $('#agencyPermitModal').modal('toggle');
                        getReleatedPermit(agencyId);
                    } else {
                        pNotifyError('Permit', responce.msg);
                    }
                }
            });
        }
    });

    /* check Agency-Permit-Form validation */
    $("#frmAgencyPermit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "PermitAgency[permit_id]": {
                required: true,
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 3,
            },

        },
        messages: {
            "PermitAgency[permit_id]": {
                required: 'Please select permit',
            },
            "PermitAgencyContact[agency_contact_id][]": {
                maxlength: 'Max limit is 3',
            },
        }
    });


    function getReleatedPermit(agencyId) {
        $.ajax({
            url: "/admin/agencies/getReleatedPermit/" + agencyId,
            type: "POST",
            dataType: 'html',
            data:{for:'agency'},
            cache: false,
            success: function (responce)
            {
                $('.agency-permit-block').html(responce);
            }
        });
    }
    /* Agency-Permit - END */

});



    