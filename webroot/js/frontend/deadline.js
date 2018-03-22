/*  
 * By Praveen Soni
 * Date : 04th Feb 2018
 */
$(function () {
    $('.inp-deadline-multi').multiselect({
        numberDisplayed: 1
    });
    if ($('.inp-deadline-type').val() <= 0) {
        $('.inp-deadline-type').attr('disabled', 'disabled');
    } else {
        var deadlineType = $('.inp-deadline-type').val();
        changeUserPermit($($(".inp-user-permit-id")));
        $('.inp-deadline-type').val(deadlineType);
        toggleDeadlineType($('.inp-deadline-permit-id').val());
        $('.inp-deadline-document').data('deadline-document-id', '');
        $('.inp-deadline-permit-form').data('deadline-permit-form-id', '');

    }

    $("#frmDeadlines").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Deadlines[user_permit_id]": {
                required: true
            },
            "Deadlines[date]": {
                required: true
            },
            "Deadlines[time]": {
                required: true
            }
        },
        messages: {
            "Deadlines[user_permit_id]": {
                required: 'Please select permit.'
            },
            "Deadlines[date]": {
                required: 'Please select date.'
            },
            "Deadlines[time]": {
                required: 'Please select time.'
            }
        }
    });
    $(document).on("change", ".inp-user-permit-id", function () {
        changeUserPermit($(this));
    });

    function changeUserPermit(element) {
        $(".inp-deadline-permit-id").val('');
        $(".inp-deadline-type").val('');
        var userPermitId = $(element).val();
        if (userPermitId) {
            $(".inp-deadline-permit-id").val($('option:selected', element).attr('data-permit-id'));
            var permitId = $(".inp-deadline-permit-id").val();
            $.ajax({
                url: "/deadlines/getRelatedFormAndDocument/" + permitId,
                type: "POST",
                dataType: 'JSON',
                cache: false,
                async: false,
                success: function (responce)
                {
                    if (responce.document) {
                        $(".inp-deadline-document").multiselect('destroy');
                        $(".inp-deadline-document").html(responce.document).multiselect({numberDisplayed: 1});
                    }
                    if (responce.form) {
                        $(".inp-deadline-permit-form").multiselect('destroy');
                        $(".inp-deadline-permit-form").html(responce.form).multiselect({numberDisplayed: 1});
                    }
                    $('.inp-deadline-type').attr('disabled', false);
                }
            });
        } else {
            $('.inp-deadline-document, .inp-deadline-permit-form').multiselect('disable').val('').multiselect('refresh');
            $('.inp-deadline-type').attr('disabled', 'disabled');
        }
    }
});


