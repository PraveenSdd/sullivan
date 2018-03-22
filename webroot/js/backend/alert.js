/*  
 * By Praveen Soni
 * Date : 04th Feb 2018
 */
$(function () {
    toggleAlertType(1);
    toggleAlertRepeat(1);
    
    /* check Alert validation */
    $("#frmAlert").validate({
        debug: false,
        errorClass: "authError",
        onkeyup: false,
        rules: {
            "Alert[alert_type_id]": {
                required: true,
            },
            "Alert[staff_id][]": {
                required: false,
            },
            "Alert[company_id][]": {
                required: true,
            },
            "Alert[operation_id][]": {
                required: true,
            },
            "Alert[title]": {
                required: true,
                maxlength: 120,
            },
            "Alert[date]": {
                required: true,
            },
            "Alert[time]": {
                required: true,
            },
            "Alert[notes]": {
                required: true,
            },
            "Alert[is_repeated]": {
                required: false,
            },
            "Alert[interval_value]": {
                required: true,
            },
            "Alert[interval_type]": {
                required: true,
            },
            "Alert[alert_end_date]": {
                required: true,
            }

        },
        messages: {
            "Alert[alert_type_id]": {
                required: 'Please select alert type',
            },
            "Alert[staff_id][]": {
                required: 'Please select staff',
            },
            "Alert[company_id][]": {
                required: 'Please select copmany',
            },
            "Alert[operation_id][]": {
                required: 'Please select operation',
            },
            "Alert[title]": {
                required: 'Please enter title',
            },
            "Alert[date]": {
                required: 'Please select date',
            },
            "Alert[time]": {
                required: 'Please select time',
            },
            "Alert[notes]": {
                required: 'Please enter notes',
            },
            "Alert[is_repeated]": {
                required: 'Please check repeat',
            },
            "Alert[interval_value]": {
                required: 'Please enter interval',
            },
            "Alert[interval_type]": {
                required: 'Please select interval type',
            },
            "Alert[alert_end_date]": {
                required: 'Please select end date.',
            }
            
        }
    });
});


