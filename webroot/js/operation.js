/* validation for Operation 
 * By @Ahsan Ahamad
 * Date : 5 Jan. 2018
 */

$(document).ready(function () {
    //***************** add Permit validation *****************************\\
    $("#operationId").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "name": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/admin/operations/checkOperationUniqueName/",
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
            "description": {
                /// required: true,
                maxlength: 160,

            },
        },
        messages: {
            "name": {
                required: "Please enter operation type",
                maxlength: "Maximum characters are 120.",
                remote: "Operation is already exist."
            },
            "short_description": {
                //  required: "Please enter notes",
                maxlength: "Maximum characters are 160."
            },
        },
    });

    /*** start   code for add agency value from admin permit**/
    $(".addOperationPermit").click(function () {
        if ($('#operationId').length == 1) {
            if ($('#operationId').valid()) {
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
        var operationId = $(element).data('operationid');
        $.ajax({
            url: "/admin/operations/getOperationPermit",
            type: "POST",
            beforeSend: function (xhr) {
                $('.loader-outer-block').css('display', 'none');
            },
            data: {operationId: operationId},
            contentType: false,
            dataType: 'JSON',
            cache: false,
            processData: false,
            success: function (responce)
            {
                if (responce.flag) {
                    pNotifySuccess('Operation Type', responce.msg);
                    $('.formId').attr('default', responce.formId);
                }
            }
        });
        $('.modelTitle').html(title);
        $('.addOperationId').val(operationId);
        $('#operationId').val([operationId]).trigger('change');
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
            "form_id[]": {
                required: true,

            },

        },
        messages: {
            "form_id[]": {
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
    $("#operationId").validate({
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

    /**  start code for add agency value from admin permit **/
    $(".addOperationAlert").click(function () {
        if ($('#operationId').length == 1) {
            if ($('#operationId').valid()) {
                var formId = $('.inp-operation-name').attr('data-id');
                if (formId > 0) {
                    openOperationAlertModal($(this));
                } else {
// code for saving data
                    saveOperationData();
                    openOperationAlertModal($(this));
                }

            }
        } else {
            openOperationAlertModal($(this));
        }
    });

    $(document).on('click', ".editOperationAlert", function () {
        if ($('#operationId').length == 1) {
            if ($('#operationId').valid()) {
                var formId = $('.inp-operation-name').attr('data-id');
                if (formId > 0) {
                    openOperationAlertModal($(this));
                } else {
// code for saving data
                    saveOperationData();
                    openOperationAlertModal($(this));
                }

            }
        } else {
            openOperationAlertModal($(this));
        }

    });

//* code open alert model  **\\

    function openOperationAlertModal(element) {

        $('#staffList').val(['']).trigger('change');
        $('#companiesList').val(['']).trigger('change');
        $('#industriesList').val(['']).trigger('change');


        var title = $(element).data('title');
        var operationId = $(element).data('operationid');
        var addOperationAlertId = $(element).data('operationalertid');
        var title = $(element).data('title');
        var alertId = $(element).data('alertid');
        var date = $(element).data('date');
        var time = $(element).data('time');
        var alertType = $(element).data('alerttype');
        var alertTitle = $(element).data('alerttitle');
        var notes = $(element).data('notes');

//*** function for hide show text field ** /  

//**  End function for hide show text field **** /         
        if (alertType == 3 || alertType == 4 || alertType == 2) {
            $.ajax({
                url: "/admin/forms/getAlertData/" + alertId + '/' + alertType,
                type: "POST",
                data: {alertType: alertType},
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    responce = responce.split(',');
                    if (alertType == 2) {
                        $('#staffList').val([responce]).trigger('change');
                    }
                    if (alertType == 3) {
                        $('#companiesList').val(responce).trigger('change');
                    }
                    if (alertType == 4) {
                        $('#industriesList').val([responce]).trigger('change');
                    }

                }
            });
        }

        $('.modelTitle').html(title);
        $('.addOperationId').val(operationId);
        $('.addOperationAlertId').val(addOperationAlertId);
        $('#alertId').val(alertId);
        $('.alertDate').val(date);
        $('.alertTime').val(time);
        $('.alertTitle').val(alertTitle);
        $('.alertNotes').val(notes);
        $('.alertType').val([alertType]).trigger('change');

        $('.modelTitle').html(title);
        $('#operationId').val(operationId);
        $('#operationId').val([operationId]).trigger('change');
        $('#operationAlertModel').modal('toggle');

    }
    //** code add  alerts **\\ 
    $("#frmOperationAlert").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmOperationAlert').valid()) {
            //displayLoder();
            $.ajax({
                url: "/admin/operations/addOperationAlert",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Alert', responce.msg);
                        $('#operationAlertModel').modal('toggle');
                        getReleatedOperationAlert(responce.operation_id);


                    } else {
                        pNotifyError('Alert', responce.msg);
                        $('#operationAlertModel').modal('toggle');
                    }

                }
            });
        }
    });

    //** code open alert model **\\

    function getReleatedOperationAlert(operation_id) {
        $.ajax({
            url: "/admin/operations/getReleatedOperationAlert/" + operation_id,
            type: "POST",
            data: {formId: 2},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.operation-alert-block').html(responce);
            }
        });
    }


//** code alert validation **\\

    $("#frmOperationAlert").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            alert_type_id: "required",
            "company_id": "required",
            "industry_id": "required",
            title: {
                required: true,
                maxlength: 40,
            },
            notes: {
                required: true,
                maxlength: 160,
            },
            date: "required",
        },
        messages: {
            alert_type_id: "Please select alert type",
            "company_id": "Please select companies",
            "industry_id": "Please select industries",
            title: {
                required: "Please enter title",
                maxlength: "Maximum characters are 40."
            },
            notes: {
                required: "Please enter notes",
                maxlength: "Maximum characters are 160."
            },
            date: "Please select a date"
        },
    });


//Code for desable and enable select list 
    /* code for on change alert type disable menus*/
    $(".alertType").on('change', function () {
        var id = $(".alertType").val();
        hideComplnyAndStaffList(id);
    });

    function hideComplnyAndStaffList(id) {
        //  id 3 for company 

        if (id == 3) {
            $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', false);
            //.$('#companiesList').html('');
            $('#staffList').find('option').each(function () {
                if ($(this).attr("selected") == 'selected') {
                    $(this).attr("selected", '');
                }
            });
            $("#staffList").next().find(".select2-selection__rendered").find("li").each(function () {
                $(this).remove();
            });

        }
//  id 4 for admin staff 
        else if (id == 2) {
            //.$('#companiesList').html('');
            $('#companiesList').find('option').each(function () {
                if ($(this).attr("selected") == 'selected') {
                    $(this).attr("selected", '');
                }
            });
            $("#companiesList").next().find(".select2-selection__rendered").find("li").each(function () {
                $(this).remove();
            });

            $('#staffList').attr('disabled', false);
            $('#companiesList').attr('disabled', 'disabled');
        } else {

            $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', 'disabled');
            $('#staffList').find('option').each(function () {
                if ($(this).attr("selected") == 'selected') {
                    $(this).attr("selected", '');
                }
            });
            $("#staffList").next().find(".select2-selection__rendered").find("li").each(function () {
                $(this).remove();
            });
            $('#companiesList').find('option').each(function () {
                if ($(this).attr("selected") == 'selected') {
                    $(this).attr("selected", '');
                }
            });
            $("#companiesList").next().find(".select2-selection__rendered").find("li").each(function () {
                $(this).attr('aria-selected', false);
                $(this).remove();
            });

        }
    }

    // Submit Company Employee Form
    $(document).on('click', '.btn-form-submit', function () {
        if ($('#operationId').valid()) {
            $('#operationId').submit();
            displayLoder();
        }
    });

});
















    