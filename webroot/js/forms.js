/*  validation for category 
 * By @Ahsan Ahamad
 * Date : 3 Nov. 2017
 */

$(document).ready(function () {
    resetUploadFields();
    var x = 1;
    var max_fields_limit = 10; //set limit for maximum input fields
    $('.add_more_button').click(function (e) { //click event on add more fields button having class add_more_button
        e.preventDefault();
        if (x < max_fields_limit) { //check conditions
            x++; //counter increment
            $('.input_fields_container').last().append('<div><a href="#" class="label label-danger remove_field" style="margin-left:10px;"><i class="fa fa-minus"></i></a><div class="form-group"> <label for="CategoryName" class="col-sm-3 control-label">Question</label><div class="col-sm-9"><input class="form-control required" type="text" id="question' + x + '" name="question[]"/></div></div><div class="form-group"> <label for="CategoryName" class="col-sm-3 control-label">Answer</label><div class="col-sm-9"><textarea class="form-control required" type="text" id="answer' + x + '" name="answer[]" rows="5"/></textarea></div></div></div>');
        }
    });
    var arrid = [];
    $('.input_fields_container').on("click", ".remove_field", function (e) { //user click on remove text links
        var id = $(this).data('id');
        arrid.push(id)
        $('#question_id').val(arrid);
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })


// code for attachement document

    var formAttachments = 0;
    $(document).on('blur', '.inp-form-attachments', function () {
        formAttachmentFields();
    });

    $(document).on('click', '.form-required-docs-add', function () {
        formAttachmentFields();
    });

    var arridAtte = [];
    $(document).on('click', '.form-required-docs-remove', function () {
        var id = $(this).data('id');

        arridAtte.push(id);
        $('#del_form_attachments_id').val(arridAtte);

        if ($('.div-form-attachments .form-required-docs').length > 0) {
            var element = $(this).parents('.form-required-docs').remove();

            var inpFormAttachments = 1;
            if (inpFormAttachments > 0) {
                inpFormAttachments--
            }
        }
        formAttachments = inpFormAttachments;
        resetAttachmentFields();

    });

    /*  @Function: formAttachmentFields()
     * @Description: add attachment fields of the form / permit
     * @By @Ahsan Ahamad
     * @Date : 12th Dec. 2017
     */

    function formAttachmentFields() {
        var inpFormAttachments = 1
        var countFormRequiredDoc = $('.div-form-attachments .form-required-docs').length;
        $('.div-form-attachments').last().append($('.form-required-docs-fields').html());

        formAttachments = inpFormAttachments;
        resetAttachmentFields();
    }

    /*  @Function: resetAttachmentFields()
     * @Description: reset attachment fields of the form / permit
     * @By @Ahsan Ahamad
     * @Date : 12th Dec. 2017
     */

    function resetAttachmentFields() {
        var docSerialedit;
        if (docSerialedit > 0) {
            var docSerial = docSerialedit + 1;
        } else {
            var docSerial = 1;
        }
        $('.div-form-attachments .form-required-docs').each(function () {
            $(this).find('.docs-count').html(docSerial);
            $(this).find('.form-required-docs-name').attr('name', 'form_attachment[' + docSerial + '][document_name]');
            $(this).find('.form-required-docs-name').attr('id', 'document_name' + docSerial);
            $(this).find('.form-required-docs-sample').attr('id', 'document_sample' + docSerial);
            $(this).find('.form-required-docs-sample').attr('name', 'form_attachment[' + docSerial + '][document_sample][]');

            $(this).find('.form-required-docs-required').attr('id', 'document_required' + docSerial);
            $(this).find('.form-required-docs-required').attr('name', 'form_required[' + docSerial + '][document_required][]');
            docSerial++;
        });
    }

//End attechement Document 

// code for Form upload

    var formUpload = 0;
    $(document).on('blur', '.inp-form-upload', function () {
        formUploadFields();
    });

    $(document).on('click', '.form-required-add', function () {
        formUploadFields();
    });
    var arridForm = [];
    $(document).on('click', '.form-required-remove', function () {
        var id = $(this).data('id');
        arridForm.push(id);
        $('#del_form_document_id').val(arridForm);

        if ($('.div-form-upload .form-required').length > 1) {
            var element = $(this).parents('.form-required').remove();
            var inpFormAttachments = 1;
            if (inpFormAttachments > 0) {
                inpFormAttachments--
            }
        }
        formUpload = inpFormAttachments;
        resetUploadFields();
    });

    /*  @Function: formUploadFields()
     * @Description: Upload form fields of the form / permit
     * @By @Ahsan Ahamad
     * @Date : 12th Oct. 2017
     */
    function formUploadFields() {

        var inpFormAttachments = 1
        var countFormRequiredDoc = $('.div-form-upload .form-required').length;
        $('.div-form-upload').last().append($('.form-required-fields').html());
        formUpload = inpFormAttachments;
        resetUploadFields();
    }

    /*  @Function: resetUploadFields()
     * @Description: reset upload fields of the form / permit
     * @By @Ahsan Ahamad
     * @Date : 12th Oct. 2017
     */
    function resetUploadFields() {
        var formSerial = 1;

        $('.div-form-upload .form-required').each(function () {
            $(this).find('.forms-count').html(formSerial);
            $(this).find('.form-required-name').attr('name', 'forms[' + formSerial + '][form_name]');
            $(this).find('.form-required-name').attr('id', 'form_name' + formSerial);
            $(this).find('.form-required-document').attr('id', 'form_document' + formSerial);
            $(this).find('.form-required-document').attr('name', 'forms[' + formSerial + '][form_document]');
            $(this).find('.form-required-sample').attr('id', 'form_sample' + formSerial);
            $(this).find('.form-required-sample').attr('name', 'forms[' + formSerial + '][form_sample][]');

            formSerial++;
        });

        if ($('.div-form-upload .form-required').length > 1) {
            $('.form-required-remove').removeClass('hide');
        } else {
            $('.form-required-remove').addClass('hide');
        }
    }

//End Form Upload 
    /* validation upload form of ther permit*/
    $("#upload_forms").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "category_id[]": "required",
            "industry_id[]": "required",

            form_document: {"required": true, extension: "pdf|doc|docx"},
            title: "required",
            "question[]": "required",
            "answer[]": "required",
            "document_name[]": "required",
            document_number: "number",

        },
        messages: {
            "category_id[]": "Please enter a category",
            "industry_id[]": "Please enter a industry",
            form_document: {"required": 'Please upload file', extension: 'Please upload pdf/doc/docx file'},

            title: "Please enter a title",
            "question[]": "Please enter a question",
            "answer[]": "Please enter a answer",
            "document_name[]": "Please enter a document name",
            document_number: "Please enter only number",

        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    /* validation upload edit form of ther permit*/

    $("#upload_edit").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "category_id[]": "required",
            "industry_id[]": "required",
            title: "required",
            "question[]": "required",
            "answer[]": "required",
            "document_name[]": "required",
            document_number: "number",

        },
        messages: {
            category_id: "Please enter a category",
            "category_id[]": "Please enter a category",
            "industry_id[]": "Please enter a industry",
            title: "Please enter a title",
            "question[]": "Please enter a question",
            "answer[]": "Please enter a answer",
            "document_name[]": "Please enter a document name",
            document_number: "Please enter only number",

        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    /* validation upload user form of ther permi form front-end */

    $("#upload_user_forms").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            category_id: "required",
            // sub_category_id: "required",
            porject_id: "required",
            form_id: "required",
            file: "required",

        },
        messages: {
            category_id: "Please select category",
            porject_id: "Please select project",
            form_id: "Please select project",
            // sub_category_id: "Please enter a sub_ category",
            file: "Please upload file",

        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    /* get form list form front-end */

    $(".formlist").on('change', function () {
        var formId = $(this).val();
        if (formId) {
            $.ajax({
                url: "/Forms/getForms",
                type: "Post",
                dataType: 'html',
                data: {id: formId},
                success: function (response) {
                    if (response) {
                        console.log(response);
                        $('#formList').html(response);
                        // $("#ProductCategoryId").html(response);
                    }
                }
            });
        } else {
            $("#formList").html();
        }
    });

    /* this is use for open form view model */

    $(document).on('click', '[data-id]', function () {
        var parentId = $(this).data('id');
        if (parentId) {
            $.ajax({
                url: "/Forms/downloadViewForm",
                type: "Post",
                dataType: 'html',
                data: {id: parentId},
                success: function (response) {
                    if (response) {
                        $('.imgDownload').html(response);
                        $('#myModal').modal('show');
                    }
                }
            });
        } else {
            $("#ProductCategoryId").html();
        }
    });


    /* change  form status form front-end */

    $(document).on('click', '.changeFormStatus', function (event) {
        var id = $(this).data('id');
        var newstatus = $(this).data('newstatus');
        var userId = $(this).data('userid');
        var title = $(this).data('title');
        var oldStatus = $(this).data('oldstatus');
        var industryId = $(this).data('industryid');
        var locationId = $(this).data('locationid');
        var agencyId = $(this).data('agencyid');
        event.preventDefault();
        var urllink = $(this).attr('href');
        ecoConfirm("Are you sure you want to change the '" + title + "' status?", function
                ecoAlert(findreturn) {
            if (findreturn == true) {
                $.ajax({
                    url: "/Customs/changeFormStatus",
                    type: "POST",
                    data: {id: id,
                        newstatus: newstatus,
                        userId: userId,
                        oldStatus: oldStatus,
                        title: title,
                        industryId: industryId,
                        locationId: locationId,
                        agencyId: agencyId,
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



});
