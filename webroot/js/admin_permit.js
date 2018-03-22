/*  upload frontent forms 
 * By @Ahsan Ahamad
 * Date : 12th Dec. 2017
 */

$(document).ready(function () {

//** add Permit validation **\
    $("#frmPermit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "title": {
                required: true,
                maxlength: 120,
                remote: {
                    url: "/admin/forms/checkPermitUniqueName/",
                    type: "post",
                    beforeSend: function (xhr) {
                        $('.loader-outer-block').css('display', 'none');
                    },
                    data: {
                        title: function () {
                            return $("#title").val();
                        },
                        id: function () {
                            return $("#title").data('id');
                        },
                    },
                },
            },

        },
        messages: {
            "title": {
                required: "Please enter permit title",
                maxlength: "Maximum characters are 150.",
                remote: "Permit title is already exist."
            },
        },
    });


    /** start   code for add agency value from admin permit */
    $(document).on('click','.permitAgency',function () {

        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitAgencyModal($(this));
                } else {
// code for saving data
                    savePermitData();
                    openPermitAgencyModal($(this));
                }

            }
        } else {
            openPermitAgencyModal($(this));
        }
    });

    /*  Function:savePermitData()
     * Description: Add new permit from ajax
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function savePermitData() {
        $.ajax({
            url: "/admin/forms/savePermitData",
            type: "POST",
            data: {title: $('.inp-permit-title').val(), description: $('.inp-permit-description').val(), id: $('.inp-permit-title').attr('data-id')},
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function (responce)
            {
                if (responce.flag) {
                    pNotifySuccess('Permit', responce.msg);
                    $('.addicons').attr('data-formId', responce.form_id);
                    $('.addFormsformId').val(responce.form_id);
                    $('.inp-permit-title').attr('data-id', responce.form_id);
                } else {
                    pNotifyError('Permit', responce.msg);
                    openPermitAgencyModal($(this));
                }

            }
        });
    }

    /*  Function:openPermitAgencyModal()
     * Description: Open agency model and set fiels value required data
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function openPermitAgencyModal(element) {
        $('#formagencyid').val(' ');
        $('#categotyId').val(' ');
        $('#agencyId').val('').trigger('change');
        $('#contactPerson').val(' ').trigger('change');
        var title = $(element).data('title');
        var formId = $(element).data('formid');
        var categoryId = $(element).data('categotyid');
        var formagencyid = $(element).data('formagencyid');
        var permitAgencyId = $(element).data('permitagencyid');
        
        if (formagencyid) {
            $('#agencyId').val([formagencyid]).trigger('change');
        }

        $.ajax({
            url: "/admin/forms/getPermitAgencyConatcPerson/" + permitAgencyId,
            type: "POST",
            data: {formagencyid: formagencyid,formId:formId},
            contentType: false,
            async: false,
            dataType: 'JSON',
            cache: false,
            processData: false,
            success: function (responce)
            {
                var responceArray = $.map(responce, function(el) { return el });
               console.log(responceArray);
                $('#contactPerson').val(responceArray).trigger('change');
            }
        });
        /* set permit id in add conact link*/
        $('.addConatctPerson').attr('data-permitId', formId);
        /* end code*/
        $('.modelTitle').html(title);
        $('#addAgencyPermitId').val(formId);
        $('#permitAgencyid').val(permitAgencyId);
        $('#formagencyid').val(formagencyid);
        $('#categotyId').val(categoryId);
        $('#permitAddAgencyModel').modal('toggle');

    }
    /** add new agency related to permit */

    $("#permitAddAgency").on('submit', function (e) {
        e.preventDefault();
        if ($('#permitAddAgency').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitAgency",
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
                        $('.permitAgency').addClass('hide');
                        $('#permitAddAgencyModel').modal('toggle');
                        getReleatedAgency(responce.permit_id);


                    } else {
                        pNotifyError('Agency', responce.msg);
                       // $('#permitAddAgencyModel').modal('toggle');
                    }

                }
            });
        }
    });

    /*  Function:getReleatedAgency()
     * Description: Get all agency related to the permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function getReleatedAgency(permit_id) {
        $.ajax({
            url: "/admin/forms/getReleatedAgency/" + permit_id,
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
    /* check agency validation */
    $("#permitAddAgency").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "agency_id": "required",
        },
        messages: {
            "agency_id": "Please select agency",

        },
    });

    /*@desctiption: open Operation model on click add/edit operation button.
     * @Date: 14th Jan 2018
     * @by: Ahsan Ahamad
     */
    $(document).on("click",".permitOperation",function () {

        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitOperationModal($(this));
                } else {
// code for saving data
                    savePermitData();
                    openPermitOperationModal($(this));
                }

            }
        } else {
            openPermitOperationModal($(this));
        }
    });

    /* @Function:openPermitAgencyModal()
     * @Description: Open operation model and set fiels value required data
     * @By @Ahsan Ahamad
     * @Date : 14th Jan. 2018
     */
    function openPermitOperationModal(element) {


        var title = $(element).data('title');
        var permitId = $(element).data('permitid');
        var permitOperationId = $(element).data('id');
        var operationId = $(element).data('operationid');
        $('.permitId').val(' ');
        $('#permitOperationId').val(' ');
        $('#operationId').val(' ');

        $('.modelTitle').html(title);
        $('.permitId').val(permitId);
        $('#permitOperationId').val(permitOperationId);
        $('.operationId').val([operationId]).trigger('change');
        $('#permitAddOperationModel').modal('toggle');

    }


    /************************** add new agency related to permit **********************/

    $("#permitAddOperation").on('submit', function (e) {
        e.preventDefault();
        if ($('#permitAddOperation').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitOperation",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Operation', responce.msg);
                        $('#permitAddOperationModel').modal('toggle');
                        getReleatedOperation(responce.permit_id);


                    } else {
                        pNotifyError('Operation', responce.msg);
                        $('#permitAddOperationModel').modal('toggle');
                    }

                }
            });
        }
    });

    /*  Function:getReleatedOperation()
     * Description: Get all agency related to the permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function getReleatedOperation(permitId) {
        $.ajax({
            url: "/admin/forms/getReleatedOperation/" + permitId,
            type: "POST",
            data: {formId: 2},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-operation-block').html(responce);
            }
        });
    }


    /* check agency validation */
    $("#permitAddOperation").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "operation_id[]": "required",
        },
        messages: {
            "operation_id[]": "Please select operations",

        },
    });

    /** start code for add forms value from admin permit view popup */
    $(document).on("click",".permitFormsModel",function () {

        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitFormModal($(this));

                } else {
                    // code for saving data
                    savePermitData();
                    openPermitFormModal($(this));
                }

            }
        } else {
            openPermitFormModal($(this));
        }
    });

    /*  Function:openPermitFormModal()
     * Description: Function use for open popup model for upload form related to permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function openPermitFormModal(element) {
        $('#documentid').val('');
        $('#form_name1').val('');
       
        var title = $(element).data('title');
        var formId = $(element).data('formid');
        var formname = $(element).data('formname');
        var documentId = $(element).data('documentid');

         $('#form_name1').val(formname);
         $('.modelTitle').html(title);
        $('#addFormsformId').val(formId);
        $('#documentid').val(documentId);
        if (documentId > 0) {
            $('.formDocument').removeClass('required');
             $('#form_document1').val(' ');
        $('#form_document_required1').val(' ');
        } else {
            $('#permitFormsModel').modal('toggle');

        }
        
        


    }

    /*  add new form related to permit **/

    $("#frmPermitForm").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitForm').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitForms",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Forms', responce.msg);
                        $('#permitFormsModel').modal('toggle');
                        getReleatedForms(responce.form_id);


                    } else {
                        pNotifyError('Forms', responce.msg);
                        $('#permitFormsModel').modal('toggle');
                    }

                }
            });
        }
    });

    /*  Function:getReleatedForms()
     * Description: Function use for get all form related to permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */

    function getReleatedForms(formId) {
        $.ajax({
            url: "/admin/forms/getReleatedForms/" + formId,
            type: "POST",
            data: {formId: formId},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-document-block').html(responce);


            }
        });
    }
    /*  validation of the permit upload form*/
    $("#frmPermitForm").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "forms[form_name][]": {
                required: true,
                maxlength: 40,
            },

        },
        messages: {
            "forms[form_name][]": {
                required: "Please enter name",
                maxlength: "Maximum characters are 40"
            },

        },
    });


    /* start code for add forms Documents value from admin permit view popup **/

    $(document).on('click',".permitAttachment",function () {
        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitAttchmentModal($(this));

                } else {
                    // code for saving data
                    savePermitData();
                    openPermitAttchmentModal($(this));
                }

            }
        } else {
            openPermitAttchmentModal($(this));
        }

    });

    /*  Function:openPermitAttchmentModal()
     * Description: Function use for open popup model for uploaded form related attach file related to permit
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    function openPermitAttchmentModal(element) {
        $('#formAttachmentId').val('');
        var title = $(element).data('title');
        var formId = $(element).data('formid');
        var formAttachmentId = $(element).data('documentid');
        var mandatory = $(element).data('mandatory');
        if(mandatory == 1){
             $('#form_document_required1').attr( 'checked',true);
           
        }
        if (formAttachmentId > 0) {
            $('.attachment').removeClass('required');
        } else {
            $('#permitDocumentsModel').modal('toggle');

        }
        var documentname = $(element).data('documentname');
        $('.modelTitle').html(title);
        $('#addDocumentformId').val(formId);
        $('#formAttachmentId').val(formAttachmentId);
        $('#form-attachment-1-document-name').val(documentname);

    }
    /* add new permit documnet */
    $("#frmPermitDocuments").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitDocuments').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitFormsAttachment",
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
                        $('#permitDocumentsModel').modal('toggle');
                        getReleatedFormAttachment(responce.form_id);

                    } else {
                        pNotifyError('Document', responce.msg);
                        $('#permitDocumentsModel').modal('toggle');
                    }


                }
            });
        }
    });

    /*  Function:getReleatedFormAttachment()
     * Description: Function use for get form related attach file related to permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function getReleatedFormAttachment(formId) {
        $.ajax({
            url: "/admin/forms/getReleatedFormAttachment/" + formId,
            type: "POST",
            data: {formId: formId},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-attachment-block').html(responce);


            }
        });
    }
    /* add /edit document related to permit */
    $("#frmPermitDocuments").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "form_attachment[document_name][]": {
                required: true,
                maxlength: 40,
            },
        },
        messages: {
            "form_attachment[document_name][]": {
                required: "Please enter document name",
                maxlength: "Maximum characters are 40"
            },
        }

    });

    /** start   code for add deadline value from admin permit **/

    $(document).on("click",".permitDeadline",function () {
        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitDeadlineModal($(this));

                } else {
                    // code for saving data
                    savePermitData();
                    openPermitDeadlineModal($(this));
                }

            }
        } else {
            openPermitDeadlineModal($(this));
        }

    });

    /*  Function:openPermitDeadlineModal()
     * Description: Function use for open deadline model related to permit
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    function openPermitDeadlineModal(element) {
        var title = $(element).data('title');
        var formId = $(element).data('formid');
        $('#formDeadlineId').val('');
        $('#date').val('');
        $('#time').val('');
        var formDeadlineId = $(element).data('deadlineid');
        var date = $(element).data('date');
        var time = $(element).data('time');
        $('.modelTitle').html(title);
        $('#formId').val(formId);
        $('#formDeadlineId').val(formDeadlineId);
        $('#date').val(date);
        $('#time').val(time);
        $('#permitDeadlinesModel').modal('toggle');
    }
    /* add new deadline related to permit */
    $("#permitdeadline").on('submit', function (e) {
        var documentId = $('#form_documents_id').val();
        e.preventDefault();
        if ($('#permitdeadline').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitDeadline",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Deadline', responce.msg);
                        $('#permitDeadlinesModel').modal('toggle');
                        getReleatedDeadline(responce.form_id);
                    } else {
                        pNotifyError('Deadline', responce.msg);
                        $('#permitDeadlinesModel').modal('toggle');
                    }


                }
            });
        }
    });
    /*  Function:getReleatedDeadline()
     * Description: Function use for get deadline related to permit
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */
    function getReleatedDeadline(formId) {
        $.ajax({
            url: "/admin/forms/getReleatedDeadline/" + formId,
            type: "POST",
            data: {formId: formId},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-deadline-block').html(responce);


            }
        });
    }
    /* validation deadline form related to permit*/
    $("#permitdeadline").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            date: "required",
        },
        messages: {
            date: "Please select date",

        },
    });

    /* start code for add forms Alert value from admin permit view popup ***/


    $(document).on("click",".permitAlert",function () {

        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitAlertModal($(this));

                } else {
                    /* code for saving data*/
                    savePermitData();
                    openPermitAlertModal($(this));
                }

            }
        } else {
            openPermitAlertModal($(this));
        }

    });

    /*  Function:getReleatedDeadline()
     * Description: Function use for open alert model related to permit
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    function openPermitAlertModal(element) {

        var title = $(element).data('title');
        var formId = $(element).data('formid');
        var alertId = $(element).data('alertid');
        var alertPermitId = $(element).data('formalertid');
        if (alertPermitId > 0) {
        } else {
            $('#permitAlertModel').modal('toggle');
        }
        var date = $(element).data('date');

        var time = $(element).data('time');
        var alertType = $(element).data('alerttype');
        var alertTitle = $(element).data('alerttitle');
        var notes = $(element).data('notes');

        $('#staffList').val(' ').trigger('change');
        $('#companiesList').val(' ').trigger('change');
        $('#industriesList').val(' ').trigger('change');
        /**function for hide show text field */

        if (alertType == 3 || alertType == 4 || alertType == 2) {
            $.ajax({
                url: "/admin/forms/getAlertData/" + alertId + '/' + alertType,
                type: "POST",
                data: {formId: formId, alertType: alertType},
                contentType: false,
                dataType: 'JSON',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    responce = responce.split(',');
                    if (alertType == 2) {
                        $('#staffList').val(responce).trigger('change');
                    }
                    if (alertType == 3) {
                        $('#companiesList').val(responce).trigger('change');
                    }
                    if (alertType == 4) {
                        $('#industriesList').val(responce).trigger('change');
                    }

                }
            });
        }

        $('.modelTitle').html(title);
        $('#alertFormId').val(formId);

        $('#alertId').val(alertId);
        $('#alertPermitId').val(alertPermitId);
        $('.alertDate').val(date);
        $('.alertTime').val(time);
        $('.alertTitle').val(alertTitle);
        $('.alertNotes').val(notes);
        $('.alertType').val([alertType]).trigger('change');
    }
    /* add new alert related to permit*/
    $("#frmPermitAlert").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitAlert').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitFormsAlert",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'Json',
                cache: false,
                processData: false,
                success: function (responce)
                {
                    if (responce.flag) {
                        pNotifySuccess('Alert', responce.msg);
                        $('#permitAlertModel').modal('toggle');
                        getReleatedFormAlerts(responce.permit_id);
                    } else {
                        pNotifyError('Alert', responce.msg);
                        $('#permitAlertModel').modal('toggle');
                    }


                }
            });
        }
    });

    /*  Function:getReleatedFormAlerts()
     * Description: Function use for get alert related to permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function getReleatedFormAlerts(formId) {
        $.ajax({
            url: "/admin/forms/getReleatedFormAlert/" + formId,
            type: "POST",
            data: {formId: formId},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-alert-block').html(responce);


            }
        });
    }
    /* validation alert form related to permit*/
    $("#frmPermitAlert").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            alert_type_id: "required",
            "company_id": "required",
            "industry_id": "required",
            title: "required",
            notes: "required",
            date: "required",
        },
        messages: {
            alert_type_id: "Please select alert type",
            "company_id": "Please select companies",
            "industry_id": "Please select industries",
            title: "Please enter a title",
            notes: "Please enter a notes",
            date: "Please select a date"
        },
    });


    /* code for on change alert type disable menus*/
    $(document).on('change',".alertType", function () {
        var id = $(".alertType").val();
        alertForm(id);
    });

    function alertForm(id) {
        /*  id 3 for company */
        if (id == 3) {
            $('#industriesList').attr('disabled', 'disabled');
            $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', false);
        }
        /*  id 4 for industry */
        else if (id == 4) {
            $('#industriesList').attr('disabled', false);
            $('#companiesList').attr('disabled', 'disabled');
            $('#staffList').attr('disabled', 'disabled');
        }
        /*  id 4 for admin staff */
        else if (id == 2) {
            $('#staffList').attr('disabled', false);
            $('#companiesList').attr('disabled', 'disabled');
            $('#industriesList').attr('disabled', 'disabled');
        } else {
            $('#staffList').attr('disabled', 'disabled');
            $('#companiesList').attr('disabled', 'disabled');
            $('#industriesList').attr('disabled', 'disabled');
        }
    }


    /* code for get agency/category conatct person on select agency */
    $(document).on('change', ".agencyId", function () {
        var categoryId = $(this).val();
        $('.addConatctPerson').attr('data-categoryId', categoryId);
        
        getAgencyContact(categoryId);

    });


    function getAgencyContact(categoryId) {
        if (categoryId) {
            $.ajax({
                url: "/admin/forms/getAgencyContacts",
                type: "Post",
                dataType: 'html',
                async: false,
                data: {categoryId: categoryId},
                success: function (response) {
                    if (response) {
                        $('.contactPerson').html(response);
                        $('.permitId').val(categoryId);


                    }
                }
            });
        } else {
            $("#ProductCategoryId").html();
        }
    }



    /* start code for add Permit Instruction value from admin permit view popup **/

    $(document).on("click",".PermiInstruction",function () {
        if ($('#frmPermit').length == 1) {
            if ($('#frmPermit').valid()) {
                var formId = $('.inp-permit-title').attr('data-id');
                if (formId > 0) {
                    openPermitInstrctionModal($(this));

                } else {
                    // code for saving data
                    savePermitData();
                    openPermitInstrctionModal($(this));
                }

            }
        } else {
            openPermitInstrctionModal($(this));
        }

    });

    /*  Function:openPermitAttchmentModal()
     * Description: Function use for open popup model for uploaded form related attach file related to permit
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    function openPermitInstrctionModal(element) {
        $('#permitInstructionId').val(' ');
        $('#permitId').val('');
        var title = $(element).data('title');
        var formId = $(element).data('formid');
        var permitAgencyId = $(element).data('permitinstructionid');
        var instructionTitle = $(element).data('instructiontitle');
        console.log(permitAgencyId);
        if (permitAgencyId > 0) {            
            $('#filePath').attr('data-is-required', '0');
        } else {            
            $('#filePath').attr('data-is-required', '1');
        }
        $('#permitId').val(formId);
        $('#instructionTitle').val(instructionTitle);
        $('#permitInstructionId').val(permitAgencyId);

        $('.modelTitle').html(title);
        $('#permitInstructionsModel').modal('toggle');

    }
    /* add new permit documnet */
    $("#frmPermitInstruction").on('submit', function (e) {
        e.preventDefault();
        if ($('#frmPermitInstruction').valid()) {
            $.ajax({
                url: "/admin/forms/addPermitInstructions",
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
                        $('#permitInstructionsModel').modal('toggle');
                        getPermitInstructions(responce.permit_id);

                    } else {
                        pNotifyError('Instruction', responce.msg);
                        $('#permitInstructionsModel').modal('toggle');
                    }


                }
            });
        }
    });

    /*  Function:getReleatedFormAttachment()
     * Description: Function use for get form related attach file related to permit
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */
    function getPermitInstructions(permitId) {
        $.ajax({
            url: "/admin/forms/getPermitInstructions/" + permitId,
            type: "POST",
            data: {permitId: permitId},
            contentType: false,
            dataType: 'html',
            cache: false,
            processData: false,
            success: function (responce)
            {
                $('.permit-instruction-block').html(responce);
            }
        });
    }
    /* add /edit document related to permit */
    $.validator.addMethod("checkAddEditUploading", function (value, element, params) {        
        var isRequired = $(element).attr('data-is-required');
        var result = true;                
        if (isRequired == 1 && value == '') {
            result = false;
        }
        return result;
    }, function (params, element) {
        return params.msg;
    });
    $("#frmPermitInstruction").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "title": {
                required: true,
                maxlength: 40,
            },

            "file_path": {
                "checkAddEditUploading": {msg: 'Please upload instruction file'}
            },
        },
        messages: {
            "title": {
                required: "Please enter title",
                maxlength: "Maximum characters are 40"
            },
            file_path: 'Please upload instrcution file'
        },
    });

});