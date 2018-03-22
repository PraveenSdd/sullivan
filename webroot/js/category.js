/*  validation for agency 
 * By @Ahsan Ahamad
 * Date : 5 Jan. 2018
 */

$(document).ready(function () {
//  phone number formate
    $(".inp-phone").mask("999-999-9999");

//***************** add agency validation *****************************\\
    $("#categoryId").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/admin/categories/checkAgencyUniqueName/",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display', 'none');
                    },
                    data: {
                        name: function () {
                            return $("#name").val();
                        },
                        id: function () {
                            return $("#name").data('id');
                        },
                    },
                },
            },
            "address1": {
                required: true,
                maxlength: 80,

            },
            "city": {
                required: true,
                maxlength: 40,

            },
            "state_id": {
                required: true,

            },
            "zipcode": {
                required: true,

            },
        },
        messages: {
            "name": {
                required: "Please enter agency name",
                maxlength: "Maximum characters are 150.",
                remote: "Agency is already exist."
            },
            "address1": {
                required: "Please enter address",
                maxlength: "Maximum characters are 80."
            },
            "state_id": {
                required: "Please select state",
            },
            "zipcode": {
                required: "Please select state",
            },
        },
    });


    /************************** start   code for add agency Conatct person **********************/
    $(document).on("click", ".addConatctPerson", function () {

        $('.additional-address-block').html('');
//        $('.additional-address-block').append($('.additional-address-html').html());
//        resetAddressFields();
        if ($('#categoryId').length == 1) {
            if ($('#categoryId').valid()) {
                var formId = $('.inp-agency-name').attr('data-id');
                if (formId > 0) {
                    openAgencyPersonModal($(this));
                } else {
// code for saving data
                    saveAgencyData();
                    openAgencyPersonModal($(this));
                }
            }
        } else {
            openAgencyPersonModal($(this));
        }
    });


//***************** add agency ajax code *****************************\\

    function saveAgencyData() {

        $.ajax({
            url: "/admin/categories/saveAgencyData",
            type: "POST",
            data: $('#categoryId').serialize(),
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function (responce)
            {
                if (responce.flag) {
                    pNotifySuccess('Agency', responce.msg);
                    $('.addicons').attr('data-categoryId', responce.agency_id);
                    $('.addCategoryId').val(responce.agency_id);
                    $('.inp-agency-name').attr('data-id', responce.agency_id);
                } else {
                    pNotifyError('Agency', responce.msg);

                }

            }
        });
    }
//***************** open model of conatct person  *****************************\\

    function openAgencyPersonModal(element) {
        /* set value from permit add agency and add contact per*/
         var categoryId = $('.inp-agency-name').attr('data-id');
        if ($(element).data('flag') == 1) {
            if ($('#permitAddAgency').valid()) {
                $('.permitId').val($(element).data('permitid'));
                $('.addCategoryId').val($(element).data('categoryid'));
            }
        } else {
            $('#categotyId').val([categoryId]).trigger('change');

        }

        $(".inp-phone").mask("999-999-9999");
        $('.agencycontactId').val(' ');
        $('.conatctName').val(' ');
        $('.conatctPosition').val(' ');
        $('.conatctEmail').val(' ');
        $('.conatctPhone').val(' ');
        $('.conatctAddress').val(' ');
        $('.agencyContactId').val(' ');

        $('#formagencyid').val(' ');

        var title = $(element).data('title');
       
        $('.modelTitle').html(title);
        $('.addCategoryId').val(categoryId);

        $('#contactPersonModel').modal('toggle');

    }
    /*validation for agency from permit add/edit page on click add agency contact person*/
    /* check agency validation */
    $("#permitAddAgency").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "category_id[]": "required",

        },
        messages: {
            "category_id[]": "Please select agency",

        },
    });


//***************** add contact person by ajax *****************************\\

    $("#AddAgencyPerson").on('submit', function (e) {
        e.preventDefault();
        if ($('#AddAgencyPerson').valid()) {

            $.ajax({
                url: "/admin/categories/addAgencyConatct",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Agency', responce.msg);
                        $('#contactPersonModel').modal('toggle');
                        if (responce.permit_id) {
                            $.ajax({
                                url: "/admin/forms/getAgencyContacts",
                                type: "Post",
                                dataType: 'html',
                                data: {categoryId: responce.category_id},
                                success: function (response) {
                                    if (response) {
                                        $('.contactPerson').html(response);

                                    }
                                }
                            });
                        } else {
                            getReleatedAgencyContact(responce.category_id);
                        }


                    } else {
                        pNotifyError('Agency', responce.msg);
                        $('#contactPersonModel').modal('toggle');
                    }

                }
            });
        }
    });

//***************** get all agency contact person list *****************************\\

    function getReleatedAgencyContact(category_id) {
        $.ajax({
            url: "/admin/categories/getReleatedAgencyContact/" + category_id,
            type: "POST",
            data: {formId: 2},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-agency-block').html(responce);
            }
        });
    }


    //***************** contact person validation *****************************\\

    $("#AddAgencyPerson").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 40,
            },
            "email": {
                required: true,
                maxlength: 40,
                email: true,
            },
            "phone": {
                required: true,
                maxlength: 15,
            },
            "Address[address1][]": {
                required: true,
                maxlength: 80,
            },
            "position": {
                required: true,
                maxlength: 40,
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
            "name": {
                required: "Please enter name",
                maxlength: "Maximum characters are 40."
            },
            "email": {
                required: "Please enter email address",
                maxlength: "Maximum characters are 40.",
                email: 'Please enter valid email addres.',
            },
            "phone": {
                required: "Please enter phone number",
                maxlength: "Maximum characters are 15"
            },
            "Address[address1][]": {
                required: "Please enter address1",
                maxlength: "Maximum characters are 80"
            },
            "position": {
                required: "Please enter position",
                maxlength: "Maximum characters are 40"
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


//***************** edit conatct person *****************************\\

    $(document).on('click', ".editAgencyConatct", function () {
        $(".inp-phone").mask("999-999-9999");
        $('.agencycontactId').val(' ');
        $('.conatctName').val(' ');
        $('.conatctPosition').val(' ');
        $('.conatctEmail').val(' ');
        $('.conatctPhone').val(' ');
        $('.inp-agency-name').attr('data-id', $(this).data('contactid'));
        $('.addCategoryId').val($(this).data('categoryid'));
        $('.agencyContactId').val($(this).data('contactid'));
        $('.conatctName').val($(this).data('conatcname'));
        $('.conatctPosition').val($(this).data('conatcposition'));
        $('.conatctEmail').val($(this).data('conatcemail'));
        $('.conatctPhone').val($(this).data('conatcphone'));
        $('.inp-add-state').attr('default', '');
        $('.inp-add-zipcode').val('');
        getReleatedAgencyContactAddress($(this).data('contactid'));
        $('#contactPersonModel').modal('toggle');
    });

//***************** get contact person address *****************************\\

    function getReleatedAgencyContactAddress(contact_id) {
        $.ajax({
            url: "/admin/categories/getReleatedAgencyContactAddress/" + contact_id,
            type: "POST",
            data: {},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.additional-address-block').html(responce);
                resetAddressFields();
            }
        });
    }


    //***************** code add for more address html  *****************************\\



    $(document).on('click', '.add-address', function () {
        $('.additional-address-block').append($('.additional-address-html').html());
        resetAddressFields();
    });

    $(document).on('click', '.additional-address-block .remove-address', function () {
        if ($('.additional-address-block .additional-address').length > 0) {
            $(this).parents('.additional-address').remove();
        }
        resetAddressFields();
    });

    function resetAddressFields() {
        $(".inp-phone").mask("999-999-9999");
        var addressSerial = 1;
        $('.additional-address-block .additional-address').each(function () {
            $(this).find('.address-count').html(addressSerial);
            $(this).find('.inp-add-address1').attr('id', 'inp-add-address1-' + addressSerial);
            $(this).find('.inp-add-address2').attr('id', 'inp-add-address2-' + addressSerial);
            $(this).find('.inp-add-city').attr('id', 'inp-add-city-' + addressSerial);
            $(this).find('.sel-add-state').attr('id', 'sel-add-state-' + addressSerial);
            $(this).find('.inp-add-zipcode').attr('id', 'inp-add-zipcode-' + addressSerial);
            $(this).find('.inp-add_address-country_code').attr('id', 'inp-add_address-country_code-' + addressSerial);
            $(this).find('.inp-address_phone').attr('id', 'inp-address_phone-' + addressSerial);
            addressSerial++;
        });
        if ($('.additional-address-block .remove-address').length > 0) {
            $('.additional-address-block .remove-address').removeClass('hide');
        } else {
            $('.additional-address-block .remove-address').addClass('hide');
        }
    }

    // Submit Company Employee Form
    $(document).on('click', '.btn-agency-submit', function () {
        if ($('#categoryId').valid()) {
            $('#categoryId').submit();
            displayLoder();
        }
    });


    /* Agency-Permit - START */
    $(document).on("click", ".btnAgencyPermitModel", function () {
        if ($('#categoryId').length == 1) {
            if ($('#categoryId').valid()) {
                var formId = $('.inp-agency-name').attr('data-id');
                if (formId > 0) {
                    openAgencyPermitModal($(this));
                } else {
// code for saving data
                    saveAgencyData();
                    openAgencyPermitModal($(this));
                }
            }
        } else {
            openAgencyPermitModal($(this));
        }
    });


    function openAgencyPermitModal(element) {
        $('#agencyPermitModel .modelTitle').html($(element).data('title'));
        var categoryId = $('.inp-agency-name').attr('data-id');
        $('#selAgencyPermit').val('');
        $('#selAgencyPermitContact').val('');
        $('#inpPermitAgencyId').val('');
        var permitId = $(element).data('permitid');
        var contactId = $(element).data('conatctid');
        var permitAgencyId = $(element).data('permitagencyid');
        $('#inpPermitAgencyId').val(permitAgencyId);
        $.ajax({
            url: "/admin/forms/getUnassignedPermitList/",
            type: "Post",
            dataType: 'html',
            async: false,
            data: {assindPermitId: permitId},
            success: function (response) {
                if (response) {
                    $('#selAgencyPermit').html(response);
                    $('.sel-agency-permit').val([permitId]).trigger('change');
                }
            }
        });

        $.ajax({
            url: "/admin/categories/getContactPersonByAgencyId/" + categoryId,
            type: "Post",
            dataType: 'html',
            async: false,
            data: {categoryId, categoryId},
            success: function (response) {
                if (response) {
                    $('#selAgencyPermitContact').html(response);
                    contactId = String(contactId);
                    if (contactId.indexOf(',') >= 0 ) {
                        $('#selAgencyPermitContact').val(contactId.split(',')).trigger('change');
                    } else {
                        $('#selAgencyPermitContact').val([contactId]).trigger('change');
                    }
                }
            }
        });
        $('#agencyPermitModel').modal('toggle');
    }


    // Save Agency-Permit Data
    $("#frmAgencyPermit").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmAgencyPermit').valid()) {
            var categoryId = $('.inp-agency-name').attr('data-id');
            $.ajax({
                url: "/admin/forms/saveAgencyPermit",
                type: "POST",
                data: {permit_id: $('#selAgencyPermit').val(), agency_id: categoryId, contact_person: $('#selAgencyPermitContact').val(), permit_agency_id: $('#inpPermitAgencyId').val()},
                dataType: 'JSON',
                cache: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Permit', responce.msg);
                        getReleatedPermitAgency(categoryId);
                        $('#agencyPermitModel').modal('toggle');
                    } else {
                        pNotifyError('Permit', responce.msg);
                    }

                }
            });
        }
    });

    /* check agency validation */
    $("#frmAgencyPermit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "permit_id": "required",

        },
        messages: {
            "permit_id": "Please select Permit",

        },
    });

    //***************** get all agency contact person list *****************************\\

    function getReleatedPermitAgency(category_id) {
        $.ajax({
            url: "/admin/categories/getPermitAgency/" + category_id,
            type: "POST",
            data: {formId: 2},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.agency_permit-block').html(responce);
            }
        });
    }


    /* Agency-Permit - START */

});

/* code for get agency contact persion details  */

$(document).on('click', '.viewContact', function () {
    var personId = $(this).data('id');
    if (personId) {
        $.ajax({
            url: "/admin/categories/getContactPerson/" + personId,
            type: "Post",
            dataType: 'html',
            data: {personId: personId},
            success: function (response) {
                if (response) {
                    $('.contactPerson').html(response);
                    $('#viewConatcPerson').modal('toggle');

                }
            }
        });
    } else {
        $(".contactPerson").html();
    }
});



    